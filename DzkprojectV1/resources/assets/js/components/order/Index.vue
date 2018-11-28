<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Lista de Pedidos Por Atender</h4>
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Fecha Pedido</th>
                                <th class="text-center">Tienda</th>
                                <th class="text-center">Sucursal</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(order,index) in orders">
                              <td>{{ index+1 }}</td>
                              <td>{{ order.user.firstname }} {{ order.user.lastname }}</td>
                              <td class="text-center">{{ order.applicationdate }}</td>
                              <td>{{ order.commerce.name }}</td>
                              <td>{{ order.branch.name }}
                                <span class="pull-right">
                                  <b-btn v-b-modal="'branchModal'" title="Cambiar de Sucursal" class="btn btn-sm" variant="default"><i class="fa fa-edit"></i></b-btn>
                                </span>
                              </td>

                              <td class="text-right">
                                  <b-btn v-can="'view_orders'" v-b-modal="'showModal'" @click="show(order.idmarketplacelisting)" class="btn btn-sm" variant="default">Detalle</b-btn>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <branch></branch>
    <show></show>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus'
import branch from './Branch'
import show from './Show'

export default {
  name: 'index',
  components: {
    branch,
    show
  },
  data() {
    return {
      url: '/marketplace-allrequest',
      orders: [],
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {
        this.orders = response.data.data
      })
      .catch(err => console.log(err))
    },

    show(id) {
      Bus.$emit('order', id);
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    }
  }
}
</script>
<style lang="scss" scoped>
  
</style>
