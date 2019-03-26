import React, {Component} from 'react';
import PropTypes from 'prop-types';

import {
	Row,
	Col,
	Input
} from 'antd';

class Search extends Component {
	render() {
		return (
			<Row>
				<Col span={24}>
					<Input
						onChange={(e) => this.props.onChange(e.target.value)}
						placeholder="type your search..."
					/>
				</Col>
			</Row>
		);
	}
}

Search.propTypes = {
	searchTerm: PropTypes.string,
	onChange: PropTypes.func
};

export default Search;