!
function ($) {

    $(function () {

        $(document).ready(function () {
            $('#showSmileys').toggle(function () {
                $('#smileys').slideDown();
            }, function () {
                $('#smileys').slideUp();
            });
        });

        function updateCountdown() {
            var remaining = 500 - $('#shout').val().length;
            $('#charcount').html(remaining);
        }
        $(document).ready(function ($) {
            updateCountdown();
            $('#shout').change(updateCountdown);
            $('#shout').keyup(updateCountdown);
            $('#shout').focus(updateCountdown);
        });

        // Auto reload #shoutbox if user's idle (no activity) for 5 minutes
        var activityTimeout = setTimeout(inActive, 300000);
        function resetActive() {
            //$(document.body).attr('class', 'active');
            clearTimeout(activityTimeout);
            activityTimeout = setTimeout(inActive, 300000);
        }
        function inActive() {
            //$(document.body).attr('class', 'inactive');
            $('#shoutbox-reload').load('get_shouts.php?randval=' + Math.random());
            $('#shoutbox-reload-sr').load('get_shouts_sr.php?randval=' + Math.random());
            $('#shoutbox-reload-gc').load('get_shouts_gc.php?randval=' + Math.random());
            clearTimeout(activityTimeout);
            activityTimeout = setTimeout(inActive, 300000);
        }
        // auto reload to refresh users online counter for each 10 minutes
        var userOnline = setTimeout(xActive, 600000);
        function xActive() {
            $('#active-user').load('active_user.php?randval=' + Math.random());
            clearTimeout(userOnline);
            userOnline = setTimeout(xActive, 600000);
        }
        // check for idle action
        $(document).bind('mousemove keypress', function () {
            resetActive()
        });
        
        // auto reload sharerlink for every 5 minutes
        var sharerlinkReload = setTimeout(sharerlinkGo, 300000);
        function sharerlinkGo() {
            $('#sharerlink-reload').load('sharerlink.php?randval=' + Math.random());
            clearTimeout(sharerlinkReload);
            sharerlinkReload = setTimeout(sharerlinkGo, 300000);
        }
        
        var latestUpdReload = setTimeout(latestUpdGo, 300000);
        function latestUpdGo() {
            $('#latest-updates').load('latest_updates.php?randval=' + Math.random());
            clearTimeout(latestUpdReload);
            latestUpdReload = setTimeout(latestUpdGo, 300000);
        }
        
        var latestReqReload = setTimeout(latestReqGo, 300000);
        function latestReqGo() {
            $('#latest-requests').load('latest_requests.php?randval=' + Math.random());
            clearTimeout(latestReqReload);
            latestReqReload = setTimeout(latestReqGo, 300000);
        }

        // Disable certain links in docs
        $('section [href^=#]').click(function (e) {
            e.preventDefault()
        })

        // make code pretty
        window.prettyPrint && prettyPrint()

        // add-ons
        $('.add-on :checkbox').on('click', function () {
            var $this = $(this),
                method = $this.attr('checked') ? 'addClass' : 'removeClass'
            $(this).parents('.add-on')[method]('active')
        })

        // fix sub nav on scroll
        var $win = $(window),
            $nav = $('.subnav'),
            navTop = $('.subnav').length && $('.subnav').offset().top - 40,
            isFixed = 0

            processScroll()

            // hack sad times - holdover until rewrite for 2.1
            $nav.on('click', function () {
                if (!isFixed) setTimeout(function () {
                    $win.scrollTop($win.scrollTop() - 47)
                }, 10)
            })

            $win.on('scroll', processScroll)

            function processScroll() {
                var i, scrollTop = $win.scrollTop()
                if (scrollTop >= navTop && !isFixed) {
                    isFixed = 1
                    $nav.addClass('subnav-fixed')
                } else if (scrollTop <= navTop && isFixed) {
                    isFixed = 0
                    $nav.removeClass('subnav-fixed')
                }
            }

        $('.popover-register').popover()
        $('.sharer-desc').popover({
            placement: 'left'
        })
        $('.rankno, .info-tip, .nav-tip, a.fnote-tip').tooltip()
        $('.regtip').tooltip({
            trigger: "focus",
            placement: "right"
        })
        $('.regtip-info, .arc-btn-tip, .UfS-showTime-tip, .actip, .outip').tooltip({
            placement: "right"
        })
        $('.smileys img, .fpass, .onionClub img, .tuzkiClub img').tooltip({
            placement: "bottom"
        })
        $('.showSmileys, .showOnions, .showTuzki').tooltip({
            placement: "left"
        })
        
        $('#showOnions').click(function () {
            $('#onionClub').modal('show')
        })
        
        $('#showTuzki').click(function () {
            $('#tuzkiClub').modal('show')
        })
        
        $('#tos').click(function () {
            $('#disclaimer').modal('show')
        })

        // button state demo
        $('#fat-btn').click(function () {
            var btn = $(this)
            btn.button('loading')
            setTimeout(function () {
                btn.button('reset')
            }, 3000)
        })

        // carousel demo
        $('#myCarousel').carousel()
        
        $('#js-news').ticker()
        
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })

    })

    // Modified from the original jsonpi https://github.com/benvinegar/jquery-jsonpi
    $.ajaxTransport('jsonpi', function (opts, originalOptions, jqXHR) {
        var url = opts.url;

        return {
            send: function (_, completeCallback) {
                var name = 'jQuery_iframe_' + jQuery.now(),
                    iframe, form

                    iframe = $('<iframe>').attr('name', name).appendTo('head')

                    form = $('<form>').attr('method', opts.type) // GET or POST
                    .attr('action', url).attr('target', name)

                    $.each(opts.params, function (k, v) {

                        $('<input>').attr('type', 'hidden').attr('name', k).attr('value', typeof v == 'string' ? v : JSON.stringify(v)).appendTo(form)
                    })

                    form.appendTo('body').submit()
            }
        }
    })

}(window.jQuery)