    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<div class="col-md-2">
						<a href=""><img src="./assets/images/logo-xrun-w.png" alt="xrun"></a>
					</div>
					<div class="col-md-10">
						<p>16 Raffles Quay #16-05 Hong Leong Building Singapore 048581<br>Copyright © 2019 XRUN PTE. LTD.  All Rights Reserved.</p>
					</div>
				</div>
			</div>
        </div>
		<div class="scrollToTop scroll-visible"><a href="#top"><i class="fas fa-chevron-up"></i></a></div>
    </footer>

    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="assets/scripts/bootstrap.min.js"></script>
    <script src="assets/scripts/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script>

        $('.navbar-toggle').click(function(e) {
            e.preventDefault()

            $('.xrun-nav-wrap').css({
                'visibility': 'visible',
                'opacity': '1'
            })

            $('.xrun-nav').css({
                'right': '0'
            })
        })

        $('.xrun-nav-close, .fake').click(function(e) {
            e.preventDefault()

            $('.xrun-nav').css({
                'right': '-100%'
            })

            setTimeout(function() {
                $('.xrun-nav-wrap').css({
                    'visibility': 'hidden',
                    'opacity': '0'
                })
            }, 300)
        })

        $('.xrun-nav-menu a').click(function(e) {
            e.preventDefault()

            $('.fake').click()
        })

        $('.icon_back').click(function(e) {
            e.preventDefault()

            var ref = document.referrer

            if ( ref == '' || ref.indexOf('xrun.run') == -1 ) {
                location.href = 'http://www.xrun.run/m/main.php'
            }

            history.back()
        })

    </script>
</body>
</html>