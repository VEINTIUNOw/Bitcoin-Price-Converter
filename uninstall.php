<?php
/**
 * Uninstall Bitcoin Price Converter
 * 
 * This file runs when the plugin is uninstalled (deleted).
 * It removes all plugin data from the database.
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all transients created by the plugin
$currencies = array('usd', 'eur', 'gbp', 'jpy', 'cad', 'aud', 'chf', 'cny', 'inr', 'brl');

foreach ($currencies as $currency) {
    delete_transient('bitcoin_price_' . $currency);
}

// Delete any options created by the plugin (if any were created)
delete_option('bitcoin_converter_settings');
delete_option('bitcoin_converter_version');

// Clear any cached data
wp_cache_flush();
?>
