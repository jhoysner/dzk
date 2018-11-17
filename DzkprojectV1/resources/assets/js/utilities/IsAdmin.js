import Vue from 'vue'

const roles = window.localStorage.getItem('roles') 

if(roles) {
	var isAdmin = roles.includes('Admin')
} else {
	var isAdmin = false
}

export const userIsAdmin = new Vue({
  data: {
    admin: isAdmin
  }
})