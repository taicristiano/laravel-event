import React, {Component} from 'react';
import { Router, Route, Link } from 'react-router';

class Master extends Component {
    render() {
        return (
            <div className="container">
                <nav className="navbar navbar-expand-sm bg-primary navbar-dark">
                  <ul className="navbar-nav">
                    <li className="nav-item">
                      <Link to="/product/create" className="nav-link">Create Product</Link>
                    </li>
                    <li className="nav-item">
                      <Link to="/" className="nav-link">Products</Link>
                    </li>
                  </ul>
                </nav>
                <div>
                    {this.props.children}
                </div>
            </div>
        )
    }
}

export default Master;