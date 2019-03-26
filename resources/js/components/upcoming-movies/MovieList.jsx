import React from 'react';
import {
	Row,
	Col,
    Card
} from 'antd';

const renderMovieCover = (imageUri, movieTitle) => {
	return (
		<img src={imageUri} alt={movieTitle}/>
	);
};

const renderMovies = (movies) => {
	return movies.map((item) => {
		return (
            <Col
                span={8}
                key={item.id}
            >
                <Card
                    className="movie-card"
                    cover={renderMovieCover(item.image, item.title)}
                >
                    <Card.Meta
                        title={item.title}
                        description={'Realease date: '+item.release_date}
                    />
                </Card>
            </Col>
		);
	});
};

const MovieList = (props) => {
	return (
		<Row gutter={12} className="movie-list">
			{renderMovies(props.movies)}
		</Row>
	);
};

export default MovieList;
