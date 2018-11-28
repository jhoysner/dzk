<template>
    <div>
        <b-modal id="showModal" ref="showModal" title="Detalle de la Solicitud" hide-footer>
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Tienda</label>
                        <p>{{ commerce }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Sucursal</label>
                        <p>{{ branch }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estatus Actual</label>
                        <p>{{ detail.estatus }}</p>
                    </div>
                    <div class="form-group" v-if="detail.applicationdate != null">
                        <label class="font-weight-bold">Fecha de Solicitud</label>
                        <p>{{ detail.applicationdate }}</p>
                    </div>
                    <div class="form-group" v-if="detail.processdate != null">
                        <label class="font-weight-bold">Fecha de Procesamiento</label>
                        <p>{{ detail.processdate }}</p>
                    </div>
                    <div class="form-group" v-if="detail.alignmentdate != null">
                        <label class="font-weight-bold">Fecha de Separación</label>
                        <p>{{ detail.alignmentdate }}</p>
                    </div>
                    <div class="form-group" v-if="detail.finaldate != null">
                        <label class="font-weight-bold">Fecha de Alistamiento</label>
                        <p>{{ detail.finaldate }}</p>
                    </div>                
                    <div class="form-group" v-if="detail.deliverdate != null">
                        <label class="font-weight-bold">Fecha de Entrega</label>
                        <p>{{ detail.deliverdate }}</p>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">Producto</th>
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Total</th>
                          <th class="text-center">Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="detal in detail.details ">
                          <td>{{ detal.product.name }}</td>
                          <td class="text-right">{{ detal.quantity }}</td>
                          <td class="text-right">{{ detal.totalprice | currency }}</td>
                          <td>{{ detal.state.name }}</td>
                        </tr>
                      </tbody>
                    </table>    

                  </div>     
              </div>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus'

export default {
  name: 'edit',
  data() {
    return {
      detail: [],
      commerce: '',
      branch: '',
    }
  },
  created() {
    Bus.$on('request', (data) => {
      this.index(data)
    });
  },
   methods: {
    index(data) {
      this.detail = data
      this.commerce = this.detail.commerce.name 
      this.branch = this.detail.branch.name
    }
   }
}
</script>
<style lang="scss" scoped>

</style>
