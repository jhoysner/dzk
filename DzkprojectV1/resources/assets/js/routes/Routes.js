import Vue from 'vue'

import Router from 'vue-router'
import Dashboard from '../components/Home.vue'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'
import discountRoutes from '../components/discount/router'

Vue.use(Router);

const baseRoutes = [
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
