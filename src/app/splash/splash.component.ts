import {Component, OnInit} from "@angular/core";
import {User} from "../shared/classes/user";
import {UserService} from "../shared/services/user.service";

@Component({
	template: require("./splash.component.html")
})

export class SplashComponent implements OnInit{
	users: User[] = [];

	constructor(protected userService: UserService) {}


	ngOnInit():void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}

}