<template>
    <div>

        <div  class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Welcome to the bigStore</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box " v-for="(product,index) in products" @key="index">
                            <router-link :to="{ path: '/products/'+ product.id}">
                                <img :src="product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">{{getCurrency}} {{changeCurrency("USD",getCurrency, product.price)}}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-dark float-right">Buy Now</button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button v-if="next" type="button" @click="navigate(next)" class="m-3 btn btn-dark float-right">Next </button>
            <button v-if="prev" type="button" @click="navigate(prev)" class="m-3 btn btn-dark">Previous </button>
        </div>
    </div>
</template>

<script>

import currency from '../helpers/currency'
import App from'../views/App'
    export default {
        components:{
            App
        },
    data(){
            return {
                products :[],
                next: null,
                prev:null,

            }
        },
        mounted(){
            // axios.get("api/products?per_page=3").then(response => this.products = response.data)
            axios.get("api/currency/").then(response => this.currency = response.data)
            this.getProducts();
            console.log(this.$store.state.currency);

        },

        computed:{

            changeCurrency:function () {
                return (from,to,amount) => currency.convert(from,to,amount);
            },

            getCurrency:function () {
                return this.$store.state.currency;
            },

        },
        methods: {
            getProducts(address) {
                axios.get(address ? address : "api/products?per_page=3").then(response => {
                    this.products = response.data.data;
                    this.prev = response.data.links.prev;
                    this.next = response.data.links.next;
                });
            },

            navigate(address) {
                this.getProducts(address + "&per_page=3");
            }
        },

    }
</script>
<style scoped>
    .small-text {
        font-size: 14px;
    }
    .product-box {
        border: 1px solid #cccccc;
        padding: 10px 15px;
    }
    .hero-section {
        height: 30vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }
    .title {
        font-size: 60px;
        color: #ffffff;
    }
</style>
