<?php

// we determine if we have a GET request. If so, we then process the request.
if ($method === "GET") {


// If it is not a GET request, we then proceed here to determine if we have a PUT or POST request.
} else if($method === "PUT" || $method === "POST") {

	//do setup that is needed for both PUT and POST requests

	//perform the actual put or post
	if($method === "PUT") {
		// determines if we have a PUT request. If so we process the request.
		// process PUT requests here


	} else if ($method === "POST") {

		// process the POST request  here

	}


	// if the above requests are neither a PUT or POST delete below
} else if($method === "DELETE") {

	// process DELETE requests here

}