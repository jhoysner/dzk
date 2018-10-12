import Vue from 'vue'

import Router from 'vue-router'
import Index from '../components/home/Index'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'
import Profile from '../components/User/ProfileComponent.vue'
import Params from '../components/params/index.vue'
import Tags from '../components/tags/index.vue'
import DetailCommerce from '../components/home/commerce-detail';
import DetailBranch from '../components/home/branch-detail';
import DetailDiscount from '../components/home/discount-detail';
import DetailCommerceBranch from '../components/home/commerce-detail-branchs';
import DetailCommerceDisocount from '../components/home/commerce-detail-discounts';
import discountRoutes from '../components/discount/router'


Vue.use(Router);

const baseRoutes = [
        {
            path: '/',
            component: Index
        },
        {
            path: '/tags',
            component: Tags
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


// const baseRoutes = new Router({

//     routes: [
//         {
//             path: '/',
//             component: Dashboard
//         },
//         {
//             path: '/commerces',
//             component: Commerces
//         },
//         {
//             path: '/branchs',
//             component: Branchs
//         },
//     ],

// })

const routes = baseRoutes.concat(discountRoutes);
export default new Router({
  mode: 'history',
  routes,
});
