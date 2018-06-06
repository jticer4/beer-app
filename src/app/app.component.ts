import {Component} from "@angular/core";
import {SessionService} from "./shared/services/session.service";

@Component({
	selector: "angular-example-app",
	template: require("./app.component.html")
})

export class AppComponent {
	constructor(
		protected sessionService: SessionService
	){}
}