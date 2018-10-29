<template>
    <div>
        <b-modal id="permissionsModal" ref="editModal" title="Permisos Adicionales" hide-footer>
          <form @submit.prevent="updatePermissions()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="col-lg-12">
                      <b-form-group>
                        <b-form-checkbox-group id="flavors"
                                               v-model="selected"
                                               name="flavs"
                                               :options="flavours"
                                               class="ml-4"
                                               aria-label="Individual flavours"
                        ></b-form-checkbox-group>
                      </b-form-group>
                      <button type="button" @click="updatePermissions(selected)" class="btn btn-primary btn-sm  btn-default"> Actualizar</button>
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
  name: 'permissions',
  data() {
    return {
      userId: '',
      url: '/roles',
      user: [],
      error: [],
      permissions: [],
      flavours: ["1","2"],
      selected: [],
      permisos: [],
    }
  },

  created() {
    Bus.$on('user_id', (data) => {
      this.userId = data;
      this.index();
      this.permissionsUser();
    });
  },

  methods: {
    index() {
      this.flavours = []
      axios.get('api/roles').then(response => {        
        this.permissions= response.data.permissions

        for(let perm in this.permissions) {
          const option = {
                text: this.permissions[perm]['name'],
                value: this.permissions[perm]['id']
              }
          this.flavours.push(option)
        }        
        console.log(this.flavours)
      })
      .catch(err => console.log(err))
    },
    permissionsUser() {
      axios.get('api/permissionsuser/'+this.userId).then(response => {        
        this.selected= response.data
      })
      .catch(err => console.log(err))
    },
    updatePermissions() {
      this.error = {};
      this.permisos = this.selected
      axios.put('api/assignpermissionsuser/'+this.userId, this.permisos )
      .then(response => {
        this.$refs.editModal.hide();
        this.$parent.index()
        swal({
          title: "",
          text: response.data.success,
          icon: "success",
        })
      })
      .catch(err => {
        if(err.response.status === 422) {
            this.error = err.response.data.error;
        }
      });
    },

  }
}
</script>