<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal>Crear Comercio</b-btn>
            <div class="settings-content">
                <h4>Lista de comercios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-striped mt-40 stat-table">
                          <thead>
                            <tr>
                                <th class="text-center">ID Comercio</th>
                                <th class="text-center">Nombre</th>
                                <!--<th class="text-center">Teléfono principal</th>
                                <th class="text-center">Teléfono alternativo</th>-->
                                <th class="text-center">Correo</th> 
                                <th class="text-center">Imagen</th>
                               <!-- <th class="text-center">Web</th>
                                <th class="text-center">País</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Ciudad</th> -->
                                <th class="text-center">Categoría</th>
                                <th class="text-center">Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="commerce in commerces">
                              <td>{{ commerce.idcommerce }}</td>
                              <td>{{ commerce.name }}</td>
                              <!--<td>{{ commerce.phone1 }}</td>
                              <td>{{ commerce.phone2 }}</td> -->
                              <td>{{ commerce.email }}</td>
                              <td>
                                <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                                  <p v-if="commerce.image == null">No posee imagen.</p>
                              </td>
                             <!--<td>{{ commerce.web }}</td>
                              <td>{{ commerce.countries.name }}</td>
                              <td>{{ commerce.states.name }}</td>
                              <td>{{ commerce.cities.name }}</td> -->
                              <td>{{ commerce.ccategories.name }}</td>
                              <td class="text-right">
                                  <b-btn v-b-modal="'showModal'" size="sm" @click="show(commerce.idcommerce)" variant="default">Detalle</b-btn>
                                  <b-btn v-b-modal="'editModal'" size="sm" @click="edit(commerce.idcommerce)" variant="warning">Editar</b-btn>
                                  <button type="button" @click="confirm(commerce.idcommerce)" class="btn btn-sm  btn-danger">Eliminar</button>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <create></create>
    <show></show>
    <edit></edit>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';
import create from './Create';
import show from './Show';
import edit from './Edit';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    create, show, edit
  },
  data() {
    return {
      url: '/commerce',
      commerces: [],
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
      axios.get('api' + this.url).then(data => {
        this.commerces = data.data.data;
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
