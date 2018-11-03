<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Permiso" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <label>Nombre</label>
                            <input type="text" placeholder="Nombre" v-model="form.name" class="common-input">
                            <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                            <p>Los permisos deben ser creados de la siguiente forma: <br>
                              Para módulo: 
                              <strong>nombre del módulo</strong> <br>
                              Para operaciones especifica
                              <strong>permiso_nombre del módulo</strong></p>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary" v-can="'add_permissions'"><i class="zmdi zmdi-plus"></i> Guardar</button>
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
              },
              url: '/permissions',
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
                title: "",
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

</style>
