<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Comercio" hide-footer>
          <form @submit.prevent="update">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <input type="text" placeholder="Nombre" v-model="commerce.name" class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono principal" v-model="commerce.phone1" class="common-input">
                          <small class="text-danger" v-if="error.phone1">{{ error.phone1[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono alternativo" v-model="commerce.phone2" class="common-input">
                          <small class="text-danger" v-if="error.phone2">{{ error.phone2[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="email" placeholder="Email" v-model="commerce.email" class="common-input">
                          <small class="text-danger" v-if="error.email">{{ error.email[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label for="">Imagen actual</label>
                          <p>
                            <img class="image-commerce" :src="'images/commerce/'+picAct" />
                          </p>
                      </div>
                      <div class="col-lg-12">
                          <input type="file" id="image" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">

                          <img :src="commerce.image" class="avatar" alt="Image">
                          <p><small class="text-danger" v-if="imageError != '' ">{{ imageError }}</small></p>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Web" v-model="commerce.web" class="common-input">
                          <small class="text-danger" v-if="error.web">{{ error.web[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> País
                              <select class="form-control common-input" v-model="commerce.country_idcountry" @change="getStates()">
                                  <option v-for="country in countries" :value="country.id">
                                    {{ country.name }}
                                  </option>
                              </select>
                              <small class="text-danger" v-if="error.country_idcountry">{{ error.country_idcountry[0] }}</small>
                          </div>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Estado
                              <select class="form-control common-input" v-model="commerce.state_idstate" @change="getCities()">
                                <option v-for="state in states" :value="state.id">
                                  {{ state.name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="error.state_idstate">{{ error.state_idstate[0] }}</small>
                          </div>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Ciudad
                              <select class="form-control common-input" v-model="commerce.city_idcity">
                                <option v-for="city in cities" :value="city.id">
                                  {{ city.name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="error.city_idcity">{{ error.city_idcity[0] }}</small>
                          </div>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Categoría
                              <select class="form-control common-input" v-model="commerce.commercecategory_idcommercecategory">
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
import Bus from '../../utilities/EventBus';
import $ from 'jquery';

export default {
  name: 'edit',
  data() {
    return {
      editId: '',
      url: '/commerce',
      commerce: [],
      error: [],
      countries: [],
      states: [],
      cities: [],
      commerceCategories: [],
      commerceMaxSize: null,
      commerceMinSize: null,
      validExtensions: [],
      imageError: '',
      picture: '',
      picsize: '',
      picAct: '',
      options: [],
      value: [],
    }
  },

  created() {
    Bus.$on('edit_id', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getCountries();
      this.getCommerceCategories();
      this.getCommercesSize();
      this.getCommercesExt();
      this.getTags()
    });
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
      console.log(image);
      let reader = new FileReader();
      this.picture = image.name;
      this.picsize = image.size;

      reader.readAsDataURL(image);
      reader.onload = e => {
        this.commerce.image = e.target.result;
      }
    },

    edit(id) {
      axios.get('api' + this.url + '/' + id + '/edit').then(data => {
        this.commerce = data.data[0];
        this.StateAct(data.data[0].country_idcountry);
        this.CityAct(data.data[0].state_idstate);
        this.picAct = data.data[0].image;
        this.getTagsCommerce(data.data[0].idcommerce)
      })
      .catch(err => console.log(err))
    },

    getCountries() {
      axios.get('api/countries').then(data => {
        this.countries = data.data;
        //this.form.country_idcountry = data.data[0].id;
      })
      .catch(err => console.log(err))
    },

    StateAct(id) {
      axios.get('api/states/' + id).then(data => {
        this.states = data.data;
      })
      .catch(err => console.log(err))
    },

    getStates() {
      axios.get('api/states/' + this.commerce.country_idcountry).then(data => {
        this.states = data.data;
        this.commerce.state_idstate = data.data[0].id;
      })
      .catch(err => console.log(err))
    },

    CityAct(id) {
      axios.get('api/cities/' + id).then(data => {
        this.cities = data.data;
      })
      .catch(err => console.log(err))
    },

    getCities() {
      axios.get('api/cities/' + this.commerce.state_idstate).then(data => {
        this.cities = data.data;
        this.commerce.city_idcity = data.data[0].id;
      })
      .catch(err => console.log(err))
    },
    getCommerceCategories() {
      axios.get('api/commerce-categories').then(data => {
        this.commerceCategories = data.data.data;
      })
      .catch(err => console.log(err))
    },
    update() {
      this.error = {};
      this.imageError = '';

      this.validateExtensionImage();

      if(this.validateExtensionImage()) {
        this.imageError = 'La imagen no cumple con el formato adecuado.'; //enviamos el error,
        return false;
      }


      if(this.validateSizeImage()) {
        this.imageError = 'La imagen no cumple con las dimensiones esperadas. Debe estar entre: ' + this.commerceMinSize + ' a ' + this.commerceMaxSize + 'KB'; //enviamos el error,
        return false;
      }

      this.commerce.tags = this.value

      axios.put('api' + this.url + '/' + this.commerce.idcommerce, this.commerce)
      .then(data => {
        this.$refs.editModal.hide();
        this.$parent.index()
        swal({
          title: "Comercio actualizado",
          text: "Comercio actualizado con exito",
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
        if(this.picture != "") {
          let ext = this.picture.split('.').pop();
        
          let found = this.validExtensions.indexOf(ext);

          if(found == -1) {
            return true;
          } else {
            return false;
          }
        }

    },

    validateSizeImage() {
      if(this.picsize != "") {
        let fileSize = this.picsize; //Tamaño de la imagen subida.
        var sizeKB = parseInt(fileSize / 1024); //Tamaño de la imagen, en kb.
        if(sizeKB > this.commerceMaxSize || sizeKB < this.commerceMinSize) { //si el tamaño de la imagen, es mayorr al max del establecido en la base de datos o menor al min
          return true;
        } else {
          return false;
        }
      }
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
        console.log(value);

      })
      .catch(err => console.log(err))

    },
    getTagsCommerce(value){
        axios.get('api/tags-commerce/'+value)
          .then((response) => {
              this.value = response.data.data
              this.value.forEach(function(item) {
                item.code = item.idtags
              })
          })  
          .catch((err) => {

              console.log(err);
        });
      
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
<style lang="scss" scoped>
.image-commerce {
  width: 80px;
  height: 50px;
  border-radius: 50%;
}
</style>
