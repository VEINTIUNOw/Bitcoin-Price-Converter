<?php
/*
Plugin Name: Bitcoin Price Converter
Plugin URI: https://wordpress.org/plugins/bitcoin-price-converter
Description: Converts WooCommerce product prices to Bitcoin using exchange rates. Settings available from the admin sidebar menu <code> <a href="/wp-admin/admin.php?page=bitcoin_price_converter_settings">Woocommerce > Bitcoin Converter</a> </code>.
Version: 1.1.5
Author: VEINTIUNOw
Author URI: http://VEINTIUO.BTC.pub
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue Font Awesome script
add_action('wp_enqueue_scripts', 'bitcoin_price_converter_enqueue_fontawesome');
function bitcoin_price_converter_enqueue_fontawesome() {
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/090ca49637.js', array(), '5.15.3', false);
}

// Add Bitcoin price conversion to WooCommerce product display
add_filter('woocommerce_get_price_html', 'convert_price_to_bitcoin', 10, 2);
function convert_price_to_bitcoin($price_html, $product) {
    // Early return if product price is not available
    if (!$product || !$product->get_price()) {
        return $price_html;
    }
    
    $bitcoin_rate = get_bitcoin_exchange_rate();
    
    // Check if bitcoin rate is valid and not zero
    if (!$bitcoin_rate || $bitcoin_rate <= 0) {
        return $price_html;
    }

    $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
    $show_fiat_price = get_option('show_fiat_price', true);
    $price = floatval($product->get_price());
    
    // Additional safety check
    if ($price <= 0) {
        return $price_html;
    }
    
    $price_in_bitcoin = $price / $bitcoin_rate;
    $formatted_price = format_bitcoin_price($price_in_bitcoin, $bitcoin_denomination);

    $converted_price_html = $formatted_price;
    if ($show_fiat_price) {
        $converted_price_html .= ' <br/><small class="grey">' . $price_html . '</small>';
    }

    return $converted_price_html;
}

// Convert prices on the cart and checkout pages
add_filter('woocommerce_cart_item_price', 'convert_cart_item_price', 10, 3);
add_filter('woocommerce_checkout_cart_item_quantity', 'convert_cart_item_price', 10, 3);
function convert_cart_item_price($price_html, $cart_item, $cart_item_key) {
    if (!isset($cart_item['data'])) {
        return $price_html;
    }
    
    $product = $cart_item['data'];
    $price = floatval($product->get_price());
    
    if ($price <= 0) {
        return $price_html;
    }
    
    $bitcoin_rate = get_bitcoin_exchange_rate();
    
    if (!$bitcoin_rate || $bitcoin_rate <= 0) {
        return $price_html;
    }

    $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
    $price_in_bitcoin = $price / $bitcoin_rate;
    $converted_price_html = format_bitcoin_price($price_in_bitcoin, $bitcoin_denomination);

    return $converted_price_html;
}

// Convert prices on the cart and checkout totals
add_filter('woocommerce_cart_item_subtotal', 'convert_cart_totals', 10, 3);
add_filter('woocommerce_checkout_cart_subtotal', 'convert_cart_totals', 10, 3);
function convert_cart_totals($subtotal_html, $cart_item, $cart_item_key) {
    if (!isset($cart_item['line_total'])) {
        return $subtotal_html;
    }
    
    $price = floatval($cart_item['line_total']);
    
    if ($price <= 0) {
        return $subtotal_html;
    }
    
    $bitcoin_rate = get_bitcoin_exchange_rate();
    
    if (!$bitcoin_rate || $bitcoin_rate <= 0) {
        return $subtotal_html;
    }

    $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
    $price_in_bitcoin = $price / $bitcoin_rate;
    $converted_price_html = format_bitcoin_price($price_in_bitcoin, $bitcoin_denomination);

    return $converted_price_html;
}

// Get the current Bitcoin exchange rate from the selected source or custom URL
function get_bitcoin_exchange_rate() {
    $exchange_rate_source = get_option('exchange_rate_source', 'coindesk');
    $stored_exchange_rate = get_option('bitcoin_exchange_rate');
    $stored_exchange_rate_timestamp = get_option('bitcoin_exchange_rate_timestamp');
    $current_timestamp = time();
    $ten_minutes_in_seconds = 10 * 60; // 10 minutes

    // Return cached rate if it's still valid and not zero
    if ($stored_exchange_rate && $stored_exchange_rate > 0 && ($current_timestamp - $stored_exchange_rate_timestamp) < $ten_minutes_in_seconds) {
        return $stored_exchange_rate;
    }

    $api_url = '';
    switch ($exchange_rate_source) {
        case 'coindesk':
            $api_url = 'https://api.coindesk.com/v1/bpi/currentprice/USD.json';
            break;
        case 'coingecko':
            $api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd';
            break;
        case 'custom':
            $api_url = get_option('custom_exchange_rate_url');
            break;
    }

    if (empty($api_url)) {
        error_log('Bitcoin Price Converter: No valid API URL configured');
        return false;
    }

    $response = wp_remote_get($api_url, array(
        'timeout' => 15,
        'headers' => array(
            'User-Agent' => 'WordPress/Bitcoin-Price-Converter-Plugin'
        )
    ));
    
    if (is_wp_error($response)) {
        error_log('Bitcoin Price Converter: API request failed - ' . $response->get_error_message());
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        error_log('Bitcoin Price Converter: API returned status code ' . $response_code);
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!$data || !is_array($data)) {
        error_log('Bitcoin Price Converter: Invalid JSON response');
        return false;
    }

    $rate = false;
    switch ($exchange_rate_source) {
        case 'coindesk':
            $rate = isset($data['bpi']['USD']['rate_float']) ? floatval($data['bpi']['USD']['rate_float']) : false;
            break;
        case 'coingecko':
            $rate = isset($data['bitcoin']['usd']) ? floatval($data['bitcoin']['usd']) : false;
            break;
        case 'custom':
            // For custom APIs, try to find a numeric value
            if (isset($data['rate'])) {
                $rate = floatval($data['rate']);
            } elseif (isset($data['price'])) {
                $rate = floatval($data['price']);
            } elseif (isset($data['usd'])) {
                $rate = floatval($data['usd']);
            }
            break;
    }

    if ($rate && $rate > 0) {
        update_option('bitcoin_exchange_rate', $rate);
        update_option('bitcoin_exchange_rate_timestamp', $current_timestamp);
        return $rate;
    } else {
        error_log('Bitcoin Price Converter: Could not parse rate from API response');
        return false;
    }
}

// Format the Bitcoin price based on the selected denomination
function format_bitcoin_price($price, $denomination) {
    if (!is_numeric($price) || $price <= 0) {
        return 'N/A';
    }
    
    switch ($denomination) {
        case 'mBTC':
            $formatted_price = number_format($price * 1000, 2, '.', ',') . ' mBTC';
            break;
        case 'sats':
            $formatted_price = number_format($price * 100000000, 0, '.', ',') . ' sats';
            break;
        case 'BTC':
        default:
            $formatted_price = '₿ ' . number_format($price, 8, '.', ',');
            break;
    }

    return $formatted_price;
}

// Add plugin settings page to the admin menu
add_action('admin_menu', 'bitcoin_price_converter_settings_page');
function bitcoin_price_converter_settings_page() {
    add_submenu_page(
        'woocommerce',
        'Bitcoin Price Converter Settings',
        'Bitcoin Converter',
        'manage_options',
        'bitcoin_price_converter_settings',
        'bitcoin_price_converter_settings_callback'
    );
}

// Callback function to render the plugin settings page
function bitcoin_price_converter_settings_callback() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['submit'])) {
        // Verify nonce for security
        if (!isset($_POST['bitcoin_converter_nonce']) || !wp_verify_nonce($_POST['bitcoin_converter_nonce'], 'bitcoin_converter_settings')) {
            wp_die('Security check failed');
        }
        
        update_option('bitcoin_denomination', sanitize_text_field($_POST['bitcoin_denomination']));
        update_option('show_fiat_price', isset($_POST['show_fiat_price']));
        update_option('exchange_rate_source', sanitize_text_field($_POST['exchange_rate_source']));
        
        if ($_POST['exchange_rate_source'] === 'custom') {
            update_option('custom_exchange_rate_url', esc_url_raw($_POST['custom_exchange_rate_url']));
        } else {
            delete_option('custom_exchange_rate_url');
        }
        
        // Clear cached exchange rate when settings change
        delete_option('bitcoin_exchange_rate');
        delete_option('bitcoin_exchange_rate_timestamp');
        
        echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
    }
    
    // Test API connection
    if (isset($_POST['test_api'])) {
        if (!isset($_POST['bitcoin_converter_nonce']) || !wp_verify_nonce($_POST['bitcoin_converter_nonce'], 'bitcoin_converter_settings')) {
            wp_die('Security check failed');
        }
        
        // Clear cache to force fresh API call
        delete_option('bitcoin_exchange_rate');
        delete_option('bitcoin_exchange_rate_timestamp');
        
        $rate = get_bitcoin_exchange_rate();
        if ($rate && $rate > 0) {
            echo '<div class="notice notice-success"><p>API connection successful! Current rate: $' . number_format($rate, 2) . '</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>API connection failed. Please check your settings and try again.</p></div>';
        }
    }

    $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
    $show_fiat_price = get_option('show_fiat_price', true);
    $exchange_rate_source = get_option('exchange_rate_source', 'coindesk');
    $custom_exchange_rate_url = get_option('custom_exchange_rate_url', '');
    $sample_fiat_price = 1;
    $current_rate = get_bitcoin_exchange_rate();
    $sample_price_in_bitcoin = $current_rate ? $sample_fiat_price / $current_rate : 0;
    ?>
    <div class="wrap">
        <h1>Bitcoin Price Converter Settings</h1>
        
        <?php if ($current_rate): ?>
            <h2>Current Exchange Rate</h2>
            <p><strong>1 BTC = $<?php echo number_format($current_rate, 2); ?></strong></p>
            
            <h2>Preview</h2>
            <p>Sample Price in Fiat: $<?php echo number_format($sample_fiat_price, 2, '.', ','); ?></p>
            <p>Sample Price in Bitcoin: <?php echo format_bitcoin_price($sample_price_in_bitcoin, 'BTC'); ?></p>
            <p>Sample Price in milli Bitcoin: <?php echo format_bitcoin_price($sample_price_in_bitcoin, 'mBTC'); ?></p>
            <p>Sample Price in satoshis: <?php echo format_bitcoin_price($sample_price_in_bitcoin, 'sats'); ?></p>
        <?php else: ?>
            <div class="notice notice-warning">
                <p><strong>Warning:</strong> Unable to fetch current Bitcoin exchange rate. Please check your API settings.</p>
            </div>
        <?php endif; ?>
        
        <hr>
        
        <form method="post" action="">
            <?php wp_nonce_field('bitcoin_converter_settings', 'bitcoin_converter_nonce'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Bitcoin Denomination</th>
                    <td>
                        <select name="bitcoin_denomination">
                            <option value="BTC" <?php selected($bitcoin_denomination, 'BTC'); ?>>Bitcoin (₿)</option>
                            <option value="mBTC" <?php selected($bitcoin_denomination, 'mBTC'); ?>>milli Bitcoin (mBTC)</option>
                            <option value="sats" <?php selected($bitcoin_denomination, 'sats'); ?>>Satoshi (sats)</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Show Fiat Price</th>
                    <td>
                        <label>
                            <input type="checkbox" name="show_fiat_price" value="1" <?php checked($show_fiat_price); ?>>
                            Display fiat price alongside Bitcoin price
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Exchange Rate Source</th>
                    <td>
                        <select name="exchange_rate_source" id="exchange_rate_source">
                            <option value="coindesk" <?php selected($exchange_rate_source, 'coindesk'); ?>>CoinDesk</option>
                            <option value="coingecko" <?php selected($exchange_rate_source, 'coingecko'); ?>>CoinGecko</option>
                            <option value="custom" <?php selected($exchange_rate_source, 'custom'); ?>>Custom URL</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top" id="custom_url_row" style="<?php echo ($exchange_rate_source === 'custom') ? '' : 'display: none;'; ?>">
                    <th scope="row">Custom Exchange Rate URL</th>
                    <td>
                        <input type="url" name="custom_exchange_rate_url" value="<?php echo esc_attr($custom_exchange_rate_url); ?>" placeholder="https://api.example.com/bitcoin/price" style="width: 100%; max-width: 400px;">
                        <p class="description">Enter a URL that returns JSON with Bitcoin price data.</p>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="Save Settings">
                <input type="submit" name="test_api" class="button-secondary" value="Test API Connection" style="margin-left: 10px;">
            </p>
        </form>
    </div>
    
    <script>
        (function ($) {
            $(document).ready(function () {
                var exchangeRateSource = $('#exchange_rate_source');
                var customUrlRow = $('#custom_url_row');
                
                exchangeRateSource.on('change', function () {
                    if (exchangeRateSource.val() === 'custom') {
                        customUrlRow.show();
                    } else {
                        customUrlRow.hide();
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}

// Add Bitcoin as Unit of Account in product settings
add_action('woocommerce_product_options_pricing', 'add_bitcoin_as_unit_of_account');
function add_bitcoin_as_unit_of_account() {
    woocommerce_wp_checkbox(array(
        'id' => '_bitcoin_as_unit_of_account',
        'label' => 'Use Bitcoin as Unit of Account',
        'description' => 'Enable this option to set Bitcoin as the unit of account for this product.',
        'desc_tip' => true,
    ));
}

// Save Bitcoin as Unit of Account option when product is saved
add_action('woocommerce_process_product_meta', 'save_bitcoin_as_unit_of_account');
function save_bitcoin_as_unit_of_account($post_id) {
    $bitcoin_as_unit_of_account = isset($_POST['_bitcoin_as_unit_of_account']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bitcoin_as_unit_of_account', $bitcoin_as_unit_of_account);
}

// Display Bitcoin denomination in product price
add_filter('woocommerce_get_price_html', 'display_bitcoin_denomination_in_price', 100, 2);
function display_bitcoin_denomination_in_price($price_html, $product) {
    $bitcoin_as_unit_of_account = get_post_meta($product->get_id(), '_bitcoin_as_unit_of_account', true);
    if ($bitcoin_as_unit_of_account === 'yes') {
        $bitcoin_rate = get_bitcoin_exchange_rate();
        if ($bitcoin_rate && $bitcoin_rate > 0) {
            $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
            $price_in_bitcoin = $product->get_price() / $bitcoin_rate;
            $price_html = '(' . format_bitcoin_price($price_in_bitcoin, $bitcoin_denomination) . ')';
        }
    }
    return $price_html;
}

// Display Total Price in Bitcoin on the checkout page
add_action('woocommerce_review_order_after_order_total', 'display_total_price_in_bitcoin');
function display_total_price_in_bitcoin() {
    if (!WC()->cart) {
        return;
    }
    
    $total_price_in_fiat = WC()->cart->total;
    
    if ($total_price_in_fiat <= 0) {
        return;
    }
    
    $bitcoin_rate = get_bitcoin_exchange_rate();
    if (!$bitcoin_rate || $bitcoin_rate <= 0) {
        return;
    }

    $bitcoin_denomination = get_option('bitcoin_denomination', 'BTC');
    $total_price_in_bitcoin = $total_price_in_fiat / $bitcoin_rate;
    $total_price_html = format_bitcoin_price($total_price_in_bitcoin, $bitcoin_denomination);
    ?>
    <tr>
        <th><?php _e('Total Price in Bitcoin', 'bitcoin-price-converter'); ?></th>
        <td><?php echo $total_price_html; ?></td>
    </tr>
    <?php
}

// Update plugin version
add_action('plugins_loaded', 'update_bitcoin_price_converter_version');
function update_bitcoin_price_converter_version() {
    $current_version = get_option('bitcoin_price_converter_version', '1.0.0');
    $new_version = '1.1.5';
    if ($current_version !== $new_version) {
        update_option('bitcoin_price_converter_version', $new_version);
    }
}

// Add admin notice for configuration
add_action('admin_notices', 'bitcoin_price_converter_admin_notice');
function bitcoin_price_converter_admin_notice() {
    $screen = get_current_screen();
    if ($screen && strpos($screen->id, 'woocommerce') !== false) {
        $rate = get_bitcoin_exchange_rate();
        if (!$rate || $rate <= 0) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>Bitcoin Price Converter:</strong> Unable to fetch Bitcoin exchange rate. ';
            echo '<a href="' . admin_url('admin.php?page=bitcoin_price_converter_settings') . '">Check your settings</a></p>';
            echo '</div>';
        }
    }
}
