define([
    'jquery',
    'TYPO3/CMS/Backend/ModuleMenu',
    'TYPO3/CMS/Backend/Notification',
    'TYPO3/CMS/Backend/ActionButton/ImmediateAction'
    ],
    function($, ModuleMenu, Notification, ImmediateAction) {
    var Module = {};

    /**
     *
     */
    Module.initialize = function() {
    }

    /**
     *
     */
    Module.ajax = function(url, data, callback) {
        $.ajax({
            url: url,
            method: 'GET',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data,
            success: function(data, textStatus, jqXHR) {
                console.log(data);
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
            complete: function(jqXHR, status) {
                // status: "success", "notmodified", "nocontent", "error", "timeout", "abort", or "parsererror"
                Module.loading(false);
            }
        });
    }

    /**
     *
     */
    Module.loading = function(show) {
        if (show === true) {
            $('a.btn.flush-cloudfront-cache img').addClass('d-none');
            $('a.btn.flush-cloudfront-cache span.icon-markup').addClass('loading');
        } else {
            $('a.btn.flush-cloudfront-cache span.icon-markup').removeClass('loading');
            $('a.btn.flush-cloudfront-cache img').removeClass('d-none');
        }
    };

    /**
     *
     */
    $(document).ready(function() {
        Module.initialize();

        // clear cache actions (top bar)
        $('a.toolbar-cache-flush-action[href*=cloudfront]').click(function(event) {
            event.preventDefault();
            console.log('toolbar-cache-flush-action');

            // close "clear cache" menu
            //$('#typo3-cms-backend-backend-toolbaritems-clearcachetoolbaritem a.dropdown-toggle').click();
            //bootstrap.Dropdown(element, ...);

            const immediateActionCallback = new ImmediateAction(function () {
                // Uncaught (in promise) TypeError: ModuleMenu.showModule is not a function
                //ModuleMenu.showModule('web_layout');
            });

            Notification.info('Clean CDN Caches', 'Are you sure that you want to clear the CDN caches of all sites?', 10, [
                {
                    label: 'CANCEL',
                    action: null
                },
                {
                    label: 'YES',
                    action: immediateActionCallback
                }
            ]);

            return false;
        });

        // button bar (in page module)
        $('a.btn.flush-cloudfront-cache').click(function(event) {
            event.preventDefault();
            Module.loading(true);
            var pageId = 'pageId=' + $(this).data('pageid');
            Module.ajax(TYPO3.settings.ajaxUrls['cloudfront_clear_page_cache'], pageId);
        });
    });
});
