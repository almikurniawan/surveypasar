<!DOCTYPE html>
<html lang="en">

<head>
	<title>SISKAPERBAKO</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url("/assets/material.css"); ?>" />


	<script src="<?= base_url("/assets/kendo/js/jquery.min.js") ?>"></script>
	<script src="<?= base_url("/assets/kendo/js/kendo.web.min.js") ?>"></script>
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
		.bg-light {
			background-color: #e91e63 !important;
		}

		.navbar-light .navbar-brand,
		.navbar-light .navbar-brand:focus,
		.navbar-light .navbar-brand:hover {
			color: white !important;
		}

		.navbar-light .navbar-nav .nav-link {
			color: white !important;
		}

		.dropdown-menu {
			color: white !important;
			background-color: #e91e63 !important;
		}

		.dropdown-item {
			color: #ffffff;
		}

		.dropdown-menu .dropdown-item.active,
		.dropdown-menu .dropdown-item:active {
			background-color: #e91e63 !important;
		}

		.material-icons {
			font-size: 20px;
			line-height: 0.75;
		}

		li.nav-item {
			padding-left: 15px;
			padding-right: 15px;
		}

		li.k-current-page{
			display: none;
		}

		.red{
			color: red;
		}
	</style>
</head>

<body>
	<navigation class="fixed-top">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand ml-1" href="<?= base_url("admin") ?>"> SISKAPERBAPO</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<?= view_cell('\App\Libraries\Navigation::menu') ?>
			</div>
		</nav>
		<nav id="breadcrumb"></nav>
	</navigation>
	<div class="container mt-5 pt-5 mb-3">
		<?= $this->renderSection('content') ?>
	</div>
</body>

</html>