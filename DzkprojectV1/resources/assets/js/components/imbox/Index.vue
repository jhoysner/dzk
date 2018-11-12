<template>
    <div>
        <div id="section-mailbox" class="settings-content">
            <div class="row">
            <div class="panel panel-default widget col-sm-8 offset-2 ">
                <div class="panel-body">
                    <ul class="list-group">
                            <li  @click="select(item)" class="list-group-item mb" v-for="item in messages">
                                <div class="row">
                                    <div class="col-xs-2 col-md-2">
                                       <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                    </div>
                                    <div class="col-xs-10 col-md-10">
                                        <div>
                                            <br>
                                            <p style="color:blue">
                                                Asunto: {{item.subject ? item.subject : 'sin asunto' }} <br>
                                            </p>
                                            {{item.message}}
                                            <a href="#" >
                                                <!-- {{$notification->data['text']}} -->
                                            </a>
                                            <div class="action pull-right">
                                                    <!-- <span class="glyphicon glyphicon-ok"></span> -->
                                                   {{item.created_at}}
                                         
                                            </div>
                                            <br>
                                            <div class="mic-info">
                                                <!-- {{$notification->created_at->diffForHumans()}} -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>            
<!--             <div class="panel panel-default widget col-sm-8 ">
                <div class="card">
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div> -->
            </div>

        </div>
    </div>

</template>

<script>
import Bus from '../../utilities/EventBus';

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
                // console.log(response)      

                this.messages = response.data.data
             
              })
              .catch(err => console.log(err))
            },
            select(item){
                // console.log(item)
                this.$router.push('/imbox/'+item.thread)
            }
          
        }
    }
</script>
<style>
#section-mailbox: {
 margin-top: 100px;
}
img {
  width: 100%;
}
</style>
