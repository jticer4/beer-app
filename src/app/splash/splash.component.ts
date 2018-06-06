import {Component, OnInit} from "@angular/core";
import {User} from "../shared/classes/profile";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	template: require("./splash.component.html")
})

export class SplashComponent implements OnInit{
	users: User[] = [];

	constructor(protected userService: ProfileService) {}


	ngOnInit():void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}

}