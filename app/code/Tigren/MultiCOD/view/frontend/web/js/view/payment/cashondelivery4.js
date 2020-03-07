/*
 * Copyright (c) 2017 www.tigren.com
 */

define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component,
              rendererList) {
        'use strict';
        rendererList.push(

            {
                type: 'cashondelivery4',
                component: 'Tigren_MultiCOD/js/view/payment/method-renderer/cashondelivery4-method'
            }
        );
        return Component.extend({});
    }
);