import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Profile} from "../classes/profile";

@Injectable()
export class ProfileService {

	constructor(protected http: HttpClient) {}

	private profileUrl = "https://jsonplaceholder.typicode.com/users/";

	getAllUsers(): Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.profileUrl));
	}
}