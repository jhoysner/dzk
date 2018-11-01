import Vue from 'vue';
import mainDashboard from './components/main.vue'
import router from './routes/Routes.js'
import BootstrapVue from 'bootstrap-vue'
import swal from 'sweetalert';
import ToggleButton from 'vue-js-toggle-button'
import Multiselect from 'vue-multiselect'

Vue.use(ToggleButton)

Vue.use(BootstrapVue);

Vue.component('multiselect', Multiselect)

require('./bootstrap');

window.Vue = require('vue');


// Authorization header
axios.interceptors.request.use(function (config) {
  var token = localStorage.getItem('access_token')
  config['headers'] = {
    Authorization: 'Bearer ' + token,
    Accept: 'application/json',
  }
  return config
}, error => Promise.reject(error))

//Unauthorized
axios.interceptors.response.use(
    (response) => {
      return response
    },
    (error) => {
      const originalRequest = error.config

      // token expired
      if (error.response.status === 401 && error.response.data.error == "token_expired") {
        window.location.href = '/login'
      }

      return Promise.reject(error)
    }
)

Vue.directive('can', function (el, binding) {
    if(el) {
      el.style.display = 'none' 
      let permissions = localStorage.getItem('permissions');
      if(permissions) {
        permissions = permissions.split(",")
        let perm = binding.expression.replace(/[']/g, "")  
        
        if(permissions.indexOf(perm) !== -1) {
          el.style.display = 'inline'
        }
      }
    }
    
  })

  

  Vue.component('login-component', require('./components/User/Login/LoginComponent.vue'));
  Vue.component('sider-component', require('./components/User/Login/SiderComponent.vue'));
  Vue.component('register-component', require('./components/User/RegisterComponent.vue'));
  Vue.component('email-component', require('./components/User/Password/EmailComponent.vue'));
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

