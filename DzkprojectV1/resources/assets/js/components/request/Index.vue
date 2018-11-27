<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Lista de Solicitudes</h4>
                <div class="responsive">
                  <div class="table-responsive">
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
                              <td class="text-right">
                                  <b-btn v-can="'view_params'" v-b-modal="'showModal'" @click="show()" class="btn btn-sm" variant="default">Detalle</b-btn>
                                  <b-btn v-can="'edit_params'" v-b-modal="'editModal'" @click="edit()" class="btn btn-sm" variant="warning">Editar</b-btn>
                              </td>
                              </th>
                            </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';

import axios from 'axios';

export default {
  name: 'index',
  components: {
  },
  data() {
    return {
      url: '/marketplace-user-requests',
      requests: [],
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {
        this.requests = response.data.data
        console.log(this.requests)

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

      })
      .catch(err => console.log(err))
    },

    show(id) {
      Bus.$emit('id_params', id);
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },

  }
}
</script>
<style lang="scss" scoped>
  
</style>
