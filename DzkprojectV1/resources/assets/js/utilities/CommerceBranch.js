import Vue from 'vue'

const user_config = JSON.parse(localStorage.getItem('user_config'))
console.log(user_config)
if( user_config ) {
	var userconfig = user_config
} else {
	var userconfig = false
}

export const commerceBranchClient = new Vue({
  data: {
    user_config: userconfig
  }
})