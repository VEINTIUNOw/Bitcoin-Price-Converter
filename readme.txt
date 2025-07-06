=== Bitcoin Price Converter ===
Contributors: veintiunow
Tags: bitcoin, cryptocurrency, price, converter, widget, shortcode
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A simple Bitcoin price converter widget that displays current Bitcoin prices and allows conversion between BTC and various fiat currencies.

== Description ==

Bitcoin Price Converter is a lightweight WordPress plugin that provides a simple and elegant way to display current Bitcoin prices and convert between Bitcoin and various fiat currencies. Perfect for cryptocurrency blogs, financial websites, or any site that needs to display Bitcoin pricing information.

**Key Features:**

* Real-time Bitcoin price display
* Convert Bitcoin to 10 major fiat currencies (USD, EUR, GBP, JPY, CAD, AUD, CHF, CNY, INR, BRL)
* Convert fiat currencies to Bitcoin
* Responsive design that works on all devices
* Customizable themes (light/dark)
* Easy to use shortcode implementation
* Automatic price caching for improved performance
* Internationalization ready

**Supported Currencies:**

* USD (US Dollar)
* EUR (Euro)
* GBP (British Pound)
* JPY (Japanese Yen)
* CAD (Canadian Dollar)
* AUD (Australian Dollar)
* CHF (Swiss Franc)
* CNY (Chinese Yuan)
* INR (Indian Rupee)
* BRL (Brazilian Real)

**Usage:**

Use the shortcode `[bitcoin_converter]` anywhere in your posts, pages, or widgets to display the Bitcoin price converter.

**Shortcode Parameters:**

* `default_currency` - Set the default currency (default: USD)
* `theme` - Set the theme (light or dark, default: light)

**Examples:**

* `[bitcoin_converter]` - Basic converter with USD as default
* `[bitcoin_converter default_currency="EUR"]` - Converter with EUR as default
* `[bitcoin_converter theme="dark"]` - Dark theme converter
* `[bitcoin_converter default_currency="GBP" theme="dark"]` - Dark theme with GBP default

The plugin uses the reliable CoinGecko API to fetch real-time Bitcoin prices and implements smart caching to ensure optimal performance without overwhelming the API.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/bitcoin-price-converter` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[bitcoin_converter]` in your posts, pages, or widgets to display the converter.

== Frequently Asked Questions ==

= How often are the prices updated? =

The plugin fetches real-time prices from the CoinGecko API and caches them for 1 minute to ensure optimal performance. The prices are automatically refreshed every 60 seconds.

= Can I customize the appearance of the converter? =

Yes, the plugin includes CSS classes that you can style according to your theme. You can also choose between light and dark themes using the shortcode parameter.

= Which currencies are supported? =

The plugin supports 10 major fiat currencies: USD, EUR, GBP, JPY, CAD, AUD, CHF, CNY, INR, and BRL.

= Does the plugin work on mobile devices? =

Yes, the converter is fully responsive and works perfectly on all devices including smartphones and tablets.

= Is the plugin translation ready? =

Yes, the plugin is internationalization ready and can be translated into any language.

= Does the plugin slow down my website? =

No, the plugin is optimized for performance with smart caching mechanisms and only loads JavaScript and CSS when needed.

== Screenshots ==

1. Bitcoin Price Converter widget with light theme
2. Bitcoin Price Converter widget with dark theme
3. Currency selection dropdown
4. Mobile responsive design

== Changelog ==

= 1.0.0 =
* Initial release
* Real-time Bitcoin price display
* Support for 10 major fiat currencies
* Bi-directional conversion (BTC to fiat and fiat to BTC)
* Responsive design
* Light and dark themes
* Shortcode implementation
* Price caching for performance
* Internationalization support

== Upgrade Notice ==

= 1.0.0 =
Initial release of Bitcoin Price Converter plugin.

== Development ==

This plugin is actively developed and maintained. For bug reports, feature requests, or contributions, please visit our GitHub repository.

== Credits ==

* Bitcoin price data provided by CoinGecko API
* Developed by VEINTIUNOw

== Privacy Policy ==

This plugin does not collect, store, or transmit any personal user data. It only fetches publicly available Bitcoin price information from the CoinGecko API to display current prices and perform conversions.

== Support ==

For support questions, please use the WordPress.org support forums. For bug reports and feature requests, please visit our GitHub repository.
