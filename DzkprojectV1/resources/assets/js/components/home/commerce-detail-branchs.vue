<template>
  <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.push('/')">Atras</button>
        <br />

        <!--<ul class="nav nav-tabs">
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
        </ul> -->
        <h3 class="mt-4">Sucursales</h3>
        <h5 v-if="branchs.length < 1">Este comercio aún no posee sucursales.</h5>    
        <div class="row justify-content-center stat-table-wrap">
            <div class="col-lg-12 stat-wrap-container">
                <div class="stat-wrap">
                    <!--<table class="table table-striped mt-40 stat-table">
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
                    </table> -->
                    <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                      <div class="col-lg-3 col-md-6" v-for="branch in branchs" :key="branch.idbranch">
                        <div class="single-image-thumb single-feature-item relative">   
                            <div class="thumb relative">
                              <div class="thumb-img relative" v-if="branch.image == null">
                                  <div class="overlay overlay-bg"></div>
                                  <img class="img-fluid" src="/img/f5.jpg" alt="">
                              </div>
                              <div class="thumb-img relative" v-else>
                                  <div class="overlay overlay-bg"></div>
                                  <img class="img-fluid" :src="'/images/branch/'+branch.image" alt="">
                              </div>
                              <div class="link">
                                  <a class="relative">
                                    <i class="icons icon-eye"></i>
                                  </a>

                                  <a class="relative" href="cart.html">
                                    <i class="icons icon-basket-loaded"></i>
                                  </a>
                              </div>
                            </div>
                            <div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                    <a>
                                        <h6>
                                          <router-link :to="`/branch/${branch.idbranch}`">
                                            {{ branch.name }}
                                          </router-link>
                                        </h6>
                                    </a>
                                    <h6 class="price">$59</h6>
                                </div>
                            </div>
                            <!--<div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                    <a href="theme-details.html">
                                        <h6>{{ branch.ccommerce.name }} </h6>
                                    </a>
                                </div>
                            </div> -->
                            <div class="meta d-flex flex-row">
                                <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                                <a href="theme-details.html">
                                    <h6>Ver descuentos activos</h6>
                                </a>
                            </div>
                        </div>
                      </div>
                    </div> <!-- Aqui termina -->
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
        commerce: {
          idcommerce: '',
        },
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
      this.getCommerce();
      this.getBranchs();

      Bus.$on('change_page', (page) => {
        this.getBranchs(page);
      });
    },

    methods: {
      getCommerce() {
        axios.get('/api/detail-commerce/' + this.$route.params.id).then(data => {
          this.commerce.idcommerce = data.data.data[0].idcommerce;
        })
        .catch(err => console.log(err))
      },

      getBranchs(page) {
        axios.get('/api/commerce-detail-branchs/' + this.$route.params.id + '?page=' + page).then(response => {
          this.branchs = response.data.branch.data;
          this.pagination = response.data.paginate;   
          console.log(response.data.branch.data);  
        }).catch(err => console.log(err))
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

  .thumb-img {
    width: 250px;
    height: 125px;
  }
</style>