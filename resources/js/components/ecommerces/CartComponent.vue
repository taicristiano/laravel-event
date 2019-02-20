<template>
    <div>
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <router-link :to="{name: 'Ecommerce'}">E-commerce Inc.</router-link>
            </div>
            <div>
                <span class="stats">{{ cart.items.length }} <template v-if="cart.items.length == 1">item</template><template v-else>items</template> in cart, totalling {{ cartTotal | currency }}</span>
                <router-link :to="{name: 'Cart'}" class="btn btn-primary">View Cart</router-link>
            </div>
        </div>

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
                        <td>{{ item.product.name }}</td>

                        <td>
                            {{ item.quantity }} &nbsp;
                            <button class="btn btn-success" @click="increaseQuantity(item)" :disabled="item.product.inStock == 0">+</button>
                            <button class="btn btn-danger" @click="decreaseQuantity(item)">-</button>
                        </td>

                        <td>{{ item.quantity * item.product.price | currency }}</td>
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
    export default {
        data: function () {
            var itemsStorage = [];
            if (JSON.parse(localStorage.getItem("cart")) != null) {
                itemsStorage = JSON.parse(localStorage.getItem("cart"));
            }
            return {
                cart: {
                    items: itemsStorage,
                },
            }
        },
        methods: {
            increaseQuantity: function(cartItem) {
                cartItem.product.inStock--;
                cartItem.quantity++;
                this.updateCart();
            },
            decreaseQuantity: function(cartItem) {
                cartItem.quantity--;
                cartItem.product.inStock++;

                if (cartItem.quantity == 0) {
                    this.removeItemFromCart(cartItem);
                }
                this.updateCart();
            },
            removeItemFromCart: function(cartItem) {
                var index = this.cart.items.indexOf(cartItem);

                if (index !== -1) {
                    this.cart.items.splice(index, 1);
                }
                this.updateCart();
            },
            checkout: function() {
                if (confirm('Are you sure that you want to purchase these products?')) {
                    this.cart.items.forEach(function(item) {
                        item.product.inStock += item.quantity;
                    });

                    this.cart.items = [];
                }
                this.updateCart();
            },
            updateCart: function() {
                localStorage.removeItem("cart");
                localStorage.setItem("cart", JSON.stringify(this.cart.items));
            }
        },
        computed: {
            cartTotal: function() {
                var total = 0;
                console.log(this.cart.items);
                this.cart.items.forEach(function(item) {
                    total += item.quantity * item.product.price;
                });

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