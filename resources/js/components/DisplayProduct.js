import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import TableRow from './TableRow';
import MyGlobleSetting from './MyGlobleSetting';

class DisplayProduct extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value: '',
            products: '',
        };
        this.deleteProduct = this.deleteProduct.bind(this);
    }
    componentDidMount(){
        axios.get(MyGlobleSetting.url + '/api/products')
        .then(response => {
            this.setState({ products: response.data });
        })
        .catch(function (error) {
            console.log(error);
        })
    }
    deleteProduct(e, index) {
        console.log(e, index);
        if (confirm('Are you sure?')) {
            axios.delete(MyGlobleSetting.url + '/api/products/' + e)
            .then(response => {
                this.state.products.splice(index, 1);
                this.setState({ products: this.state.products });
            })
            .catch(function (error) {
                console.log(error);
            })
        }
    }
    tabRow() {
        if(this.state.products instanceof Array) {
            var app = this
            return this.state.products.map(function(object, i) {
                return (
                    <tr key={ i }>
                        <td>{ object.id }</td>
                        <td>{ object.title }</td>
                        <td>{ object.body }</td>
                        <td width="200px">
                            <Link to={'product/edit/' + object.id } className="btn btn-info">Edit</Link>
                            <button className="btn btn-danger" onClick={app.deleteProduct.bind(app, object.id, i)}>Delete</button>
                        </td>
                    </tr>
                );
            })
        }
    }

    render() {
        return (
            <div>
                <h1>Products</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/product/create">Create Product</Link>
                    </div>
                </div><br />
                <table className="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Product Title</td>
                            <td>Product Body</td>
                            <td width="200px">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        {this.tabRow()}
                    </tbody>
                </table>
            </div>
        )
    }
}

export default DisplayProduct;