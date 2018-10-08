<template>
<div id="section-reset" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
			    <h1>Reset Password</h1>
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

			    <form action="" class="billing-form" v-on:submit.prevent="submitReset()">
			        <div class="pt-30 text-center col-lg-12">
			            <div class="col-lg-12 ">
			                <input type="email" placeholder="Email Address*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Email Address*'" required class="common-input" v-model="email">
			            </div>
			            <div class="col-lg-12">
			                <input type="password" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password*'" required class="common-input" v-model="password">
			            </div>
			            <div class="col-lg-12">
			                <input type="password" placeholder="Password confirmation*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password confirmation*'" required class="common-input" v-model="password_confirmation">
			            </div>
			            
			            <div class="col-lg-12 text-right" >
			                <button class="primary-btn">Reset Password</button>
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
        	this.token = window.location.pathname.substr(16)
        },
         data() {
            return {
                'email': "",
                'password': "",
                'password_confirmation': "",
                'token': "",
                'errors' : [],
                'success' : [],
            }
        },
        methods: {
        	submitReset() {
                this.errors = []
                if(!this.email) this.errors.push('Email required.');
                if(!this.password) this.errors.push('Password required.');
                if(!this.password_confirmation) this.errors.push('Password Confirmation required.');
                
                console.log(this.password)
                if (this.password !== this.password_confirmation) {
                    this.password = ""
                    this.password_confirmation = ""
                    this.errors.push('Passwords do not match')
                    return
                }

                const params = {
                    'email': this.email,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation,
                    'token': this.token
                }

                axios.post('/password/reset', params)
                    .then((response) => {
                            //this.success.push(response.data.success);
                            if(response.status == 200) {
                            	window.location.href = '/login';
                            }

                        }).catch((error) => {
                            let err = error.response.data.errors
                            this.errors.push(err)

                        })
            }
        }
    }
</script>
<style>
#section-reset {
	margin-top: 100px;
	margin-bottom: 60px;
}
</style>