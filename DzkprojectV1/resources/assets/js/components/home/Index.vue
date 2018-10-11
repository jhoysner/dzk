<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Comercios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
              <div class="row justify-content-center stat-table-wrap">
                <div class="col-lg-12 stat-wrap-container">
                    <div class="stat-wrap">
                        <a href="#" class="primary-btn white-btn"><i class="icons icon-magnifier"></i></a>
                        <table class="table table-striped mt-40 stat-table">
                            <thead>
                              <tr>
                                <th>ID Comercio</th>
                                <th>Nombre</th>
                                <th>Correo</th> 
                                <th>Imagen</th>
                                <th>Categoría</th>
                                <th>Options</th>
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
                                  <router-link :to="`commerce/${commerce.idcommerce}`">
                                    <a href="#" class="btn btn-warning btn-sm">
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