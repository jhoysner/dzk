<template>
    <div>
        <b-modal id="stockModal" ref="stockModal" title="Actualizar Stock de Producto" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                      <div class="col-lg-12">
                          <label><i class="required">*</i>Cantidad</label>
                          <input type="number" min="0" v-model="product.stock" class="common-input">
                          <small class="text-danger" v-if="error.stock">{{ error.stock[0] }}</small>
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
              product: [],
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
              error: {},
            }
        },
        created() {
          this.index();
        },
        methods: {
          index() {
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
