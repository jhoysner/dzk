<template>
    <div>
        <div id="section-mailbox" class="settings-content">
            <div class="row">
                <div class="panel panel-default widget col-sm-8 offset-2 ">
                    <div class="panel-body">
                        <ul class="list-group" v-if="messages">
                            <template  v-for="item in messages">
                                
                                <li  @click="select(item)" class="list-group-item mb " :class="{ unread : messageState(item)}" >
                                    <div class="row">
                                        <div class="col-xs-2 col-md-2">
                                           <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                        </div>
                                        <div class="col-xs-10 col-md-10">
                                            <div v-if="messageState(item)" class="pull-right">
                                                   <span class="badge badge-info"> Leer </span>
                                            </div>                                    
                                            <div>
                                                <span class="badge badge-secondary"> Cliente ({{ item.from.firstname}} ) - Tienda ({{ item.commerce.name}})
                                                 </span>

                                                <p style="color:blue">
                                                    Asunto: {{item.subject ? item.subject : 'sin asunto' }} <br>
                                                </p>
                                                {{item.message}}
                                               

                                                <div class="action pull-right">
                                                       {{formatDate(item.created_at)}}
                                                </div>
                                                <br>

                                            </div>

                                        </div>
                                    </div>
                                </li>
                            </template>

                        </ul>
                        <div v-if="messages.length == 0">
                            <div >
                                
                                <h3 class="text-center">No tiene mensajes</h3>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
         

        </div>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';
    import moment from 'moment';
     moment.locale('es');


    export default {
        data() {
            return {
                'messages': [],
                'user':{},
            }
        },
        created(){
            this.auth();
        },
        methods: {
            auth() {
                axios.get('api/profile').then((response) => {
                  this.user = response.data.user;
                  this.index();
                })
                .catch(err => console.log(err))
            },
            index() {
              axios.get('api/all-messages/' + this.user.id).then(response => {  
                console.log(response)
                this.messages = response.data.data
              })
              .catch(err => console.log(err))
            },
            select(item){
                axios.get('/api/message-read/' + item.idmessengerservice).then(response => {  
                    console.log(response)
                })
                .catch(err => console.log(err))

                Bus.$emit('header-mesasge-false')

                this.$router.push('/imbox/'+item.thread)
            },
            formatDate(value){
                return  moment(value).format('LT a | MMMM D');
            },
            messageState(item) {

                if (item.users_id_from != this.user.id){

                    if (item.read_at == null ){

                        Bus.$emit('header-message-true') 
                        return true; 
                    }
                }
                return false;

            },             
          
        },
    }
</script>
<style>
#section-mailbox: {
 margin-top: 100px;
}
img {
  width: 100%;
}
.unread{
    background:#ebebeb;
}
.unread-text{
    color: red;
}

</style>
