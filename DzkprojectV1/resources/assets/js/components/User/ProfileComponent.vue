<template>
    <div>
        <div id="section-profile" class="settings-content">
            <h1>Perfil de Usuario</h1>
            <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>Primer Nombre</strong></label>
                        <p>{{user.firstname}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Segundo Nombre</strong></label>
                        <p>{{user.middlename}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Apellidos</strong></label>
                        <p>{{user.lastname}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Correo Electrónico</strong></label>
                        <p>{{user.email}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Teléfono</strong></label>
                        <p>{{user.phone}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Fecha de Nacimiento</strong></label>
                        <p>{{user.birthday}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Dirección</strong></label>
                        <p>{{user.address}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>País</strong></label>
                        <p>{{user.country}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Estado</strong></label>
                        <p>{{user.state}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Ciudad</strong></label>
                        <p>{{user.city}}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Latitud y Logintud</label>
                        <p>{{ user.latitude }} / {{ user.longitude }}</p>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex "><strong>Imagend de Perfil</strong>                        
                            <div class="col-md-6 text-center avatar-wrap">
                                <div class="avatar-thumb mr-20">
                                    <img :src="user.image" alt="" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="col-lg-12 text-right" id="buttons-form">
                        <a class="primary-btn white-btn" v-on:click="desactivate()">Desactivar Cuenta</a>
                        <b-btn v-b-modal="'editModal'" @click="edit(user.id)" variant="" class="primary-btn">Editar</b-btn>

                    </div>
                </div>
            </div>
        </div>
        <edit></edit>

    </div>

</template>

<script>
import Bus from '../../utilities/EventBus';
import edit from './Edit';
import { Logged } from '../../utilities/Logged'


    export default {
        name: "profile",
        mixins:[Logged],
        mounted() {
            this.index();
        },
        components : {
            edit
        },
        data() {
            return {
                'url': '/profile',
                'user' : { },
                'countries.name' : ""
            }
        },
        methods: {
            index() {

                //this.data = JSON.parse(localStorage.getItem('userdata'));
                axios.get('api'+ this.url)
                    .then(
                        (response) => {
                            this.user = response.data.user;
                            this.user.country = this.user.countries.name
                            this.user.state = this.user.states.name
                            this.user.city = this.user.cities.name
                        }   
                    )
            },
            desactivate() {
                let id = this.user.id

                swal({
                  title: "Esta seguro?",
                  text: "Una vez desactivada, la cuenta no estará disponible!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si!'
                })
                .then((result) => {
                        if (result) {
                            axios.get('/desactivateaccount/'+id) 
                                 .then((response) => {
                                swal(response.data.success, {
                                icon: "success",
                                });
                                window.location.href = '/login';
                             })
                        }
                });

            },
            edit(id) {
              Bus.$emit('id_user', id);
            },
        }
    }
</script>
<style>
#section-profile: {
 margin-top: 100px;
}
img {
  width: 30%;
}
</style>
