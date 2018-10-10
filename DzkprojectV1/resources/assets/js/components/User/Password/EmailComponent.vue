<template>
    <div id="section-register" class="container">
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
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <input type="email" placeholder="Correo Electrónico*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Correo Electrónico*'" required class="common-input" v-model="email">
                        </div>
                        <div class="col-lg-12 text-right" required>
                            <button class="primary-btn" :disabled="btnlocked">Solicitar</button>
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
            console.log('Component mounted.')
        },
        data() {
            return {
                'email': "",
                'errors': [],
                'success':[],
                'btnlocked' : false

            }
        },
        methods: {
            submitReset() {
            this.errors = [];
            this.success = [];

                if(!this.email){ 
                    this.errors.push('El correo electrónico es requerido.');
                    return;
                }

                const params = {
                    'email': this.email
                }

                this.btnlocked = true
                axios.post('/password/email', params)
                    .then((response) => {
                            console.log(response.status)
                            if(response.status == 200) {
                                this.success.push('Se ha enviado un correo electrónico para resetear la contraseña.')
                            }
                            //window.location.href = '/login';

                        }).catch((error) => {
                            this.btnlocked = true
                            this.errors.push(error.response.data)
                        })
            }
        }
    }
</script>
<style>
#section-register {
    margin-top: 120px;
    margin-bottom: 100px;
}
</style>
