<template>
      <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <div class="category-wrap">
                    <h6 class="pt-20">Tipo</h6>
                    <div class="product-type">
                      <select v-model="form.producttype_idproducttype" @change="filtering(form.producttype_idproducttype)" class="form-control common-input">
                        <option value="0">Todos</option>
                        <option v-for="option in typeproducts" :value="option.idproducttype">{{option.name}}</option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="name-desc-wrap">
                    <h4>Productos</h4>
                    <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
                    <div class="row pb-120 pt-80">
                      <div class="col-lg-3 col-md-6" v-for="product in products" :key="product.idproduct">
                          <div class="single-image-thumb single-feature-item relative">
                              <div class="thumb relative">
                                  <div class="thumb-img relative" v-if="product.image == null">
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" src="img/f5.jpg" alt="">
                                  </div>
                                  <div class="thumb-img relative" v-else>
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" :src="product.image" alt="">
                                  </div>

                                  <div class="link">
                                      <a class="relative" @click="addOrder(product.idproduct)" title="Agregar a Lista de Compra"><i class="icons icon-basket-loaded"></i></a>
                                  </div>
                              </div>
                              <div class="details pb-10 pt-20">
                                  <div class="title d-flex flex-row justify-content-between">
                                      <a href="theme-details.html">
                                          <h6>{{product.name}}</h6>
                                      </a>
                                      <h6 class="price">$ {{product.price}}</h6>
                                  </div>
                              </div>
                              <div class="meta d-flex flex-row">
                                  <div class="user-img"><img src="img/user-img.png" alt=""></div>
                                  <p>{{product.commerces.name}}</p>
                              </div>
                          </div>
                      </div>
                    </div>  
                </div>
            </div>
        </div>
      </div>
</template>
<script>

import Bus from '../../utilities/EventBus'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
  name: 'index',
  components: {
    PulseLoader,
  },
  data() {
    return {
      url: '/list-products',
      form: {},
      userId: '',
      products: [],
      branchs: [],
      typeproducts: [],
      loading: false,
      color: '#5bc0de',
      size:'30px',
    }
  },
  created() {
    this.index();
  },

  methods: {
    index() {
      this.loading = true

      axios.get('api/type-products').then(response => {
          this.typeproducts = response.data.data
        })            
      
      axios.get('api'+this.url).then(response => {
          this.products = response.data.data
          this.loading = false
          this.form.producttype_idproducttype = 0
        })            
    },
    addOrder(idproduct) {
      console.log(idproduct)
    },

    filtering(id) {
      this.loading = true
      if(id == 0) {
        axios.get('api'+this.url).then(response => {
          this.products = response.data.data
          this.loading = false
        })
      } else {
        axios.get('api'+this.url+'/all-branch/'+id).then(response => {
          this.branchs = response.data.data
          this.products= []
          for( let i=0; i<this.branchs.length; i++ ) {
            if(this.branchs[i].products.length != 0) {
                var productos = this.branchs[i].products
                for( let j=0; j<productos.length; j++ ) {
                  this.products.push(productos[j])
                }
            }
          }
          this.loading = false
        })  
      }           
    }

  }
}
</script>
<style lang="scss" scoped>
 .thumb-img {
    width: 200px;
    height: 120px;
  }
  #spinner {
    text-align: center;
    padding-top: 10vh;
    height: 80vh;
  }


</style>

