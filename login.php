<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Admin | Laundry Management System</title>


	<?php include('./header.php'); ?>
	<?php include('./db_connect.php'); ?>
	<?php
	session_start();
	if (isset($_SESSION['login_id']))
		header("location:index.php?page=home");
	?>
</head>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");
	body {
		width: 100%;
		height: calc(100%);
		background: #007bff;
	}
	main#main {
		width: 100%;
		height: calc(100%);
		background: white;
	}
	#login-right {
		position: absolute;
		right: 0;
		width: 40%;
		height: calc(100%);
		background: white;
		
		display: flex;
		align-items: center;
	}
	#login-left {
		position: absolute;
		left: 0;
		width: 60%;
		height: calc(100%);
		display: flex;
		background: #5433FF;
		background: -webkit-linear-gradient(to right, #A5FECB, #20BDFF, #5433FF);
		background: linear-gradient(to right, #A5FECB, #20BDFF, #5433FF);
		flex-direction: column-reverse;
		align-items: center;
	}
	#login-right .card {
		margin: auto ;

	}
	.logo {
		margin: auto;
		font-size: 8rem;
		background: white;
		padding: .5em 0.7em;
		border-radius: 50% 50%;
		color: #000000b3;
	}
	h3 {
		margin-top: 80px;
		font-size: 40px;
		font-weight: 900;
		color: white;
	}
</style>
<body>
	<main id="main" class=" bg-dark">
		<div id="login-left">
			<div class="logo">
				<div class="laundry-logo"></div>
			</div>
			<div class="content">
				<h3>Laundry Management System</h3>
			</div>
		</div>
		<div id="login-right">
			<div class="card col-md-8">
				<div class="card-body">
					<form id="login-form">
						<div class="form-group">
							<i class="fas fa-user"></i>
							<label for="username" class="control-label">Username</label>
							<input type="text" id="username" name="username" class="form-control">
						</div>
						<div class="form-group">
							<i class="fas fa-lock"></i>
							<label for="password" class="control-label">Password</label>
							<input type="password" id="password" name="password" class="form-control">

						</div>
						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
					</form>
				</div>
			</div>
		</div>
	</main>
</body>
<script>
	$('#login-form').submit(function(e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true);
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=home';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>
</html>