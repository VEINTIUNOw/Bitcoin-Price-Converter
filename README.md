# Bitcoin Price Converter

**Contributors:** VEINTIUNOw  
**Donate link:** https://VEINTIUNO.btc.pub/participa/#patrocinador  
**Tags:** bitcoin, cryptocurrency, price converter, widget, shortcode, btc converter, bitcoin price  
**Requires at least:** 5.0  
**Tested up to:** 6.8  
**Stable tag:** 1.0.0  
**Requires PHP:** 7.4  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  
**Version:** 1.0.0  

## Description

A simple and elegant Bitcoin price converter widget that displays current Bitcoin prices and allows conversion between BTC and various fiat currencies. Perfect for cryptocurrency blogs, financial websites, or any site that needs to display Bitcoin pricing information.

Unlike WooCommerce-specific converters, this plugin provides a universal Bitcoin price display widget that can be used anywhere on your WordPress site with a simple shortcode.

**Source code on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter)**  
**Demo on [site](https://veintiuno.BTC.pub/m/digitales/bitcoin-price-converter-wordpress-plugin/)**  
**Donate sats or contribute from https://VEINTIUNO.btc.pub/participa/#patrocinador**

## Features

- **Real-time Bitcoin Price Display:** Shows current Bitcoin prices using reliable API sources
- **Multi-Currency Support:** Convert between Bitcoin and 10 major fiat currencies
- **Bi-directional Conversion:** Convert from Bitcoin to fiat and vice versa
- **Responsive Design:** Works perfectly on desktop, tablet, and mobile devices
- **Customizable Themes:** Choose between light and dark themes
- **Easy Integration:** Simple shortcode implementation - just add `[bitcoin_converter]` anywhere
- **Performance Optimized:** Smart caching system prevents API overload
- **Internationalization Ready:** All strings are translatable
- **Accessibility Compliant:** Proper ARIA labels and keyboard navigation support

## Supported Currencies

- **USD** - US Dollar
- **EUR** - Euro
- **GBP** - British Pound
- **JPY** - Japanese Yen
- **CAD** - Canadian Dollar
- **AUD** - Australian Dollar
- **CHF** - Swiss Franc
- **CNY** - Chinese Yuan
- **INR** - Indian Rupee
- **BRL** - Brazilian Real

## Installation

1. Upload the `bitcoin-price-converter` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[bitcoin_converter]` in your posts, pages, or widgets to display the converter.

## Usage

### Basic Shortcode
```
[bitcoin_converter]
```

### With Custom Default Currency
```
[bitcoin_converter default_currency="EUR"]
```

### With Dark Theme
```
[bitcoin_converter theme="dark"]
```

### Full Customization
```
[bitcoin_converter default_currency="GBP" theme="dark"]
```

### Shortcode Parameters

- **default_currency**: Set the default currency (default: USD)
  - Available options: USD, EUR, GBP, JPY, CAD, AUD, CHF, CNY, INR, BRL
- **theme**: Set the visual theme (default: light)
  - Available options: light, dark

## Plugin Features

### Real-time Price Updates
- Prices are automatically updated every 60 seconds
- Uses the reliable CoinGecko API for accurate pricing data
- Smart caching system reduces API calls and improves performance

### User-Friendly Interface
- Clean, intuitive design that matches most WordPress themes
- Responsive layout that works on all screen sizes
- Smooth animations and transitions for better user experience

### Performance Optimized
- Minimal resource usage with efficient caching
- Only loads JavaScript and CSS when the widget is displayed
- Optimized API calls with proper error handling

## Technical Specifications

- **WordPress Version:** 5.0 or higher
- **PHP Version:** 7.4 or higher
- **Browser Support:** All modern browsers including IE11+
- **API Source:** CoinGecko API (free tier)
- **Update Frequency:** Every 60 seconds with caching
- **File Size:** Less than 50KB total

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

## Reviews

If you find Bitcoin Price Converter helpful, consider leaving a positive review on the [WordPress Plugin Page](https://wordpress.org/plugins/bitcoin-price-converter) to help others discover the plugin.

## Donations

If you appreciate the work we put into developing and maintaining this plugin, you can support us:
- **Bitcoin donations:** https://VEINTIUNO.btc.pub/participa/#patrocinador
- **Geyser Fund:** [Bitcoin Price Converter Project](https://geyser.fund/project/bitcoinpriceconverterwordpressplugin)

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
