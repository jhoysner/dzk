import Vue from 'vue'

import Router from 'vue-router'
import Index from '../components/home/Index'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'
import Profile from '../components/User/ProfileComponent.vue'
import Params from '../components/params/index.vue'

import discountRoutes from '../components/discount/router'

Vue.use(Router);

const baseRoutes = [
        {
            path: '/',
            component: Index
        },
        {
            path: '/params',
            component: Params
        },
        {
            path: '/commerces',
            component: Commerces
        },
        {
            path: '/branchs',
            component: Branchs
        },
        {
            path: '/profile',
            component: Profile
        },
 
];


const routes = baseRoutes.concat(discountRoutes);
export default new Router({
  mode: 'history',
  routes,
});
