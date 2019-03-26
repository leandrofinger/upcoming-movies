import React, {Component} from 'react';
import {Row} from 'antd';

import Search from './Search';
import MovieList from './MovieList';
import {MovieClass} from '../../models/Movie.class';
import * as actions from '../../actions';

class UpcomingMovies extends Component {
	state = {
		upcomingMovies: [],
		moviesToShow: [],
		searchTerm: ""
	};

	async componentDidMount() {
		const response = await actions.getUpcomingMovies();
		const movies = await response.data.map(movie => new MovieClass(movie));

		this.setState({
            upcomingMovies: movies,
            moviesToShow: movies
		});
    }

    onChangeSearchTerm(searchTerm) {
        const moviesToShow = this.state.upcomingMovies.filter(item => {
            const regex = new RegExp(searchTerm.toLowerCase());
            if (regex.test(item.title.toLowerCase())) {
                return item;
            }
        });

        this.setState({
            moviesToShow,
            searchTerm
        });
    }

	render() {
		return (
			<Row>
				<Search
					searchTerm={this.state.searchTerm}
					onChange={(term) => this.onChangeSearchTerm(term)}
				/>
				<MovieList
					movies={this.state.moviesToShow}
				/>
			</Row>
		)
	}
}

export default UpcomingMovies;
