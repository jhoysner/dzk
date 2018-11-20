<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Producto" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <label><i class="required">*</i> Nombre</label>
                          <input type="text" placeholder="Nombre" v-model="form.name" class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label>Referencia</label>
                          <input type="text" placeholder="Referencia" v-model="form.reference" class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <label>Precio</label>
                          <input type="number" min="0" step="0.01" placeholder="Precio" v-model="form.price" class="common-input">
                          <small class="text-danger" v-if="error.price">{{ error.price[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <label>Impuesto</label>
                          <input type="number" min="0" step="0.01" placeholder="Impuesto" v-model="form.taxpercentage" class="common-input">
                          <small class="text-danger" v-if="error.price">{{ error.price[0] }}</small>
                      </div>
                      
                      <div class="col-lg-12">
                        <div class="sorting"><i class="required">*</i> Unidad de Medida
                          <select v-model="form.productunitofmeasurement_idproductunitofmeasurement" required class="form-control common-input">
                            <option v-for="option in units" :value="option.idproductunitofmeasurement">{{option.name}}</option>
                          </select>
                          <small class="text-danger" v-if="error.productunitofmeasurement_idproductunitofmeasurement">{{ error.productunitofmeasurement_idproductunitofmeasurement[0] }}</small>
                         </div> 
                      </div>
                      <div class="col-lg-12">
                        <div class="sorting"><i class="required">*</i> Tipo
                          <select v-model="form.producttype_idproducttype" required class="form-control common-input">
                            <option v-for="option in types" :value="option.idproducttype">{{option.name}}</option>
                          </select>
                          <small class="text-danger" v-if="error.producttype_idproducttype">{{ error.producttype_idproducttype[0] }}</small>
                         </div> 
                      </div>
                      <div class="col-lg-12">
                        <div class="sorting"><i class="required">*</i> Tienda
                          <select v-model="form.commerce_idcommerce" required class="form-control common-input">
                            <option v-for="option in commerces" :value="option.commerce_idcommerce">{{option.commerces.name}}</option>
                          </select>
                          <small class="text-danger" v-if="error.commerce_idcommerce">{{ error.commerce_idcommerce[0] }}</small>
                         </div> 
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                            <label>Maneja Stock</label>&nbsp;
                            <toggle-button :value="form.usestock" v-model="form.usestock" :sync="true"/>
                            &nbsp;
                            <span v-if="form.usestock == true"><strong>SI</strong></span>
                            <span v-if="form.usestock == false"><strong>NO</strong></span>
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
                            <span v-if="form.image">
                              <img :src="form.image" alt="" >
                            </span>
                            <span v-else>
                              <i class="fa fa-picture-o fa-5x"></i>
                            </span>
                        </div>
                      </div>
                      <div class="col-lg-12 text-right">
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

    export default {
      name: 'create',
        data() {
            return {
              form: {
                name: '',
                reference: '',
                image: '',
                usestock: false,
                producttype_idproducttype: ''
              },
              imageError: '',
              url: '/products',
              types: [],
              commerces: [],
              units: [],
              error: {},
            }
        },
        created() {
          this.index();
        },
        methods: {
          index() {
            axios.get('api/unit-products')
              .then(response => {
                this.units = response.data.data          
              })
              .catch(err => {
                  console.log(err.response)
              })

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
          },
          submitForm() {
            this.error = {};

            let params = new FormData()

            _.each(this.form, function(val,key) {
              params.append(key,val)
            })

            if(this.form.usestock == true) {
              params.append('usestock',1)
            } else {
              params.append('usestock',0)
            }

            let input = document.querySelector('input[type=file]')                
            let file = (input.files[0] ? input.files[0]: null)
            if(file !== undefined || file !== NULL || file.type.match(/image.*/)) params.append('image', file);
            
            axios.post('api' + this.url, params)
            .then(response => {          
              this.$refs.createModal.hide();
              this.form = {};
              this.form.image = null
              this.$refs.image.value = null
              this.$parent.index()
              swal({
                title: "",
                text: response.data.success,
                icon: "success",
              })
            })
            .catch(err => {
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
                    this.form.image = e.target.result
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
