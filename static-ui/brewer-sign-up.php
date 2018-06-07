<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>onTap Sign Up</title>
	</head>
	<body>
		<form class="form-horizontal " role="form">
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-4">
					<input maxlength="128" class="form-control" id="email" placeholder="Email" ngModel required>
				</div>
			</div>
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-4">
					<input class="form-control" id="username" placeholder="Username" ngModel required>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input class="form-control" id="password" placeholder="Password" ngModel required>
				</div>
			</div>
			<div class="form-group">
				<label for="passwordConfirm" class="col-sm-2 control-label">Confirm Password</label>
				<div class="col-sm-4">
					<input class="form-control" id="passwordConfirm" placeholder="ConfirmPassword" ngModel required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success">Sign up</button>
				</div>
			</div>
		</form>
	</body>
</html>