import {Component, OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Profile} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	selector: 'profile-component',
	template:  `
		require("./profile.component.html")
`
	})

export class ProfileComponent implements OnInit{

	profile: Profile = new Profile(
		null,
		null,
		null,
		null,
		null
	);
	status: Status = null;

	constructor(private  profileService: ProfileService) {}

		ngOnInit():void {

	}
}