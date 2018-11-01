<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal v-can="'add_roles'">Crear Grupo</b-btn>
            <router-link to='/permissions'>
                  <a v-can="'permissions'" class="btn white-btn">
                    Permisos
                  </a>
              </router-link>
            <div class="settings-content">
                <h4>Lista de Grupos de Usuarios y Permisos</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                    
                    <div v-for="rol in roles"  role="tablist">
                      <b-card no-body class="mb-1" >
                        <b-card-header header-tag="header" class="p-1" role="tab">
                          <div class="text-center">
                            <a class="btn" block href="#" v-on:click="acordion(rol.id)" v-b-toggle="rol.name" variant="info">
                              <strong>{{rol.name}}</strong>
                            </a>
                            <i class="pull-right">
                              <b-btn v-b-modal="'editModal'" v-can="'edit_roles'" size="sm" @click="edit(rol.id)" variant="warning"><i class="fa fa-edit"></i></b-btn>
                              <button v-can="'delete_roles'" class="btn btn-danger btn-sm" @click="confirm(rol.id)" title="Eliminar"><i class="fa fa-trash"></i></button>
                            </i>
                          </div>
                        </b-card-header>
                        <b-collapse v-bind:id="rol.name" accordion="my-accordion" role="tabpanel">
                          <b-card-body>
                            <div class="card-text">
                                <b-form-group>
                                  <b>Cambiar los permisos:</b><br>
                                  <b-form-checkbox-group id="flavors"
                                                         v-model="selected"
                                                         name="flavs"
                                                         :options="flavours"
                                                         aria-label="Permisos"
                                  ></b-form-checkbox-group>
                                </b-form-group>
                              <button v-can="'edit_roles'" type="button" @click="updatePermission(rol.id,selected)" class="btn btn-primary btn-sm  btn-default"> Actualizar</button>
                            </div>
                          </b-card-body>
                        </b-collapse>
                      </b-card>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <create></create>
    <edit></edit>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';
import create from './Create';
import edit from './Edit';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    create, edit
  },
  data() {
    return {
      url: '/roles',
      roles: [],
      permissions: [],
      flavours: [],
      selected: [],
      allSelected: false,
      indeterminate: false,
    }
  },

  created() {
    this.index();
  },

  methods: {
    acordion(id){
      this.selected = []
      axios.get('api/permissionsroles/' + id).then(response => {        
        this.selected= response.data
        })
        .catch(err => console.log(err))
    },
    edit(id) {
      Bus.$emit('edit_id', id);
    },

    index() {
      this.flavours = []
      axios.get('api' + this.url).then(response => {        
        this.roles= response.data.roles
        this.permissions= response.data.permissions

        for(let perm in this.permissions) {
          const option = {
                text: this.permissions[perm]['name'],
                value: this.permissions[perm]['id']
              }
          this.flavours.push(option)
        }        
      })
      .catch(err => console.log(err))
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },

    confirm(id) {
        swal({
          title: "Seguro quieres eliminar el Grupo?",
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
        this.index();
      })
      .catch(err => console.log(err))
    },
    updatePermission(rol,selected) {
      this.permissions = []
      this.permissions = selected;
      console.log(this.permissions)  
      axios.put('api' + this.url+'/'+rol,this.permissions).then(response => {        
          console.log(response.data)
        swal({
          title: "Permisos actualizado",
          icon: "success",
        })  
      })
      .catch(err => {
        console.log(err)
      })
      
    },
  
  }
  

}
</script>
<style lang="scss" scoped>
</style>
