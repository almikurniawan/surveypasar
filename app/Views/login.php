<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Yayasan Bhakti Wiyata - Staff Daily Report">
	<meta name="author" content="Hartsimagineering.com">
	<link rel="icon" href="./images/favicon/favicon-16x16.png">

	<title>SURVEY PASAR</title>
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
	<script src="./assets/kendo2020/js/jquery.min.js"></script>
	<script src="./bootstrap4/js/bootstrap.min.js"></script>
	<style>
		:root {
			--input-padding-x: 1.5rem;
			--input-padding-y: .75rem;
		}

		body {
			background: #e91e63;
			background: linear-gradient(to right, #e91e63, #ff568e);
		}

		.card-signin {
			border: 0;
			border-radius: 1rem;
			box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
		}

		.card-signin .card-title {
			margin-bottom: 2rem;
			font-weight: 300;
			font-size: 1.5rem;
		}

		.card-signin .card-body {
			padding: 2rem;
		}

		.form-signin {
			width: 100%;
		}

		.form-signin .btn {
			font-size: 80%;
			border-radius: 5rem;
			letter-spacing: .1rem;
			font-weight: bold;
			padding: 1rem;
			transition: all 0.2s;
		}

		.form-label-group {
			position: relative;
			margin-bottom: 1rem;
		}

		.form-label-group input {
			height: auto;
			border-radius: 2rem;
		}

		.form-label-group>input,
		.form-label-group>label {
			padding: var(--input-padding-y) var(--input-padding-x);
		}

		.form-label-group>label {
			position: absolute;
			top: 0;
			left: 0;
			display: block;
			width: 100%;
			margin-bottom: 0;
			/* Override default `<label>` margin */
			line-height: 1.5;
			color: #495057;
			border: 1px solid transparent;
			border-radius: .25rem;
			transition: all .1s ease-in-out;
		}

		.form-label-group input::-webkit-input-placeholder {
			color: transparent;
		}

		.form-label-group input:-ms-input-placeholder {
			color: transparent;
		}

		.form-label-group input::-ms-input-placeholder {
			color: transparent;
		}

		.form-label-group input::-moz-placeholder {
			color: transparent;
		}

		.form-label-group input::placeholder {
			color: transparent;
		}

		.form-label-group input:not(:placeholder-shown) {
			padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
			padding-bottom: calc(var(--input-padding-y) / 3);
		}

		.form-label-group input:not(:placeholder-shown)~label {
			padding-top: calc(var(--input-padding-y) / 3);
			padding-bottom: calc(var(--input-padding-y) / 3);
			font-size: 12px;
			color: #777;
		}

		/* Fallback for Edge
-------------------------------------------------- */

		@supports (-ms-ime-align: auto) {
			.form-label-group>label {
				display: none;
			}

			.form-label-group input::-ms-input-placeholder {
				color: #777;
			}
		}

		/* Fallback for IE
-------------------------------------------------- */

		@media all and (-ms-high-contrast: none),
		(-ms-high-contrast: active) {
			.form-label-group>label {
				display: none;
			}

			.form-label-group input:-ms-input-placeholder {
				color: #777;
			}
		}
	</style>
</head>

<body class="text-center">
	<div class="container">
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
					<div class="card card-signin my-5">
						<div class="card-body">
							<div style="padding: 10px;">
								<h1 class="h3 mb-3 font-weight-normal">
									LOGIN SURVEY PASAR
								</h1>
							</div>
							<form class="form-signin text-left" method="post" action="<?= base_url("login/auth")?>">
								<div class="form-label-group">
									<input type="username" id="inputEmail" class="form-control" placeholder="Username" name="username" required autofocus>
									<label for="inputEmail">Username</label>
								</div>

								<div class="form-label-group">
									<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
									<label for="inputPassword">Password</label>
								</div>

								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customCheck1">
								</div>
								<button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<script>
	var htmlbutton = '<div class="row"><div class="col"><button type="button" class="btn btn-success" style="width:90%" onclick="goTelkom()">Via Jalur Telkom</button></div><div class="col"><button type="button" class="btn btn-success" style="width:90%" onclick="goBiznet()">Via Jalur Biznet</button></div></div>';

	function getButton() {
		$("#akseslambat").html(htmlbutton);
	}

	function goTelkom() {
		window.location.href = 'https://oasis.iik.ac.id:7444/sbsdev/';
	}

	function goBiznet() {
		window.location.href = 'http://srv1.iik.ac.id:2801/sbsdev/';
	}
</script>

</html>