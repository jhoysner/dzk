<template>
    <div>
        <div id="section-mailbox" class="settings-content">
            <div class="row">
                <div class="panel panel-default widget col-sm-12 ">
                  <!-- seccion tiendas -->

                  <h2 class="my-4">Mis Tiendas</h2> 

                  <div class="row">             
                    <template v-for="commerce in commerces">
                      <div class="card ml-2" style="width: 18rem;" @click="findFollower(commerce.commerce_idcommerce)">
                        <div class="card-body">
                          <h5 class="card-title">{{commerce.commerces.name}}</h5>
                          <h6 class="card-subtitle mb-2 text-muted">{{commerce.commerces.email}}</h6>
                          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
<!--                           <a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a> -->
                        </div>
                      </div>
                    </template>
                  </div>
                  <hr>
                  <!-- seccion follower -->
                  <div v-if="followers.length ==0">
                     <p class="text-center mt-4"><small>Elige una tienda para ver sus seguidores</small></p>
                  </div>
                  <div v-if="followers.length > 0">

                    <button type="button" class="btn btn-outline-primary pull-right"  v-b-modal.showMessage @click="contactAll(commerceSelect.idcommerce)"> Contactar Seguidores</button>

                    <h3 class="text-center my-4">Seguidores de la Tienda : {{commerceSelect.name}}</h3>
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
                                       <button class="card-link btn btn-info btn-sm pull-right" v-b-modal.showMessage @click="contact(follower.user.id ,commerceSelect.idcommerce)"> Contactar</button>
                                    </div>
                                </div>
                            </div>
                        </template>

                  </div> 
                  </div>
                </div>            
            </div>
         
        </div>
        <message></message> 

    </div>

</template>

<script>
  import Bus from '../../utilities/EventBus';
  import message from '../message/message';

    export default {
      components: { message },
        data() {
            return {
                'followers': [],
                'user':{},
                'commerces':[],
                'commerceSelect':'',
            }
        },
        created(){
            this.auth();
            this.index();
        },
        methods: {
            auth() {
                axios.get('api/profile').then((response) => {
                  this.user = response.data.user;
                  // this.index();
                })
                .catch(err => console.log(err))
            },
            index() {
                axios.get('api/commerces-user')
                  .then(response => {
                    console.log(response);
                    this.commerces = response.data.data[0].commerces_user     
                    // this.findFollower(this.commerce);      
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            },            
            findFollower(id) {
                axios.get('api/user-follower/'+id)
                  .then(response => {
                     this.followers = response.data.data; 
                     this.commerceSelect = response.data.data[0].commerce;
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            },
            contactAll(commerce) {
                let data = {
                      client: this.user.id,
                      commerce: commerce,
                    };
              
                Bus.$emit('contact_all', data);
            },             
            contact(folllower, commerce) {
              console.log(folllower +" -" + commerce)
                let data = {
                      client: this.user.id,
                      commerce: commerce,
                      to : folllower,
                    };
              
                Bus.$emit('contact_follower', data);
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
