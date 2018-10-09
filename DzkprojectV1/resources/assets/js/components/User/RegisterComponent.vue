<template>
<div id="section-register" class="settings-content">
    <h1>Registrar Usuario</h1>
        <div class="lg-12">
            <div v-if="errorsback.length">
                <ul>
                    <li role="alert" v-for="error in errorsback">
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          {{error}} <br>
                      
                          <a href="/login">Volver al Login</a>
                        </div>
                    </li>
                </ul>
            </div>
        
        </div>

    <form action="" class="billing-form" v-on:submit.prevent="submitRegister()" novalidate>
        <div class="row pt-30">
            <div class="col-lg-6">
                <input type="text" placeholder="Primer Nombre*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Primer Nombre*'" required class="common-input" v-model="firstname" ><small class="text-danger" v-if="errors.firstname">{{ errors.firstname }}</small>
            </div>
            <div class="col-lg-6">
                <input type="text" placeholder="Apellidos*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Apellidos*'" required class="common-input" v-model="lastname"><small class="text-danger" v-if="errors.lastname">{{ errors.lastname }}</small>
            </div>
            <div class="col-lg-12">
                <input type="email" placeholder="Correo Electrónico*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Correo Electrónico*'" required class="common-input" v-model="email"><small class="text-danger" v-if="errors.email">{{ errors.email }}</small>
            </div>
            <div class="col-lg-6">
                <input type="password" placeholder="Contraseña*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Contraseña*'" required class="common-input" v-model="password"><small class="text-danger" v-if="errors.password">{{ errors.password }}</small><small class="text-danger" v-if="errors.passwordmatch">{{ errors.passwordmatch }}</small>
            </div>
            <div class="col-lg-6">
                <input type="password" placeholder="Confirmación Contraseña*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Confirmación Contraseña*'" required class="common-input" v-model="password_confirmation"><small class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</small><small class="text-danger" v-if="errors.passwordmatch">{{ errors.passwordmatch }}</small>
            </div>
            <div class="col-lg-6">
                <div class="sorting">
                    <select v-model="country_id" @change="country(country_id)" class="form-control common-input">
                        <option v-for="option in countries" :value="option.id">{{option.name}}</option>
                    </select>
                    <small class="text-danger" v-if="errors.country_id">{{ errors.country_id }}</small>
                </div>
            </div>
            <div class="col-lg-6" >
                <div class="sorting">
                    <select v-model="state_id" @change="state(state_id)" required class="form-control common-input">
                        <option v-for="option in states" :value="option.id">{{option.name}}</option>
                    </select>
                    <small class="text-danger" v-if="errors.state_id">{{ errors.state_id }}</small>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="col-lg-6">
                <div class="sorting">
                    <select v-model="city_id" required class="form-control common-input">
                        <option v-for="option in cities" :value="option.id">{{option.name}}</option>
                    </select>
                    <small class="text-danger" v-if="errors.city_id">{{ errors.city_id }}</small>
                </div>
            </div>

            <div class="col-lg-12 text-right" required>
                <button class="primary-btn" :disabled="btnlocked">Registrar</button>
            </div>
        </div>
    </form>
</div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/getcountries')
                    .then(
                        (response) => {
                            this.countries = response.data;
                        }   
                    )
        },
        data() {
            return {
                'firstname':"",
                'lastname':"",
                'email': "",
                'password': "",
                'password_confirmation': "",
                'country_id': 0,
                'state_id': 0,
                'city_id' : 0,
                'countries': [],
                'states': [],
                'cities': [],
                'errors' : {},
                'errorsback' : [],
                'btnlocked' : false
            }
        },
        methods: {
            countDownChanged (dismissCountDown) {
              this.dismissCountDown = dismissCountDown
            },
            submitRegister() {
                this.errors = {};
                this.errorsback = [];
                if(!this.firstname) this.errors.firstname='Primer Nombre requerido.';
                if(!this.lastname) this.errors.lastname ='Apellidos requerido.';
                if(!this.email) this.errors.email = 'Correo Electrónico requerido.';
                if(!this.password) this.errors.password = 'Contraseña requerido.';
                if(!this.password) this.errors.password_confirmation = 'Confirmación Contraseña requerido.';
                if(!this.country_id) this.errors.country_id = 'Pais requerido.';
                if(!this.state_id) this.errors.state_id = 'Estado requerido.';
                if(!this.city_id) this.errors.city_id = 'Ciudad requerido.';

                if (this.password !== this.password_confirmation) {
                    this.password = ""
                    this.password_confirmation = ""
                    this.errors.passwordmatch = 'Contraseñas no coinciden'
                } 

                if(Object.keys(this.errors).length > 0) {
                    return
                }

                const params = {
                    'firstname' : this.firstname,
                    'lastname' : this.lastname,
                    'email' : this.email,
                    'password' : this.password,
                    'password_confirmation' : this.password_confirmation,
                    'country_id' : this.country_id,
                    'state_id' : this.state_id,
                    'city_id' : this.city_id
                }

                this.btnlocked = true

                axios.post('/register', params)
                   .then(response => {
                      this.btnlocked = false
                      swal({
                          title: "Aviso",
                          text: response.data.success,
                          icon: "success"
                        })
                        .then((result) => {
                        if (result) {
                           window.location.href = '/login';
                        }
                        });
                   })
                   .catch(errors => {
                        let errores = errors.response.data.error

                        for (let i in errores) {
                            this.errorsback.push(errores[i].toString())
                            console.log(errores[i])
                        }
                        this.btnlocked = false
                   });     
            },
            country(id) {
                this.cities = []
                const params = {
                    id: id 
                }

                axios.get('/getstates/'+id)
                    .then(
                        (response) => {
                            this.states = response.data;
                        }   
                    )
            },
            state(id) {
                const params = {
                    id: id 
                }

                axios.get('/getcities/'+id)
                    .then(
                        (response) => {
                            this.cities = response.data;
                        }   
                    )
            }

        }
    }
</script>
<style scoped>
#section-register{
    margin-top: 70px;
}
</style>