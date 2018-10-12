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

                        <div class="col-lg-12">
                          <label>Tags</label>
                          <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="Buscar o Agregar tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" @tag="addTag"></multiselect>
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
              results: [],
              options: [],
              value: [],
            }
        },

        created() {
          this.getCountries();
          this.getCommerceCategories();
          this.getCommercesSize();
          this.getCommercesExt();
          this.getTags()
        },

        methods: {
          //Guarda tag
          addTag (newTag) {
            const tag = {
              name: this.validName(newTag),
              code: this.randomString(36)
            }

            this.value.push(tag)
            this.options.push(tag)

            axios.post('api/tags', tag).then(response =>{
              //console.log(response)
            })
          },
          //Muestra Listado de Tag
          getTags() {
             axios.get('api/tags').then(response => {
              this.options = []
              this.options = response.data.tags
              this.options.forEach(function(item) {
                item.code = item.idtags
              })
            })
            .catch(err => console.log(err))
          },
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

          },
          randomString(len, an){
            an = an&&an.toLowerCase();
            var str="", i=0, min=an=="a"?10:0, max=an=="n"?10:62;
            for(;i++<len;){
              var r = Math.random()*(max-min)+min <<0;
              str += String.fromCharCode(r+=r>9?r<36?55:61:48);
            }
            return str;
          },
          validName(cadena) {
            let specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
            
            //Elimina los caracteres
            for (let i = 0; i < specialChars.length; i++) {
              cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
            }
            //conviente a minuscula
            cadena = cadena.toLowerCase();
            
            //eliminamso acentos y ñ
            cadena = cadena.replace(/á/gi,"a");
            cadena = cadena.replace(/é/gi,"e");
            cadena = cadena.replace(/í/gi,"i");
            cadena = cadena.replace(/ó/gi,"o");
            cadena = cadena.replace(/ú/gi,"u");
            cadena = cadena.replace(/ñ/gi,"n");
            
            return cadena
          }
        }

    }
</script>

<style media="screen">
  .avatar {
    width: 150px;
  }

