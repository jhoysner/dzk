
//import Vue from 'vue'
import Notifications from 'vue-notification';
import swal from 'sweetalert';


require('./bootstrap');

window.Vue = require('vue');

var bus = new Vue()

Vue.use(Notifications)


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



const app = new Vue({
    el: '#app'
}); 

