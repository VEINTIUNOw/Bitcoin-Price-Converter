# Bitcoin Price Converter

**Contributors:** VEINTIUNOw  
**Donate link:** https://VEINTIUNO.btc.pub/participa/#patrocinador
**Tags:** bitcoin, btc converter, bitcoin price  
**Requires at least:** 4.9  
**Tested up to:** 6.6  
**Stable tag:** 1.1.5  
**Requires PHP:** 5.6  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  
**Version:** 1.1.5  

## Description
Converts WooCommerce product prices to Bitcoin using real-time exchange rates. This plugin allows customers to view prices in Bitcoin with the selected denomination (BTC, mBTC, or sats) and displays the equivalent fiat price alongside it.

Settings available from the admin sidebar menu: [Woocommerce > Bitcoin Converter](wp-admin/admin.php?page=bitcoin_price_converter_settings)

- **Source code on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter)**
- **Demo on [site](https://veintiuno.BTC.pub/m/digitales/bitcoin-price-co%E2%80%A6ocommerce-plugin/)**
- **Donate sats or contribute from https://VEINTIUNO.btc.pub/participa/#patrocinador

## Features

- **Automatic Price Conversion:** Automatically converts product prices to Bitcoin using the latest exchange rates.
- **Denomination Options:** Choose between BTC, mBTC, or sats as your preferred Bitcoin denomination.
- **Show Fiat Price:** Display fiat price alongside Bitcoin price for customer convenience.
- **Use Bitcoin as Unit of Account:** Optionally set Bitcoin as the unit of account for individual products.
- **Customizable Exchange Rate Source:** Choose from CoinDesk, CoinGecko, or provide a custom exchange rate URL.
- **Total Price in Bitcoin:** Display the total order price in Bitcoin on the checkout page.

## Installation

1. Upload the `bitcoin-price-converter` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure the plugin settings from the admin sidebar menu "WooCommerce > Bitcoin Converter."
4. Choose your preferred Bitcoin denomination (BTC, mBTC, or sats) and enable/disable fiat price display.
5. Optionally set Bitcoin as the unit of account for individual products in the product settings.
6. Select the desired exchange rate source: CoinDesk, CoinGecko, or provide a custom URL.

## Usage

- Prices will be automatically converted to Bitcoin on the product, cart, and checkout pages.
- Customers will see the converted price based on the selected denomination alongside the fiat price (if enabled).

## Plugin Settings

- **Bitcoin Denomination:** Choose your preferred denomination of Bitcoin (BTC, mBTC, or sats).
- **Show Fiat Price:** Enable/disable the display of fiat price alongside Bitcoin price.
- **Exchange Rate Source:** Select the source of exchange rate data (CoinDesk, CoinGecko, or custom URL).
- **Custom Exchange Rate URL:** If "Custom" is selected as the exchange rate source, provide the custom URL here.

## Support

For queries or support requests, please:
- Open an issue on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter/issues)
- Contact us via [X](https://x.com/VEINTIUNOw) or [nostr](https://snort.social/21)
- Visit our support forum on [WordPress.org](https://wordpress.org/support/plugin/bitcoin-price-converter/)

## Contributing

Bitcoin Price Converter is an open-source project, and we welcome contributions from the community. You can find the plugin's source code on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter). 

### How to Contribute
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

If you encounter any issues or have suggestions for improvements, feel free to submit a pull request or open an issue on the GitHub repository.


## Donations

If you appreciate the work we put into developing and maintaining this plugin, you can support us:
- **Bitcoin donations:** https://VEINTIUNO.btc.pub/participa/#patrocinador
- **Geyser Fund:** https://geyser.fund/project/bitcoinpriceconverterwordpressplugin

## Follow Us

Stay updated with the latest developments:
- **X (Twitter):** [@VEINTIUNOw](https://twitter.com/VEINTIUNOw)
- **Nostr:** [snort.social/21](https://snort.social/21)
- **Website:** [VEINTIUNO.btc.pub](https://VEINTIUNO.btc.pub)

## Changelog

### 1.0.0
- **Initial release** of Bitcoin Price Converter
- Real-time Bitcoin price display with 10 major fiat currencies
- Bi-directional conversion (BTC ↔ Fiat)
- Responsive design with light and dark themes
- Shortcode implementation for easy integration
- Performance optimized with smart caching
- Internationalization support
- WordPress 6.8 compatibility
- PHP 7.4+ support

## Frequently Asked Questions

### How often are prices updated?
Prices are fetched in real-time from the CoinGecko API and cached for 60 seconds to ensure optimal performance.

### Can I customize the appearance?
Yes! The plugin includes CSS classes for custom styling and offers light/dark theme options via shortcode parameters.

### Does it work with caching plugins?
Yes, the plugin is designed to work seamlessly with popular caching plugins like WP Super Cache, W3 Total Cache, and WP Rocket.

### Is it mobile-friendly?
Absolutely! The converter is fully responsive and works perfectly on smartphones, tablets, and desktop computers.

### Can I use multiple converters on the same page?
Yes, you can use the shortcode multiple times on the same page with different configurations.

## Requirements

- **WordPress:** 5.0 or higher
- **PHP:** 7.4 or higher
- **Internet connection** for API access
- **Modern web browser** for optimal experience

## License

Bitcoin Price Converter is distributed under the [GPLv3 or later](https://www.gnu.org/licenses/gpl-3.0.html) license.

## Credits

Bitcoin Price Converter is developed and maintained by **VEINTIUNOw**. We especially appreciate:
- The WordPress community for their ongoing support
- CoinGecko for providing reliable Bitcoin price data
- Contributors who help improve the plugin

## Security

This plugin follows WordPress security best practices:
- Proper nonce verification for all AJAX requests
- Input sanitization and validation
- Secure API communication
- No sensitive data storage

## Privacy

The plugin respects user privacy:
- No personal data collection or storage
- No tracking or analytics
- Only fetches publicly available Bitcoin price data
- GDPR compliant

## Disclaimer

Bitcoin Price Converter is provided "as is" without any warranty. We are not responsible for any direct or indirect damage caused by using this plugin. Cryptocurrency prices are volatile and for informational purposes only.

## Screenshots

![Bitcoin Price Converter Widget - Light Theme](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter/blob/main/screenshot-1.png)
*Bitcoin Price Converter widget with light theme showing real-time BTC price*

![Bitcoin Price Converter Widget - Dark Theme](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter/blob/main/screenshot-2.png)
*Dark theme version perfect for modern websites*

![Currency Selection](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter/blob/main/screenshot-3.png)
*Easy currency selection with support for 10 major fiat currencies*

![Mobile Responsive Design](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter/blob/main/screenshot-4.png)
*Fully responsive design that works perfectly on mobile devices*
