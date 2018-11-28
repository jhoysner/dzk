<template>
    <div>
         <span v-if="state" class="icons icon-envelope"></span>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';
   
    export default {
        props: ['contact','user'],

        data() {
            return {
                state: false,
                messages: [],

            }
        },
        created(){

          this.index()
        },
        methods: {
          index(contact){
            axios.get('/api/find-thread-chat/'+this.user.id+'/'+this.contact.id).then(response => {  
              if(response.data.data.length > 0){
                    this.messages = response.data.data
                    this.unread();
              }
            })
            .catch(err => console.log(err))
          }, 
          unread(){
            self = this;
            self.messages.find(function(element) {
                if(element.users_id_to == self.user.id && element.read_at == null){
                  self.state = true;
                }
            });
          }
            
        },
        computed:{

        }
    }

</script>
<style>
#contacts > ul > li > div > div > div > span{
    right: 0 !important;
    left: inherit  !important;
    background-color: inherit  !important;
    color:red;
  }


</style>
