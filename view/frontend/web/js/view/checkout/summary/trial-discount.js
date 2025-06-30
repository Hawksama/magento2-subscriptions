define([
    'ko',
    'Magento_Checkout/js/view/summary/abstract-total',
], function (
    ko,
    Component
) {
    var config = window.checkoutConfig.mollie.subscriptions;

    return Component.extend({
        defaults: {
            hasTrialProductInCart: ko.observable(config.has_trial_products_in_cart),
            product: ko.observable(config.trial.product),
            discount: ko.observable(config.trial.discount),
            shipping: ko.observable(config.trial.shipping),

            hasDiscount: ko.observable(config.trial.has_discount !== 0),
            hasShipping: ko.observable(config.trial.has_shipping !== 0),
        },

        getTotal() {
            return this.product() + this.discount() + this.shipping();
        },

        formattedProduct() {
            return this.getFormattedPrice(this.product());
        },

        formattedDiscount() {
            return this.getFormattedPrice(this.discount());
        },

        formattedShipping() {
            return this.getFormattedPrice(this.shipping());
        }
    })
})
