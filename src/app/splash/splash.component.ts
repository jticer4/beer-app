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
	beers: Beer[] = [];
	locations: any = {};
	cerveza: Beer = new Beer(null, null,null,null,null,null);
	location: Profile = new Profile(null, null,null,null,null,null, null);
	pourBeer: boolean = false;

	constructor(protected profileService: ProfileService, protected beerService: BeerService) {}




	ngOnInit():void {
		this.profileService.locationObserver.subscribe(locations => {
			this.locations = locations;
			this.beerService.beerObserver.subscribe(beers => this.beers = beers);
		});
	}

	// clicked({target: marker} : any, beer : Beer) {
	// 	this.beer = marker;
	// 	marker.nguiMapComponent.openInfoWindow('beer-details', marker);
	// }
	// hideMarkerInfo() {
	// 	this.point.display = !this.point.display;
	// }
	//
	 displayLocation(profile: Profile) {
	 	this.location = profile;
	 	this.pourBeer = true;
	 }


}