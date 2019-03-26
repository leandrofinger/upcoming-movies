export class MovieClass {
	id = '';
	title = '';
	image = '';
	genres = '';
	overview = '';
	release_date = '';

	constructor(data) {
		this.id = data.id;
		this.title = data.title;
		this.image = data.image_path;
		this.genres = data.genres;
		this.overview = data.overview;
		this.release_date = data.release_date;
	}
}