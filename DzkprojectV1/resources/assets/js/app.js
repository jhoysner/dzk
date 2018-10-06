
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

//Vue.component('main-dashboard', require('./components/main.vue'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));


const app = new Vue({
    el: '#app',
    components: {
    	mainDashboard,
    },
    router
});

