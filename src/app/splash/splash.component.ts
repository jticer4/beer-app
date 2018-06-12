import {Component, OnInit} from "@angular/core";
import {Profile} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";
import {BeerService} from "../shared/services/beer.service";
import {Beer} from "../shared/classes/beer";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";


@Component({
	selector:'splash',
	template: require("./splash.component.html"),

})

export class SplashComponent implements OnInit{
	userForm: FormGroup;
	profile: Profile[] = [];
	beers: Beer[] = [];
	status: Status = null;

	onSumbit(){


	}

	constructor(
		protected formBuilder;
		protected profileService: ProfileService,
		protected beerService: BeerService){}



	ngOnInit():void {
		this.beerService.beerObserver.subscribe(beers => this.beers = beers);
		this.reloadBeers();
		this.userForm = this.formBuilder.group({
			attribution: ["", [Validators.maxLength(64), Validators.required]],
			submitter: [""]
		})

	}

	reloadBeers() : void {

	}

}