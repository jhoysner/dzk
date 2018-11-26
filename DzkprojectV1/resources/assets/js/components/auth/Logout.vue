<template>
  <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

  export default {
    name: 'logout',

    data: () => {
      return {
        token:'',
        loading: false,
        color: '#5bc0de',
        size:'30px',
      }
    },
    components: {
      PulseLoader
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
                    this.loading = true
                    axios.post('/api/logout', this.token)
                      .then((response) => {
                        localStorage.removeItem('access_token')
                        localStorage.removeItem('user_config')
                        localStorage.removeItem('roles')
                        localStorage.removeItem('permissions')
                        localStorage.removeItem('redirect')
                        this.loading = false

                        window.location.href = '/';

                      }).catch((error) => {
                        this.loading = false
                        console.log(error)  
                      })
                }
        });      
      }
    }
  }
</script>
<style>
  #spinner {
    text-align: center;
    padding-top: 10vh;
    height: 80vh;
  }

</style>