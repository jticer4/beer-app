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
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {MapToIterable} from "./shared/pipes/map.to.iteratable";


export const allAppComponents = [
	SplashComponent,
	NavbarComponent,
	SignInComponent,
	SignUpComponent,
	ProfileComponent,
	MapToIterable
];

export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "sign-in", component: SignInComponent},


];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	ProfileService,
	SessionService,
	AuthService,
	BeerService,
	SignInService,
	SignUpService,
	StyleService
];

export const routing = RouterModule.forRoot(routes);