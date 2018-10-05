
import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginComponent from '../components/LoginComponent'

Vue.use(VueRouter)

const router = new VueRouter({

	routes:  [
		{
			path: '/login',
			component: LoginComponent
		}
	]
})

export default router
