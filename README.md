# Bitcoin Price Converter

## Description
Converts WooCommerce product prices to Bitcoin using real-time exchange rates. This plugin allows customers to view prices in Bitcoin with the preselected Satoshi denomination.

- **Source code on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter)**
- **Demo on [site](https://veintiuno.BTC.pub/m/digitales/bitcoin-price-co%E2%80%A6ocommerce-plugin/)**
- **Donate** sats or contribute from https://VEINTIUNO.btc.pub/participa/#patrocinador


## Contributing

Bitcoin Price Converter is an open-source project, and we welcome contributions from the community. You can find the plugin's source code on [GitHub](https://github.com/VEINTIUNOw/Bitcoin-Price-Converter). 



## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Customization](#customization)
- [Contributing](#contributing)
- [License](#license)

## Features

- Displays product prices in Bitcoin (BTC) or Satoshi.
- Uses Font Awesome icons for a better visual representation.
- Supports dynamic exchange rate fetching from CoinGecko API.
- Formats prices with comma separators for better readability.
- Displays prices in satoshi on cart, checkout, and order pages.

## Installation

1. **Upload the Plugin:**
   - Download the plugin zip file from the [releases](https://github.com/yourusername/woocommerce-btc-prices/releases) page.
   - Go to your WordPress admin dashboard.
   - Navigate to `Plugins > Add New > Upload Plugin`.
   - Choose the downloaded zip file and click `Install Now`.
   - Activate the plugin.

2. **Manual Installation:**
   - Download the plugin zip file from the [releases](https://github.com/yourusername/woocommerce-btc-prices/releases) page.
   - Extract the zip file.
   - Upload the extracted folder to the `wp-content/plugins/` directory of your WordPress installation.
   - Go to your WordPress admin dashboard.
   - Navigate to `Plugins` and activate the `WooCommerce BTC Prices` plugin.

## Usage

1. **Activate the Plugin:**
   - Once installed, activate the `WooCommerce BTC Prices` plugin from the WordPress admin dashboard.

2. **View Prices in BTC/Satoshi:**
   - After activation, product prices on your WooCommerce store will be displayed in Bitcoin (BTC) or Satoshi.
   - Prices on the cart, checkout, and order pages will also be displayed in satoshi.

3. **Customize the Exchange Rate:**
   - The plugin fetches the exchange rate from the CoinGecko API every hour. If you want to change the frequency or use a different API, you can modify the `woocommerce_btc_get_exchange_rate` function in the plugin file.

## Customization

- **Change the Font Awesome Icon:**
  - To change the Font Awesome icon, modify the `woocommerce_btc_currency_symbol` function in the plugin file. Update the icon class as needed.

- **Custom Exchange Rate API:**
  - If you want to use a different API for the exchange rate, modify the `woocommerce_btc_get_exchange_rate` function to fetch data from your preferred API.

- **Format Adjustments:**
  - You can adjust the price formatting by modifying the `wc_price` function calls in the plugin. Change the `thousand_separator`, `decimal_separator`, and `decimals` parameters as needed.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues for bugs, feature requests, or improvements.

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch-name`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin feature-branch-name`.
5. Submit a pull request.

## License

This plugin is licensed under the [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.html).

## Support

For support, please open an issue on the [GitHub issues page](https://github.com/yourusername/woocommerce-btc-prices/issues).


## Donations

If you appreciate the work we put into developing and maintaining this plugin, you can support us:
- **Bitcoin donations:** https://VEINTIUNO.btc.pub/participa/#patrocinador
- **Geyser Fund:** https://geyser.fund/project/bitcoinpriceconverterwordpressplugin

## Follow Us

Stay updated with the latest developments:
- **X (Twitter):** [@VEINTIUNOw](https://twitter.com/VEINTIUNOw)
- **Nostr:** [snort.social/21](https://snort.social/21)
- **Website:** [VEINTIUNO.btc.pub](https://VEINTIUNO.btc.pub)

---

Feel free to customize this README further to fit your specific needs and preferences.
