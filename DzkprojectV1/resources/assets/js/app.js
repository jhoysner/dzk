
//import Vue from 'vue'

import swal from 'sweetalert';

import BootstrapVue from 'bootstrap-vue'

require('./bootstrap');

window.Vue = require('vue');

var bus = new Vue()

Vue.use(BootstrapVue);


Vue.component('login-component', require('./components/user/login/LoginComponent.vue'));
Vue.component('sider-component', require('./components/user/login/SiderComponent.vue'));
Vue.component('register-component', require('./components/user/RegisterComponent.vue'));
Vue.component('email-component', require('./components/user/password/EmailComponent.vue'));
Vue.component('profile-component', require('./components/user/profileComponent.vue'));
Vue.component('resend-component', require('./components/user/password/ResendComponent.vue'));
Vue.component('unlocked-component', require('./components/user/activate/UnlockedComponent.vue'));
Vue.component('reset-component', require('./components/user/password/ResetComponent.vue'));
Vue.component('activation-component', require('./components/user/activate/ActivationComponent.vue'));
Vue.component('locked-component', require('./components/user/activate/LockedComponent.vue'));



const app = new Vue({
    el: '#app'
}); 

