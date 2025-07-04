/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Mollie_Payment/js/view/payment/method-renderer': {
                'Mollie_Subscriptions/js/view/payment/method-renderer-mixin': true
            },

            'Magento_Tax/js/view/checkout/summary/grand-total': {
                'Mollie_Subscriptions/js/view/checkout/summary/grand-total-mixin': true
            }
        }
    }
};

