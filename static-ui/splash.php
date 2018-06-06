<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<section id="splash" class="splash">
	<div class="bgImage position-absolute">
		<img src="" alt="onTap background image">

	</div>
	<div class="container">

		<div class="row justify-content-center">
			<div class="box col-sm-8 mt-3">
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-sm-4 mt-4">

				<select class="form-control">
					<option>Type</option>
						</select>

				<select class="form-control mt-2">
					<option>Abv</option>
				</select>

				<select class="form-control mt-2">
					<option>IBU</option>
				</select>

				<select class="form-control mt-2">
					<option>Distance</option>
				</select>
				<button class="my-4 col-sm-12 justify-content-center" (click)="onClickMe()">Submit</button>
			</div>
		</div>
	</div>

	</section>



