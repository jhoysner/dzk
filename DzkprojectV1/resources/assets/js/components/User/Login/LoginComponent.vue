<template>
	<div>
		<h1>Iniciar Sesión</h1>
		
		<div v-if="errors.length">
            <ul>
                <li role="alert" v-for="error in errors">
                    <div class="alert alert-danger alert-dismissable" v-if="error == 'Account user not active'">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}<br>
                      <a href="/resendemail">Click para solicitar reenvio de email</a>
                    </div>

                    <div class="alert alert-danger alert-dismissable" v-if="error == 'Account user locked'">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}<br>
                      <a href="/emailunlocked">Click para solicitar activación</a>
                    </div>
                    
                    <div class="alert alert-danger alert-dismissable" v-if="error !== 'Account user locked' && error !== 'Account user not active'">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}
                    </div>
                    
                </li>
            </ul>
        </div>
		<form action="" class="pt-30" v-on:submit.prevent="submitLogin()" novalidate>
			<div class="form-group">
				<label class="text-uppercase">Email</label>
				<input type="email" placeholder="Email Address" onfocus="this.placeholder=''" onblur="this.placeholder = 'Email Address'" required class="common-input mt-10" v-model="email">
			</div>
			<div class="form-group">
				<label class="text-uppercase">Password</label>
				<input type="password" placeholder="Enter Password" onfocus="this.placeholder=''" onblur="this.placeholder = 'Enter Password'" required class="common-input mt-10" v-model="password">
				
			</div>
			<button class="primary-btn view-btn mt-20 mr-20"><span>Ingresar</span></button>
		</form>
	</div>
</template>




<script>

import Notify from 'vue-notify-me'

	export default {
		mounted() {
	 		console.log('Login Mounted.')
	 	},
	 	data() {
            return {
            	errors:[],
                'email':"",
                'password':"",
                'reg': /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },
	 	methods: {
	 		submitLogin() {
	 			this.errors = [];
	 			if(!this.email) this.errors.push('Email required.');
	 			if(!this.validEmail(this.email)) this.errors.push('Valid email required.');
	 			if(!this.password) this.errors.push('Password required.');

	 			if(this.validEmail(this.email) && this.password) {
	 				const params = {
	 					email: this.email,
	 					password: this.password 
	 				}
					
					axios.post('/login', params)
                    	.then((response) => {
                            console.log(response)
                            window.location.href = '/profile';

                        }).catch((error) => {
                            this.errors.push(error.response.data.error);
							
                        })
	 			}
	 		},
	 		validEmail:function(email) {
      				return (this.reg.test(email))
      				//var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				    //return re.test(email);
			}
	 	}
	}
</script>