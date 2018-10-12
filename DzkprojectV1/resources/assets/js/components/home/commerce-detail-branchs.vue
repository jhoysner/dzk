<template>
  <div id="section-profile" class="settings-content">
        <a href="#" class="btn btn-danger">Volver atrás</a>
        <h2 class="my-4">Comercio: {{commerce.idcommerce}}</h2>

        <ul class="nav nav-tabs">
          <li class="nav-item">
             <router-link :to="`/commerce/${id}`" class="nav-link">
                Detalle
             </router-link>
          </li>
          <li class="nav-item">
             <router-link :to="`/commerce/${id}/branchs`" class="nav-link active">
                Sucursales
             </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="`/commerce/${id}/discounts`" class="nav-link">
                Descuentos
             </router-link>
          </li>
        </ul>
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
</template>

<script>
  export default {
    data() {
      return {
        id: this.$route.params.id,
        commerce: {
          idcommerce: '',
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
                this.branchs = data.data.data[0].branchs;

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