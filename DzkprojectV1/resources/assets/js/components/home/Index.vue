<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Comercios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center">ID Comercio</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Correo</th> 
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Categoría</th>
                                <th class="text-center">Options</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="commerce in commerces" :key="commerce.idcommerce">
                              <td>{{ commerce.idcommerce }}</td>
                              <td>{{ commerce.name }}</td>
                              <td>{{ commerce.email }}</td>
                              <th>
                                <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                                  <p v-if="commerce.image == null">No posee imagen.</p>
                              </th>
                              <td>{{ commerce.ccategories.name }}</td>
                              <td>
                              	<router-link :to="`/commerce/${commerce.idcommerce}`">
                              		<a href="#" class="btn btn-warning sm">
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
  			commerces: [],
  		}
  	},

  	mounted() {
  		this.index();
  	},

  	methods: {
  		index() {
	      axios.get('api/all-commerces').then(data => {
	        this.commerces = data.data.data;
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