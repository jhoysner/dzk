<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Parametro" hide-footer>
          <form @submit.prevent="submitUpdate">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <label>Nombre</label>
                          <input type="text" placeholder="Nombre" v-model="tag.name" class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                      </div>
                      <div class="col-lg-12 text-right">
                          <button type="submit" class="btn btn-primary" v-can="'edit_tags'"><i class="zmdi zmdi-plus"></i> Guardar</button>
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
      url: '/tags',
      tag: [],
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
      axios.get('api' + this.url + '/' + id).then(response => {
        this.tag = response.data.tag[0];
      })
      .catch(err => console.log(err))
    },

    submitUpdate() {
      this.error = {};
      console.log(this.tag)
      axios.put('api' + this.url, this.tag)
      .then(response => {
        this.$refs.editModal.hide();
        this.$parent.index()
        swal({
          title: "Tag actualizado",
          text: response.data.success,
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
