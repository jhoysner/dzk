<template>
    <div id="section-profile" class="settings-content">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <router-link to="/cliente" class="nav-link">
                Descuentos sin redimir
            </router-link>
          </li>
          <li class="nav-item">
             <router-link to="/cliente-descuentos-redimidos" class="nav-link active">
                 Descuentos Redimidos
             </router-link>
          </li>
        </ul>
        <button type="button" class="btn btn-outline-dark pull-right mt-2" @click="$router.push('/')">Atras</button>
        <br />
        </ul>
        <h3 class="mt-4">Descuentos Redimidos</h3>
        <!-- <h5 v-if="branchs.length < 1">Este comercio aún no posee sucursales.</h5>     -->
        <div class="row justify-content-center stat-table-wrap">
            <div class="col-lg-12 stat-wrap-container">
                <div class="stat-wrap">

                    <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                      <div class="col-lg-3 col-md-6" v-for="discount in filter" :key="discount.iddiscount">
                        <div class="single-image-thumb single-feature-item relative">   
                            <div class="thumb relative">
                              <div class="thumb-img relative" v-if="discount.image == null">
                                  <div class="overlay overlay-bg"></div>
                                  <img class="img-fluid" src="/img/f5.jpg" alt="">
                              </div>
                              <div class="thumb-img relative" v-else>
                                  <div class="overlay overlay-bg"></div>
                                  <img class="img-fluid" :src="'/images/discount/'+discount.image" alt="">
                              </div>
                              <div class="link">
                                  <a class="relative">
                                    <i class="icons icon-eye"></i>
                                  </a>

                              </div>
                            </div>
                            <div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                    <a>
                                      <h6>
                                        <router-link :to="`/discount/${discount.iddiscount}`">
                                          {{ discount.title }}
                                        </router-link>
                                      </h6>
                                    </a>
                                </div>
                            </div>                            
                            <div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                    <h6>
                                        Precio : {{ discount.normalprice }}                                     
                                    </h6>
                                </div>
                            </div>                            
                            <div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                     <h6>Precio Descunto: {{discount.discountprice}}</h6> 
                                </div>
                            </div>
                            <div class="details pb-10 pt-20">
                                <div class="title d-flex flex-row justify-content-between">
                                    <h6>
                                        {{ discount.startdate }}                                     
                                    </h6>
                                    <h6>{{discount.enddate}}</h6> 
                                </div>
                            </div>                            
                         
                            <div class="meta d-flex flex-row">
                                <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                                <router-link class="btn btn-outline-primary btn-block view-discount" :to="`/client-discount/${discount.pivot.idusers_has_discount}`">
                                  <!-- {{discount.pivot.idusers_has_discount}} -->
                                  ver
                                </router-link>
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
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        discounts:[],
        user: {
          id: '',
        }
      }
    },

    mounted() {
      this.auth();
    },
    computed: {
        filter() {
          // const search = this.search.toLowerCase();
           return this.discounts.filter((item) => item.pivot.userhasdiscountstatus_iduserhasdiscountstatus == 3);
        }
    },
    methods: {  
      auth() {
        axios.get('api/profile').then((response) => {
          this.user.id = response.data.user.id;
          this.index();
          // this.index();
        })
        .catch(err => console.log(err))
      }, 
      index(){
        axios.get('api/client/'+this.user.id).
          then(response => {
            console.log(response)
             this.discounts = response.data.data;
          })
          .catch(error => {
            console.log(error.response.data)

          });
      }
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

  .view-branch:hover .link-branch {
    color: #FFF;
  }
</style>