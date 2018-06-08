import {Component, OnInit} from "@angular/core";
import {Profile} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	template: require("./splash.component.html")
})

export class SplashComponent implements OnInit{
	profile: Profile[] = [];


	constructor(protected profileService: ProfileService) {
		}


	ngOnInit():void {

	}

}