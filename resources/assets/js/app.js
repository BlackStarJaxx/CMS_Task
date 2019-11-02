require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex';
import VueRouter from 'vue-router'
import Router from 'vue-router';



const originalPush = Router.prototype.push;
Router.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
};

// import VeeValidate from 'vee-validate'
// Vue.use(VeeValidate)
Vue.use(Vuex);
Vue.use(Router);
Vue.use(VueRouter)

import App from './views/App'
import Home from './views/Home'
import Login1 from './views/Login1'
import Register1 from './views/Register1'
import SingleProduct from './views/SingleProduct'
import Checkout from './views/Checkout'
import Confirmation from './views/Confirmation'
import UserBoard from './views/UserBoard'
import Admin from './views/Admin'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login1',
            name: 'login',
            component: Login1
        },
        {
            path: '/register1',
            name: 'register',
            component: Register1
        },
        {
            path: '/products/:id',
            name: 'single-products',
            component: SingleProduct
        },
        {
            path: '/confirmation',
            name: 'confirmation',
            component: Confirmation
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
            props: (route) => ({ pid: route.query.pid })
        },
        {
            path: '/dashboard',
            name: 'userboard',
            component: UserBoard,
            meta: {
                requiresAuth: true,
                is_user: true
            }
        },
        {
            path: '/admin/:page',
            name: 'admin-pages',
            component: Admin,
            meta: {
                requiresAuth: true,
                is_admin: true
            }
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
            meta: {
                requiresAuth: true,
                is_admin: true
            }
        },
    ],
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('bigStore.jwt') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('bigStore.user'))
            if (to.matched.some(record => record.meta.is_admin)) {
                if (user.is_admin == 1) {
                    next()
                }
                else {
                    next({ name: 'userboard' })
                }
            }
            else if (to.matched.some(record => record.meta.is_user)) {
                if (user.is_admin == 0) {
                    next()
                }
                else {
                    next({ name: 'admin' })
                }
            }
            next()
        }
    } else {
        next()
    }
})
const store = new Vuex.Store({
    state: {
        currency:"USD",
    },
    mutations: {
        changeCurrency(state,value) {
            state.currency = value;
        }
    }
});
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
