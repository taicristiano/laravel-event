<template>
    <div>
        <cart-header-component
            :cart="cart">
        </cart-header-component>
        <div>
            <h1>Cart</h1>

            <table v-if="cart.items.length > 0" class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in cart.items">
                        <td>{{ item.name }}</td>

                        <td>
                            {{ item.quantity }} &nbsp;
                            <button class="btn btn-success" @click="increaseQuantity(item)" :disabled="item.inStock == 0">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-danger" @click="decreaseQuantity(item)">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </td>

                        <td>{{ item.quantity * item.price | currency }}</td>
                    </tr>

                    <tr>
                        <td class="text-right" colspan="2">
                            <strong>Subtotal</strong>
                        </td>

                        <td>{{ cartTotal | currency }}</td>
                    </tr>

                    <tr>
                        <td class="text-right" colspan="2">
                            <strong>Taxes</strong>
                        </td>

                        <td>{{ taxAmount | currency }}</td>
                    </tr>

                    <tr>
                        <td class="text-right" colspan="2">
                            <strong>Grand total</strong>
                        </td>

                        <td>{{ cartTotal + taxAmount | currency }}</td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td><button class="btn btn-success" @click="checkout">Checkout</button></td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Your cart is currently empty.</p>
        </div>
    </div>
</template>

<script>
    import CartHeaderComponent from './CartHeaderComponent.vue';

    export default {
        data: function () {
            return {
                cart: {
                    items: [],
                },
                total: 0,
            }
        },
        mounted() {
            this.getCart();
        },
        components: {
            CartHeaderComponent
        },
        methods: {
            increaseQuantity: function(cartItem) {
                cartItem.inStock--;
                cartItem.quantity++;
                this.updateCart(cartItem);
            },
            decreaseQuantity: function(cartItem) {
                cartItem.quantity--;
                cartItem.inStock++;

                if (cartItem.quantity == 0) {
                    this.removeItemFromCart(cartItem);
                }
                this.updateCart(cartItem);
            },
            removeItemFromCart: function(cartItem) {
                var index = this.cart.items.indexOf(cartItem);

                if (index !== -1) {
                    this.cart.items.splice(index, 1);
                }
            },
            checkout: function() {
                if (confirm('Are you sure that you want to purchase these products?')) {
                    console.log(this.cart.items, this.total);
                    var dataPost = {
                        'items': this.cart.items,
                        'total': this.total
                    }
                    var app = this
                    var url = 'api/v1/carts/checkout'
                    axios.post(url, dataPost)
                        .then(function (response) {
                            console.log("oke");
                            app.cart.items = [];
                            window.location.href = 'ecommerce'
                        })
                        .catch(function (response) {
                            console.log(response);
                            alert("Could not load cart");
                        });

                }
                // this.updateCart();
            },
            updateCart: function(cartItem) {
                var dataPost = {
                    product_id: cartItem.id,
                    cart_id: cartItem.cart_id,
                    is_update: true,
                    quantity: cartItem.quantity,
                    inStock: cartItem.inStock
                }

                var app = this
                var url = 'api/v1/carts'
                axios.post(url, dataPost)
                    .then(function (response) {
                        console.log('oke');
                    })
                    .catch(function (response) {
                        console.log(response);
                        alert("Could not update cart products");
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
                        console.log(response);
                        alert("Could not load cart");
                    });
            }
        },
        computed: {
            cartTotal: function() {
                var total = 0;
                this.cart.items.forEach(function(item) {
                    total += item.quantity * item.price;
                });
                this.total = total;

                return total;
            },
            taxAmount: function() {
                return ((this.cartTotal * 10) / 100);
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