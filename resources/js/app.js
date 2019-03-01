
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';

import Master from './components/Master';
import CreateProduct from './components/CreateProduct';
import DisplayProduct from './components/DisplayProduct';
import UpdateProduct from './components/UpdateProduct';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Example');

render(
    <Router history={browserHistory}>
        <Route component={Master} >
            <Route path="/product/create" component={CreateProduct} />
            <Route path="/" component={DisplayProduct} />
            <Route path="/product/edit/:id" component={UpdateProduct} />
        </Route>
    </Router>,
    document.getElementById('crud-app')
);
