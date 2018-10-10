<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal>Crear Parametro</b-btn>
            <div class="settings-content">
                <h4>Lista de Parametros</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center">ID Parametro</th>
                                <th class="text-center">Key</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="param in params">
                              <th>{{ param.idparams }}</th>
                              <th>{{ param.key }}</th>
                              <th>{{ param.val }}</th>
                              <td class="text-right">
                                  <b-btn v-b-modal="'showModal'" @click="show(commerce.idcommerce)" class="btn btn-sm" variant="default">Detalle</b-btn>
                                  <b-btn v-b-modal="'editModal'" @click="edit(commerce.idcommerce)" class="btn btn-sm" variant="warning">Editar</b-btn>
                                  <button type="button" @click="confirm(commerce.idcommerce)" class="btn btn-sm  btn-danger">Eliminar</button>
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
//import create from './Create';
//import show from './Show';
//import edit from './Edit';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    //create, show, edit
  },
  data() {
    return {
      url: '/params',
      params: [],
    }
  },

  created() {
    /*let data = {
      title: 'Comercios',
      subtitle: 'Crea un comercio'
    };
    Bus.$emit('jumbo-msg', data);*/

    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {
        this.params = response.data.params
        console.log(this.params)

      })
      .catch(err => console.log(err))
    },

    show(id) {
      Bus.$emit('id_commerce', id);
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },

    confirm(id) {
        swal({
          title: "Seguro quieres eliminar el comercio?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.destroy(id)
          }
        });
    },

    destroy(id) {
      axios.delete('api' + this.url + '/' + id).then(data => {
        console.log(data);
        this.index();
      })
      .catch(err => console.log(err))
    }
  }
}
</script>
<style lang="scss" scoped>
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }
</style>
