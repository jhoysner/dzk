<template>
    <div>
        <b-modal v-model="show" id="editModal" ref="editModal" title="Editar Comercio" hide-footer>
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
                          <input type="file" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                          <img :src="commerce.image" class="avatar" alt="Image">
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

export default {
  data() {
    return {
      editId: '',
      url: '/commerce',
      commerce: [],
      error: [],
      countries: [],
      states: [],
      cities: [],
      commerceCategories: []
    }
  },

  created() {
    Bus.$on('edit_id', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getCountries();
      this.getCommerceCategories();
    });
  },

  methods: {
    getImage(e) {
      let image = e.target.files[0];
      let reader = new FileReader();

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
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
