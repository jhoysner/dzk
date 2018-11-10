export const Logged = {
	data() {
		return {
			logged: false
		}
	},
	methods: {
		checkLogin() {
			const token = localStorage.getItem('access_token')

			if( !token) {
				this.logged = false
				return this.logged
			}
			
			axios.get('/api/profile').then(response => {
				console.log(response)        
			    	this.logged = true		
			        return this.logged
			    })
			    .catch(err => {
			    	return this.logged = false
			    }) 
			    
/*			if(token) {
				axios.get('/api/profile').then(response => {
				console.log(response)        
			    	this.logged = true		
			        return this.logged
			    })
			    .catch(err => {
			    	return this.logged = false
			    }) 
			}*/
		}		
		
	}
}