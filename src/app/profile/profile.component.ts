import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Profile} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	template: `
	<h1>Hello World</h1>
	`
})

export class ProfileComponent implements OnInit{

	profile: Profile = new Profile(null, null, null, null,null);
	status: Status = null;

	constructor(private  profileService: ProfileService) {}

		ngOnInit():void {
		}
}