import { Pipe, PipeTransform } from '@angular/core';
// Credit goes to @bersling https://stackoverflow.com/questions/31490713/iterate-over-object-in-angular
@Pipe({
	name: 'mapToIterable'
})
export class MapToIterable implements PipeTransform {
	transform(dict: Object) {
		var a = [];
		for (var key in dict) {
			if (dict.hasOwnProperty(key)) {
				a.push({key: key, val: dict[key]});
			}
		}
		return a;
	}
}