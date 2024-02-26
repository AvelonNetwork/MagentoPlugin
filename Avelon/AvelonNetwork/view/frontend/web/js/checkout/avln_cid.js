define(
    [
        'ko',
        'jquery',
        'uiComponent',
        'mage/url'
    ],
    function (ko, $, Component, url) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Avelon_AvelonNetwork/checkout/avlnCid'
            },
            avlnCid: ko.observable(false),

            /**
             * Initialize component
             */
            initialize: function () {
                this._super();
                this.updateAvlnCid();
            },

            /**
             * Update avlnCid with the value from the cookie
             */
            updateAvlnCid: function () {
                var avlnCidCookie = $.cookie('avln_cid');
                if (avlnCidCookie) {
                    this.avlnCid(avlnCidCookie);
                    console.log('avlnCid updated:', avlnCidCookie);
                    this.sendAvlnCidToServer(avlnCidCookie); // Send the value to the server
                }
            },

            /**
             * Send avlnCid value to the server via AJAX
             * @param {string} value 
             */
            sendAvlnCidToServer: function (value) {
                var linkUrls = url.build('module/checkout/saveInQuote');
                $.ajax({
                    showLoader: true,
                    url: linkUrls,
                    data: { avlnCid: value },
                    type: "POST",
                    dataType: 'json'
                }).done(function (data) {
                    console.log('success');
                });
            }
        });
    }
);
