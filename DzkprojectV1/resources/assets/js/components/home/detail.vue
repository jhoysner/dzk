<template>
	<div>
        <b-modal id="showModal" ref="showModal" :title="commerce.name" hide-footer>
          <div class="modal-content">
              <div class="modal-body">
                <div class="row pt-30">
                	<div class="col-lg-12">
                        <label><strong>ID Comercio</strong></label>
                        <p>{{commerce.idcommerce}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono principal</strong></label>
                        <p>{{commerce.phone1}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Categoría</strong></label>
                        <p>{{commerce.commercecategory_idcommercecategory}}</p>
                    </div>
                    <div class="col-lg-12">
                        <label><strong>Correo Electrónico</strong></label>
                        <p>{{commerce.email}}</p>
                    </div>
					<div class="col-lg-12">
                        <label>
                        	<strong>
                        		Afiliado a {{ countbranchs }} sucursales
                        	</strong>
                        </label>
                        <p>
                        	<ul v-for="branch in branchs" :key="branch.idbranch">
                        		<li>{{ branch.name }}</li>
                        	</ul>
                        </p>
                        <hr>
                    </div>
                    <div class="col-lg-12">
                        <label>
                        	<strong>
                        		Disponibles {{ countDiscounts }} Descuentos
                        	</strong>
                        </label>
                        <template  v-for="branch in branchs">
                        	<ul v-for="discount in branch.discounts">
                        		<li>{{ discount.title }}</li>
                        	</ul>
                        </template>
                        <hr>
                    </div>

                </div>
              
              </div>
              <div class="modal-footer">
                <router-link :to="`commerce/${commerce.idcommerce}`">
	              <a href="#" class="btn btn-warning btn-sm">
	               Detalle
	              </a>     
	            </router-link>
              </div>
          </div>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
	export default {
		data() {
			return {
				commerce: {
			     	idcommerce: '',
			        name: '',
			        phone1: '',
			        email: '',
			        commercecategory_idcommercecategory: ''
			     },
			  countbranchs: '',
			  branchs: [],
			  countDiscounts: 0
			}
		},

		created() {
			Bus.$on('detail_homeinit', (id) => {
		      this.showCommerce(id);
		    });
		},

		methods: {
			showCommerce(id) {
				this.countDiscounts = 0; 

        axios.get('/api/detail-commerce/' + id).then(response => {
          this.commerce.idcommerce = response.data.data[0].idcommerce;
          this.commerce.name = response.data.data[0].name;
          this.commerce.phone1 = response.data.data[0].phone1;
          this.commerce.email = response.data.data[0].email;
          this.commerce.commercecategory_idcommercecategory = response.data.data[0].ccategories.name;
          this.branchs = response.data.data[0].branchs;
          this.countbranchs = response.data.data[0].branchs.length;
          
          response.data.data[0].branchs.forEach(response => {
          	this.countDiscounts += response.discounts.length;
          	//console.log(this.countDiscounts + ' Descuentos');
          });
        })
        .catch(err => console.log(err))
      },	
		}
	}
</script>

<style>
	
</style>