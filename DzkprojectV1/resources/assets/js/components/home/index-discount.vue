<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <router-link to="/" class="nav-link">
                      COMERCIOS
                  </router-link>
                </li>
                <li class="nav-item">
                   <router-link to="/home-discounts" class="nav-link active">
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
<!--                         <table class="table table-striped mt-40 stat-table">
                            <thead>
                              <tr>
                                  <th>ID Descuento</th>
                                  <th>Titulo</th>
                                  <th>Descripcion</th>
                                  <th>Inicio</th>
                                  <th>Fin</th>
                                  <th>Destacado</th>
                                  <th>Options</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr  v-for="discount in filter">
                                  <td>{{ discount.iddiscount}}</td>
                                  <td>{{ discount.title }}</td>
                                  <td class="text-center">{{ discount.description }}</td>
                                  <td class="text-center">{{ discount.startdate }}</td>
                                  <td class="text-center">{{ discount.enddate }}</td>
                                  <td class="text-center">
                                    {{ discount.outstanding ? "Si" : "No" }}
                                  </td>
                                  <td>
                                    <b-btn variant="primary" size="sm" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                      Ver Detalles
                                     </b-btn>
                                  </td>
                              </tr>
                           
                            </tbody>
                        </table> -->
                        <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                          <div class="col-lg-3 col-md-6" v-for="discount in filter" :key="discount.iddiscount">
                            <div class="single-image-thumb single-feature-item relative">   
                                <div class="thumb relative">
                                  <div class="thumb-img relative" v-if="discount.image == null">
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" src="img/f5.jpg" alt="">
                                  </div>
                                  <div class="thumb-img relative" v-else>
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" :src="'images/discount/'+discount.image" alt="">
                                  </div>
                                  <div class="link">
                                      <a class="relative showModal" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                        <i class="icons icon-eye"></i>
                                      </a>
                                  </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a class="showModal" v-b-modal.showModal  @click="detail(discount.idcommerce)">
                                            <h6>{{ discount.title }}</h6>
                                        </a>
                                        <h6 class="price">${{ discount.discountprice }}</h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>Nombre del Comercio</h6>
                                        </a>
                                        <h6 class="price"><s>${{ discount.normalprice }}</s></h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>{{ discount.categories.name }} </h6>
                                        </a>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>Listado de tags</h6>
                                        </a>
                                        <i class="icons icon-share"></i>
                                    </div>
                                </div>
                                <div class="meta d-flex flex-row">
                                    <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                                       <button type="button" class="btn btn-outline-primary">Obetener este Descuento</button>
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
    <detail></detail>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';
import detail from './modal-detail-discount';
import paginator from '../../utilities/paginator';

  export default {
    components: { detail, paginator},
    data() {
      return {
        discounts: [],
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
          return this.discounts.filter((item) => item.title.toLowerCase().includes(search));
        }
    },

    methods: {
      index(page) {
        axios.get('api/all-discounts?page=' + page).then(response => {
          //console.log(response);
          this.discounts = response.data.discount.data;
          this.pagination = response.data.paginate;

          console.log(response.data.discount.data)
        })
        .catch(err => console.log(err))
      },

      toggleSearch() {
        $('#search').toggle();
      },

      detail(id) {
        Bus.$emit('detail_homeinit-discount', id);
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

</style>