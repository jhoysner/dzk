<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal>Crear Usuario</b-btn>
            <div class="settings-content">
                <h4>Lista de Usuarios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center">Nombres y Apellidos</th>
                                <th class="text-center">Correo Electrónico</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="user in users">
                              <td >{{ user.firstname }} {{ user.middlename }} {{ user.lastname }}</td>
                              <td >{{ user.email }}</td>
                              <td >{{ user.status }}</td>
                              <td class="text-right">
                                  <b-btn v-b-modal="'permissionsModal'" @click="permissions(user.id)" class="btn btn-default btn-sm" title="Permisos Adicionales"><i class="fa fa-cogs"></i></b-btn>
                                  <b-btn v-b-modal="'showModal'" @click="show(user.id)" class="btn btn-sm" variant="default"><i class=""></i> Detalle</b-btn>
                                  <b-btn v-b-modal="'editModal'" @click="edit(user.id)" class="btn btn-sm" variant="warning"><i class=""></i> Editar</b-btn>
                                  <button type="button" @click="confirm(user.id)" class="btn btn-sm btn-danger" title="Eliminar"><i class=""></i>Eliminar</button>
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
    <edit></edit>
    <show></show>
    <permissions></permissions>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';
import create from './Create';
import edit from './Edita';
import show from './Show';
import permissions from './Permissions';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    create, permissions, edit, show
  },
  data() {
    return {
      url: '/users',
      users: [],
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {        
        this.users= response.data.users.data
        this.users.forEach(function(item) {
          (item.status == 0)? item.status = "Inactivo":item.status = "Activo";
        })
      })
      .catch(err => console.log(err))
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },
    show(id) {
      Bus.$emit('edit_id', id);
    },

    permissions(id) {
      Bus.$emit('user_id', id);
    },

    confirm(id) {
        swal({
          title: "Seguro quieres eliminar el usuario?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((response) => {
          if (response) {
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
</style>
