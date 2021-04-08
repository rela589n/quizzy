$(function () {
    let $form = $('.test-questions form');
    let testTime = window.passTestCountDownSeconds || 10 * 60;

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

            let formattedTime = (+h * 60 + +m) + ':' + s;
            $(this.element).text(formattedTime);
        }
    });

    stopwatch.element.show();

    // when switch tab, need delete time from storage
    window.closeWhenSwitchedTabsConfigOnClose = async function () {
        console.log('closeWhenSwitchedTabsConfigOnClose');

        await $.post(`/tests/${currentSubject.uri_alias}/${currentTest.uri_alias}/cancel`,
            {
                _token: $form.find('[name=_token]').val(),
            }
        );

        $form.trigger('reset');
    };
});
