<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Comercio" hide-footer>
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
                            <input type="file" id="image" placeholder="Imagen corporativa" @change="getImage" accept="image/*" ref="image" class="common-input">
                            <img v-if="!!form.image" :src="form.image" class="avatar" alt="Image">
                            <p><small class="text-danger" v-if="imageError != '' ">{{ imageError }}</small></p>
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
import $ from 'jquery';

    export default {
      name: 'create',
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
              commerceMaxSize: null,
              commerceMinSize: null,
              validExtensions: [],
              imageError: '',
            }
        },

        created() {
          this.getCountries();
          this.getCommerceCategories();
          this.getCommercesSize();
          this.getCommercesExt();
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
            this.imageError = '';

            if(this.validateExtensionImage()) {
              this.imageError = 'La imagen no cumple con el formato adecuado.'; //enviamos el error,
              return false;
            }


            if(this.validateSizeImage()) {
              this.imageError = 'La imagen no cumple con las dimensiones esperadas. Debe estar entre: ' + this.commerceMinSize + ' a ' + this.commerceMaxSize + 'KB'; //enviamos el error,
              return false;
            }

            axios.post('api' + this.url, this.form)
            .then(data => {          
              //Sino, continuamos nuestra operacion.

              console.log(data);
              this.$refs.createModal.hide();
              this.form = {};
              this.getCountries();
              this.getCommerceCategories();
              this.form.image = null;
              this.$refs.image.value = null
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

          validateExtensionImage() {
            if($("#image").val() != "") {
              let ext = $("#image").val().split('.').pop();
            
              let found = this.validExtensions.indexOf(ext);

              if(found == -1) {
                return true;
              } else {
                return false;
              }
            }

          },

          validateSizeImage() {
            if($("#image").val() != "") {
              let fileSize = $('#image')[0].files[0].size; //Tamaño de la imagen subida.
              var sizeKB = parseInt(fileSize / 1024); //Tamaño de la imagen, en kb.
              if(sizeKB > this.commerceMaxSize || sizeKB < this.commerceMinSize) { //si el tamaño de la imagen, es mayorr al max del establecido en la base de datos o menor al min
                return true;
              } else {
                return false;
              }
            }
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
              this.form.commercecategory_idcommercecategory = data.data.data[0].idcommercecategory;
            })
            .catch(err => console.log(err))
          },

          getCommercesSize() {
            axios.get('api/commerce-size').then(data => {
              let value = data.data[0].val;
              let val = JSON.parse(value);

              this.commerceMaxSize = val.maxsize;
              this.commerceMinSize = val.minsize;

              console.log('El minimo permitido es: ' + this.commerceMinSize + 'KB Y el maximo es: ' + this.commerceMaxSize + 'KB');

            })
            .catch(err => console.log(err))
          },

          getCommercesExt() {
            axios.get('api/commerce-ext').then(data => {
              let value = data.data[0].val;
              this.validExtensions = value;

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
