<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Parametro" hide-footer>
          <form @submit.prevent="submitUpdate">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <label>Key</label>
                          <input type="text" placeholder="Key" v-model="param.key" class="common-input">
                          <small class="text-danger" v-if="error.key">{{ error.key[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label>Valor</label>
                          <input type="text" placeholder="Valor" v-model="param.val" class="common-input">
                          <small class="text-danger" v-if="error.val">{{ error.val[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label>Descripción</label>
                          <textarea row="2" cols="30" v-model="param.description" class="common-input"></textarea>
                          <small class="text-danger" v-if="error.description">{{ error.description[0] }}</small>
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
      url: '/params',
      param: [],
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
        this.param = response.data.param[0];
      })
      .catch(err => console.log(err))
    },

    submitUpdate() {
      this.error = {};

      axios.put('api' + this.url, this.param)
      .then(response => {
        this.$refs.editModal.hide();
        this.$parent.index()
        swal({
          title: "Parametro actualizado",
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
