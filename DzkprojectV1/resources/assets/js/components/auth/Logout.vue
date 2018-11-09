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
        
        swal({
          title: "Desea Salir?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si!'
        })
        .then((result) => {
                if (result) {
                    axios.post('/api/logout', this.token)
                      .then((response) => {
                        localStorage.removeItem('access_token')
                        localStorage.removeItem('roles')
                        localStorage.removeItem('permissions')
                        localStorage.removeItem('redirect')

                        window.location.href = '/';

                      }).catch((error) => {
                        console.log(error)  
                      })
                }
        });      
      }
    }
  }
</script>
