/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

import $ from 'jquery';
import Notification from "@typo3/backend/notification.js";

$(function() {

    /**
     * Execute an Ajax call
     */
    jQuery.fn.ajax = function(url, data, callback) {
        $.ajax({
            url: url,
            method: 'GET',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data,
            success: function(data, textStatus, jqXHR) {
                //console.log(data);
                if (data.success === true) {
                    if (callback) {
                        console.log('callback');
                        callback(data);
                    } else {
                        Notification.success(data.message);
                    }
                } else {
                    Notification.error(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Notification.error('Error', textStatus);
            },
            complete: function(jqXHR, status) {
                // status: "success", "notmodified", "nocontent", "error", "timeout", "abort", or "parsererror"
                $().loading(false);
            }
        });
    }

    /**
     * Show/hide "loading" spinner
     */
    jQuery.fn.loading = function(show) {
        if (show === true) {
            $('a.btn.flush-cloudfront-cache img').addClass('d-none');
            $('a.btn.flush-cloudfront-cache span.icon-markup').addClass('loading');
        } else {
            $('a.btn.flush-cloudfront-cache span.icon-markup').removeClass('loading');
            $('a.btn.flush-cloudfront-cache img').removeClass('d-none');
        }
    };

    /**
     * Click on "flush cache" button (button bar)
     */
    $('a.btn.flush-cloudfront-cache').click(function(event) {
        event.preventDefault();
        $().loading(true);
        var pageId = 'pageId=' + $(this).data('pageid');
        $().ajax(TYPO3.settings.ajaxUrls['cloudfront_clear_page_cache'], pageId);
    });

});