fieldset[disabled] .multiselect {
  pointer-events: none;
}
.multiselect__spinner {
  position: absolute;
  right: 1px;
  top: 1px;
  width: 48px;
  height: 35px;
  background: #fff;
  display: block;
}
.multiselect__spinner:before,
.multiselect__spinner:after {
  position: absolute;
  content: "";
  top: 50%;
  left: 50%;
  margin: -8px 0 0 -8px;
  width: 16px;
  height: 16px;
  border-radius: 100%;
  border-color: #41B883 transparent transparent;
  border-style: solid;
  border-width: 2px;
  box-shadow: 0 0 0 1px transparent;
}
.multiselect__spinner:before {
  animation: spinning 2.4s cubic-bezier(0.41, 0.26, 0.2, 0.62);
  animation-iteration-count: infinite;
}
.multiselect__spinner:after {
  animation: spinning 2.4s cubic-bezier(0.51, 0.09, 0.21, 0.8);
  animation-iteration-count: infinite;
}
.multiselect__loading-enter-active,
.multiselect__loading-leave-active {
  transition: opacity 0.4s ease-in-out;
  opacity: 1;
}
.multiselect__loading-enter,
.multiselect__loading-leave-active {
  opacity: 0;
}
.multiselect,
.multiselect__input,
.multiselect__single {
  font-family: inherit;
  font-size: 14px;
  touch-action: manipulation;
}
.multiselect {
  box-sizing: content-box;
  display: block;
  position: relative;
  width: 100%;
  min-height: 40px;
  text-align: left;
  color: #35495E;
}
.multiselect * {
  box-sizing: border-box;
}
.multiselect:focus {
  outline: none;
}
.multiselect--disabled {
  pointer-events: none;
  opacity: 0.6;
}
.multiselect--active {
  z-index: 50;
}
.multiselect--active:not(.multiselect--above) .multiselect__current,
.multiselect--active:not(.multiselect--above) .multiselect__input,
.multiselect--active:not(.multiselect--above) .multiselect__tags {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.multiselect--active .multiselect__select {
  transform: rotateZ(180deg);
}
.multiselect--above.multiselect--active .multiselect__current,
.multiselect--above.multiselect--active .multiselect__input,
.multiselect--above.multiselect--active .multiselect__tags {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.multiselect__input,
.multiselect__single {
  position: relative;
  display: inline-block;
  min-height: 20px;
  line-height: 20px;
  border: none;
  border-radius: 5px;
  background: #fff;
  padding: 1px 0 0 5px;
  width: calc(100%);
  transition: border 0.1s ease;
  box-sizing: border-box;
  margin-bottom: 8px;
  vertical-align: top;
}
.multiselect__tag ~ .multiselect__input,
.multiselect__tag ~ .multiselect__single {
  width: auto;
}
.multiselect__input:hover,
.multiselect__single:hover {
  border-color: #cfcfcf;
}
.multiselect__input:focus,
.multiselect__single:focus {
  border-color: #a8a8a8;
  outline: none;
}
.multiselect__single {
  padding-left: 6px;
  margin-bottom: 8px;
}
.multiselect__tags-wrap {
  display: inline
}
.multiselect__tags {
  min-height: 40px;
  display: block;
  padding: 8px 40px 0 8px;
  border-radius: 5px;
  border: 1px solid #E8E8E8;
  background: #fff;
}
.multiselect__tag {
  position: relative;
  display: inline-block;
  padding: 4px 26px 4px 10px;
  border-radius: 5px;
  margin-right: 10px;
  color: #fff;
  line-height: 1;
  background: #5240b8;
  margin-bottom: 5px;
  white-space: nowrap;
  overflow: hidden;
  max-width: 100%;
  text-overflow: ellipsis;
}
.multiselect__tag-icon {
  cursor: pointer;
  margin-left: 7px;
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  font-weight: 700;
  font-style: initial;
  width: 22px;
  text-align: center;
  line-height: 22px;
  transition: all 0.2s ease;
  border-radius: 5px;
}
.multiselect__tag-icon:after {
  content: "×";
  color: #266d4d;
  font-size: 14px;
}
.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background: #369a6e;
}
.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
  color: white;
}
.multiselect__current {
  line-height: 16px;
  min-height: 40px;
  box-sizing: border-box;
  display: block;
  overflow: hidden;
  padding: 8px 12px 0;
  padding-right: 30px;
  white-space: nowrap;
  margin: 0;
  text-decoration: none;
  border-radius: 5px;
  border: 1px solid #E8E8E8;
  cursor: pointer;
}
.multiselect__select {
  line-height: 16px;
  display: block;
  position: absolute;
  box-sizing: border-box;
  width: 40px;
  height: 38px;
  right: 1px;
  top: 1px;
  padding: 4px 8px;
  margin: 0;
  text-decoration: none;
  text-align: center;
  cursor: pointer;
  transition: transform 0.2s ease;
}
.multiselect__select:before {
  position: relative;
  right: 0;
  top: 65%;
  color: #999;
  margin-top: 4px;
  border-style: solid;
  border-width: 5px 5px 0 5px;
  border-color: #999999 transparent transparent transparent;
  content: "";
}
.multiselect__placeholder {
  color: #ADADAD;
  display: inline-block;
  margin-bottom: 10px;
  padding-top: 2px;
}
.multiselect--active .multiselect__placeholder {
  display: none;
}
.multiselect__content-wrapper {
  position: absolute;
  display: block;
  background: #fff;
  width: 100%;
  max-height: 240px;
  overflow: auto;
  border: 1px solid #E8E8E8;
  border-top: none;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
  z-index: 50;
  -webkit-overflow-scrolling: touch;
}
.multiselect__content {
  list-style: none;
  display: inline-block;
  padding: 0;
  margin: 0;
  min-width: 100%;
  vertical-align: top;
}
.multiselect--above .multiselect__content-wrapper {
  bottom: 100%;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border-bottom: none;
  border-top: 1px solid #E8E8E8;
}
.multiselect__content::webkit-scrollbar {
  display: none;
}
.multiselect__element {
  display: block;
}
.multiselect__option {
  display: block;
  padding: 12px;
  min-height: 40px;
  line-height: 16px;
  text-decoration: none;
  text-transform: none;
  vertical-align: middle;
  position: relative;
  cursor: pointer;
  white-space: nowrap;
}
.multiselect__option:after {
  top: 0;
  right: 0;
  position: absolute;
  line-height: 40px;
  padding-right: 12px;
  padding-left: 20px;
}
.multiselect__option--highlight {
  background: #41B883;
  outline: none;
  color: white;
}
.multiselect__option--highlight:after {
  content: attr(data-select);
  background: #41B883;
  color: white;
}
.multiselect__option--selected {
  background: #F3F3F3;
  color: #35495E;
  font-weight: bold;
}
.multiselect__option--selected:after {
  content: attr(data-selected);
  color: silver;
}
.multiselect__option--selected.multiselect__option--highlight {
  background: #FF6A6A;
  color: #fff;
}
.multiselect__option--selected.multiselect__option--highlight:after {
  background: #FF6A6A;
  content: attr(data-deselect);
  color: #fff;
}
.multiselect--disabled {
  background: #ededed;
  pointer-events: none;
}
.multiselect--disabled .multiselect__current,
.multiselect--disabled .multiselect__select {
  background: #ededed;
  color: #a6a6a6;
}
.multiselect__option--disabled {
  background: #ededed;
  color: #a6a6a6;
  cursor: text;
  pointer-events: none;
}
.multiselect__option--disabled.multiselect__option--highlight {
  background: #dedede !important;
}
.multiselect-enter-active,
.multiselect-leave-active {
  transition: all 0.15s ease;
}
.multiselect-enter,
.multiselect-leave-active {
  opacity: 0;
}
.multiselect__strong {
  margin-bottom: 10px;
  display: inline-block
}
*[dir="rtl"] .multiselect {
    text-align: right;
}
*[dir="rtl"] .multiselect__select {
    right: auto;
    left: 1px;
}
*[dir="rtl"] .multiselect__tags {
    padding: 8px 8px 0px 40px;
}
*[dir="rtl"] .multiselect__content {
    text-align: right;
}
*[dir="rtl"] .multiselect__option:after {
    right: auto;
    left: 0;
}
*[dir="rtl"] .multiselect__clear {
    right: auto;
    left: 12px;
}
*[dir="rtl"] .multiselect__spinner {
    right: auto;
    left: 1px;
}
@keyframes spinning {
  from { transform:rotate(0) }
  to { transform:rotate(2turn) }
}
</style>
