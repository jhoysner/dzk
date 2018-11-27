<template>
	<div class="col-lg-12">
            <div class="settings-content">
                <h4>Lista de Compra</h4>
                <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
               	<div v-if="listProductsMarket.length > 0">
                   	<div v-if="!loading">
	                   	<div class="col-lg-12 text-right">
		               		<button class="btn btn-primary white-btn" @click="volver()">Agregar Productos</button>
		               	</div>
		               	<div class="clear-fix"></div>
		               	<br>
		               	<div class="col-lg-12">
			                <table class="table table-condensed">
				               	<thead>
				               		<tr>
				               			<th>Producto</th>
				               			<th class="text-center">Cantidad</th>
				               			<th class="text-center">Precio Unitario</th>
				               			<th class="text-center">Total</th>
				               			<th></th>
				               		</tr>
				               	</thead>
				               	<tbody>
				               		<tr v-for="list in listProductsMarket">
				               			<td width="60%">
				               				<span v-if="list.product.image">
				               					<img :src="list.product.image" class="img-product">
				               				</span>
				               				{{list.product.name}}
				               			</td>
				               			<td width="10%"><input type="number" min="0" id="cantidad" v-model="list.quantity" @change="updateQuantity(list)" class="form-control"></td>
				               			<td width="15%" class="text-right">{{list.unitprice | currency}}</td>
				               			<td width="15%" class="text-right">{{list.unitprice * list.quantity | currency}}</td>
				               			<td><a  title="Eliminar" @click="deleteProduct(list)"><i class="fa fa-trash-o a-delete"></i></a></td>
				               		</tr>
				               	</tbody>
			               	</table>
			               	<hr>
			               	<table class="table-responsive" width="100%">
			               		<thead>
			               			<tr>
			               				<td width="55%"></td>
			               				<td width="30%"><h4>Subtotal</h4></td>
			               				<td width="15%" id="cantidad"><h4>{{ listMarket[0].initprice | currency }}</h4></td>
			               			</tr>
			               			<tr>
			               				<th width="65%"></th>
			               				<th width="20%"><h4>Impuesto</h4></th>
			               				<th width="15%" id="cantidad"><h4>{{ listMarket[0].inittaxes | currency }}</h4></th>
			               			</tr>
			               			<tr>
			               				<th width="55%"></th>
			               				<th width="30%"><h4>Total</h4></th>
			               				<th width="15%" id="cantidad"><h4>{{ listMarket[0].inittotalprice | currency }}</h4></th>
			               			</tr>
			               		</thead>
			               		<tbody>
			               		</tbody>
			               	</table>
		               	</div>        
		               	<div class="col-lg-12">
		               		<label>Observaciones</label>
			               	<textarea class="form-control" v-model="observations"></textarea>
		               	</div>
		               	<br>
		               	<div class="col-lg-12 text-center">
		               		<button type="button" class="btn btn-primary" @click="endMarket()">Finalizar</button>
		               	</div>
                   	</div>
                </div>
               	<div v-else class="col-lg-12 text-center">
	                <div v-if="!loading">
		                <h2>
		                	Lista de Compra Vacia
		                </h2>
		                <br>
		                <div>
		                	<span class="fa fa-list fa-5x"></span>
		                </div>
		                <br>
		                <div class="clear-fix">
		               		<button class="btn primary-btn" @click="volver()">Agregar Productos</button>
		               	</div>
	            	</div>
	            </div>
                	

            </div>
    </div>
