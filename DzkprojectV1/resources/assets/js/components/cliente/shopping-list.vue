<template>
	<div class="col-lg-12">
            <div class="settings-content">
                <h4>Lista de Compra</h4>
                <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
               	<div v-if="listProductsMarket.length > 0">
                   	<div v-if="!loading">
	                   	<div class="text-right">
		               		<button class="btn btn-primary white-btn" @click="volver()">Continuar agregando Productos</button>
		               	</div>
		               	<div class="clear-fix"></div>
		               	<br>	        
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
			               			<td width="15%" class="text-right">{{list.unitprice}}</td>
			               			<td width="15%" class="text-right">{{list.unitprice * list.quantity}}</td>
			               			<td><button class="btn btn-danger btn-xs" title="Eliminar"><i class="fa fa-trash-o"></i></button></td>
			               		</tr>
			               	</tbody>
		               	</table>
		               	<table class="table table-condensed">
		               		<thead>
		               			<tr>
		               				<th width="90%"><h3>Subtotal</h3></th>
		               				<th width="10%"><h3>$ 12332</h3></th>
		               			</tr>
		               			<tr>
		               				<th width="90%"><h3>Total</h3></th>
		               				<th width="10%"><h3>$ 12332</h3></th>
		               			</tr>
		               			
		               		</thead>
		               		<tbody></tbody>
		               	</table>
		               	<div class="col-lg-12">
		               		<label>Observación</label>
			               	<textarea class="form-control"></textarea>
		               	</div>
		               	<br>
		               	<div class="col-lg-12 text-center">
		               		<button type="button" class="btn btn-primary">Finalizar</button>
		               	</div>
                   	</div>
                </div>
	               	<div v-else class="col-lg-12 text-center">
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
              console.log(this.listProductsMarket)
              this.loading = false
           })
    	},
    	updateQuantity(product) {
    		console.log(product)
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
		        'commerce_idcommerce': this.idcommerce,
		        'idmarketplacelisting': product.marketplacelisting_idmarketplacelisting,
		        'branch_idbranch': this.idbranch,
		        'detalle': detalles
		      }

		      console.log(data)
		      axios.put('api/marketplace/'+idMarketList,data).then(response => {
		      	console.log(response)
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

</style>