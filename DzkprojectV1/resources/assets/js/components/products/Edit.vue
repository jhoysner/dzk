<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Producto" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <label><i class="required">*</i> Nombre</label>
                          <input type="text" placeholder="Nombre" v-model="product.name" class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label>Referencia</label>
                          <input type="text" placeholder="Referencia" v-model="product.reference" class="common-input">
                          <small class="text-danger" v-if="error.reference">{{ error.reference[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                        <div class="sorting"><i class="required">*</i> Tipo
                          <select v-model="product.producttype_idproducttype" required class="form-control common-input">
                            <option v-for="option in types" :value="option.idproducttype">{{option.name}}</option>
                          </select>
                          <small class="text-danger" v-if="error.producttype_idproducttype">{{ error.producttype_idproducttype[0] }}</small>
                         </div> 
                      </div>
                      <div class="col-lg-12">
                        <div class="sorting"><i class="required">*</i> Tienda
                          <select v-model="product.commerce_idcommerce" required class="form-control common-input">
                            <option v-for="option in commerces" :value="option.commerce_idcommerce">{{option.commerces.name}}</option>
                          </select>
                          <small class="text-danger" v-if="error.commerce_idcommerce">{{ error.commerce_idcommerce[0] }}</small>
                         </div> 
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                            <label>Maneja Stock</label>&nbsp;
                            <toggle-button :value="product.usestock" v-model="product.usestock" :sync="true"/>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="upload-fleid"> Seleccionar imagen de Producto
                          <div class="input-group input-file">
                            <input class="form-control" type="file" id="image" ref="image" placeholder="Imagen de Producto" accept="image/*" @change="previewImage">
                            <small class="text-danger" v-if="imageError != '' ">{{ imageError }}</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 text-center avatar-wrap">
                        <div class="avatar-thumb mr-20">
                            <span v-if="product.image">
                              <img :src="product.image" alt="" >
                            </span>
                            <span v-else>
                              <i class="fa fa-picture-o fa-5x"></i>
                            </span>
                        </div>
                      </div>
                      <div class="col-lg-12 text-right">
                          <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i>
                           Guardar</button>
                      </div>
                    </div>
                  </div>
              </div>
          </form>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus'

    export default {
      name: 'create',
        data() {
            return {
              editId: '',
              product: [],
              imageError: '',
              url: '/products',
              types: [],
              commerces: [],
              error: {},
            }
        },
        created() {
          Bus.$on('edit_id', (data) => {
            this.editId = data;
            this.edit(this.editId);
          });
        },
        methods: {
          edit(id) {
            axios.get('api/type-products')
              .then(response => {
                this.types = response.data.data          
              })
              .catch(err => {
                  console.log(err.response)
              })
            axios.get('api/commerces-user')
              .then(response => {
                this.commerces = response.data.data[0].commerces_user          
              })
              .catch(err => {
                  console.log(err.response)
              })
            axios.get('api/products/'+id)
              .then(response => {
                this.product = response.data.data
                if(this.product.usestock == 0 ) {
                  this.product.usestock=false
                } else {
                  this.product.usestock=true
                }

              })
              .catch(err => {
                  console.log(err.response)
              })
          },
          submitForm() {
            this.error = {};

            let params = new FormData()
            
            _.each(this.product, function(val,key) {
              params.append(key,val)
            })

            if(this.product.usestock == true) {
              params.append('usestock',1)
            } else {
              params.append('usestock',0)
            }

            axios.post('api' + this.url + '/'+ this.editId, params)
            .then(response => {          
              this.$refs.editModal.hide();
              this.product = {};
              this.product.image = null
              this.$refs.image.value = null
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
          previewImage: function(event) {
            let input = event.target

            if(input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.product.image = e.target.result
                }
                reader.readAsDataURL(input.files[0])
            }
          },

        }

    }
</script>

<style media="screen">
  img {
    width: 30%;
  }
</style>
