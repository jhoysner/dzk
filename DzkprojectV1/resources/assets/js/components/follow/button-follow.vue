<template>
    <div>

        <button v-if="!userStateFollow()" type="button" class="btn" :class="classState"  @click="seguir" >

            Seguir
        </button>        

        <button v-if="userStateFollow()" type="button" class="btn" :class="classState"  @click="dejarSeguir" >

             Siguiendo
        </button>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';
   
    export default {
        props: ['user','commerce', 'state'],

        data() {
            return {
                commerceFollower: [],
            }
        },

        methods: {
            seguir() {

                console.log('seguir');
                axios.get('/api/follow/'+this.user.id+'/'+this.commerce).then((response) => {
                    this.$parent.followerState();
                })
                .catch(err => console.log(err))
            },            
            dejarSeguir() {
                console.log('Dejar seguir');
                axios.get('/api/unfollow/'+this.user.id+'/'+this.commerce).then((response) => {
                    this.$parent.followerState();
                })
                .catch(err => console.log(err))
            },
            userStateFollow(id){

                return this.state
            }
            
        },
        computed: {
          classState: function () {
            return {
              'btn-outline-primary': this.state == false,
              'btn-primary': this.state == true
            }
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
.unread{
    background:#ebebeb;
}
.unread-text{
    color: red;
}
.unread-text{
    color: red;
}

/* #section-profile > div.container > div > div.col-lg-3.sidebar.theme-details-sidebar > div:nth-child(1) > div > button:hover{
    background-color: red;
}*/
</style>
