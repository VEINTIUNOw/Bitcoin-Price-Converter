jQuery(document).ready(function($) {
    let currentPrice = 0;
    let currentCurrency = 'USD';
    let isUpdating = false;
    
    // Initialize the converter
    function initConverter() {
        const $widget = $('.bitcoin-converter-widget');
        if ($widget.length === 0) return;
        
        currentCurrency = $('#currency-select').val() || 'USD';
        updateBitcoinPrice();
        
        // Auto-refresh price every 60 seconds
        setInterval(updateBitcoinPrice, 60000);
        
        // Event listeners
        $('#currency-select').on('change', function() {
            currentCurrency = $(this).val();
            updateBitcoinPrice();
            clearInputs();
        });
        
        $('#refresh-price').on('click', function() {
            updateBitcoinPrice(true);
        });
        
        // Input event listeners for real-time conversion
        $('#btc-amount').on('input', function() {
            if (!isUpdating) {
                convertBtcToFiat();
            }
        });
        
        $('#fiat-amount').on('input', function() {
            if (!isUpdating) {
                convertFiatToBtc();
            }
        });
    }
    
    // Update Bitcoin price display
    function updateBitcoinPrice(force = false) {
        if (isUpdating && !force) return;
        
        isUpdating = true;
        const $priceDisplay = $('.current-price');
        const $refreshBtn = $('#refresh-price');
        
        if (!force) {
            $priceDisplay.text(bitcoin_converter_ajax.loading_text);
        }
        $refreshBtn.prop('disabled', true).text(bitcoin_converter_ajax.loading_text);
        
        $.ajax({
            url: bitcoin_converter_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_bitcoin_price',
                currency: currentCurrency,
                nonce: bitcoin_converter_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    currentPrice = response.data.price;
                    $priceDisplay.text(response.data.formatted_price);
                    $('.price-currency').text(response.data.currency);
                    
                    // Update conversions if inputs have values
                    if ($('#btc-amount').val()) {
                        convertBtcToFiat();
                    } else if ($('#fiat-amount').val()) {
                        convertFiatToBtc();
                    }
                } else {
                    $priceDisplay.text(bitcoin_converter_ajax.error_text);
                    console.error('Bitcoin price fetch error:', response.data);
                }
            },
            error: function(xhr, status, error) {
                $priceDisplay.text(bitcoin_converter_ajax.error_text);
                console.error('AJAX error:', error);
            },
            complete: function() {
                isUpdating = false;
                $refreshBtn.prop('disabled', false).text($refreshBtn.data('original-text') || 'Refresh Price');
            }
        });
    }
    
    // Convert Bitcoin to fiat currency
    function convertBtcToFiat() {
        const btcAmount = parseFloat($('#btc-amount').val());
        
        if (isNaN(btcAmount) || btcAmount <= 0) {
            $('#fiat-amount').val('');
            return;
        }
        
        if (currentPrice > 0) {
            const fiatAmount = btcAmount * currentPrice;
            $('#fiat-amount').val(fiatAmount.toFixed(2));
        } else {
            // If no current price, fetch it
            $.ajax({
                url: bitcoin_converter_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'convert_bitcoin',
                    amount: btcAmount,
                    currency: currentCurrency,
                    type: 'btc_to_fiat',
                    nonce: bitcoin_converter_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('#fiat-amount').val(parseFloat(response.data.result).toFixed(2));
                    }
                }
            });
        }
    }
    
    // Convert fiat currency to Bitcoin
    function convertFiatToBtc() {
        const fiatAmount = parseFloat($('#fiat-amount').val());
        
        if (isNaN(fiatAmount) || fiatAmount <= 0) {
            $('#btc-amount').val('');
            return;
        }
        
        if (currentPrice > 0) {
            const btcAmount = fiatAmount / currentPrice;
            $('#btc-amount').val(btcAmount.toFixed(8));
        } else {
            // If no current price, fetch it
            $.ajax({
                url: bitcoin_converter_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'convert_bitcoin',
                    amount: fiatAmount,
                    currency: currentCurrency,
                    type: 'fiat_to_btc',
                    nonce: bitcoin_converter_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('#btc-amount').val(parseFloat(response.data.result).toFixed(8));
                    }
                }
            });
        }
    }
    
    // Clear input fields
    function clearInputs() {
        $('#btc-amount').val('');
        $('#fiat-amount').val('');
    }
    
    // Format number with commas
    function formatNumber(num, decimals = 2) {
        return num.toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    // Store original button text
    $('#refresh-price').data('original-text', $('#refresh-price').text());
    
    // Initialize when DOM is ready
    initConverter();
    
    // Handle dynamic content loading
    $(document).on('DOMContentLoaded', function() {
        initConverter();
    });
    
    // Handle AJAX content loading
    $(document).ajaxComplete(function() {
        if ($('.bitcoin-converter-widget').length > 0) {
            setTimeout(initConverter, 100);
        }
    });
});

// Vanilla JavaScript fallback for non-jQuery environments
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery === 'undefined' && document.querySelector('.bitcoin-converter-widget')) {
        console.warn('Bitcoin Price Converter: jQuery is required for full functionality');
    }
});
