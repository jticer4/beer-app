import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";

import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Style} from "../classes/style";

@Injectable()
export class StyleService {

		constructor(protected http : HttpClient) {}

		//define the API endpoint
		private styleUrl = "api/style/";

		//call the style API and create the style
		getStyle(id: number) : Observable<Style> {
				return(this.http.get<Style>(this.styleUrl + id));
		}

		//call to the API grab an array of profiles based on the user input
	getAllStyles(id: number) : Observable<Style[]> {
			return(this.http.get<Style[]>(this.styleUrl + id));
	}
}