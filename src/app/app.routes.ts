import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import {ProfileService} from "./shared/services/profile.service";
import {APP_BASE_HREF} from "@angular/common";
import {SessionService} from "./shared/services/session.service";
import {AuthService} from "./shared/services/auth.service";
import {BeerService} from "./shared/services/beer.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignUpService} from "./shared/services/sign.up.service";
import {StyleService} from "./shared/services/style.service";


export const allAppComponents = [SplashComponent];

export const routes: Routes = [
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	ProfileService,
	SessionService,
	AuthService,
	BeerService,
	SignInService,
	SignUpService,
	StyleService
];

export const routing = RouterModule.forRoot(routes);