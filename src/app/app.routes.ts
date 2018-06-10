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
import {NavbarComponent} from "./shared/components/navbar/navbar.component";
import {SignInComponent} from "./shared/components/sign-in/sign-in.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {ProfileComponent} from "./profile/profile.component";


export const allAppComponents = [
	SplashComponent,
	NavbarComponent,
	SignInComponent,
	SignUpComponent,
	ProfileComponent,

];

export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "sign-up", component: SignUpComponent},

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