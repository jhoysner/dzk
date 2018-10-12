<template>
	<div id="section-profile" class="settings-content">
        <a href="#" class="btn btn-danger">Volver atrás</a>
        <h2 class="my-4">Surcursal: {{branch.idbranch}}</h2>

            <h3 class="mt-4">{{ branch.name }}</h3>
            <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>ID Sucursal</strong></label>
                        <p>{{branch.idbranch}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Dirección</strong></label>
                        <p>{{branch.address}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Horarios de atención</strong></label>
                        <p>{{branch.schedule}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono principal</strong></label>
                        <p>{{branch.phone1}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono secundario</strong></label>
                        <p>{{branch.phone2}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Imagen</strong></label>
                        <p>
		                  <img class="image-branch" :src="'images/branch/'+branch.image" />
		                </p>
                    </div>
                    <div class="col-lg-6" v-if="branch.latitude != null ">
                        <label><strong>Latitud y Longitud</strong></label>
                        <p>{{branch.latitude}} / {{ branch.longitude }}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Comercio</strong></label>
                        <p>{{ branch.commerce_idcommerce }}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>País</strong></label>
                        <p>{{branch.country_idcountry}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Estado</strong></label>
                        <p>{{branch.state_idstate}}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Ciudad</label>
                        <p>{{ branch.city_idcity }}</p>
                    </div>

                    <div class="clearfix"></div>
                    <br>
              
                </div>
            
            </div>
        </div>
</template>

<script>
	export default {
		data() {
			return {
				id: this.$route.params.id,
			     branch: {
                    idbranch: '',
                    name: '',
                    address: '',
                    schedule: '',
                    phone1: '',
                    phone2: '',
                    image: '',
                    latitude: '',
                    longitude: '',
                    commerce_idcommerce: '',
                    country_idcountry: '',
                    state_idstate: '',
                    city_idcity: ''
                  },
                 branchs:[],
			}
		},

		mounted() {
			this.index();
		},

		methods: {
            index() {
              axios.get('/api/branch/' + this.$route.params.id).then(response => {
                this.branch.idbranch = response.data.data[0].idbranch;
                this.branch.name = response.data.data[0].name;
                this.branch.address = response.data.data[0].address;
                this.branch.schedule = response.data.data[0].schedule;
                this.branch.phone1 = response.data.data[0].phone1;
                this.branch.phone2 = response.data.data[0].phone2;
                this.branch.image = response.data.data[0].image;
                this.branch.latitude = response.data.data[0].latitude;
                this.branch.longitude = response.data.data[0].longitude;
                this.branch.country_idcountry = response.data.data[0].countries.name;
                this.branch.state_idstate = response.data.data[0].states.name;
                this.branch.city_idcity = response.data.data[0].cities.name;
                this.branch.commerce_idcommerce = response.data.data[0].commerces.name;
              })
              .catch(err => console.log(err))
            },			

		}
	}
</script>

<style>
	.image-branch {
	  width: 80px;
	  height: 50px;
	  border-radius: 50%;
	}
</style>