import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Observable} from "rxjs/Observable";
import {Beer} from "../classes/beer";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {Point} from "../classes/point";

@Injectable()
export class BeerService {
	protected beerSubject : BehaviorSubject<Beer[]> = new BehaviorSubject<Beer[]>([]);
	public beerObserver : Observable<Beer[]> = this.beerSubject.asObservable();

	constructor(protected http: HttpClient) {
		this.getAllBeers().subscribe(beers => this.beerSubject.next(beers));
	}

	//define the API endpoint
	private beerUrl = "api/beer/";

// call to the Beer API and get a beer object by its id
	getBeerByBeerId(beerId : string): Observable<Beer> {
		return (this.http.get<Beer>(this.beerUrl + beerId));
	}

// call to the API and get an array of beers based off the profileId
	getBeerByBeerProfileId(beerProfileId : string) : Observable<Beer[]> {
		return(this.http.get<Beer[]>(this.beerUrl + beerProfileId));

	}

	// call to the API and get an array of beers based off the beer Abv
	getBeerByBeerAbv(beerAbv : number) : Observable<Beer[]> {
		return(this.http.get<Beer[]>(this.beerUrl + beerAbv));

	}

	// call to the API and get an array of beers based off the beer Ibu
	getBeerByBeerIbu(beerIbu : number) : Observable<Beer[]> {
		return(this.http.get<Beer[]>(this.beerUrl + beerIbu));

	}

	// call to the API and get an array of beers based off the beer name
	getBeerByBeerName(beerName : string) : Observable<Beer[]> {
		return(this.http.get<Beer[]>(this.beerUrl + beerName));

	}

	// call to the Beer API and get a Beer object by its style
	getBeerStyleByBeerStyleBeerId(beerStyleBeerId: string): Observable<Beer[]> {
		return (this.http.get<Beer[]>(this.beerUrl, {params: new HttpParams().set("beerStyleBeerId", beerStyleBeerId)}));
	}

// call to the Beer API and get a Beer object by its style
	getBeerStyleByBeerStyleStyleId(beerStyleStyleId: string): Observable<Beer[]> {
		return (this.http.get<Beer[]>(this.beerUrl, {params: new HttpParams().set("beerStyleStyleId", beerStyleStyleId)}));
	}

// call to the Beer API and get all Beer
	getAllBeers(): Observable<Beer[]> {
		return (this.http.get<Beer[]>(this.beerUrl));
	}


}