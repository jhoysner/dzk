<template>
  <div>
    <div class="col-lg-12">
      <div>
          <div class="settings-content">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <router-link class="nav-link active" to='/discounts-postulated'>
                  
                    Solcicitudes para descuento
                </router-link>
              </li>
              <li class="nav-item">
                 <router-link to="/discounts-redeemed" class="nav-link">
                    Redimir un descuento
                 </router-link>
              </li>
            </ul>
          </div>

          <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
            <div class="col-lg-3 col-md-6" v-for="discount in discounts">
              <div class="single-image-thumb single-feature-item relative">   
                  <div class="thumb relative">
                    <div class="thumb-img relative" v-if="discount.discounts.image == null">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="img/f5.jpg" alt="">
                    </div>
                    <div class="thumb-img relative" v-else>
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" :src="'images/discount/'+discount.discounts.image" alt="">
                    </div>
                    <div class="link">
                        <a class="relative">
                          <i class="icons icon-eye"></i>
                        </a>

                        <!--<a class="relative" href="cart.html">
                          <i class="icons icon-basket-loaded"></i>
                        </a> -->
                    </div>
                  </div>
                  <div class="details pb-10 pt-20">
                      <div class="title d-flex flex-row justify-content-between">
                          <a>
                           <h6>{{ discount.discounts.title }}</h6>
                          </a>
                          <!--<h6 class="price">$59</h6> -->
                          <i class="icons icon-share"></i>
                      </div>
                  </div>
                  <div class="details pb-10 pt-20">
                      <div class="title d-flex flex-row justify-content-between">
                          <a href="theme-details.html">
                              <h6>Precio: ${{ discount.normalprice }}</h6>
                          </a>
                          <h6 class="price"></h6>
                      </div>
                  </div>
                  <div class="details pb-10 pt-20">
                      <div class="title d-flex flex-row justify-content-between">
                          <a href="theme-details.html">
                              <h6>Con descuento: ${{ discount.discountprice }}</h6>
                          </a>
                      </div>
                  </div>
                  <div class="details pb-10 pt-20">
                    <div class="title d-flex flex-row justify-content-between">
                      <a href="theme-details.html">
                          <h6>
                            Estado: 
                            <span class="badge badge-dark" v-if="discount.discounts_status.name == 'AUTHORIZED' ">Autorizado</span>
                            <span class="badge badge-dark" v-if="discount.discounts_status.name == 'ACTIVE' ">Activo</span>
                            <span class="badge badge-dark" v-if="discount.discounts_status.name == 'REDEEMED' ">Redimido</span>
                            <span class="badge badge-dark" v-if="discount.discounts_status.name == 'NOTAUTHORIZED' ">No autorizado</span>
                            <span class="badge badge-dark" v-if="discount.discounts_status.name == 'CANCELLED' ">Cancelado</span>
                          </h6>
                      </a>
                    </div>
                  </div>
                  <div class="meta d-flex flex-row">
                    <a class="btn btn-outline-primary btn-d btn-block" v-if="discount.discounts_status.name == 'ACTIVE' " @click="authorize(discount.idusers_has_discount)">
                      Autorizar descuento
                    </a>
                  </div> 
                  <div class="meta d-flex flex-row">
                    <a class="btn btn-outline-warning btn-d btn-block" v-if="discount.discounts_status.name == 'AUTHORIZED'" @click="notAuthorize(discount.idusers_has_discount)">
                      No autorizar
                    </a>
                  </div>

                  <div class="meta d-flex flex-row">
                    <a class="btn btn-outline-danger btn-d btn-block" v-if="discount.discounts_status.name == 'AUTHORIZED' || discount.discounts_status.name == 'ACTIVE'" @click="cancel(discount.idusers_has_discount)">
                      Cancelar
                    </a>
                  </div>
              </div>
            </div>
          </div> <!-- Aqui termina -->
      </div>
    </div>
    <paginator :pagination="pagination"></paginator>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import paginator from '../../utilities/paginator';

  export default {
    components: { paginator},
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
        user: {
          id: ''
        },
      }
    },

    mounted() {
      this.auth();

      Bus.$on('change_page', (page) => {
        this.index(page);
      });
    },

    methods: {
      auth() {
        axios.get('api/profile').then((response) => {
          this.user.id = response.data.user.id;

          this.index();
        })
        .catch(err => console.log(err))
      },

      index(page) {
        axios.get('api/user-has-discount/'+this.user.id+'/?page=' + page).then(response => {
          this.discounts = response.data.data.data;
          this.pagination = response.data.paginate;
        })
        .catch(err => console.log(err))
      },

      authorize(id) {
        swal({
          title: "¿Estas seguro de autorizar esta solicitud?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((will) => {
          if (will) {
            axios.get('api/authorize-discount/' + id).then(response => {
              swal({
                title: response.data.msg,
                icon: "success",
              });
              this.index();
            })
            .catch(err => console.log(err))
          }
        });
        
      },

      notAuthorize(id) {
        swal({
          title: "¿Estas seguro de no autorizar esta solicitud?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((will) => {
          if (will) {
            axios.get('api/not-authorize-discount/' + id).then(response => {
              swal({
                title: response.data.msg,
                icon: "success",
              });
              this.index();
            })
            .catch(err => console.log(err))
          }
        });
        
      },

      cancel(id) {
        swal({
          title: "¿Estas seguro de cancelar esta solicitud?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((will) => {
          if (will) {
            axios.get('api/cancel-discount/' + id).then(response => {
              swal({
                title: response.data.msg,
                icon: "success",
              });
              this.index();
            })
            .catch(err => console.log(err))
          }
        });
      },
    }
  }
</script>

<style>
  .btn-d {
    margin-top: 5px;
  }

  .btn-d:hover {
    color: #FFF !important;
  }

  .img-fluid {
    height: 125px;
  }
</style>