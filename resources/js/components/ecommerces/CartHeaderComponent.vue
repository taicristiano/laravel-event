<template>
    <div>
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <router-link :to="{name: 'Ecommerce'}">E-commerce Inc.</router-link>
            </div>
            <div>
                <span class="stats">{{ cart.items.length }} <template v-if="cart.items.length == 1">item</template><template v-else>items</template> in cart, totalling {{ cartTotal | currency }}</span>
                <router-link :to="{name: 'Cart'}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;View Cart</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            cart: {
                type: Object,
                require: true
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