<template>
  <div>
        <b-modal  id="showMessage" ref="showMessage" :title="`Mensaje para ${commerce.name}`" hide-footer>
            <div class="container">
                    <div class="row mb-4">
                        
                        <b-form-input v-model="form.subject"
                                      type="text"
                                      placeholder="subject"></b-form-input>
                    </div>

                    <div class="row">
                       
                        <b-form-textarea id="textarea1"
                             v-model="form.message"
                             placeholder="Enter something"
                             :rows="3"
                             :max-rows="6">
                        </b-form-textarea>
                  </div>
                  <div class="modal-footer">
                        <b-btn  @click="hideModal">Cancelar</b-btn>
                        <button type="submit"  @click="send" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Enviar</button>
                  </div>
                </div>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
  export default {
    data() {
        return {
          form: {
            users_id_from: '',
            subject: '',
            message: '',
            commerce_idcommerce: '',
            messengerservicetopic_idmessengerservicetopic: '1',
          },  
          commerce: {},
        }
   
    },

    created() {
        Bus.$on('contact', (data) => {
          this.commerce = data.commerce
          this.form.users_id_from = data.client
          this.form.commerce_idcommerce = this.commerce.idcommerce
        });
    },

    methods: {
        send(){
          axios.post('/api/message-send', this.form).then(response => {
            console.log(response)
            this.form.subject = ''
            this.form.message = ''
            this.$refs.showMessage.hide()
            swal({
                title: "Mensaje Enviado",
                text: "Mensaje evniado con exito",
                icon: "success",
            })
          })
          .catch(err => console.log(err));

        },
        hideModal () {
          this.form.subject = ''
          this.form.message = ''
          this.$refs.showMessage.hide()
        }
    }
  }
</script>

<style>
  
</style>