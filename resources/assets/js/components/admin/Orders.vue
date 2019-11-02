<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Cost</td>
                <td>Delivery Address</td>
                <td>Currency</td>
                <td>is Delivered?</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(order,index) in orders" @key="index">
                <td>{{index+1}}</td>
                <td v-html="order.product.name"></td>
                <td>{{order.quantity}}</td>
                <td>{{order.quantity * order.product.price}} {{order.product.currency}}</td>
                <td>{{order.address}}</td>
                <td>{{order.product.currency}}</td>
                <td>{{order.is_delivered == 1? "Yes" : "No"}}</td>
                <td v-if="order.is_delivered == 0"><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                orders : [],
                products :[]
            }
        },
        beforeMount(){
            axios.get('/api/orders/').then(response => this.orders = response.data)
            axios.get('/api/products/').then(response => this.products = response.data)
            axios.get('/api/currency/').then(response => this.currency = response.data)

        },
        methods: {
            deliver(index) {
                let order = this.orders[index]
                axios.patch(`/api/orders/${order.id}/deliver`).then(response => {
                    this.orders[index].is_delivered = 1
                    this.$forceUpdate()
                })
            }
        }
    }
</script>
