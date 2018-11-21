import Vue from 'vue'

import Router from 'vue-router'
import Index from '../components/home/Index'
import IndexDiscount from '../components/home/index-discount.vue'
import IndexBranchsMap from '../components/home/Branchs-map'
import Commerces from '../components/commerces/index.vue'
import Branchs from '../components/branchs/index.vue'
import Profile from '../components/User/ProfileComponent.vue'
import Params from '../components/params/index.vue'
import Tags from '../components/tags/index.vue'
import Discountsp from '../components/discounts-postulated/index.vue';
import Discountsrd from '../components/discounts-postulated/discounts-redeemed.vue';
import DetailCommerce from '../components/home/commerce-detail';
import DetailBranch from '../components/home/branch-detail';
import DetailDiscount from '../components/home/discount-detail';
import CommerceTag from '../components/home/commerce-tag';
import DiscountTag from '../components/home/discount-tag';
import DetailCommerceBranch from '../components/home/commerce-detail-branchs';
import DetailCommerceDisocount from '../components/home/commerce-detail-discounts';
import discountRoutes from '../components/discount/router'
import Cliente from '../components/cliente/index'
import DescuentosRedimidos from '../components/cliente/cliente-descuentos-redimidos'
import DetailClienteDiscount from '../components/cliente/detail-discount'
import Users from '../components/user/Index'
import Roles from '../components/groups/Index'
import Permissions from '../components/permissions/Index'
import Logout from '../components/auth/Logout'
import Products from '../components/products/Index'
import Imbox from '../components/imbox/Index';
import ImboxConversation from '../components/imbox/conversation';
import Follow from '../components/follow/index';

Vue.use(Router);

const baseRoutes = [
        {
            path: '/',
            component: Index,
            meta: { 
                requiresAuth: false
            }
        },        
        {
            path: '/home-discounts',
            component: IndexDiscount,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/branchs-map',
            component: IndexBranchsMap,
            meta: { 
                requiresAuth: true,
                redirectAuth: true
            }
        },
        {
            path: '/tags',
            component: Tags,
            meta: { 
                requiresAuth: true
            }
        },        
        {
            path: '/cliente',
            component: Cliente,
            meta: { 
                requiresAuth: false
            }
        },        
        {
            path: '/cliente-descuentos-redimidos',
            component: DescuentosRedimidos,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/params',
            component: Params,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/commerces',
            component: Commerces,
            meta: { 
                requiresAuth: false
            }
        },      
        {
            path: '/commerce/:id',
            component: DetailCommerce,
            meta: { 
                requiresAuth: false
            }
        },        
        {
            path: '/commerce/:id/branchs',
            component: DetailCommerceBranch,
            meta: { 
                requiresAuth: false
            }
        },        
        {
            path: '/commerce/:id/discounts',
            component: DetailCommerceDisocount,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/branch/:id',
            component: DetailBranch,
            
        }, 
        {
            path: '/discount/:id',
            component: DetailDiscount,
            meta: { 
                requiresAuth: false
            }
        }, 

        {
            path: '/branchs',
            component: Branchs,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/discounts-postulated',
            component: Discountsp,
            meta: { 
                requiresAuth: false
            }
        },   
        {
            path: '/commerce/:idtag/tag',
            component: CommerceTag,
            meta: { 
                requiresAuth: false
            }
        },        
        {
            path: '/discount/:idtag/tag',
            component:DiscountTag,
            meta: { 
                requiresAuth: false
            }
        },         
        {
            path: '/client-discount/:id',
            component: DetailClienteDiscount,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/discounts-redeemed',
            component: Discountsrd,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/users',
            component: Users,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/roles',
            component: Roles,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/permissions',
            component: Permissions,
            meta: { 
                requiresAuth: true
            }
        },
        {
            path: '/products',
            component: Products,
            meta: { 
                requiresAuth: true
            }
        },

        {
            path: '/profile',
            component: Profile,
            meta: { 
                requiresAuth: false
            }
        },
        {
            path: '/logout', 
            component: Logout 
        },
        {
            path: '/imbox', 
            component: Imbox,
          
        },        
        {
            path: '/imbox/:id', 
            component: ImboxConversation,
            props: true,

        },        
        {
            path: '/followers', 
            component: Follow,

        }


 
];


const routes = baseRoutes.concat(discountRoutes);

const router = new Router({
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {

        if(to.matched.some(record => record.meta.redirectAuth)) {
            localStorage.setItem('redirect', to.fullPath)
        }

        const token = window.localStorage.getItem('access_token') 
        
        if( !token || token  == null ) {
            next(
                window.location.href = '/login'
                )
        } else {
            next()
        }
    } else {
        next()
    }
});

export default router
