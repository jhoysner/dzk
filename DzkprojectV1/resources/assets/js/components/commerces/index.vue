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
                      <table class="table table-hover table-bordered table-striped table-condensed">
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
                              <th>{{ commerce.idcommerce }}</th>
                              <th>{{ commerce.name }}</th>
                              <!--<th>{{ commerce.phone1 }}</th>
                              <th>{{ commerce.phone2 }}</th> -->
                              <th>{{ commerce.email }}</th>
                              <th>
                                <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                                  <p v-if="commerce.image == null">No posee imagen.</p>
                              </th>
                             <!--<th>{{ commerce.web }}</th>
                              <th>{{ commerce.countries.name }}</th>
                              <th>{{ commerce.states.name }}</th>
                              <th>{{ commerce.cities.name }}</th> -->
                              <th>{{ commerce.ccategories.name }}</th>
                              <th>
                                <td class="text-right">
                                    <b-btn v-b-modal="'showModal'" @click="show(commerce.idcommerce)" variant="default">Detalle</b-btn>
                                    <b-btn v-b-modal="'editModal'" @click="edit(commerce.idcommerce)" variant="warning">Editar</b-btn>
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
