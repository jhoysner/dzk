<template>
    <div>
        <b-modal id="showModal" ref="showModal" title="Detalle del Pedido" hide-footer>
              <div class="modal-content">
                  <div class="modal-body">
                    <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
                    <div v-if="!loading">
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
                            <td>
                              <select v-model="detal.statelisting_idstatelisting" :disabled="detail.alignmentdate !== null" @change="updateState(detal.marketplacelisting_idmarketplacelisting,detal.idmarketplacelistingdetail,detal.statelisting_idstatelisting)" class="common-input">
                                <option v-for="opt in stateslisting" :value="opt.idstatelisting" >{{opt.name}}</option>
                              </select>                  
                            </td>
                          </tr>
                        </tbody>
                      </table>    
                      <hr>
                      <div class="form-group" v-if="detail.observations != null">
                          <label class="font-weight-bold">Observaciones</label>
                          <p>{{ detail.observations }}</p>
                      </div>
                      <div v-can="'edit_orders'">
                        <div class="text-center" v-if="detail.alignmentdate == null">
                          <button class="btn primary-btn" :disabled="saving" @click="end(detail.idmarketplacelisting)">Finalizar Separación</button>
                        </div>
                        <div class="text-center" v-if="detail.finaldate == null && detail.alignmentdate != null">
                          <button class="btn primary-btn" :disabled="saving" @click="final(detail.idmarketplacelisting)">Listo para Entrega</button>
                        </div>
                        <div class="text-center" v-if="detail.deliverdate == null && detail.finaldate != null">
                          <button class="btn primary-btn" :disabled="saving" @click="delivery(detail.idmarketplacelisting)">Entregado</button>
                        </div>
                      </div>
                    </div>
                  </div>     
              </div>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
  name: 'detail',
  components: {
    PulseLoader,
  },
  data() {
    return {
      detail: [],
      stateslisting: [],
      commerces: '',
      branchs: '',
      saving: false,
      loading: false,
      color: '#5bc0de',
      size:'20px',
      align: false,
    }
  },
  created() {
    Bus.$on('order', (data) => {
      this.index(data)
    })
  },
   methods: {
    index(order) {
      this.loading = true
      axios.get('api/stateslisting').then(response => {
        this.stateslisting = response.data.data
        console.log(this.stateslisting)
      })
      .catch(err => console.log(err))

      axios.get('api/marketplace/'+order).then(response => {
        this.detail = response.data.data[0]
        this.loading = false
        console.log(this.detail)
      })
      .catch(err => {
        this.loading = false
        console.log(err)
      })
    },
    updateState(order,id,state) {
      console.log(order)
      console.log(id)
      console.log(state)

      axios.post('api/marketplace-updatedatelist/'+order).then(response => {
        console.log(response.data)
      })
      .catch(err => console.log(err))


      axios.post('api/marketplace-updatestateproduct/'+id+'/'+state).then(response => {
        console.log(response.data)
      })
      .catch(err => {
        console.log(err)
      })
    },
    end(id){
      console.log(id)
      this.saving = true
      axios.post('api/marketplace-updatedatealignlist/'+id).then(response => {
        this.saving = false
        this.$refs.showModal.hide();
        this.$parent.index()
        console.log(response.data)
      })
      .catch(err => {
        this.saving = false
        console.log(err)
      })
    },
    final(id) {
      this.saving = true
      axios.post('api/marketplace-updatedatefinallist/'+id).then(response => {
        this.saving = false
        this.$refs.showModal.hide();
        this.$parent.index()
      })
      .catch(err => {
        this.saving = false
        console.log(err)
      })
    },
    delivery(id) {
      this.saving = true
      axios.post('api/marketplace-updatedatedeliverylist/'+id).then(response => {
        this.saving = false
        this.$refs.showModal.hide();
        this.$parent.index()
      })
      .catch(err => {
        this.saving = false
        console.log(err)
      })
    }


   }
}
</script>
<style lang="scss" scoped>
  #spinner {
      text-align: center;
    }
</style>
