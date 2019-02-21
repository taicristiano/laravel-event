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
                            <div class="col-4">
                                <div class="lead">{{ product.price | currency }}</div>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-between">
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
            var itemsStorage = [];
            if (JSON.parse(localStorage.getItem("cart")) != null) {
                itemsStorage = JSON.parse(localStorage.getItem("cart"));
            }
            return {
                cart: {
                    items: itemsStorage,
                },
                products: [
                    {
                        id: 1,
                        name: 'MacBook Pro (15 inch)',
                        description: 'This laptop has a super crisp Retina display. Yes, we know that it\'s overpriced...',
                        price: 2999,
                        inStock: 50,
                        image: 'https://macone.vn/wp-content/uploads/2018/06/15inch_2018_gray.jpg'
                    },
                    {
                        id: 2,
                        name: 'Samsung Galaxy Note 7',
                        description: 'Unlike the overpriced MacBook Pro, we\'re selling this one a bit cheap...',
                        price: 299,
                        inStock: 755,
                        image: 'https://cdn.fptshop.com.vn/Uploads/Originals/2016/8/5/636060120230577954_s7-silver-1.jpg'
                    },
                    {
                        id: 3,
                        name: 'HP Officejet 5740 printer',
                        description: 'This one might not last for so long, but hey, printers never work anyways, right?',
                        price: 149,
                        inStock: 5,
                        image: 'https://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04339763.png'
                    },
                    {
                        id: 4,
                        name: 'iPhone 7 cover',
                        description: 'Having problems keeping a hold of that phone, huh? Ever considered not dropping ...',
                        price: 49,
                        inStock: 42,
                        image: 'http://trianium.com/wp-content/uploads/2016/10/00120.jpg'
                    },
                    {
                        id: 5,
                        name: 'iPad Pro (9.7 inch)',
                        description: 'We heard it\'s supposed to be pretty good. At least that\'s what people say.',
                        price: 599,
                        inStock: 0,
                        image: 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/image/AppleInc/aos/published/images/r/fb/rfb/97/rfb-97-ipad-pro-silver-wifi-2015?wid=572&hei=572&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1542160026733'
                    },
                    {
                        id: 6,
                        name: 'OnePlus 3 cover',
                        description: 'Does your phone spend most of its time on the ground? This cheap piece of plastic ...',
                        price: 19,
                        inStock: 81,
                        image: 'https://ae01.alicdn.com/kf/HTB1KgiDKVXXXXclXVXXq6xXFXXXp/Oneplus-3-tr-ng-h-p-B-Thu-S-n-ban-u-c-ng-M-Y.jpg'
                    }
                ]
            }
        },
        components: {
            CartHeaderComponent
        },
        methods: {
            addProductToCart: function(product) {
                var cartItem = this.getCartItem(product);

                if (cartItem != null) {
                    cartItem.quantity++;
                } else {
                    this.cart.items.push({
                        product: product,
                        quantity: 1
                    });
                }

                product.inStock--;
                localStorage.removeItem("cart");
                localStorage.setItem("cart", JSON.stringify(this.cart.items));
            },
            getCartItem: function(product) {
                for (var i = 0; i < this.cart.items.length; i++) {
                    if (this.cart.items[i].product.id === product.id) {
                        return this.cart.items[i];
                    }
                }

                return null;
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