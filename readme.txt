=== Bitcoin Price Converter ===
Contributors: veintiuno
Tags: bitcoin, woocommerce, cryptocurrency, price converter, btc
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.1.5
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Converts WooCommerce product prices to Bitcoin using real-time exchange rates from CoinDesk or CoinGecko APIs.

== Description ==

Bitcoin Price Converter is a WordPress plugin that seamlessly integrates with WooCommerce to display product prices in Bitcoin alongside traditional fiat currency prices. The plugin fetches real-time Bitcoin exchange rates from trusted sources like CoinDesk and CoinGecko.

**Features:**

* Display product prices in Bitcoin (BTC), milli Bitcoin (mBTC), or Satoshis
* Real-time exchange rate updates with 10-minute caching
* Support for multiple exchange rate sources (CoinDesk, CoinGecko, Custom API)
* Option to show or hide fiat prices alongside Bitcoin prices
* Bitcoin pricing on cart, checkout, and product pages
* Admin settings panel for easy configuration
* API connection testing functionality

**Supported Denominations:**

* Bitcoin (₿) - Full Bitcoin amounts
* mBTC - Milli Bitcoin (1/1000 of a Bitcoin)
* Satoshis - The smallest unit of Bitcoin (100,000,000 satoshis = 1 Bitcoin)

**Exchange Rate Sources:**

* CoinDesk API
* CoinGecko API
* Custom API endpoint (for advanced users)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/bitcoin-price-converter` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to WooCommerce > Bitcoin Converter to configure the plugin settings
4. Select your preferred Bitcoin denomination and exchange rate source
5. Test the API connection to ensure proper functionality

== Frequently Asked Questions ==

= Does this plugin work with all WooCommerce themes? =

Yes, the plugin uses WooCommerce's built-in hooks and filters, making it compatible with most WooCommerce themes.

= How often are exchange rates updated? =

Exchange rates are cached for 10 minutes to balance between accuracy and performance. You can test the API connection anytime from the settings page.

= Can I use my own exchange rate API? =

Yes, the plugin supports custom API endpoints. Your API should return JSON data with Bitcoin price information.

= Will this slow down my website? =

No, the plugin uses efficient caching and only makes API calls when necessary. Exchange rates are cached for 10 minutes.

= What happens if the API is unavailable? =

If the exchange rate API is unavailable, the plugin will display the original fiat prices without Bitcoin conversion.

== Screenshots ==

1. Plugin settings page with denomination and API source options
2. Product page showing Bitcoin price alongside fiat price
3. Cart page with Bitcoin pricing
4. Checkout page with total Bitcoin price

== Changelog ==

= 1.1.5 =
* Added GPL license header
* Fixed output escaping for security compliance
* Removed debug error_log statements
* Fixed input validation and sanitization
* Improved nonce verification
* Enhanced security for WordPress.org submission

= 1.1.4 =
* Improved error handling for API calls
* Better caching mechanism
* Enhanced admin interface

= 1.1.3 =
* Added support for custom API endpoints
* Improved price formatting
* Bug fixes and performance improvements

= 1.1.2 =
* Added mBTC and Satoshi denomination options
* Improved API error handling
* Enhanced admin settings interface

= 1.1.1 =
* Fixed compatibility issues with newer WooCommerce versions
* Improved price calculation accuracy
* Added API connection testing

= 1.1.0 =
* Added CoinGecko API support
* Improved caching system
* Enhanced admin interface

= 1.0.0 =
* Initial release
* Basic Bitcoin price conversion functionality
* CoinDesk API integration

== Upgrade Notice ==

= 1.1.5 =
This version includes important security improvements and WordPress.org compliance fixes. Please update immediately.

== Additional Info ==

For support and feature requests, please visit the plugin's support forum or contact the developer.

The plugin requires WooCommerce to be installed and activated to function properly.
