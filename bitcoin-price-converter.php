<?php
/**
 * Plugin Name: Bitcoin Price Converter
 * Description: A simple Bitcoin price converter widget that displays current Bitcoin prices and allows conversion between BTC and various fiat currencies.
 * Version: 1.0.0
 * Author: VEINTIUNOw
 * Text Domain: bitcoin-price-converter
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BITCOIN_CONVERTER_VERSION', '1.0.0');
define('BITCOIN_CONVERTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BITCOIN_CONVERTER_PLUGIN_URL', plugin_dir_url(__FILE__));

class BitcoinPriceConverter {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('bitcoin_converter', array($this, 'display_converter'));
        add_action('wp_ajax_get_bitcoin_price', array($this, 'ajax_get_bitcoin_price'));
        add_action('wp_ajax_nopriv_get_bitcoin_price', array($this, 'ajax_get_bitcoin_price'));
        add_action('wp_ajax_convert_bitcoin', array($this, 'ajax_convert_bitcoin'));
        add_action('wp_ajax_nopriv_convert_bitcoin', array($this, 'ajax_convert_bitcoin'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }
    
    public function init() {
        // Plugin initialization
    }
    
    public function load_textdomain() {
        load_plugin_textdomain('bitcoin-price-converter', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('bitcoin-converter-js', BITCOIN_CONVERTER_PLUGIN_URL . 'assets/bitcoin-converter.js', array('jquery'), BITCOIN_CONVERTER_VERSION, true);
        wp_enqueue_style('bitcoin-converter-css', BITCOIN_CONVERTER_PLUGIN_URL . 'assets/bitcoin-converter.css', array(), BITCOIN_CONVERTER_VERSION);
        
        wp_localize_script('bitcoin-converter-js', 'bitcoin_converter_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bitcoin_converter_nonce'),
            'loading_text' => __('Loading...', 'bitcoin-price-converter'),
            'error_text' => __('Error fetching data. Please try again.', 'bitcoin-price-converter')
        ));
    }
    
    public function display_converter($atts) {
        $atts = shortcode_atts(array(
            'default_currency' => 'USD',
            'theme' => 'light'
        ), $atts, 'bitcoin_converter');
        
        $currencies = array(
            'USD' => __('US Dollar', 'bitcoin-price-converter'),
            'EUR' => __('Euro', 'bitcoin-price-converter'),
            'GBP' => __('British Pound', 'bitcoin-price-converter'),
            'JPY' => __('Japanese Yen', 'bitcoin-price-converter'),
            'CAD' => __('Canadian Dollar', 'bitcoin-price-converter'),
            'AUD' => __('Australian Dollar', 'bitcoin-price-converter'),
            'CHF' => __('Swiss Franc', 'bitcoin-price-converter'),
            'CNY' => __('Chinese Yuan', 'bitcoin-price-converter'),
            'INR' => __('Indian Rupee', 'bitcoin-price-converter'),
            'BRL' => __('Brazilian Real', 'bitcoin-price-converter')
        );
        
        ob_start();
        ?>
        <div class="bitcoin-converter-widget" data-theme="<?php echo esc_attr($atts['theme']); ?>">
            <div class="bitcoin-converter-header">
                <h3><?php _e('Bitcoin Price Converter', 'bitcoin-price-converter'); ?></h3>
                <div class="bitcoin-price-display">
                    <span class="current-price"><?php _e('Loading...', 'bitcoin-price-converter'); ?></span>
                    <span class="price-currency"><?php echo esc_html($atts['default_currency']); ?></span>
                </div>
            </div>
            
            <div class="bitcoin-converter-form">
                <div class="converter-row">
                    <div class="input-group">
                        <label for="btc-amount"><?php _e('Bitcoin (BTC)', 'bitcoin-price-converter'); ?></label>
                        <input type="number" id="btc-amount" step="0.00000001" min="0" placeholder="0.00000000">
                    </div>
                    <div class="converter-arrow">⇄</div>
                    <div class="input-group">
                        <label for="fiat-amount"><?php _e('Fiat Currency', 'bitcoin-price-converter'); ?></label>
                        <input type="number" id="fiat-amount" step="0.01" min="0" placeholder="0.00">
                    </div>
                </div>
                
                <div class="currency-selector">
                    <label for="currency-select"><?php _e('Select Currency:', 'bitcoin-price-converter'); ?></label>
                    <select id="currency-select">
                        <?php foreach ($currencies as $code => $name): ?>
                            <option value="<?php echo esc_attr($code); ?>" <?php selected($code, $atts['default_currency']); ?>>
                                <?php echo esc_html($code . ' - ' . $name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="converter-buttons">
                    <button type="button" id="refresh-price" class="btn-refresh">
                        <?php _e('Refresh Price', 'bitcoin-price-converter'); ?>
                    </button>
                </div>
            </div>
            
            <div class="bitcoin-converter-footer">
                <small><?php _e('Prices updated every 60 seconds', 'bitcoin-price-converter'); ?></small>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function ajax_get_bitcoin_price() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash(sanitize_text_field($_POST['nonce'])), 'bitcoin_converter_nonce')) {
            wp_die(__('Security check failed', 'bitcoin-price-converter'));
        }
        
        $currency = isset($_POST['currency']) ? sanitize_text_field(wp_unslash($_POST['currency'])) : 'USD';
        
        $price = $this->fetch_bitcoin_price($currency);
        
        if ($price !== false) {
            wp_send_json_success(array(
                'price' => $price,
                'currency' => $currency,
                'formatted_price' => $this->format_price($price, $currency)
            ));
        } else {
            wp_send_json_error(__('Failed to fetch Bitcoin price', 'bitcoin-price-converter'));
        }
    }
    
    public function ajax_convert_bitcoin() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash(sanitize_text_field($_POST['nonce'])), 'bitcoin_converter_nonce')) {
            wp_die(__('Security check failed', 'bitcoin-price-converter'));
        }
        
        $amount = isset($_POST['amount']) ? floatval(wp_unslash($_POST['amount'])) : 0;
        $currency = isset($_POST['currency']) ? sanitize_text_field(wp_unslash($_POST['currency'])) : 'USD';
        $type = isset($_POST['type']) ? sanitize_text_field(wp_unslash($_POST['type'])) : 'btc_to_fiat';
        
        $btc_price = $this->fetch_bitcoin_price($currency);
        
        if ($btc_price !== false) {
            if ($type === 'btc_to_fiat') {
                $result = $amount * $btc_price;
            } else {
                $result = $amount / $btc_price;
            }
            
            wp_send_json_success(array(
                'result' => $result,
                'formatted_result' => $this->format_conversion_result($result, $type, $currency)
            ));
        } else {
            wp_send_json_error(__('Failed to fetch Bitcoin price for conversion', 'bitcoin-price-converter'));
        }
    }
    
    private function fetch_bitcoin_price($currency = 'USD') {
        $transient_key = 'bitcoin_price_' . strtolower($currency);
        $cached_price = get_transient($transient_key);
        
        if ($cached_price !== false) {
            return $cached_price;
        }
        
        $api_url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=' . strtolower($currency);
        
        $response = wp_remote_get($api_url, array(
            'timeout' => 30,
            'headers' => array(
                'User-Agent' => 'Bitcoin Price Converter WordPress Plugin'
            )
        ));
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['bitcoin'][strtolower($currency)])) {
            $price = $data['bitcoin'][strtolower($currency)];
            set_transient($transient_key, $price, 60); // Cache for 1 minute
            return $price;
        }
        
        return false;
    }
    
    private function format_price($price, $currency) {
        $symbols = array(
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CHF' => 'CHF ',
            'CNY' => '¥',
            'INR' => '₹',
            'BRL' => 'R$'
        );
        
        $symbol = isset($symbols[$currency]) ? $symbols[$currency] : $currency . ' ';
        $formatted_price = number_format($price, 2, '.', ',');
        
        return $symbol . $formatted_price;
    }
    
    private function format_conversion_result($result, $type, $currency) {
        if ($type === 'btc_to_fiat') {
            return $this->format_price($result, $currency);
        } else {
            return number_format($result, 8, '.', ',') . ' BTC';
        }
    }
}

// Initialize the plugin
new BitcoinPriceConverter();

// Activation hook
register_activation_hook(__FILE__, 'bitcoin_converter_activate');
function bitcoin_converter_activate() {
    // Create necessary database tables or options if needed
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'bitcoin_converter_deactivate');
function bitcoin_converter_deactivate() {
    // Clean up transients
    delete_transient('bitcoin_price_usd');
    delete_transient('bitcoin_price_eur');
    delete_transient('bitcoin_price_gbp');
    delete_transient('bitcoin_price_jpy');
    delete_transient('bitcoin_price_cad');
    delete_transient('bitcoin_price_aud');
    delete_transient('bitcoin_price_chf');
    delete_transient('bitcoin_price_cny');
    delete_transient('bitcoin_price_inr');
    delete_transient('bitcoin_price_brl');
    
    flush_rewrite_rules();
}
?>
