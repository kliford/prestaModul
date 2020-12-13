(function ($) {
    $.fn.countTo = function (options) {
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.to - options.from) / loops;

        return $(this).each(function () {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                $(_this).html(value.toFixed(options.decimals));

                if (typeof (options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof (options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,
        to: 100,
        speed: 1000,
        refreshInterval: 100,
        decimals: 0,
        onUpdate: null,
        onComplete: null,
    };
})(jQuery);

jQuery(function ($) {
    function containerWidth() {
        let parrentContainer = $('.container-modul-page');
        let widthChild = parrentContainer.find('.contentPage').width();
        parrentContainer.find('.sectionPage').css('width', widthChild + 2);
    }
    containerWidth();
    let blNumbPaid = $('.number-span-paid');
    blNumbPaid.each(function (index, value) {
        let valueNum = $(this).text();
        $(this).countTo({
            from: 0,
            to: valueNum,
            speed: 3000,
            refreshInterval: 50,
            decimals: 2,
        });
    });
    let blNumb = $('.number-span');
    blNumb.each(function (index, value) {
        let valueNum = $(this).text();
        $(this).countTo({
            from: 0,
            to: valueNum,
            speed: 3000,
            refreshInterval: 50,
        });
    });
});
