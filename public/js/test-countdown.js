$(function () {
    let $form = $('.test-questions form');
    let testTime = window.passTestCountDownMinutes || 10;
    let testId = window.passTestId || 1;

    if (!(window.performance && performance.navigation.type === 1)) {
        // This page is not reloaded (first load)
        clearTime(); // user start test from scratch
    }

    testTime *= 60; // convert into seconds
    testTime = window.localStorage.getItem(`test-time-left-${testId}`) || testTime;

    let stopwatch = new Stopwatch({
        'element': $('#test-countdown'),    // DOM element
        'paused': false,                        // Status
        'elapsed': 999 * (testTime + 1),        // Current time in milliseconds
        'countingUp': false,                    // Counting up or down
        'timeLimit': 1000,                      // Time limit in milliseconds
        'updateRate': 1000,                     // Update rate, in milliseconds
        'onTimeUp': function () {                // onTimeUp callback
            // Countdown finished
            this.stop();
            $form.submit();
        },
        'onTimeUpdate': function () {            // onTimeUpdate callback
            let t = this.elapsed,
                h = ('0' + Math.floor(t / 3600000)).slice(-2),
                m = ('0' + Math.floor(t % 3600000 / 60000)).slice(-2),
                s = ('0' + Math.floor(t % 60000 / 1000)).slice(-2);

            // save to local storage each second
            saveTime(t / 1000 - 3); // minus 3 second to reload page

            let formattedTime = (+h * 60 + +m) + ':' + s;
            $(this.element).text(formattedTime);
        }
    });

    $form.submit(function (e) {
        // remove from local storage
        clearTime();
    });

    stopwatch.element.show();

    // when switch tab, need delete time from storage
    window.closeWhenSwitchedTabsConfigOnClose = function () {
        clearTime();
    };

    // used functions
    function saveTime(time) {
        window.localStorage.setItem(`test-time-left-${testId}`, time.toString());
    }

    function clearTime() {
        window.localStorage.removeItem(`test-time-left-${testId}`);
    }
});
