import {Component, OnInit} from "@angular/core";
import {Profile} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";
import {BeerService} from "../shared/services/beer.service";
import {Beer} from "../shared/classes/beer";

@Component({
	selector:'splash',
	template: require("./splash.component.html"),

})

export class SplashComponent implements OnInit{
	profile: Profile[] = [];
	beers: Beer[] = [];


	constructor(protected profileService: ProfileService, protected beerService: BeerService) {}



	ngOnInit():void {
		this.beerService.getAllBeers().subscribe(beers => this.beers = beers);

	}

}