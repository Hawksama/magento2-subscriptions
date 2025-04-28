define([
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/totals',
    'Mollie_Subscriptions/js/view/checkout/summary/trial-discount',
], function (
    quote,
    totals,
    TrialDiscount,
) {
    'use strict';

    return function (grandTotal) {
        return grandTotal.extend({
            totals: quote.getTotals(),

            getValue: function () {
                var price = 0;

                if (this.totals()) {
                    price = totals.getSegment('grand_total').value;
                }

                if (TrialDiscount().hasTrialProductInCart()) {
                    price += TrialDiscount().getTotal();
                }

                return this.getFormattedPrice(price);
            },
        });
    }
});
