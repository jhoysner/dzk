<template>
	<div>
		<h1>Iniciar Sesión</h1>
		
		<div v-if="errors.length">
            <ul>
                <li role="alert" v-for="error in errors">
                    <div class="alert alert-danger alert-dismissable" v-if="error == 'Account user inactive' || error == 'Cuenta de usuario inactiva' ">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}<br>
                      <a href="/resendemail">Click para solicitar reenvio de email</a>
                    </div>

                    <div class="alert alert-danger alert-dismissable" v-if="error == 'Account user locked' || error == 'Cuenta de usuario bloqueada'">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}<br>
                      <a href="/emailunlocked">Click para solicitar activación</a>
                    </div>
                    
                    <div class="alert alert-danger alert-dismissable" v-if="error !== 'Account user locked' && error !== 'Account user not active' && error !== 'Cuenta de usuario bloqueada' && error !== 'Cuenta de usuario inactiva'">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{error}}
                    </div>
                    
                </li>
            </ul>
        </div>
       
			<form action="" class="pt-30" v-on:submit.prevent="submitLogin()" novalidate>
				<div class="form-group">
					<label class="text-uppercase">Correo Eléctronico</label>
					<input type="email" placeholder="Correo Electrónico" onfocus="this.placeholder=''" onblur="this.placeholder = 'Correo Electrónico'" required class="common-input mt-10" v-model="email"><small class="text-danger" v-if="errors.email">{{ errors.email }}</small><small class="text-danger" v-if="errors.emailvalid">{{ errors.emailvalid }}</small>
				</div>
				<div class="form-group">
					<label class="text-uppercase">Contraseña</label>
					<input type="password" placeholder="Contraseña" onfocus="this.placeholder=''" onblur="this.placeholder = 'Contraseña'" required class="common-input mt-10" v-model="password"><small class="text-danger" v-if="errors.password">{{ errors.password }}</small>
					
				</div>
				<button class="primary-btn view-btn mt-20 mr-20"><span>Ingresar</span></button>
    			<div class="mt-20 pull-right"><a class="" href="password/reset">Olvidó Contraseña</a></div>

			</form>
		
	
	</div>

</template>
<script>

	export default {
		mounted() {
	 	},
	 	data() {
            return {
            	errors:{},
                'email':"",
                'password':"",
                'reg': /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },
	 	methods: {
	 		submitLogin() {
	 			this.errors = [];
	 			if(!this.email) this.errors.password ='El Correo Electrónico es requerido.';
	 			if(!this.validEmail(this.email)) this.errors.emailvalid = 'Se requiere un correo válido.';
	 			if(!this.password) this.errors.password = 'La contraseña es requerido.';

	 			if(this.validEmail(this.email) && this.password) {
	 				const params = {
	 					email: this.email,
	 					password: this.password 
	 				}
					

					axios.post('/api/login', params)
                    	.then((response) => {                    		
							
                    		const accessToken = response.data.access_token
            				localStorage.setItem('access_token', accessToken)

            				const role = response.data.role
            				localStorage.setItem('roles', (role))

            				const permissions = response.data.permissions
            				localStorage.setItem('permissions', (permissions))

            				window.location.href = '/';

                        }).catch((error) => {
                            this.errors.push(error.response.data.error);
							
                        })
	 			}
	 		},
	 		validEmail:function(email) {
      			return (this.reg.test(email))
			},
			encriptar(valor) {
				let CryptoJS = require("crypto-js");
				let enc = CryptoJS.AES.encrypt(valor, 'dzkproject');
				return enc;
			}
	 	}
	}
</script>