<template>
<div id="section-reset" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
			    <h1>Resetear Contraseña</h1>
			    <div v-if="errors.length">
                    <ul>
                        <li role="alert" v-for="error in errors">
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{error}}
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-if="success.length">
                    <ul>
                        <li role="alert" v-for="tmp in success">
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{tmp}}<br>
                              <a href="/login">Volver al Login</a>
                            </div>
                        </li>
                    </ul>
                </div>

			    <form action="" class="billing-form" v-on:submit.prevent="submitReset()">
			        <div class="pt-30 text-center col-lg-12">
			            <div class="col-lg-12 ">
			                <input type="email" placeholder="Correo Electrónico*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Correo Electrónico*'" required class="common-input" v-model="email">
			            </div>
			            <div class="col-lg-12">
			                <input type="password" placeholder="Contraseña*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Contraseña*'" required class="common-input" v-model="password">
			            </div>
			            <div class="col-lg-12">
			                <input type="password" placeholder="Confirmación Contraseña*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Confirmación Contraseña*'" required class="common-input" v-model="password_confirmation">
			            </div>
			            
			            <div class="col-lg-12 text-right" >
			                <button class="primary-btn"><i class="fa fa-spinner fa-spin"></i> Resetear Contraseña </button>
			            </div>
			        </div>
			    </form>
			</div>
		</div>
	</div>
</template>


<script>
export default {
        mounted() {
        	this.token = window.location.pathname.substr(16)
        },
         data() {
            return {
                'email': "",
                'password': "",
                'password_confirmation': "",
                'token': "",
                'errors' : [],
                'success' : [],
            }
        },
        methods: {
        	submitReset() {
                this.errors = []
                if(!this.email) this.errors.push('Correo Electrónico requerido.');
                if(!this.password) this.errors.push('Contraseña requerida.');
                if(!this.password_confirmation) this.errors.push('La confirmación de la contraseña es requerida.');
                
                if (this.password !== this.password_confirmation) {
                    this.password = ""
                    this.password_confirmation = ""
                    this.errors.push('La contraseña no son iguales.')
                    return
                }

                const params = {
                    'email': this.email,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation,
                    'token': this.token
                }

                axios.post('/password/reset', params)
                    .then((response) => {
                            console.log(response)
                            if(response.status == 200) {
                            	swal({
                                  title: "Aviso",
                                  text: "Se reseteo correctamente la contraseña. Se redireccionará al Login.",
                                  icon: "success"
                                })
                                .then((result) => {
                                if (result) {
                                   window.location.href = '/login';
                                }
                                });
                            }

                        }).catch((error) => {
                            if(error.response.status == 422){
                                let errores = error.response.data.error
                                if(typeof(errores) == 'object'){
                                    for (let i in errores) {
                                        this.errors.push(errores[i].toString())
                                    }
                                }
                                if(typeof(errores) == 'string') {
                                    this.errors.push(errores)
                                }
                            }
                        })
            }
        }
    }
</script>
<style>
#section-reset {
	margin-top: 100px;
	margin-bottom: 60px;
}
</style>