<template>
    <div>
        <b-modal id="createModal" ref="createtModal" title="Crear Grupo de Usuario" hide-footer>
                <form @submit.prevent="saveRole()">
                    <div class="modal-content">
                        <div class="modal-body">
                          <div class="form-group">
                              <label>Nombre</label>
                              <input type="text" class="form-control" v-model="form.name" >
                              <span class="text-danger" v-if="!!errors.name"> {{errors.name[0]}} </span>
                          </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i>Guardar</button>
                        </div>
                    </div>
                </form>
        </b-modal> 
    </div>
</template>

<script>
  import axios from 'axios';

    export default {
        name: "create",
        data() {
            return {
                form: { 
                  name: '' 
                },
                url: '/roles',
                error: [],
                errors: {},
            }
        },
        created(){
        },
        methods: {
            saveRole() {
              this.errors = {};

                axios.post('api'+this.url,this.form)
                .then(response => { 
                    this.form = {}            
                    $('#createModal').trigger("reset");
                    this.$refs.createtModal.hide()
                    this.$parent.index()
                    swal({
                      title: "",
                      text: response.data.success,
                      icon: "success",
                    })
                })
                .catch(error => {
                  if(error.response.status === 422) {
                    this.errors = error.response.data.error;
                  }
                });
            },         
        }

    }
</script>

<style>

</style>