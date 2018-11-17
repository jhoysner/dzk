<template>
    <div>
        <b-modal id="stockModal" ref="stockModal" title="Actualizar Stock de Producto" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                        <small  class="text-danger" v-if="error !=''">{{error}}</small>
                        <table class="table table-hover ">
                          <thead>
                            <tr>
                              <th width="60%" class="text-center">Sucursal</th>
                              <th class="text-center">Cantidad</th>
                            </tr>
                          </thead>
                          <tbody v-if="sucursales.length > 0">
                              <tr v-for="branch in sucursales">
                                <td width="60%">{{branch.name}}</td>
                                <td class="text-right"><input type="number" min="0" class="form-control text-right" @change="actTotal(branch.stock)" v-model="branch.stock"></td>
                              </tr>
                              <tr>
                                <td width="60%"><h4>Total</h4></td>
                                <td class="text-center"><input type="number" class="form-control text-right" v-model="total" readonly></td>
                              </tr>
                          </tbody>
                          <tbody v-else>
                            <tr>No tiene sucursal</tr>
                          </tbody>
                        </table>
                      </div>
                      <div v-if="sucursales.length > 0" class="col-lg-12 text-right">
                          <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                      </div>
                    </div>
                  </div>
              </div>
          </form>
        </b-modal> 
    </div>
</template>

<script>
import axios from 'axios';
import Bus from '../../utilities/EventBus'

    export default {
      name: 'stock',
        data() {
            return {
              productId: '',
              commerceId: '',
              error: [],
              sucursales: [],
              total: 0,
              branchs: {},
            }
        },
        created() {
          Bus.$on('product_id', (data) => {
            this.productId = data;
          });
          Bus.$on('commerce_id', (data) => {
            this.commerceId = data;
            this.stock(this.productId,this.commerceId);
          });
          
        },
        methods: {
          stock(product,commerce) {
            this.total = 0

            axios.get('api/product-commerces/'+commerce+'/'+product)
              .then(response => {
                this.products = response.data.data          
            })

            axios.get('api/branch-commerce/'+commerce)
              .then(response => {
                this.sucursales = response.data.data          

              for(let i=0; i<this.sucursales.length; i++) {
                var idbranch = this.sucursales[i].idbranch
                var prod = this.products.filter(function(operation) {
                  return operation.branch_idbranch==idbranch
                })

                if(Object.keys(prod).length === 0) {
                    this.sucursales[i].stock = 0  
                } else {
                  this.sucursales[i].stock = prod[0].stock  
                }

                this.total+=parseInt(this.sucursales[i].stock)
              } 

            })
          },
          actTotal(cant) {
            this.total = 0
            for(let i=0; i<this.sucursales.length; i++) {
              this.total+=parseInt(this.sucursales[i].stock)
            }
          },
          submitForm() {
            this.branchs.productId = this.productId
            this.branchs.branchs = this.sucursales 

            axios.post('api/update-stock', this.branchs)
              .then(response => {          
                this.$refs.stockModal.hide();
                this.sucursales = {};
                this.$parent.index()
                swal({
                  title: "",
                  text: response.data.success,
                  icon: "success",
                })
              })
              .catch(err => {
                console.log(err)
                if(err.response.status === 422) {
                    this.error = err.response.data.errors;
                }
              });

          },
        }

    }
</script>
