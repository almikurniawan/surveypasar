<!DOCTYPE html>
<html lang="en">

<head>
	<title>JALINMAS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/css/bootstrap.css"); ?>" />

	<link rel="stylesheet" href="<?= base_url("/assets/kendo/styles/kendo.common-bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/kendo/styles/kendo.blueopal.min.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/kendo/styles/kendo.blueopal.mobile.min.css") ?>" />
	
	<link rel="stylesheet" href="<?= base_url("/assets/testing.css"); ?>" />
    
	<script src="<?= base_url("/assets/kendo/js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("/assets/kendo/js/kendo.all.min.js") ?>"></script>
	<!-- <script src="<?= base_url("/assets/kendo/js/kendo.web.min.js") ?>"></script> -->
	<script src="<?= base_url("/assets/kendo/js/cultures/kendo.culture.id-ID.min.js") ?>"></script>

	<script src="<?= base_url("/assets/bootstrap/js/bootstrap.min.js") ?>"></script>
	<script src="<?= base_url("/assets/app.js") ?>"></script>
	<script>
		function confirm_delete(url, id, clb) {
			if (confirm("Yakin ingin menghapus data ini?")) {
				$.post(url, {
					'id': id
				}, function(result) {
					clb(result);
				}, 'json');
			}
		}

		// function formatNumber(num) {
		// 	let number = num ? ? 0;
		// 	if (isNaN(number)) {
		// 		number = 0;
		// 	}
		// 	return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
		// }

		function showForm(setWidth, setHeight, windowName, URL) {

			var w = window.screen.availWidth;
			var h = window.screen.availHeight;

			var leftPos = (w - setWidth) / 2,
				topPos = ((h - setHeight) / 2) - 50;
			setHeight += 50;
			eval(windowName + " = window.open('" + URL + "','" + windowName + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=" + setWidth + ",height=" + setHeight + ",left = " + leftPos + ",top = " + topPos + "');");
		}
	</script>

	<style>
		body {
			background-image: url(<?= base_url('/assets/images/bg.jpg') ?>);
			background-position: center center;
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment: fixed;
		}

		.bg-light {
			background-color: #4baca4 !important;
		}

		.navbar-light .navbar-brand,
		.navbar-light .navbar-brand:focus,
		.navbar-light .navbar-brand:hover {
			color: white !important;
			font-family: math;
			font-size: 18;
		}

		.navbar-light .navbar-nav .nav-link {
			color: white !important;
		}

		.dropdown-menu {
			color: white !important;
			background-color: #4baca4 !important;
		}

		.dropdown-item {
			color: #ffffff;
		}

		.dropdown-menu .dropdown-item.active,
		.dropdown-menu .dropdown-item:active {
			background-color: #4baca4 !important;
		}

		.material-icons {
			font-size: 20px;
			line-height: 0.75;
		}

		li.nav-item {
			padding-left: 15px;
			padding-right: 15px;
		}

		li.k-current-page {
			display: none;
		}

		.red {
			color: red;
		}

		.card{
			border: 0;
			border-radius: 1rem;
			box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
		}
	</style>
</head>

<body>
	<navigation class="fixed-top">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand ml-1" href="<?= base_url("") ?>"> <img src="https://i.pinimg.com/originals/c4/68/3d/c4683d13550e7919b6b2e95a9e14740c.png" width="30"/> JALINMAS</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			</div>
		</nav>
		<nav id="breadcrumb"></nav>
	</navigation>

	<div class="container mt-5 pt-5 mb-3">
		<?= $this->renderSection('content') ?>
	</div>
</body>

</html>