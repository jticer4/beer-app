<?php
	require_once ("head-utils.php");
?>

<div class="container smallHide">
	<ul class="nav justify-content-center">
		<a class="navbar-brand" href="#"><img src="" alt="onTap icon"></a>
		<li class="nav-item">
			<a id="" class="nav-link" href="#">Sign In</a>
		</li>
		<li class="nav-item">
			<a id="" class="nav-link" href="#">Sign Up</a>
		</li>
	</ul>
</div>

<div class="container bigHide fixed-bottom">
	<div class="row">
		<div id="nameBar" class="col-12 text-center fixed-top mt-3">onTap</div>
	</div>
	<div class="collapse " id="btmNavToggle">
		<div class="d-flex flex-row mb-3 justify-content-around" aria-label="navigation">
			<a href="#" role="button" class="btn" >Sign Up</a>
			<a href="#" role="button" class="btn" >Sign In</a>
		</div>
	</div>
	<nav class="navbar navbar-light justify-content-center">
		<button class="navbar-toggler btn-btn-primary" type="button" data-toggle="collapse" data-target="#btmNavToggle"
				  aria-controls="btmNavToggle" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav>
</div>


