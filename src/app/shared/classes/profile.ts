export class Profile {
	constructor(public profileId: string,
					public profileUsername: string,
					public profileEmail: string,
					public profilePassword: string,
					public profilePasswordConfirm: string,
					public latitude?: number,
					public longitude?: number
	) {}
}