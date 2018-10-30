<template>
</template>

<script>
  export default {
    name: 'logout',

    data: () => {
      return {
        token:''
      }
    },

    mounted () {
      this.logout()
    },

    methods: {
      logout() {
        this.token = localStorage.getItem('access_token')
        
        axios.post('/api/logout', this.token)
          .then((response) => {
            
            console.log(response.data)
            

            localStorage.removeItem('access_token')

            localStorage.removeItem('roles')

            localStorage.removeItem('permissions')

            window.location.href = '/login';

          }).catch((error) => {
            console.log(error)  
          })
      }
    }
  }
</script>
