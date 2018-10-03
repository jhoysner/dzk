import Discount from './Discount.vue';
import Create from './Create.vue';


export default [
  {
    path: '/discount',
    name: 'discount',
    component: Discount,
    // children: [
    //   {
    //     path: '/create',
    //     name: 'discount.create',
    //     component: Discount,
    //   },

    // ],
  },
  {
    path: '/discount-create',
    name: 'discount.create',
    component: Create,

  },
];