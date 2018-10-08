<template>
    <div class="container" id="section-activation">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="errors.length">
                    <ul>
                        <li role="alert" v-for="error in errors">
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{error}}
                            </div>
                        </li>
                    </ul>
                
                    <div class="col-md-12">
                        <h3>Si desea solicitar nuevamente el reenvio del email de desbloqueo, haga click en el boton</h3>
                        <div class="text-center">
                            <a class="btn btn-success" href="/emailunlocked">Solicitar</a>
                        </div>
                    </div>

                </div>
                <div v-if="success.length">
                    <ul>
                        <li role="alert" v-for="tmp in success">
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{tmp}}
                            </div>
                        </li>
                    </ul>
                    <div class="col-md-12">
                        <h3>La cuenta con el email {{user.email}} fue desbloqueada correctamente</h3>
                        <div class="text-center">
                            <a class="btn btn-success" href="/login">Ir al Login</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.tokenun = window.location.pathname.substring(16)

            const params = {
                'token': this.tokenun
            }
            console.log(params)

            axios.post('/accountunlocked', params)
                .then((response) => {
                        console.log(response.data)
                        this.user = response.data.user
                        this.success.push(response.data.success);
                    }).catch((error) => {
                        this.errors.push(error.response.data.error)
                        
                    })
        },
        data() {
            return {
                'token': "",
                'user' : "",
                'errors' : [],
                'success' : [],
            }
        },
    }
</script>
<style>
#section-activation {
    margin-top: 120px;
    margin-bottom: 100px;
}
</style>
