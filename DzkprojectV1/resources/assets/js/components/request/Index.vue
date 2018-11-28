<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Lista de Solicitudes</h4>
                <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
                <div class="responsive"  v-if="!loading">

                  <div class="table-responsive" v-if="requests.length > 0">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Total Solicitud</th>
                                <th class="text-center">Total Impuesto</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Tienda</th>
                                <th class="text-center">Sucursal</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(request,index) in requests">
                              <td>{{ index+1 }}</td>
                              <td>{{ request.estatus }}</td>
                              <td class="text-right">
                                <span v-if="request.finalprice != null">
                                  {{ request.finalprice | currency }}
                                </span>
                                <span v-else>
                                  {{ request.initprice | currency }}
                                </span>
                              </td>
                              <td class="text-right">
                                <span v-if="request.finaltaxes != null">
                                  {{ request.finaltaxes | currency }}
                                </span>
                                <span v-else>
                                  {{ request.inittaxes | currency }}
                                </span>
                              </td>
                              <td class="text-right">
                                <span v-if="request.finaltotalprice != null">
                                  {{ request.finaltotalprice | currency }}
                                </span>
                                <span v-else>
                                  {{ request.inittotalprice | currency }}
                                </span>
                              </td>
                              <td>{{ request.commerce.name }}</td>
                              <td>{{ request.branch.name }}</td>
                              <td class="text-right" >
                                  <button v-if="request.applicationdate==null" @click="edit(request)" class="btn btn-warning btn-sm" >Editar</button>
                                  <b-btn v-b-modal="'showModal'" @click="showModal(request)" class="btn btn-sm" variant="default">Detalle</b-btn>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
                  <div v-else class="text-center">
                    <h2>No tiene solicitudes</h2>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <show></show>
  </div>
</template>
<script>
import Bus from '../../utilities/EventBus'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import show from './Show';

export default {
  name: 'index',
  components: {
    PulseLoader,
    show
  },
  data() {
    return {
      url: '/marketplace-user-requests',
      requests: [],
      loading: false,
      color: '#5bc0de',
      size:'30px',
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      this.loading = true
      axios.get('api' + this.url).then(response => {
        this.requests = response.data.data
      
        for(let i=0; i<this.requests.length; i++) {
          var application = this.requests[i].applicationdate
          var proccess = this.requests[i].processdate
          var alignment = this.requests[i].alignmentdate
          var final = this.requests[i].finaldate
          var delivery = this.requests[i].deliverdate

            if( application == null) {
              this.requests[i].estatus = 'Borrador'
            } else if(application != null && proccess == null) {
              this.requests[i].estatus = 'Solicitado'
            } else if(application != null && proccess != null && alignment == null) {
              this.requests[i].estatus = 'En proceso de separación'
            } else if(application != null && proccess != null && alignment != null && final == null) {
              this.requests[i].estatus = 'Finalización de separación - Alistamiento'
            } else if(application != null && proccess != null && alignment != null && final != null && delivery == null) {
              this.requests[i].estatus = 'Listo para recoger'
            } else if(application != null && proccess != null && alignment != null && final != null && delivery != null) {
              this.requests[i].estatus = 'Entregado - Retirado por cliente'
            }
        }
        this.loading = false
      })
      .catch(err => {
        this.loading = false
        console.log(err)
      })
    },

    showModal(data) {
      Bus.$emit('request', data);
    },
    edit(data) {
      const user_config = JSON.parse(localStorage.getItem('user_config'))

      if( user_config ) {
        localStorage.removeItem('user_config') 
      }

      var dat = {}
        dat.list = []
        dat.list.push({
          'commerce': data.commerce_idcommerce,
          'branch': data.branch_idbranch
        })
        localStorage.setItem('user_config', JSON.stringify(dat))

      this.$router.push('/list-products')
    },

  }
}
</script>
<style lang="scss" scoped>
  #spinner {
    text-align: center;
    padding-top: 10vh;
    height: 80vh;
  }
</style>
