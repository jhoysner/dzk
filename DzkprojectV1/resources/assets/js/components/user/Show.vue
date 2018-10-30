<template>
    <div>
        <b-modal id="showModal" ref="editModal" title="Detalle Usuario" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">ID Usuario</label>
                            <p>{{ user.id }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Primer Nombre</label>
                            <p>{{ user.firstname }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Apellidos</label>
                            <p>{{ user.lastname }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Correo Electrónico</label>
                            <p>{{ user.email }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">País</label>
                            <p>{{ user.country }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Estado</label>
                            <p>{{ user.state }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Ciudad</label>
                            <p>{{ user.city }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Estatus</label>
                            <p v-if="user.status">Activo</p>
                            <p v-else="user.status">Inactivo</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Grupos</label>
                            <p><multiselect v-model="value" placeholder="Buscar Grupos" label="name" track-by="id" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" disabled ></multiselect></p>
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
      name: ''

    }
  },

  mounted() {
    Bus.$on('edit_id', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getRoles();
    });
  },

  methods: {
    edit(id) {
      axios.get('api' + this.url + '/' + id ).then(response => {   
        this.user = response.data.user
        this.user.country = this.user.countries.name
        this.user.state = this.user.states.name
        this.user.city = this.user.cities.name
        this.value = response.data.user.roles
      })
      .catch(err => console.log(err))
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