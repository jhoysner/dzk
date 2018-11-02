<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Usuario" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <label>Primer Nombre</label>
                            <input type="text" v-model="user.firstname" class="common-input">
                            <small class="text-danger" v-if="error.firstname">{{ error.firstname[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Apellidos</label>
                            <input type="text" v-model="user.lastname" class="common-input">
                            <small class="text-danger" v-if="error.lastname">{{ error.lastname[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                              <label>Correo Electrónico</label>
                              <input type="text" v-model="user.email" class="common-input">
                              <small class="text-danger" v-if="error.email">{{ error.email[0] }}</small>
                          </div>
                        <div class="col-lg-12">
                            <label>Contraseña</label>
                            <input type="password" v-model="user.password" class="common-input">
                            <small class="text-danger" v-if="error.password">{{ error.password[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">País
                            <select v-model="user.country_idcountry" @change="country(user.country_idcountry)" class="form-control common-input">
                                <option v-for="option in countries" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.country">{{ error.country[0] }}</small>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">Estado
                            <select v-model="user.state_idstate" @change="state(user.state_idstate)" required class="form-control common-input">
                                <option v-for="option in states" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.state">{{ error.state[0] }}</small>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">Ciudad
                            <select v-model="user.city_idcity" required class="form-control common-input">
                                <option v-for="option in cities" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.city">{{ error.city[0] }}</small>
                           </div> 
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">Estatus
                            <select  v-model="user.status" class="form-control common-input">
                                <option value="0">Inactivo</option>
                                <option value="1" selected>Activo</option>
                            </select>
                           </div> 
                        </div>
                        <div class="col-lg-12">
                          <label>Grupos</label>
                          <multiselect v-model="value" placeholder="Buscar Grupos" label="name" track-by="id" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" ></multiselect>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="col-lg-12 text-right">
                            <br>
                            <button type="button" @click.prevent="update" v-can="'edit_users'" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
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
      url: '/users',
      user: [],
      error: [],
      countries: [],
      states: [],
      cities: [],
      roles:[],
      options: [],
      value: [],

    }
  },

  mounted() {
    Bus.$on('edit_id', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getCountries();
      this.getRoles();
    });
  },

  methods: {
    edit(id) {
      axios.get('api' + this.url + '/' + id ).then(response => {   
        this.user = response.data.user;
        this.value = response.data.user.roles
        this.country(this.user.country_idcountry)
        this.state(this.user.state_idstate)
      })
      .catch(err => console.log(err))
    },
    getCountries() {
      axios.get('api/countries').then(data => {
        this.countries = data.data;
      })
      .catch(err => console.log(err))
    },
    update() {
      this.errors = {};
      this.roles = []

      for(let val in this.value) {
        this.roles[val] =this.value[val]['name']  
      }

      this.user.roles = this.roles
console.log(this.user)
      axios.put('api'+this.url+'/'+this.user.id, this.user)
         .then(response => {
              this.user={}
              this.$refs.editModal.hide();              
              this.$parent.index()
              $('#editModal').trigger("reset");
              swal({
                title: "",
                text: response.data.success,
                icon: "success"
              })
         })
         .catch(errors => {
            if(errors.response.status === 422) {
              this.error = errors.response.data.error;
            }
         });

    },
    country(id) {
      this.cities = []
      axios.get('/api/states/'+id)
          .then(
              (response) => {
                  this.states = response.data;
              }   
          )
    },
    state(id) {
      axios.get('/api/cities/'+id)
        .then(
            (response) => {
                this.cities = response.data;
            }   
        )
    },
    getRoles() {
      axios.get('api/roles' ).then(response => {
        this.options = []
        this.options = response.data.roles
      })
      .catch(err => console.log(err))              
    },


  }
}
</script>

<style media="screen">
</style>