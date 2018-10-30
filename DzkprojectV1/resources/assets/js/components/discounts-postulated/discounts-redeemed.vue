<template>
  <div>
    <div class="col-lg-12">
      <div>
          <div class="settings-content">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <router-link class="nav-link" to='/discounts-postulated'>
                  
                    Solcicitudes para descuento
                </router-link>
              </li>
              <li class="nav-item">
                 <router-link class="nav-link active" to="/discounts-redeemed">
                    Redimir un descuento
                 </router-link>
              </li>
            </ul>

            <div class="container my-4">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="text" class="form-control" id="charcode" placeholder="Ingresa Charcode" v-model="charcode">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary btn-block" @click="auth">Buscar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row pb-120 pt-80 item-redeemed">    <!-- Aqui empieza -->           
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
                    <a class="btn btn-outline-primary btn-d btn-block" v-if="discount.discounts_status.name == 'AUTHORIZED' " @click="redeemed(discount.idusers_has_discount)">
                      Redimir descuento
                    </a>
                  </div> 
              </div>
            </div>
          </div> <!-- Aqui termina -->
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery';

  export default {
    data() {
      return {
        charcode: '',
        discounts: [],
        user: {
          id: ''
        }
      }
    },

    mounted() {
      
    },

    methods: {

      auth() {
        axios.get('api/profile').then((response) => {
          this.user.id = response.data.user.id;

          this.sendCharcode(this.user.id);
        })
        .catch(err => console.log(err))
      },

      sendCharcode(id) {

        if(!this.charcodeSize()) {
          swal({
            title: 'El charcode debe ser de 4 caracteres',
            icon: "warning",
          });
          $('.item-redeemed').css('display', 'none');
          return false;
        }

        axios.get('api/search-charcode/' + this.charcode + '/' + id).then(response => {
          console.log(response.data);
          if(!response.data.success) {
            swal({
              title: response.data.msg,
              icon: "warning",
            });
            this.charcode = '';
            $('.item-redeemed').css('display', 'none');
            return false;
          }

          $('.item-redeemed').css('display', 'block');
          swal({
            title: response.data.msg,
            icon: "success",
          });
          this.discounts = response.data.data;
        })
        .catch(err => console.log(err))
      },

      charcodeSize() {
        let code = $('#charcode').val();
        if(code.length !== 4 ) {
          return false
        } else {
          return true;
        }
      },

      redeemed(id) {
        axios.get('api/redeemed-discount/' + id).then(response => {
          swal({
            title: response.data.msg,
            icon: "success",
          });

          this.$router.push('/discounts-postulated');
        })
        .catch(err => console.log(err))
      }
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
  
  .item-redeemed {
    style: none;
  }
</style>