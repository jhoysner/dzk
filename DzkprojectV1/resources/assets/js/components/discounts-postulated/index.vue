<template>
	<div>
    <div class="col-lg-12">
      <div>
          <div class="settings-content">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a href="" class="nav-link active" @click="$router.push('/')">
                  
                    Solcicitudes para descuento
                </a>
              </li>
              <li class="nav-item">
                 <router-link to="/home-discounts" class="nav-link">
                    Redimir un descuento
                 </router-link>
              </li>
            </ul>
	     		</div>

	     		<div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
            <div class="col-lg-3 col-md-6" v-for="discount in discounts">
              <div class="single-image-thumb single-feature-item relative">   
                  <div class="thumb relative">
                    <div class="thumb-img relative">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="img/f5.jpg" alt="">
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
                           <h6>Nombre del descuento</h6>
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
                          <h6 class="price">Con descuento: ${{ discount.discountprice }}</h6>
                      </div>
                  </div>
                  <div class="details pb-10 pt-20">
                    <div class="title d-flex flex-row justify-content-between">
                      <a href="theme-details.html">
                          <h6>Estado: {{ discount.userhasdiscountstatus_iduserhasdiscountstatus }}</h6>
                      </a>
                    </div>
                  </div>
                  <!--<div class="meta d-flex flex-row">
                    <a class="btn btn-outline-primary btn-d btn-block">
                    	Autorizar descuento
                    </a>
                  </div> -->
                  <div class="meta d-flex flex-row">
                    <a class="btn btn-outline-warning btn-d btn-block">
                    	No autorizar
                    </a>
                  </div>

                  <div class="meta d-flex flex-row">
                    <a class="btn btn-outline-danger btn-d btn-block">
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
				axios.get('api/user-has-discount?page=' + page).then(response => {
          this.discounts = response.data.data.data;
          this.pagination = response.data.paginate;
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
</style>