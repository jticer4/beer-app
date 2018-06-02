<?php
	require_once ("head-utils.php");
?>

<div class="container smallHide animated fadeInDown">
	<ul class="nav justify-content-center">
		<li id="portfolioLink" class="nav-item">
			<a class="navbar-brand" href="#"><img id="brandIcon" src="/src/app/images/on-tap-balloon.svg" alt=""></a>
		</li>
		<li class="nav-item">
			<a id="" class="nav-link" href="#">Sign In</a>
		</li>
		<li class="nav-item">
			<a id="" class="nav-link" href="#">Sign Up</a>
		</li>
	</ul>
</div>

<div class="container bigHide fixed-bottom">
	<div class="collapse " id="btmNavToggle">
		<div class="d-flex flex-row mb-3 justify-content-around" aria-label="navigation">
			<a href="#" role="button" class="btn" >Sign Up</a>
			<a href="#" role="button" class="btn" >Sign In</a>
		</div>
	</div>
	<nav class="navbar navbar-light justify-content-center">
		<button class="navbar-toggler backWhite" type="button" data-toggle="collapse" data-target="#btmNavToggle"
				  aria-controls="btmNavToggle" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</nav>
</div>

