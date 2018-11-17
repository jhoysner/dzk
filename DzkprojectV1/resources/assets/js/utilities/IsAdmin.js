import Vue from 'vue'

const roles = window.localStorage.getItem('roles') 

export const userIsAdmin = new Vue({
  data: {
    admin: roles.includes('Admin')
  }
})