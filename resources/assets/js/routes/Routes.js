import Vue from 'vue'

import VueRouter from 'vue-router'
import Dashboard from '../components/Home.vue'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'

Vue.use(VueRouter)

const router = new VueRouter({

    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/commerces',
            component: Commerces
        },
        {
            path: '/branchs',
            component: Branchs
        },
    ],

    //mode: 'history'
})

export default router
