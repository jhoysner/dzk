<template>
    <div>
        <b-modal id="showModal" ref="showModal" title="Detalle de Parametro" hide-footer>
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">ID Parametro</label>
                        <p>{{ param.idparams }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Key</label>
                        <p>{{ param.key }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Valor</label>
                        <p>{{ param.val }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Descripción</label>
                        <p>{{ param.description }}</p>
                    </div>

                    
                  </div>     
              </div>
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

  mounted() {
    Bus.$on('id_params', (id) => {
      axios.get('api' + this.url + '/' + id).then(response => {
        this.param = response.data.param[0]
      })
      .catch(err => console.log(err))
    });
  }
}
</script>
<style lang="scss" scoped>

</style>
