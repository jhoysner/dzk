<template>
	<div>
		<div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
      <div class="col-lg-3 col-md-6" v-for="commerce in tags">
        <div class="single-image-thumb single-feature-item relative">   
              <div class="thumb relative">
                <div class="thumb-img relative" v-if="commerce.image == null">
                    <div class="overlay overlay-bg"></div>
                    <img class="img-fluid" src="/img/f5.jpg" alt="">
                </div>
                <div class="thumb-img relative" v-else>
                    <div class="overlay overlay-bg"></div>
                    <img class="img-fluid" :src="'/images/commerce/'+commerce.image" alt="">
                </div>
                <div class="link">
                    <a class="relative showModal" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                      <i class="icons icon-eye"></i>
                    </a>

                    <!--<a class="relative" href="cart.html">
                      <i class="icons icon-basket-loaded"></i>
                    </a> -->
                </div>
              </div>
              <div class="details pb-10 pt-20">
                  <div class="title d-flex flex-row justify-content-between">
                      <a class="showModal" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                          <h6>{{ commerce.name }}</h6>
                      </a>
                      <!--<h6 class="price">$59</h6> -->
                      <i class="icons icon-share"></i>
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
                      <div v-for="tag in commerce.tags"> 
                        <span class="badge badge-secondary">
                          <router-link class="tag" :to="`/commerce/${tag.idtags}/tag`">
                            {{tag.name}}
                          </router-link>
                        </span>
                      </div>
                      <span v-if="commerce.tags.length < 1"> Sin Tags</span>
                  </div>
              </div>
              <div class="meta d-flex flex-row">
                <router-link class="btn btn-outline-primary btn-block view-branch":to="`/commerce/${commerce.idcommerce}/branchs`">
                  Ver sucursales
                </router-link>
              </div>
              <div class="meta d-flex flex-row">
                  <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                  <!--<a href="theme-details.html"> -->
                  <router-link class="btn btn-outline-primary btn-block view-branch" :to="`/commerce/${commerce.idcommerce}/discounts`">
                    Ver descuentos activos
                  </router-link>
                  <!--</a> -->
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
				axios.get('/api/filter-tags/' + this.id + '?page=' + page).then(response => {
					this.pagination = response.data.paginate; 
          let unification = []; //Unificacion de descuentos repetidos vacío.

          response.data.tags.data.forEach(res => {
          		if(res.commerces != null) {
          			unification.push(res.commerces); //Se unifican.
          		}
          });
          
          this.tags = unification; //Parseamos y añadimos a discounts para mostrarlos.
          console.log(this.tags);
          
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