import Vue from 'vue'

import Router from 'vue-router'
import Dashboard from '../components/Home.vue'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'
import discountRoutes from '../components/discount/router'
import Profile from '../components/User/ProfileComponent.vue'
import Params from '../components/params/index.vue'

Vue.use(Router);

const baseRoutes = [
        {
            path: '/',
            component: Dashboard
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