</template>
<script>
import Bus from '../../utilities/EventBus';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
    name: 'index',
	components: {
	   	PulseLoader,
	},
	props: ['marketplace'],
	data() {
	    return {
	    	url: '/marketplace',
	    	idcommerce: '',
	    	idbranch: '',
	    	list: [],
	      	loading: false,
	      	color: '#5bc0de',
	      	size:'30px',
	      	marketPlaceId: '',
	      	listProductsMarket: [],
	      	listMarket: [],
	      	feedback: ''
	    }
	},
	created() {
		this.index()
    },

    methods: {
    	index() {
    		this.loading = true

    		if(this.marketplace) {
    			this.detailList(this.marketplace)
    		} else {
	    		const user_config = JSON.parse(localStorage.getItem('user_config'))
    			
			    if( user_config ) {
			        this.idcommerce = user_config.list[0].commerce
			        this.idbranch = user_config.list[0].branch

			        axios.get('api/marketplace-active/'+this.idcommerce+'/'+this.idbranch).then(response => {
			        	this.list = response.data.data
			        	if(this.list.length == 0) {
				        	this.loading = false
			        	}
			        	if(this.list.length > 0) {
			        		this.detailList(this.list[0].idmarketplacelisting)
			        	}
			        }) 
			      } else {
			      	this.loading = false
			      }
    		}

    	},
    	detailList(id) {
    		axios.get('api'+this.url+'/'+id).then(response => {
              this.listProductsMarket = response.data.data[0].details
              this.listMarket = response.data.data
              this.loading = false
           })
    	},
    	updateQuantity(product) {
    		let detalles = []
    		let idMarketList = product.marketplacelisting_idmarketplacelisting

		    let detalle = {
		        'quantity': product.quantity,
		        'unitprice': product.product.price,
		        'taxes': parseFloat(product.quantity*product.product.price*(product.product.taxpercentage/100)).toFixed(2),
		        'product_idproduct': product.product_idproduct,
		        'productunitofmeasurement_idproductunitofmeasurement': product.product.productunitofmeasurement_idproductunitofmeasurement,
		        'statelisting_idstatelisting': '1'
		      }

		      detalles.push(detalle)
		      
		      var data = {
		        'commerce_idcommerce': product.commerce_idcommerce,
		        'idmarketplacelisting': product.marketplacelisting_idmarketplacelisting,
		        'branch_idbranch': product.branch_idbranch,
		        'detalle': detalles
		      }

		      axios.put('api/marketplace/'+idMarketList,data).then(response => {
		      	this.detailList(this.listProductsMarket[0].marketplacelisting_idmarketplacelisting)
		      	//this.index()
              })

    	},

    	deleteProduct(product) {
    		var id = product.idmarketplacelistingdetail
    		
    		axios.delete('api/marketplace-product/'+id).then(response => {
              this.index()
           	})
    		.catch(error => {
                  swal('No se ha podido eliminar el producto, intenta nuevamente', {
                        icon: "danger",
                        });
                })	
    	},
    	endMarket() {
    		if(this.observations.length > 0) {
    			this.listMarket[0].observations = this.observations
    		}
    		swal({
	          title: "Desea realizar el pedido de la lista de compra?",
	          text: "",
	          icon: "warning",
	          buttons: {
			    cancel: {
			    	text: "Cancelar",
			    	closeModal: true,
			    	visible: true
			    },
			    confirm: {
			    	text: "Si",
			    	value: true,
			    	visible: true,
			    	closeModal: true,
			    },
			  },
	          dangerMode: true,
	        })
	        .then((result) => {
	                if (result) {
	                    this.loading = true
	          			var id = this.listMarket[0].idmarketplacelisting

	                    axios.post('/api/marketplace-order/'+id, this.listMarket[0])
	                      .then((response) => {
	          				this.loading = false
	                      	this.$router.push('/requests')
	          				swal({
	          					title: response.data.success, 
                                icon: "success",
                                });
	                      }).catch((error) => {
	                        this.loading = false
	                        console.log(error) 
   	          				swal({
	          					title: error.data, 
                                icon: "error",
                            })
	                      })
	                }
	        })  
    	},
    	
	    volver() {
	      this.$router.push('/list-products')
	    },
	}
}

</script>
<style>
	#cantidad {
		text-align: right;
	}
	.img-product {
		width: 5vh;
    	height: 30px;
    	border-radius: 45%;
	}
	#spinner {
	    text-align: center;
	    padding-top: 10vh;
	    height: 80vh;
	}
	.a-delete {
		color: red;
	}

</style>