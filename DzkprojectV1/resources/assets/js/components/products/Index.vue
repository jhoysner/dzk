<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal v-can="'add_products'">Crear Producto</b-btn>
            <div class="settings-content">
                <h4>Lista de Productos</h4>
                <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
                <div class="responsive" v-if="!loading">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Referencia</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Tienda</th>
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="product in products">
                              <td>{{ product.name }}</td>
                              <td>{{ product.reference }}</td>
                              <td>{{ product.type.name }}</td>
                              <td>{{ product.commerces.name }}</td>
                              <td width="10%" v-if="product.image" id="imagen">
                                <img class="image-product" :src="product.image" > 
                              </td>
                              <td width="10%" v-else id="imagen">
                                <i class="fa fa-picture-o fa-2x"></i>
                              </td>
                              <td width="20%" class="text-right">
                                  <b-btn v-if="product.usestock == true && product.pert == true" v-can="'edit_products'" v-b-modal="'stockModal'" @click="stock(product.idproduct)" class="btn btn-sm btn-success" >Stock</b-btn>
                                  <b-btn v-if="product.pert == true" v-can="'edit_products'" v-b-modal="'editModal'" @click="edit(product.idproduct)" class="btn btn-sm" variant="warning">Editar</b-btn>
                                  <button v-if="product.pert" v-can="'delete_products'" type="button" @click="eliminar(product.idproduct)" class="btn btn-sm  btn-danger">Eliminar</button>
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
    <edit></edit>
    <stock></stock>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import create from './Create'
import edit from './Edit'
import stock from './Stock'
import axios from 'axios'

export default {
  name: 'index',
  components: {
    PulseLoader,create,edit,stock
  },
  data() {
    return {
      url: '/products',
      products: [],
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
        this.productos = response.data.data
        this.loading = false
      })
      .catch(err => console.log(err))

      axios.get('api/commerces-user')
        .then(response => {
          this.commerces = response.data.data[0].commerces_user
          for(let i=0; i<this.productos.length; i++) {
            let pos = this.commerces.map( function(e) {
              return (e.commerce_idcommerce)
            }).indexOf(this.productos[i].commerce_idcommerce)

            if(pos == -1 ) {
              this.productos[i].pert = false
            } else {
              this.productos[i].pert = true
            }
          }
          this.products = this.productos
        })
        .catch(err => {
          console.log(err.response)
        })                        
       
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },

    eliminar(id) {
        swal({
          title: "Esta seguro de eliminar el producto?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          showCancelButton: true,
          confirmButtonText: 'Si!'
        })
        .then((result) => {
                if (result) {
                axios.delete('api' + this.url + '/' + id).then(response => {
                        this.index()
                        swal(response.data.success, {
                        icon: "success",
                        });
                     })
                .catch(error => {
                  swal(error.data.errors, {
                        icon: "danger",
                        });
                })
                }
        });
    }
  }
}
</script>
<style lang="scss" scoped>
  #imagen {
    text-align: center;
  }
  #spinner {
    text-align: center;
    padding-top: 10vh;
    height: 80vh;
  }
  .image-product {
    width: 40%;
  } 
</style>
