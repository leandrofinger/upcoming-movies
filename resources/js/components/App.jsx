import React, {Component} from 'react';
import {
	Layout,
	Row,
	Col,
	AutoComplete
} from 'antd';

import UpcomingMovies from './upcoming-movies/UpcomingMovies';

const {Header, Content} = Layout;

class App extends Component {
	render() {
		return (
			<Layout>
				<Header>
					<h1>Upcoming Movies</h1>
				</Header>
				<Content>
					<Row gutter={15}>
						<UpcomingMovies />
					</Row>
				</Content>
			</Layout>
		);
	}
}

export default App;