<template>
    <div>
        <div class="modal fade" id="add-commerce">
          <div class="modal-dialog">
            <form @submit.prevent="store()">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Crea un comercio</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row pt-30">
                        <div class="col-lg-12">
                            <input type="text" placeholder="Nombre" v-model="form.name" class="common-input">
                            <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Telefono principal" v-model="form.phone1" class="common-input">
                            <small class="text-danger" v-if="error.phone1">{{ error.phone1[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Telefono alternativo" v-model="form.phone2" class="common-input">
                            <small class="text-danger" v-if="error.phone2">{{ error.phone2[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="email" placeholder="Email" v-model="form.email" class="common-input">
                            <small class="text-danger" v-if="error.email">{{ error.email[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="file" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                            <img :src="form.image" class="avatar" alt="Image">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Web" v-model="form.web" class="common-input">
                            <small class="text-danger" v-if="error.web">{{ error.web[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <div class="sorting"> País
                                <select class="form-control common-input" v-model="form.country_idcountry">
                                    <option value="1">Colombia</option>
                                    <option value="2">Venezuela</option>
                                    <option value="3">Perú</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Estado
                                <select class="form-control common-input" v-model="form.state_idstate">
                                    <option value="1">District*</option>
                                    <option value="1">Default sorting</option>
                                    <option value="1">Default sorting</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Ciudad
                                <select class="form-control common-input" v-model="form.city_idcity">
                                    <option value="1">District*</option>
                                    <option value="1">Default sorting</option>
                                    <option value="1">Default sorting</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Categoría
                                <select class="form-control common-input" v-model="form.commercecategory_idcommercecategory">
                                    <option value="1">Category 1</option>
                                    <option value="1">Category 2</option>
                                    <option value="1">Category 3</option>
                                    <option value="1">Category 4</option>
                                    <option value="1">Category 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                        </div>
                      </div>

                    </div>

                </div>
            </form>
          </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        name: "create",
        data() {
            return {
              form: {
                name: '',
                phone1: '',
                phone2: '',
                email: '',
                image: '',
                web: '',
                country_idcountry: '',
                state_idstate: '',
                city_idcity: '',
                commercecategory_idcommercecategory: ''
              },
              url: '/commerce',
              error: {},
            }
        },
        methods: {
          getImage(e) {
            let image = e.target.files[0];
            let reader = new FileReader();

            reader.readAsDataURL(image);
            reader.onload = e => {
              this.form.image = e.target.result;
            }
          },

          store() {
            this.error = {};

            axios.post('api' + this.url, this.form)
  					.then(data => {
  						console.log(data);
  					})
  					.catch(err => {
              if(err.response.status === 422) {
	                this.error = err.response.data.errors;
	            }
            });
          }
        }

    }
</script>

<style media="screen">
  .avatar {
    width: 150px;
  }
</style>
