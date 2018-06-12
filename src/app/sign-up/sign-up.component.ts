/*
 this component is used for signing up
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Router} from "@angular/router";
import {Status} from "../shared/classes/status";
import {SignUp} from "../shared/classes/sign.up";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign.up.service";

//declare $ for jquery
declare let $: any;

// set the template url and the selector for the ng powered html tag
@Component({
	template: require("./sign-up.component.html")
})

export class SignUpComponent implements OnInit{

	signUpForm : FormGroup;

	signUp: SignUp = new SignUp(
		null,
		null,
		null,
		null
	);
	status: Status = null;


	constructor(private formBuilder : FormBuilder, private router: Router, private signUpService: SignUpService) {}

	ngOnInit()  : void {
		this.signUpForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileUsername: ["", [Validators.maxLength(48), Validators.required]],
			profilePassword:["", [Validators.maxLength(48), Validators.required]],
			profilePasswordConfirm:["", [Validators.maxLength(48), Validators.required]]

		});

	}

	createSignUp(): void {

		let profile: SignUp =  new SignUp(this.signUpForm.value.profileEmail, this.signUpForm.value.profileUsername, this.signUpForm.value.profilePassword, this.signUpForm.value.profilePasswordConfirm);

		this.signUpService.createProfile(profile)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					let self = this;
					setTimeout(function() {
						self.router.navigate([""]);
					}, 500);
				}
			});
	}
}