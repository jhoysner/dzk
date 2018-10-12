<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Parametro" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <input type="text" placeholder="Key" v-model="form.key" class="common-input">
                            <small class="text-danger" v-if="error.key">{{ error.key[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Valor" v-model="form.val" class="common-input">
                            <small class="text-danger" v-if="error.val">{{ error.val[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Descripción</label>
                            <textarea row="2" cols="30" v-model="form.description" class="common-input"></textarea>
                            <small class="text-danger" v-if="error.description">{{ error.description[0] }}</small>
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
                key: '',
                val: '',
                description: ''
              },
              url: '/params',
              error: {},
            }
        },

        methods: {
          submitForm() {
            this.error = {};

            axios.post('api' + this.url, this.form)
            .then(response => {          
              this.$refs.createModal.hide();
              this.form = {};
              this.$parent.index()
              swal({
                title: "Parametro creado",
                text: response.data.success,
                icon: "success",
              })
            })
            .catch(err => {
              if(err.response.status === 422) {
                console.log(err.response.data.errors)
                  this.error = err.response.data.errors;
              }
            });
          },

        }

    }
</script>

<style media="screen">
  .avatar {
    width: 150px;
  }
</style>
