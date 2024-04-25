<!DOCTYPE html>
<html lang="en">
<?php
$companyInfo = $this->db->query("select * from tbl_company c order by c.Company_SlNo desc limit 1")->row();
?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $companyInfo->Company_Name; ?> || Login Page</title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>uploads/favicon.png">
	<link rel="stylesheet" type="text/css" href="/assets/login/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/login/css/style.css">

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			overflow: hidden;
		}

		section {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100vh;
			background: url("/assets/login/img/bg2.jpg");
			background-size: cover;
			/* animation: animateBg 50s linear infinite; */
		}

		@keyframes animateBg {

			0%,
			100% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.2);
			}
		}

		span {
			position: absolute;
			top: 50%;
			left: 50%;
			width: 4px;
			height: 4px;
			background: #fff;
			border-radius: 50%;
			box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1), 0 0 0 8px rgba(255, 255, 255, 0.1), 0 0 20px rgba(255, 255, 255, 0.1);
			animation: animate 3s linear infinite;
		}

		span::before {
			content: '';
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			width: 300px;
			height: 1px;
			background: linear-gradient(90deg, #fff, transparent);
		}

		@keyframes animate {
			0% {
				transform: rotate(315deg) translateX(0);
				opacity: 1;
			}

			70% {
				opacity: 1;
			}

			100% {
				transform: rotate(315deg) translateX(-1000px);
				opacity: 0;
			}
		}

		span:nth-child(1) {
			top: 0;
			right: 0;
			left: initial;
			animation-delay: 0s;
			animation-duration: 1s;
		}

		span:nth-child(2) {
			top: 0;
			right: 80px;
			left: initial;
			animation-delay: 0.2s;
			animation-duration: 3s;
		}

		span:nth-child(3) {
			top: 80;
			right: 0px;
			left: initial;
			animation-delay: 0.4s;
			animation-duration: 2s;
		}

		span:nth-child(4) {
			top: 0;
			right: 180px;
			left: initial;
			animation-delay: 0.6s;
			animation-duration: 1.5s;
		}

		span:nth-child(5) {
			top: 0;
			right: 400px;
			left: initial;
			animation-delay: 0.8s;
			animation-duration: 2.5s;
		}

		span:nth-child(6) {
			top: 0;
			right: 600px;
			left: initial;
			animation-delay: 1s;
			animation-duration: 3s;
		}

		span:nth-child(7) {
			top: 300px;
			right: 0px;
			left: initial;
			animation-delay: 1.2s;
			animation-duration: 1.75s;
		}

		span:nth-child(8) {
			top: 0px;
			right: 700px;
			left: initial;
			animation-delay: 1.4s;
			animation-duration: 1.25s;
		}

		span:nth-child(9) {
			top: 0px;
			right: 1000px;
			left: initial;
			animation-delay: 0.75s;
			animation-duration: 2.25s;
		}

		span:nth-child(9) {
			top: 0px;
			right: 450px;
			left: initial;
			animation-delay: 2.75s;
			animation-duration: 2.75s;
		}

		.login-form {
			padding: 60px 55px;
			min-height: 400px;
		}

		@media only screen and (min-width: 300px) {
			.login {
				width: 95%;
			}

			.login-form h4 {
				font-size: 20px;
			}
		}

		@media only screen and (min-width: 600px) {
			.right-cont {
				min-height: 313px !important;
			}

			.login-form {
				padding: 60px 55px;
				min-height: 400px;
			}
		}

		@media only screen and (min-width: 1000px) {
			.login {
				width: 55%;
			}

			.headding {
				top: 50px;
			}
		}

		@media only screen and (min-width: 1200px) {
			.login {
				width: 55%;
				top: 50%;
			}

			.headding {
				top: 50px;
			}
		}

		@media only screen and (min-width: 1400px) {
			.login {
				width: 40%;
				top: 50%;
			}

			.headding {
				top: 115px;
			}
		}
	</style>
</head>

<body>
	<section>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>


		<div class="content">
			<h2 class="headding">
				<p id="typed"></p>
			</h2>
			<div class="login">
				<div class="left-cont">
					<div class="company-feature">
						<div class="com-image">
							<?php if ($companyInfo->Company_Logo_thum == "") { ?>
								<img src="/assets/login/img/images.jpg" style="width: 100%;height: 125px; border-radius: 25px;padding-top: 5px;">
							<?php } else { ?>
								<img src="/uploads/company_profile_org/<?php echo $companyInfo->Company_Logo_thum; ?>" style="width: 100%;height: 125px; border-radius: 25px;padding-top: 5px;">
							<?php } ?>
						</div>

					</div>
					<!-- </div> -->
					<div class="company-info">
						<h4>
							<?php echo $companyInfo->Company_Name; ?>
						</h4>
						<div class="com-add">
							<div class="com-profile">
								<strong>Address</strong> :
								<?php echo $companyInfo->Repot_Heading; ?> <br>
							</div>
						</div>
					</div>
					<div class="develop_by"><strong style="font-size: 10px">Develop By </strong> <a href="http://linktechbd.com">Link-Up Technology Ltd.</a></div>
					<div class="corcel">
						<div class="round">
							<div class="inner-round">
								<div class="inner-logo"><!-- ERP --></div>
							</div>
						</div>
					</div>

				</div>
				<div class="right-cont">
					<div class="login-form">
						<div class="form">
							<h4>Sign In Form</h4>
							<p style="color:red;">
								<?php if (isset($message)) {
									echo $message;
								} ?>
							</p>
							<form method="post" action="<?php echo base_url(); ?>Login/procedure">
								<div class="form-group">
									<?php echo form_error('user_name'); ?>
									<input type="text" name="user_name" class="form-control" placeholder="User Name">
								</div>
								<div class="form-group">
									<?php echo form_error('password'); ?>
									<input type="password" name="password" class="form-control" placeholder="Password">
								</div>
								<div class="form-group">
									<input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
								</div>
							</form>
						</div>
					</div>

				</div>
				<div class="clr"></div>
			</div>
		</div>
	</section>

	<script src="/assets/login/js/jquery.min.js"></script>
	<script src="/assets/login/js/bootstrap.min.js"></script>
	<script src="/assets/js/typed.js"></script>
	<script>
		$(function() {
			var typed = new Typed('#typed', {
				strings: ['Welcome to Online POS Accounting Software'],
				typeSpeed: 100,
				backSpeed: 100,
				loop: true
			});
		});
	</script>
</body>

</html>