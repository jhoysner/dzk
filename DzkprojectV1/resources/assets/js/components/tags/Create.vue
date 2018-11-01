<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Tag" hide-footer>
          <form @submit.prevent="submitForm()">
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <label>Nombre</label>
                            <input type="text" placeholder="Nombre" v-model="form.name" class="common-input">
                            <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary" v-can="'add_tags'"><i class="zmdi zmdi-plus"></i> Guardar</button>
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
import functions from '../../utilities/Functions'

    export default {
      //mixins: [functions.formMixin],
      name: 'create',
        data() {
            return {
              form: {
                name: '',
              },
              url: '/tags',
              error: {},
            }
        },

        methods: {
          submitForm() {
            this.error = {};

            const params = {
              'name' : this.validName(this.form.name),
            }

            axios.post('api' + this.url, params)
            .then(response => {          
              this.$refs.createModal.hide();
              this.form = {};
              this.$parent.index()
              swal({
                title: "Tag creado",
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
          validName(cadena) {
            let specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
            
            //Elimina los caracteres
            for (let i = 0; i < specialChars.length; i++) {
              cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
            }
            //conviente a minuscula
            cadena = cadena.toLowerCase();
            
            //eliminamso acentos y ñ
            cadena = cadena.replace(/á/gi,"a");
            cadena = cadena.replace(/é/gi,"e");
            cadena = cadena.replace(/í/gi,"i");
            cadena = cadena.replace(/ó/gi,"o");
            cadena = cadena.replace(/ú/gi,"u");
            cadena = cadena.replace(/ñ/gi,"n");
            
            return cadena
          }

        }

    }
</script>

<style media="screen">
  .avatar {
    width: 150px;
  }
</style>
