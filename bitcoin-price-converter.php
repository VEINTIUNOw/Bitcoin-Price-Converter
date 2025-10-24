<?php
/*
Plugin Name: Bitcoin Price Converter
Plugin URI: https://wordpress.org/plugins/bitcoin-price-converter
Description: Converts WooCommerce product prices to Bitcoin using exchange rates. Settings available from the admin sidebar menu <code> <a href="/wp-admin/admin.php?page=bitcoin_price_converter_settings">Woocommerce > Bitcoin Converter</a> </code>.
Version: 1.2
Author: VEINTIUNOw
Author URI: http://VEINTIUO.BTC.pub
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'plugins_loaded', 'woocommerce_btc_prices_init' );
add_action( 'wp_enqueue_scripts', 'woocommerce_btc_enqueue_fontawesome' );

function woocommerce_btc_prices_init() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    add_filter( 'woocommerce_currency_symbol', 'woocommerce_btc_currency_symbol', 10, 2 );
    add_filter( 'woocommerce_get_price_html', 'woocommerce_btc_price_html', 10, 2 );
    add_filter( 'woocommerce_cart_item_price', 'woocommerce_btc_cart_item_price', 10, 3 );
    add_filter( 'woocommerce_cart_subtotal', 'woocommerce_btc_cart_subtotal', 10, 2 );
    add_filter( 'woocommerce_checkout_item_quantity', 'woocommerce_btc_checkout_item_quantity', 10, 3 );
    add_filter( 'woocommerce_checkout_item_subtotal', 'woocommerce_btc_checkout_item_subtotal', 10, 3 );
    add_filter( 'woocommerce_get_order_item_totals', 'woocommerce_btc_checkout_item_totals', 10, 3 );
    add_filter( 'woocommerce_currencies', 'woocommerce_btc_add_currency' );
    add_filter( 'woocommerce_currency_symbol_position', 'woocommerce_btc_currency_symbol_position', 10, 2 );
}

function woocommerce_btc_enqueue_fontawesome() {
    wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/090ca49637.js', array(), null, true );
}

function woocommerce_btc_currency_symbol( $currency_symbol, $currency ) {
    if ( $currency === 'BTC' ) {
        return '<i class="fak fa-satoshisymbol-solid"></i>';
    }
    return $currency_symbol;
}

function woocommerce_btc_price_html( $price, $product ) {
    $exchange_rate = woocommerce_btc_get_exchange_rate();
    if ( $exchange_rate == 0 ) {
        return $price; // Return the original price if exchange rate fetch fails
    }
    $btc_price = $product->get_price() / $exchange_rate;
    $satoshi_price = $btc_price * 100000000; // Convert BTC to satoshi

    return wc_price( $satoshi_price, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) );
}

function woocommerce_btc_cart_item_price( $price, $cart_item, $cart_item_key ) {
    $exchange_rate = woocommerce_btc_get_exchange_rate();
    if ( $exchange_rate == 0 ) {
        return $price; // Return the original price if exchange rate fetch fails
    }
    $btc_price = $cart_item['data']->get_price() / $exchange_rate;
    $satoshi_price = $btc_price * 100000000; // Convert BTC to satoshi

    return wc_price( $satoshi_price, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) );
}

function woocommerce_btc_cart_subtotal( $subtotal, $compact ) {
    $exchange_rate = woocommerce_btc_get_exchange_rate();
    if ( $exchange_rate == 0 ) {
        return $subtotal; // Return the original subtotal if exchange rate fetch fails
    }
    $btc_subtotal = WC()->cart->cart_contents_total / $exchange_rate;
    $satoshi_subtotal = $btc_subtotal * 100000000; // Convert BTC to satoshi

    return wc_price( $satoshi_subtotal, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) );
}

function woocommerce_btc_checkout_item_quantity( $product_quantity, $item, $order ) {
    $exchange_rate = woocommerce_btc_get_exchange_rate();
    if ( $exchange_rate == 0 ) {
        return $product_quantity; // Return the original quantity if exchange rate fetch fails
    }
    $btc_price = $item->get_total() / $exchange_rate;
    $satoshi_price = $btc_price * 100000000; // Convert BTC to satoshi

    return wc_price( $satoshi_price, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) );
}

function woocommerce_btc_checkout_item_subtotal( $subtotal, $item, $order ) {
    $exchange_rate = woocommerce_btc_get_exchange_rate();
    if ( $exchange_rate == 0 ) {
        return $subtotal; // Return the original subtotal if exchange rate fetch fails
    }
    $btc_subtotal = $item->get_subtotal() / $exchange_rate;
    $satoshi_subtotal = $btc_subtotal * 100000000; // Convert BTC to satoshi

    return wc_price( $satoshi_subtotal, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) );
}

function woocommerce_btc_checkout_item_totals( $total_rows, $order, $tax_display ) {
    foreach ( $total_rows as $key => $total ) {
        if ( 'order_total' === $key ) {
            $exchange_rate = woocommerce_btc_get_exchange_rate();
            if ( $exchange_rate == 0 ) {
                continue; // Skip if exchange rate fetch fails
            }
            $btc_total = $order->get_total() / $exchange_rate;
            $satoshi_total = $btc_total * 100000000; // Convert BTC to satoshi

            $total_rows[$key]['value'] = wc_price( $satoshi_total, array( 'currency' => 'BTC', 'decimal_separator' => '.', 'thousand_separator' => ',', 'decimals' => 0 ) ) . ' (' . wc_price( $order->get_total(), array( 'currency' => get_woocommerce_currency() ) ) . ')';
        }
    }
    return $total_rows;
}

function woocommerce_btc_get_exchange_rate() {
    $transient_name = 'woocommerce_btc_exchange_rate';
    $exchange_rate = get_transient( $transient_name );

    if ( false === $exchange_rate ) {
        $response = wp_remote_get( 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=USD' );
        if ( is_wp_error( $response ) ) {
            return 0; // Return 0 or handle the error as needed
        }
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        if ( isset( $data['bitcoin']['usd'] ) ) {
            $exchange_rate = $data['bitcoin']['usd'];
            set_transient( $transient_name, $exchange_rate, HOUR_IN_SECONDS );
        } else {
            $exchange_rate = 0; // Handle the error as needed
        }
    }

    return $exchange_rate;
}

function woocommerce_btc_add_currency( $currencies ) {
    $currencies['BTC'] = 'Bitcoin';
    return $currencies;
}

function woocommerce_btc_currency_symbol_position( $position, $currency ) {
    if ( $currency === 'BTC' ) {
        return 'left';
    }
    return $position;
}
