<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>onTap Sign In</title>
	</head>
	<body>
		<form class="form-horizontal " role="form">
			<div class="form-group">
				<label for="inputEmail" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-4">
					<input class="form-control" id="inputEmail" placeholder="Email" ngModel="formInfo.Email">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input class="form-control" id="inputPassword" placeholder="Password" ngModel="formInfo.Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success">Sign in</button>
				</div>
			</div>
		</form>
	</body>
</html>