
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import Vue from 'vue';

 import mainDashboard from './components/main.vue'

 import router from './routes/Routes.js'
 
 import BootstrapVue from 'bootstrap-vue'

 import swal from 'sweetalert';


Vue.use(BootstrapVue);

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('main-dashboard', require('./components/main.vue'));

const app = new Vue({
    el: '#app',
    components: {
    	mainDashboard,
    },
    router
});
