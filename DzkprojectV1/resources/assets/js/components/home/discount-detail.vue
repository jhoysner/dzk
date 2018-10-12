<template>
	<div id="section-profile" class="settings-content">
        <a href="#" class="btn btn-danger">Volver atrás</a>
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
                        <p>{{discount.outstanding}}</p>
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
			}
		},

		mounted() {
			this.index();
		},

		methods: {
            index() {
              axios.get('/api/discount/' + this.$route.params.id).then(response => {
                this.discount.iddiscount = response.data.data.iddiscount;
                this.discount.title = response.data.data.title;
                this.discount.description = response.data.data.description;
                this.discount.image = response.data.data.image;
                this.discount.startdate = response.data.data.startdate;
                this.discount.enddate = response.data.data.enddate;
                this.discount.outstanding = response.data.data.outstanding;
                this.discount.conditions = response.data.data.conditions;
                this.discount.restrictions = response.data.data.restrictions;
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