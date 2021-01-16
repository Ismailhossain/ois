<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('meta')

    <title>
        @section('title')
            OIS
        @show
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery.validate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
    <link href="assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">


<!-- Custom Notifications -->
    <link href="assets/css/jquery.noty.css" rel="stylesheet" type="text/css">
    <link href="assets/css/noty_theme_default.css" rel="stylesheet" type="text/css">
    <link href="assets/css/noty_theme_twitter.css" rel="stylesheet" type="text/css">

    <!-- Ui Dialog CSS -->

    <link href="assets/css/jquery-confirm.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css">


<!-- End of Ui Dialog CSS -->

    <!-- Colorbox CSS -->
    <link href="assets/css/colorbox.css" rel="stylesheet" type="text/css">


<!-- End of Colorbox CSS -->


    @yield('styles')
<!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->

    <script src="assets/js/respond.min.js"></script>
    <script src="assets/js/html5shiv.js"></script>



<!-- jQuery -->

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery.validate.js"></script>
    <script src="assets/js/jquery.validation.functions.js"></script>



<!-- Bootstrap Core JavaScript -->

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>


<!-- Menu Toggle Script -->

    <!-- Custom Notifications -->
    <script src="assets/js/jquery.noty.js"></script>


    <!-- Ui Dialog JS -->
    <script src="assets/js/jquery-confirm.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>

<!-- End of Ui Dialog JS -->


    <!-- Colorbox JS -->
    <script src="assets/js/jquery.colorbox-min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
<!-- End of Colorbox JS -->


    <!-- Ajax File upload -->
    <script src="assets/js/rajax.js"></script>

<!-- End of Ajax File upload -->

    @yield('script')

    <script>
		$("#menu-toggle").click(function (e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});

		// To Display Multiple Modal

		$(document).on('show.bs.modal', '.modal', function (event) {
			var zIndex = 1040 + (10 * $('.modal:visible').length);
			$(this).css('z-index', zIndex);
			setTimeout(function () {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		});


		// End of Display Multiple Modal
    </script>


</head>




