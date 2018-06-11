import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";

import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {Beer} from "../classes/beer";

@Injectable()
export class ProfileService {
	protected locationSubject : BehaviorSubject<any> = new BehaviorSubject<any>({});
	public locationObserver : Observable<any> = this.locationSubject.asObservable();

	constructor(protected http: HttpClient) {
		this.getProfileLocations().subscribe(locations => this.locationSubject.next(locations));
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

	getProfileLocations() :Observable<any> {
		return(this.http.get<any>(this.profileUrl + "?profileLocation=true"));
	}

}