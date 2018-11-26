<template>
	<div class="col-lg-12">
            <div class="settings-content">
                <h4>Lista de Compra</h4>
                <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
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
	               			<th class="text-center">Total</th>
	               			<th></th>
	               		</tr>
	               	</thead>
	               	<tbody>
	               		<tr>
	               			<td width="60%"></td>
	               			<td width="10%"><input type="number" min="0" id="cantidad" class="form-control"></td>
	               			<td width="25%"></td>
	               			<td><button class="btn btn-danger btn-xs" title="Eliminar"><i class="fa fa-trash-o"></i></button></td>
	               		</tr>
	               	</tbody>
               	</table>
               	<table class="table table-condensed">
               		<thead>
               			<tr>
               				<th width="80%"><h3>Subtotal</h3></th>
               				<th width="20%"><h3>$ 12332</h3></th>
               			</tr>
               		</thead>
               		<tbody></tbody>
               	</table>
               	<div class="col-lg-12 text-center">
               		<button type="button" class="btn btn-primary">Finalizar</button>
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
	data() {
	    return {
	    	url: '/list-products',
	      	form: {},
	      	userId: '',
	      	productId: '',
	      	products: [],
	      	branchs: [],
	      	typeproducts: [],
	      	loading: false,
	      	color: '#5bc0de',
	      	size:'30px',
	    }
	},
	created() {
		Bus.$on('product_id', (data) => {
            this.productId = data;
            console.log(this.productId)
        });
    },
    methods: {
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
</style>