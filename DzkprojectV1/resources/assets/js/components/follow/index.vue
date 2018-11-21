<template>
    <div>
        <div id="section-mailbox" class="settings-content">
            <div class="row">
                <div class="panel panel-default widget col-sm-12 ">
                    <div class="row">
                        <template v-for="follower in followers">                           
                            <div class="card ml-2">
                                <div class="card-body">
                                   <img class="card-img-top" src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                       
                                    <div class="col-xs-10 col-md-10">
                                        <center>
                                            <span class="badge badge-info">{{follower.user.firstname}} </span>
                                            <span class="badge badge-secondary">{{follower.user.email}}</span>
                                        </center>
                                    </div>
                                    <div class="card-footer bg-transparent border-success">
                                       <button class="card-link btn btn-danger btn-sm pull-left"> Bloquear</button>
                                       <button class="card-link btn btn-info btn-sm pull-right"> Contactar</button>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div> 
                </div>            
            </div>
         
        </div>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';

    export default {
        data() {
            return {
                'followers': [],
                // 'user':{},
                'commerce':{},
            }
        },
        created(){
            this.index();
        },
        methods: {
            index() {
                axios.get('api/commerces-user')
                  .then(response => {
                    this.commerce = response.data.data[0].commerces_user[0].commerce_idcommerce     

                    this.findFollower(this.commerce);      
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            },            
            findFollower(id) {
                axios.get('api/user-follower/'+id)
                  .then(response => {
                     this.followers = response.data.data; 
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            },
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
