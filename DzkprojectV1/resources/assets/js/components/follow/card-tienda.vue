<template>
    <div>
            <div class="card ml-2" style="width: 18rem;" @click="findFollower(commerce.commerce_idcommerce)">
                <div class="card-body">
                  <h5 class="card-title">{{commerceJson.name}}</h5>
                  <h6 class="card-subtitle mb-2 text-muted">{{commerceJson.email}}</h6>
                </div>
            </div>
    </div>

</template>

<script>
    import Bus from '../../utilities/EventBus';
   
    export default {
        props: ['commerce'],

        data() {
            return {
                commerceJson: {},
            }
        },
        mounted(){
            this.findCommerce(this.commerce.commerce_idcommerce);
        },
        methods: {
            findFollower(id) {
                axios.get('api/user-follower/'+id)
                  .then(response => {
                     this.$parent.followers = response.data.data; 
                     this.$parent.commerceSelect = response.data.data[0].commerce;
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
            }, 
            findCommerce(id) {
                axios.get('/api/commerce/'+id)
                  .then(response => {
                    this.commerceJson = response.data[0]
                  })
                  .catch(err => {
                      console.log(err.response)
                  })   
                
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
.unread-text{
    color: red;
}

/* #section-profile > div.container > div > div.col-lg-3.sidebar.theme-details-sidebar > div:nth-child(1) > div > button:hover{
    background-color: red;
}*/
</style>
