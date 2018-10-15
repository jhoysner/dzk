<template>
	<div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>
        <h2 class="my-4">Descuento: {{discount.iddiscount}}</h2>

            <h3 class="mt-4">{{ discount.title }}</h3>
            <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>ID Descuento</strong></label>
                        <p>{{discount.iddiscount}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Descripción</strong></label>
                        <p>{{discount.description}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Inicio</strong></label>
                        <p>{{discount.startdate}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Fin</strong></label>
                        <p>{{discount.enddate}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Destacado</strong></label>
                        <p> {{ discount.outstanding ? "Si" : "No" }}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Imagen</strong></label>
                        <p>
		                  <img class="image-discount" :src="'images/discount/'+discount.image" />
		                </p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Condición</strong></label>
                        <p>{{discount.condition}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Restricciones</strong></label>
                        <p>{{discount.restrictions}}</p>
                    </div>                    
                    <div class="col-lg-6">
                        <label><strong>Normal Precio</strong></label>
                        <p>{{discount.normalprice}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Precio Descuento</strong></label>
                        <p>{{discount.discountprice}}</p>
                    </div>                    
                    <div class="col-lg-6">
                        <label><strong>Porcetaje Descuento</strong></label>
                        <p>{{discount.discountpercentage}} %</p>
                    </div>

                    <div class="clearfix"></div>
                    <br>
              
                </div>
                <div>
                    <h3 class="mt-4">Sucursales</h3>    
                    <div class="row justify-content-center stat-table-wrap">
                        <div class="col-lg-12 stat-wrap-container">
                            <div class="stat-wrap">
                                <table class="table table-striped mt-40 stat-table">
                                    <thead>
                                      <tr>
                                        <th>ID Sucursal</th>
                                        <th>Nombre</th>
                                        <th>Imagen</th>
                                        <th>Latitud y Longitud</th>
                                        <th>Options</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="branch in branchs" >
                                        <td>{{ branch.idbranch }}</td>
                                        <td>{{ branch.name }}</td>
                                        <td>
                                          <img class="image-branch" v-if="branch.image != null" :src="'images/branch/'+branch.image" />
                                          <p v-if="branch.image == null">No posee imagen.</p>
                                        </td>
                                        <td>{{ branch.latitude }} - {{ branch.longitude }}</td>
                                        <td>
                                          <router-link :to="`/branch/${branch.idbranch}`">
                                            <a href="#" class="btn btn-primary btn-sm">
                                            Detalle
                                            </a>     
                                          </router-link>
                                        </td>
                                        
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
	export default {
		data() {
			return {
				id: this.$route.params.id,
			    discount: {
			     	iddiscount: '',
			        title: '',
			        description: '',
			        image: '',
			        startdate: '',
			        enddate: '',
			        outstanding: '',
			        conditions: '',
			        restrictions: '',
			        amountapproved: '',
			        amountavailable: '',
                    amountredeemed: '',
                    normalprice: '',
                    discountprice: '',
                    discountpercentage: ''
			    },
                branchs:[],
			}
		},

		mounted() {
			this.index();
		},

		methods: {
            index() {
              axios.get('/api/discount/' +this.id).then(response => {
                console.log(response)
                this.discount.iddiscount = response.data.data.iddiscount;
                this.discount.title = response.data.data.title;
                this.discount.description = response.data.data.description;
                this.discount.image = response.data.data.image;
                this.discount.startdate = response.data.data.startdate;
                this.discount.enddate = response.data.data.enddate;
                this.discount.outstanding = response.data.data.outstanding;
                this.discount.conditions = response.data.data.conditions;
                this.discount.restrictions = response.data.data.restrictions;
                this.discount.normalprice = response.data.data.normalprice;
                this.discount.discountprice = response.data.data.discountprice;
                this.discount.discountpercentage = response.data.data.discountpercentage;

                this.branchs = response.data.data.branchs;
              })
              .catch(err => console.log(err))
            },			

		}
	}
</script>

<style>
	.image-discount {
	  width: 80px;
	  height: 50px;
	  border-radius: 50%;
	}
</style>