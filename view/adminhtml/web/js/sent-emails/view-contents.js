/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html'
        },

        viewContents: function () {
            alert('hi');
        },

        /**
         * Returns element's value.
         *
         * @param {Object} row
         * @return {*}
         */
        getLabel: function (row) {
            return '<a href="#" data-bind="click: viewContents">View Contents</a>'; // this._super(row);
        }
    });
});
