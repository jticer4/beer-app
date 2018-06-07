import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";

import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable()
export class ProfileService {

	constructor(protected http: HttpClient) {

	}

	private profileUrl = "api/profile/";

	//call to the Profile API and get a Profile object by its id
	getProfile(profileId: string) :Observable<Profile> {
			return(this.http.get<Profile>(this.profileUrl + profileId));
	}

	//call to the Profile API and get a Profile object by its email
	getProfileByProfileEmail(profileEmail: string) :Observable<Profile[]> {
			return(this.http.get<Profile[]>(this.profileUrl + "?profileEmail=" + profileEmail));
	}

	//call to the Profile API and get a Profile object by its username
	getProfileUsername(profileUsername: string) :Observable<Profile[]> {
			return(this.http.get<Profile[]>(this.profileUrl + "?profileUsername=" + profileUsername));
	}

}