$(function () {
    let $form = $('.test-questions form');
    let testTime = window.passTestCountDownMinutes || (5 * 60);
    testTime *= 60;
    testTime = window.localStorage.getItem('test-time-left') || testTime;

    let stopwatch = new Stopwatch({
        'element': $('#test-countdown'),    // DOM element
        'paused': false,                        // Status
        'elapsed': 999 * (testTime + 1),        // Current time in milliseconds
        'countingUp': false,                    // Counting up or down
        'timeLimit': 1000,                      // Time limit in milliseconds
        'updateRate': 1000,                     // Update rate, in milliseconds
        'onTimeUp': function () {                // onTimeUp callback
            console.log('Countdown finished!');
            this.stop();
            $form.submit();
        },
        'onTimeUpdate': function () {            // onTimeUpdate callback
            let t = this.elapsed,
                h = ('0' + Math.floor(t / 3600000)).slice(-2),
                m = ('0' + Math.floor(t % 3600000 / 60000)).slice(-2),
                s = ('0' + Math.floor(t % 60000 / 1000)).slice(-2);

            // save to local storage each 2 seconds
            if (s % 2 === 0) {
                window.localStorage.setItem('test-time-left', (t / 1000).toString());
            }

            let formattedTime = (+h * 60 + +m) + ':' + s;
            $(this.element).text(formattedTime);
        }
    });

    $form.submit(function (e) {
        // remove from local storage
        window.localStorage.removeItem('test-time-left');
    });


    stopwatch.element.show();
});
