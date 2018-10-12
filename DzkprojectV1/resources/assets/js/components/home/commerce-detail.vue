<template>
	<div id="section-profile" class="settings-content">
        <a href="#" class="btn btn-danger">Volver atrás</a>
        <h2 class="my-4">Comercio: {{commerce.idcommerce}}</h2>
        <ul class="nav nav-tabs">
          <li class="nav-item">
             <router-link :to="`/commerce/${id}`" class="nav-link active">
                Detalle
             </router-link>
          </li>
          <li class="nav-item">
             <router-link :to="`/commerce/${id}/branchs`" class="nav-link">
                Sucursales
             </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="`/commerce/${id}/discounts`" class="nav-link">
                Descuentos
            </router-link>
          </li>
        </ul>

            <h3 class="mt-4">{{ commerce.name }}</h3>
            <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>ID Comercio</strong></label>
                        <p>{{commerce.idcommerce}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono principal</strong></label>
                        <p>{{commerce.phone1}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono secundario</strong></label>
                        <p>{{commerce.phone2}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Correo Electrónico</strong></label>
                        <p>{{commerce.email}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Imagen</strong></label>
                        <p>
		                  <img class="image-commerce" :src="'images/commerce/'+commerce.image" />
		                </p>
                    </div>
                    <div class="col-lg-6" v-if="commerce.web != null ">
                        <label><strong>Web</strong></label>
                        <p>{{commerce.web}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>País</strong></label>
                        <p>{{commerce.country_idcountry}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Estado</strong></label>
                        <p>{{commerce.state_idstate}}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Ciudad</label>
                        <p>{{ commerce.city_idcity }}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Categoría</label>
                        <p>{{ commerce.commercecategory_idcommercecategory }}</p>
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
			     commerce: {
			     	idcommerce: '',
			        name: '',
			        phone1: '',
			        phone2: '',
			        email: '',
			        image: '',
			        web: '',
			        country_idcountry: '',
			        state_idstate: '',
			        city_idcity: '',
			        commercecategory_idcommercecategory: ''
			     },
                 branchs:[],
			}
		},

		mounted() {
			this.index();
		},

		methods: {
            index() {
              axios.get('/api/detail-commerce/' + this.$route.params.id).then(data => {
                this.commerce.idcommerce = data.data.data[0].idcommerce;
                this.commerce.name = data.data.data[0].name;
                this.commerce.phone1 = data.data.data[0].phone1;
                this.commerce.phone2 = data.data.data[0].phone2;
                this.commerce.email = data.data.data[0].email;
                this.commerce.image = data.data.data[0].image;
                this.commerce.web = data.data.data[0].web;
                this.commerce.country_idcountry = data.data.data[0].countries.name;
                this.commerce.state_idstate = data.data.data[0].states.name;
                this.commerce.city_idcity = data.data.data[0].cities.name;
                this.commerce.commercecategory_idcommercecategory = data.data.data[0].ccategories.name;
              })
              .catch(err => console.log(err))
            },			

		}
	}
</script>

<style>
	.image-commerce {
	  width: 80px;
	  height: 50px;
	  border-radius: 50%;
	}
</style>