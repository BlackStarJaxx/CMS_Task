<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="order-box">
                    <router-link :to="{name: 'home'}" class="btn btn-dark float-md-right">Back</router-link>

                    <img :src="product.image" :alt="product.name">
                    <h2 class="title" v-html="product.name"></h2>
                    <p class="small-text text-muted float-left">{{product.price}} {{product.currency}}</p>
                    <p class="small-text text-muted float-right">Available Units: {{product.units}}</p>
                    <br>
                    <hr>
                    <label class="row">
                        <span class="col-md-2 float-left">Quantity: </span>
                        <input type="number" name="units" min="1" :max="product.units" class="col-md-2 float-left form-control is-valid"
                               v-model="quantity" @change="checkUnits" >
                        <h5 class="text-danger col-md-5 float-left " v-if="!quantity">  Units must be integer number</h5>
                    </label>
                </div>
                <br>
                <div>
                    <div v-if="!isLoggedIn">
                        <h2>You need to login to continue</h2>
                        <button class="col-md-4 btn btn-primary float-left" @click="login">Login</button>
                        <button class="col-md-4 btn btn-danger float-right" @click="register">Create an account</button>
                    </div>
                    <div v-if="isLoggedIn">
                        <div class="row">
                            <label for="address" class="col-md-3 col-form-label">Delivery Address</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control " placeholder="Your address" v-model="address" required>
                                <h5 class="text-danger col-md-7 float-left" v-if="!address"   @click="placeOrder">The address must be strings and not be null</h5>
                                <h5 class="text-danger col-md-7 float-left" v-else-if="!address.address"> Min  7 letters </h5>

                            </div>
                        </div>
                        <br>
                        <button class="col-md-4 btn btn-sm btn-success float-right" v-if="isLoggedIn" @click="placeOrder">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .small-text { font-size: 18px; }
    .order-box { border: 1px solid #cccccc; padding: 10px 15px; }
    .title { font-size: 36px; }
</style>
<script>

    export default {
        props : ['pid'],
        data(){
            return {
                address : "",
                quantity : 1,
                isLoggedIn : null,
                product : []
            }
        },
        mounted() {
            this.isLoggedIn = localStorage.getItem('bigStore.jwt') != null
        },
        beforeMount() {
            axios.get(`/api/products/${this.pid}`).then(response => this.product = response.data)

            if (localStorage.getItem('bigStore.jwt') != null) {
                this.user = JSON.parse(localStorage.getItem('bigStore.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt')
            }
        },
        methods : {
            login() {
                this.$router.push({name: 'login', params: {nextUrl: this.$route.fullPath}})
            },
            register() {
                this.$router.push({name: 'register', params: {nextUrl: this.$route.fullPath}})
            },
            placeOrder(e) {
                e.preventDefault()

                let address = this.address
                let product_id = this.product.id
                let quantity = this.quantity

                axios.post('api/orders/', {address, quantity, product_id,})
                    .then(response => this.$router.push('/confirmation'))
            },
            checkUnits(e){
                if (this.quantity > this.product.units) {
                    this.quantity = this.product.units
                }
            }
        }
    }
</script>
