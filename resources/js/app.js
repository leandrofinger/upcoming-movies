import React from 'react';
import {render} from 'react-dom';

// import 'babel-polyfill';
import 'core-js/modules/es6.promise';
import 'core-js/modules/es6.array.iterator';

import App from './components/App';

render(
	<App />,
	document.getElementById('root')
);
