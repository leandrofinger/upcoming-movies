import axios from 'axios';

export function getUpcomingMovies() {
	return axios.get('/api/upcoming-movies');
}