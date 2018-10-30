<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal v-can="'add_permissions'">Crear Permiso</b-btn>
            <div class="settings-content">
                <h4>Lista de Permisos</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                          </thead>
                          <tbody>
                            <tr v-for="perm in permissions">
                              <td>{{ perm.name }}</td>
                              <!--<td class="text-right">
                                  <b-btn v-b-modal="'editModal'" @click="edit(perm.id)" class="btn btn-sm" variant="warning">Editar</b-btn>
                              </td>-->
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
    <!--<edit></edit>-->
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';
import create from './Create';
//import edit from './Edit';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    create //, edit
  },
  data() {
    return {
      url: '/permissions',
      permissions: [],
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {        
        this.permissions= response.data.permissions
      })
      .catch(err => console.log(err))
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },
  }
}
</script>
