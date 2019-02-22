<template>
    <div>
        <cart-header-component
            :cart="cart">
        </cart-header-component>
        <div id="products" class="row  align-items-center mt-3">
            <div v-for="product in products" class="item col-lg-4 d-flex align-items-stretch">
                <div class="card mt-3">
                    <img class="card-img-top" alt="Card image" v-bind:src="product.image">
                        <div class="card-body">
                        <h4 class="card-title">{{ product.name }}</h4>
                        <p class="card-text">{{ product.description }}</p>
                        <div class="row d-flex align-items-center">
                            <div class="col-4 pr-0">
                                <div class="lead">{{ product.price | currency }}</div>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-between pl-0">
                                <div class="number-in-stock" :class="{ few: product.inStock < 10 && product.inStock > 0, none: product.inStock == 0 }">
                                    {{ product.inStock }} in stock
                                </div>
                                <button class="btn btn-success" @click="addProductToCart(product)" :disabled="product.inStock == 0"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CartHeaderComponent from './CartHeaderComponent.vue';

    export default {
        data: function () {
            return {
                cart: {
                    items: []
                },
                products: []
            }
        },
        mounted() {
            this.getProducts();
            this.getCart();
        },
        components: {
            CartHeaderComponent
        },
        methods: {
            addProductToCart: function(product) {
                var cartItem = this.getCartItem(product);
                if (cartItem != null) {
                    console.log(cartItem.inStock, product.inStock)
                    var quantity = cartItem.quantity + 1;
                    var dataPost = {
                        product_id: cartItem.id,
                        cart_id: cartItem.cart_id,
                        is_update: true,
                        quantity: quantity,
                        inStock: product.inStock - 1
                    }
                } else {
                    var cartId = null;
                    if (this.cart.items.length) {
                        cartId = this.cart.items[0].cart_id;
                    }
                    var dataPost = {
                        product_id: product.id,
                        cart_id: cartId,
                        is_update: false,
                        quantity: 1,
                        inStock: product.inStock - 1
                    }
                }

                var app = this
                var url = 'api/v1/carts'
                axios.post(url, dataPost)
                    .then(function (response) {
                        if (cartItem == null) {
                            var productItem = {
                                id: product.id,
                                cart_id: response.data,
                                name: product.name,
                                price: product.price,
                                quantity: 1,
                                stock: product.inStock - 1
                            }
                            app.cart.items.push(productItem);
                        } else {
                            cartItem.quantity++;
                            cartItem.inStock--;
                        }
                        console.log(product.inStock);
                        product.inStock--;
                        console.log(product.inStock);
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not update cart products");
                    });
            },
            getCartItem: function(product) {
                for (var i = 0; i < this.cart.items.length; i++) {
                    if (this.cart.items[i].id === product.id) {
                        return this.cart.items[i];
                    }
                }

                return null;
            },
            getProducts: function() {
                var app = this
                var url = 'api/v1/products'
                axios.get(url)
                    .then(function (response) {
                        app.products = response.data
                    })
                    .catch(function (response) {
                        alert("Could not load products");
                    });
            },
            getCart: function() {
                var app = this
                var url = 'api/v1/carts'
                axios.get(url)
                    .then(function (response) {
                        app.cart.items = response.data
                    })
                    .catch(function (response) {
                        alert("Could not load cart");
                    });
            }
        },
        filters: {
            currency: function(value) {
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 0
                });

                return formatter.format(value);
            }
        }
    }
</script>