<template>
  <div>
      <div class="col-lg-12">
          <div>
<!--               <router-link :to="{name: 'discount.create'}" class="btn btn-success mb-4">Create Discount</router-link>
 -->              
                    <a class="btn btn-success mb-4" data-toggle="modal" href='#modal-agregar-discount'>
                       ADD DISCOUNT
                    </a>
                  <div class="settings-content">
                  <h4>List Discounts</h4>
                <!-- <spinner :show="loadingProductos"></spinner> -->
                  <div class="responsive">
                      <div class="table-responsive">
                          <table class="table table-hover table-bordered table-striped table-condensed">
                              <thead>
                                  <tr>
                                      <th class="text-center">iddiscount</th>
                                      <th class="text-center">title</th>
                                      <th class="text-center">description</th>
                                      <th class="text-center">image</th>
                                      <th class="text-center">startdate</th>
                                      <th class="text-center">enddate</th>
                                      <th class="text-center">Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="discount in discounts">
                                      <td>{{ discount.iddiscount}}</td>
                                      <td>{{ discount.title }}</td>
                                      <td class="text-center">{{ discount.description }}</td>
                                      <td class="text-center">{{ discount.image }}</td>
                                      <td class="text-center">{{ discount.startdate }}</td>
                                      <td class="text-center">{{ discount.enddate }}</td>
                                      <td class="text-right">
                                          <button type="button" @click="detalleProducto(producto)" class="btn btn-sm  btn-default"> Detalles</button>
                                          <button type="button" @click="editarProducto(producto)" class="btn  btn-sm  btn-info"> Editar</button>
                                          <button type="button" @click="confirm(producto)" class="btn btn-sm  btn-danger">Eliminar</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>

                      <!-- <pagination :pag="pagination" @anterior="cargarProductos(...arguments)" @siguiente="cargarProductos(...arguments)"></pagination> -->
                    
                </div>
              </div>
          </div>
      </div>
      <create></create> 
  </div>
</template>
<script>
   import Create from './Create'

   export default {
        name: "discount",
        components: { Create},
        data() {
            return {
                // form: { nombre: '', codigo: '', costo_venta: null, stock_minimo: '', stock_total: '' },
                errorsProducto: {},
                discounts: {},
                // pagination: {},
                // loadingProductos: false,
                // tmpProducto: {},
                // query: '',
                // file: '',
                // accion: ''
            }
        },

        mounted() {
            this.cargarDiscount();
        },

        watch: {
            query() {
                this.cargarDiscount()
            }
        },

        methods: {
            cargarDiscount() {
                // this.errorsProducto = {}
                // this.loadingProductos = true

                // console.log(window.BaseUrl+'/api/discount');
                  axios.get('api/discount/')
                    .then((response) => {
                        // this.loadingProductos = false
                        this.discounts = response.data.data
                        // this.pagination = response.data.meta.pagination
                        // console.log(response.data.data);
                    })
                    .catch((err) => {
                        // this.loadingProductos = false
                        // let errors = this.$laravelErrors.handle(err)
                        // this.errorsProducto = errors.errors
                        console.log(err);
                    });
            },

        }
    }
</script>