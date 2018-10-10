<template>
    <div id="section-register" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Solicitar activación de cuenta</h1>
        
                <div v-if="errors.length">
                    <ul>
                        <li role="alert" v-for="error in errors">
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{error}}
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-if="success.length">
                    <ul>
                        <li role="alert" v-for="tmp in success">
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              {{tmp}}<br>
                              <a href="/login">Volver al Login</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <form action="" class="billing-form" v-on:submit.prevent="submitSend()" novalidate>
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <input type="email" placeholder="Email Address*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Email Address*'" required class="common-input" v-model="email">
                        </div>
                        <div class="col-lg-12 text-right" required>
                            <button class="primary-btn">Solicitar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>  
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                'email': "",
                'errors' : [],
                'success' : [],
            }
        },
        methods: {
            submitSend() {
                this.errors = []
                if(!this.email){ 
                    this.errors.push('Email required.');
                    return;
                }

                const params = {
                    'email': this.email
                }

                axios.post('/emailunlocked', params)
                    .then((response) => {
                            this.success.push(response.data.success);
                        }).catch((error) => {
                            this.errors.push(error.response.data.error)
                            
                        })
            }
        }
    }
</script>
<style>
#section-register {
    margin-top: 120px;
    margin-bottom: 100px;
}
</style>
