import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {NguiMapModule} from "@ngui/map";
import {FormGroup, FormsModule, ReactiveFormsModule} from "@angular/forms";
import {SignIn} from "./shared/classes/sign.in";
import {SignInService} from "./shared/services/sign.in.service";
import {CookieService} from "ng2-cookies";
import {SessionService} from "./shared/services/session.service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:[
		BrowserModule,
		HttpClientModule,
		FormsModule,
		ReactiveFormsModule,
		routing,
		NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyBIv8OMsp0GR-DxUfJybsqiCi0Zvt2K4VM'})
	],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})
export class AppModule {

}