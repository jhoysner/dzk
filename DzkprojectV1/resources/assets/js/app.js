
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import Vue from 'vue';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import Vue from 'vue'

import mainDashboard from './components/main.vue'

import router from './routes/Routes.js'

import BootstrapVue from 'bootstrap-vue'

import swal from 'sweetalert';


Vue.use(BootstrapVue);

require('./bootstrap');

window.Vue = require('vue');

  Vue.component('login-component', require('./components/User/Login/LoginComponent.vue'));
  Vue.component('sider-component', require('./components/User/Login/SiderComponent.vue'));
  Vue.component('register-component', require('./components/User/RegisterComponent.vue'));
  Vue.component('email-component', require('./components/User/Password/EmailComponent.vue'));
  Vue.component('profile-component', require('./components/User/ProfileComponent.vue'));
  Vue.component('resend-component', require('./components/User/Password/ResendComponent.vue'));
  Vue.component('unlocked-component', require('./components/User/Activate/UnlockedComponent.vue'));
  Vue.component('reset-component', require('./components/User/Password/ResetComponent.vue'));
  Vue.component('activation-component', require('./components/User/Activate/ActivationComponent.vue'));
  Vue.component('locked-component', require('./components/User/Activate/LockedComponent.vue'));

// Vue.component('main-dashboard', require('./components/main.vue'));
// Vue.component('example-component', require('./components/ExampleComponent.vue'));


const app = new Vue({
    el: '#app',
    components: {
    	mainDashboard,
    },
    router
});

