<template>
  <div>
    <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
      <div class="col-lg-3 col-md-6" v-for="discount in tags">
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
                                        <a class="showModal" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                            <h6>{{ discount.title }}</h6>
                                        </a>
                                        <h6 class="price">${{ discount.discountprice }}</h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                          <h6 v-if="discount.branchs.length > 0">
                                            <router-link :to="`/commerce/${discount.branchs[0].commerces.idcommerce}`">
                                              <span> {{discount.branchs[0].commerces.name}}</span>
                                            </router-link>
                                         </h6>
                                          <h6 v-if="discount.branchs.length < 1">Descuento sin Asignar</h6>
                                        </a>
                                        <h6 class="price"><s>${{ discount.normalprice }}</s></h6>
                                    </div>
                                </div>                                
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>{{ discount.categories.name }} </h6>
                                        </a>
                                        <i class="icons icon-share"></i>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <div v-for="tag in discount.tags"> 
                                          <span class="badge badge-secondary">
                                              <router-link class="tag" :to="`/discount/${tag.idtags}/tag`">
                                                {{tag.name}}
                                              </router-link>
                                         </span>
                                        </div>
                                        <span v-if="discount.tags.length < 1"> Sin Tags</span>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                          <h6>Vence:<span class="vence"> {{formatDateHuman(discount.enddate)}}</span> </h6> 
                                      
                                        <h6 class="price">%{{ discount.discountpercentage}}</h6>
                                    </div>
                                </div>
                                <div class="meta d-flex flex-row">
                                    <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                                      <button type="button" :disabled="userHaveDiscount(discount.iddiscount)" :class="{ userHaveDiscount: userHaveDiscount(discount.iddiscount) }" class="btn btn-outline-primary" @click="obtenerDescuento(discount)">
                                          {{ userHaveDiscount(discount.iddiscount) ? 'Ya aplicaste a este descuento': 'Obtener este Descuento'}} 
                                     </button>
                                </div>
                            </div>      
      </div>
    </div> <!-- Aqui termina -->
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
        id: this.$route.params.idtag,
        tags: [],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        offset: 2,
      }
    },

    mounted() {
      this.filterTags();

      Bus.$on('change_page', (page) => {
        this.filterTags(page);
      });
    },

    methods: {
      filterTags(page) {
        axios.get('/api/filter-tags-discount/' + this.id + '?page=' + page).then(response => {
          this.pagination = response.data.paginate; 
          let unification = []; //Unificacion de descuentos repetidos vacío.

          response.data.tags.data.forEach(res => {
              if(res.discounts != null) {
                unification.push(res.discounts); //Se unifican.
              }
          });
          
          this.tags = unification; //Parseamos y añadimos a discounts para mostrarlos.
          // console.log(this.tags);
          
        })
        .catch(err => console.log(err))
      }
    }
  }
</script>

<style>
  .tag {
    color: #FFF;
  }

  .tag:hover {
    color: #FFF;
  }
</style>