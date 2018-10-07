<template>
    <div>
        <b-modal v-model="show" id="createModal" ref="createModal" title="Crear Comercio" hide-footer>
          <form @submit.prevent="store()">
              <div class="modal-content">
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
                                <select class="form-control common-input" v-model="form.country_idcountry" @change="getStates()">
                                    <option v-for="country in countries" :value="country.id">
                                      {{ country.name }}
                                    </option>
                                </select>
                                <small class="text-danger" v-if="error.country_idcountry">{{ error.country_idcountry[0] }}</small>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Estado
                                <select class="form-control common-input" v-model="form.state_idstate" @change="getCities()">
                                  <option v-for="state in states" :value="state.id">
                                    {{ state.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.state_idstate">{{ error.state_idstate[0] }}</small>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Ciudad
                                <select class="form-control common-input" v-model="form.city_idcity">
                                  <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.city_idcity">{{ error.city_idcity[0] }}</small>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="sorting"> Categoría
                                <select class="form-control common-input" v-model="form.commercecategory_idcommercecategory">
                                  <option v-for="cc in commerceCategories" :value="cc.idcommercecategory">
                                    {{ cc.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.commercecategory_idcommercecategory">{{ error.commercecategory_idcommercecategory[0] }}</small>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                        </div>
                      </div>
                      
                  </div>
              </div>
          </form>
        </b-modal> 
    </div>
</template>

<script>
import axios from 'axios';

    export default {
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
              countries: [],
              states: [],
              cities: [],
              commerceCategories: [],
            }
        },

        created() {
          this.getCountries();
          this.getCommerceCategories();
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
              this.$refs.createModal.hide();
              this.form = {};
              this.$parent.index()
              swal({
                title: "Comercio creado",
                text: "Comercio creado con exito",
                icon: "success",
              })
            })
            .catch(err => {
              if(err.response.status === 422) {
                  this.error = err.response.data.errors;
              }
            });
          },

          getCountries() {
            axios.get('api/countries').then(data => {
              this.countries = data.data;
              this.form.country_idcountry = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getStates() {
            axios.get('api/states/' + this.form.country_idcountry).then(data => {
              this.states = data.data;
              this.form.state_idstate = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getCities() {
            axios.get('api/cities/' + this.form.state_idstate).then(data => {
              this.cities = data.data;
              this.form.city_idcity = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getCommerceCategories() {
            axios.get('api/commerce-categories').then(data => {
              this.commerceCategories = data.data.data;
              console.log(data);
              // this.form.commercecategory_idcommercecategory = data.data.data[0].idcommercecategory;
            })
            .catch(err => console.log(err))
          }
        }

    }
</script>

<style media="screen">
  .avatar {
    width: 150px;
  }
</style>
