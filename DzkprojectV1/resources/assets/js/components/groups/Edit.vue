<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Grupo" hide-footer>
          <form @submit.prevent="updateRole()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <input type="text" placeholder="Nombre" v-model="rol.name" class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
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
  name: 'edit',
  data() {
    return {
      editId: '',
      url: '/roles',
      rol: [],
      error: [],
    }
  },

  created() {
    Bus.$on('edit_id', (data) => {
      this.editId = data;
      this.edit(this.editId);
    });
  },

  methods: {
    edit(id) {
      axios.get('api' + this.url + '/' + id ).then(response => {
        this.rol = response.data.rol;
      })
      .catch(err => console.log(err))
    },
    updateRole() {
      this.error = {};
      axios.put('api' + this.url + '/' + this.rol.id, this.rol)
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