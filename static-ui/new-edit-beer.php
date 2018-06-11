<?php
/**
 * Get basic dependencies and other components
 *
 */
	require_once ("head-utils.php");
	require_once("navbar.php");
?>

<div class="container">
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
		New Beer
	</button>

	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add a new beer</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="">
							<div class="form-group">
							<label for="formGroupExampleInput">Beer Name</label>
							<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Beer Name">
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput2">Beer Description</label>
							<input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Write a description...">
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput3">ABV</label>
							<input type="text" class="form-control" id="formGroupExampleInput3" placeholder="ABV">
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput4">IBU</label>
							<input type="text" class="form-control" id="formGroupExampleInput4" placeholder="IBU 0-120">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>
