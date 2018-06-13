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
	location: Profile = new Profile(null, null,null,null,null,null, null);
	pourBeer: boolean = false;

	searchAbv: number = 0;

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

	 hideCard() {
		this.pourBeer = false;
	 }

	 filterByBrewery(): Beer[] {
		return(this.beers.filter(beer => beer.beerProfileId === this.location.profileId));
	 }

	 filterByAbv(): Beer[] {
		if(this.pourBeer === true && this.searchAbv !== 0) {
			let minAbv = Math.max(this.searchAbv - .01, 0);
			let maxAbv = Math.min(this.searchAbv + .01, 1);
			return(this.filterByBrewery().filter(beer => beer.beerAbv >= minAbv && beer.beerAbv <= maxAbv));
		} else {
			return(this.filterByBrewery());
		}
	 }

	 searchByAbv(event: any): void {
		 this.searchAbv = parseFloat(event.target.value);
	 }
}