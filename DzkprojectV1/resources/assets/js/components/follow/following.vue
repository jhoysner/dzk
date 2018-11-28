<template>
    <div>
        <div id="section-mailbox" class="settings-content">
            <div class="row">
                <div class="panel panel-default widget col-sm-12 ">
                  <!-- seccion tiendas -->

                  <h2 class="my-4 text-center">Tiendas que Sigues</h2> 

                  <hr>

                  <div class="row">
                        <template v-for="follower in following">                           
                            <div class="card ml-2">
                                <div class="card-body">
                                   <img class="rounded mx-auto d-block" src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                       
                                    <div class="col-xs-12 col-md-12">
                                        <center>
                                            <span class="badge badge-info">{{follower.commerce.name}} </span><br>
                                            <span class="badge badge-secondary">{{follower.commerce.email}}</span>
                                        </center>
                                    </div>
                                    <div class="card-footer bg-transparent border-success text-center">
                                                       
                                      <div v-if="!follower.locked">
                                          <button type="button" class="btn btn-primary"  @click="dejarSeguir(follower.commerce.idcommerce)" >

                                             Siguiendo
                                          </button>
                                      </div>

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
                'following': [],
                'user':{},
                'followState': false,
            }
        },
        created(){
            this.auth();
        },
        methods: {
            auth() {
                axios.get('api/profile').then((response) => {
                  this.user = response.data.user;
                  this.findFollowing();
                })
                .catch(err => console.log(err))
            },          
            findFollowing() {
                axios.get('/api/user-following/'+this.user.id)
                  .then(response => {
                     console.log(response)
                     this.following = response.data.data; 
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            },      
            dejarSeguir(commerce) {
                console.log('Dejar seguir');
                axios.get('/api/unfollow/'+this.user.id+'/'+commerce).then((response) => {
                    this.findFollowing();
                })
                .catch(err => console.log(err))
            },
      
        }    
    }
</script>
<style>
#section-mailbox: {
 margin-top: 100px;
}
img {
  width: 50%;
}
.card-image{
  margin: 0 auto;
}

</style>
