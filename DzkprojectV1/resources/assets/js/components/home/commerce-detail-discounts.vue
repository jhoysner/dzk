<template>
  <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.push('/')">Atras</button>
        <h2 class="my-4">Comercio: {{id}}</h2>

        <ul class="nav nav-tabs">
          <li class="nav-item">
             <router-link :to="`/commerce/${id}`" class="nav-link">
                Detalle
             </router-link>
          </li>
          <li class="nav-item">
             <router-link :to="`/commerce/${id}/branchs`" class="nav-link">
                Sucursales
             </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="`/commerce/${id}/discounts`" class="nav-link active">
                Descuentos
             </router-link>
          </li>
        </ul>
        <h3 class="mt-4">Descuentos</h3>    
        <div class="row justify-content-center stat-table-wrap">
            <div class="col-lg-12 stat-wrap-container">
                <div class="stat-wrap">
                    <table class="table table-striped mt-40 stat-table">
                        <thead>
                          <tr>
                            <th>ID Descuento</th>
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Destacado</th>
                            <th>Opcciones</th>
                            </tr>
                          </tr>
                        </thead>
                        <tbody>
                          <template  v-for="branch in branchs">
                            <tr v-for="discount in branch.discounts">
                              <td>{{ discount.iddiscount}}</td>
                              <td>{{ discount.title }}</td>
                              <td>{{ discount.description }}</td>
                              <td>{{ discount.startdate }}</td>
                              <td>{{ discount.enddate }}</td>
                              <td>
                              {{ discount.outstanding ? "Si" : "No" }}
                              </td>
                              <td>
                                <router-link :to="`/discount/${discount.iddiscount}`">
                                  <a href="#" class="btn btn-primary btn-sm">
                                  Detalle
                                  </a>     
                                </router-link>
                              </td>
                            </tr>
                          </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <paginator :pagination="pagination"></paginator>

        </div>
  </div>
</template>

<script>
  import Bus from '../../utilities/EventBus.js';
  import paginator from '../../utilities/paginator';

  export default {
    components: { paginator },
    data() {
      return {
        id: this.$route.params.id,
        branchs:[],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
      }
    },

    mounted() {
      this.index();
      Bus.$on('change_page', (page) => {
        this.index(page);
      });
    },

    methods: {
            index(page) {
              axios.get('/api/commerce-detail-discounts/' + this.$route.params.id+ '?page=' + page).then(response => {
                console.log(response.data.branchs.data)
                this.branchs = response.data.branchs.data;
                this.pagination = response.data.paginate;        
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