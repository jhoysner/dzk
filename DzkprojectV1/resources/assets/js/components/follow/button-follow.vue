<template>
    <div>
        <button type="button" class="btn btn-outline-primary"  @click="seguir()" >Seguir</button>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';
   
    export default {
        props: ['user','commerce'],

        data() {
            return {

            }
        },
        // created(){
        //     console.log(this.user)
        // },
        methods: {
            seguir() {
                axios.get('api/follow/'+this.user.id+'/'+this.commerce).then((response) => {
                 
                })
                .catch(err => console.log(err))
                // console.log('seguir')
                // console.log(this.user.id)
                // console.log(this.commerce)

            },
            // index() {
            //   axios.get('api/all-messages/' + this.user.id).then(response => {  
            //     console.log(response)
            //     this.messages = response.data.data
            //   })
            //   .catch(err => console.log(err))
            // },
            
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
