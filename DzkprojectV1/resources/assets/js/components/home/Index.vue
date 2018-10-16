<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <router-link to="/" class="nav-link active">
                      COMERCIOS
                  </router-link>
                </li>
                <li class="nav-item">
                   <router-link to="/home-discounts" class="nav-link">
                      DESCUENTOS
                   </router-link>
                </li>
              </ul>
              <!-- <spinner :show="loadingProductos"></spinner> -->
              <div class="row justify-content-center stat-table-wrap">
                <div class="col-lg-12 stat-wrap-container">
                    <div class="stat-wrap my-4">
                        <a class="primary-btn white-btn" @click="toggleSearch"><i class="icons icon-magnifier"></i></a>
                        <hr>
                        <input type="text" class="form-control" id="search" placeholder="Buscar" v-model="search">
                        <!--<table class="table table-striped mt-40 stat-table">
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
                              <tr v-for="commerce in filter" :key="commerce.idcommerce">
                                <td>{{ commerce.idcommerce }}</td>
                                <td>{{ commerce.name }}</td>
                                <td>{{ commerce.email }}</td>
                                <th>
                                  <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                                    <p v-if="commerce.image == null">No posee imagen.</p>
                                </th>
                                <td>{{ commerce.ccategories.name }}</td>
                                <td> -->
                                  <!--<router-link :to="`commerce/${commerce.idcommerce}`">
                                    <a href="#" class="btn btn-warning btn-sm">
                                    Detalle
                                    </a>   
                                  </router-link> -->
                                  <!--<b-btn variant="primary" size="sm" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                                    Ver Detalles
                                  </b-btn>
                                </td>
                              </tr>
                            </tbody>
                        </table> -->
                        <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                          <div class="col-lg-3 col-md-6" v-for="commerce in filter" :key="commerce.idcommerce">
                            <div class="single-image-thumb single-feature-item relative">   
                                <div class="thumb relative">
                                  <div class="thumb-img relative" v-if="commerce.image == null">
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" src="img/f5.jpg" alt="">
                                  </div>
                                  <div class="thumb-img relative" v-else>
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" :src="'images/commerce/'+commerce.image" alt="">
                                  </div>
                                  <div class="link">
                                      <a class="relative showModal" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                                        <i class="icons icon-eye"></i>
                                      </a>

                                      <a class="relative" href="cart.html">
                                        <i class="icons icon-basket-loaded"></i>
                                      </a>
                                  </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a class="showModal" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                                            <h6>{{ commerce.name }}</h6>
                                        </a>
                                        <h6 class="price">$59</h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>Valoración 4.4</h6>
                                        </a>
                                        <h6 class="price">Leer comentarios</h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>{{ commerce.ccategories.name }} </h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>Listado de tags</h6>
                                        </a>
                                        <h6 class="price">
                                          <router-link class="branch-link" :to="`/commerce/${commerce.idcommerce}/branchs`">
                                            Ver sucursales
                                          </router-link>
                                        </h6>
                                    </div>
                                </div>
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
              </div>
            </div>
        </div>
    </div>
    <paginator :pagination="pagination"></paginator>
    <show></show>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';
import show from './detail';
import paginator from '../../utilities/paginator';

  export default {
    components: { show, paginator},
    data() {
      return {
        commerces: [],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
          offset: 2,
          search: '',
      }
    },

    mounted() {
      this.index();

      Bus.$on('change_page', (page) => {
        this.index(page);
      });
    },

    computed: {
        filter() {
          const search = this.search.toLowerCase();
          return this.commerces.filter((item) => item.name.toLowerCase().includes(search));
        }
    },

    methods: {
      index(page) {
        axios.get('api/all-commerces?page=' + page).then(response => {
          //console.log(response);
          this.commerces = response.data.commerce.data;
          this.pagination = response.data.paginate;
        })
        .catch(err => console.log(err))
      },

      toggleSearch() {
        $('#search').toggle();
      },

      detail(id) {
        Bus.$emit('detail_homeinit', id);
      },
    },
  }
</script>

<style>
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }

  #search {
    display: none;
  }

  .showModal {
    cursor: pointer;
  }

  .thumb-img {
    width: 250px;
    height: 125px;
  }

  .branch-link {
    color: #333;
  }
</style>