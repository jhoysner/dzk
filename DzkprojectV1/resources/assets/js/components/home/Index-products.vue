<template>
      <div class="col-lg-12">
        <div class="col-lg-12 settings-content" v-if="isLogged">
              <div class="col-lg-12 row">
                <div class="col-lg-6">
                  <div class="form-inline row">
                    <label for="nombre" class="col-form-label col-sm-2"><h3>Tienda</h3></label>
                    <div class="col-sm-8" v-if="!loading">
                      <span v-if="commerce">
                        {{commerce.name}}
                        <span>
                          <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                        </span>

                        &nbsp;
                        <b-btn v-b-modal="'commercesModal'" title="Cambiar de Tienda" class="btn btn-sm" variant="default"><i class="fa fa-edit"></i></b-btn>
                      </span>
                      <span v-else>
                        No hay tienda seleccionada 
                        &nbsp;
                        <b-btn v-b-modal="'commercesModal'" title="Cambiar de Tienda" class="btn btn-sm" variant="success"><i class="fa fa-plus"></i></b-btn>
                      </span>
                    </div>
                  </div>  
                </div>
                <div class="col-lg-6">
                  <div class="form-inline row" v-if="commerce">
                    <label for="nombre" class="col-form-label col-sm-2"><h3>Sucursal</h3></label>
                    <div class="col-sm-8" v-if="!loading">
                      <span v-if="branch">
                        {{branch.name}}
                      </span>
                    </div>
                  </div>  
                </div>
                
            </div>
          </div>
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
                      <div class="col-lg-3 col-md-6" v-if="products.length > 0" v-for="product in products" :key="product.idproduct">
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
                                    <span v-if="!product.agregate">
                                      <a class="relative" @click="addOrder(product)" title="Agregar a Lista de Compra"><i class="icons icon-basket-loaded"></i></a>
                                    </span>
                                    <span v-else>
                                      <button class="relative btn" @click="" title="Agregado a Lista de Compra">Agregado</button>
                                    </span>
                                  </div>
                              </div>
                              <div class="details pb-10 pt-20">
                                  <div class="title d-flex flex-row justify-content-between">
                                      <a href="theme-details.html">
                                          <h6>{{product.name}}</h6>
                                          {{product.agregate}}
                                      </a>
                                      <h6 class="price">$ {{product.price}}</h6>
                                  </div>
                              </div>
                              <div class="meta d-flex flex-row">
                                  <div class="user-img">
                                    <img class="product-img" v-if="product.commerces.image != null" :src="'images/commerce/'+product.commerces.image" />
                                    <img v-else class="product-img" src="img/user-img.png" alt="">
                                  </div>
                                  <p>{{product.commerces.name}}</p>
                              </div>
                          </div>
                      </div>
                      <div v-if="products ==0" class="col-lg-12 text-center">
                        <h2 >No existen productos</h2>
                      </div>
                    </div>  
                </div>
            </div>
        </div>
        <commerces></commerces>
        <!-- Modal -->
        <b-modal id="loginModal" ref="loginModal" hide-header hide-footer>
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <button type="button" class="close" @click="closeModal()">
                    <span>x</span>
                  </button>
                  <h2 class="text-center">Aviso</h2>
                  <div class="clear-fix"></div>
                  <br>
                  <div class="col-lg-12">
                    <h4><p class="text-justify">No estás autenticado, debes ingresar para agregar productos a la lista de compra</p></h4>
                  </div>
                  <div class="clear-fix"></div>
                  <br>
                  <button class="col-lg-12 btn primary-btn" @click="login()">Ingresar</button>
                </div>
              </div>
            </div>
          </div>
        </b-modal> 
        <!-- Modal -->
        <b-modal id="notifyModal" ref="notifyModal" hide-header hide-footer>
          <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                    <button type="button" class="close" @click="closeNotifyModal()">
                      <span>x</span>
                    </button>
                    <h2 class="text-center">Aviso</h2>
                    <div class="clear-fix"></div>
                    <br>
                    <div class="col-lg-12">
                      <h4><p class="text-justify">No ha seleccionado Tienda y/o Sucursal</p></h4>
                    </div>
                    <div class="clear-fix"></div>
                    <br>
                    <b-btn v-b-modal="'commercesModal'" @click="closeNotifyModal()" title="Seleccionar de Tienda" class="btn primary-btn col-lg-12">Seleccionar</b-btn>
                  </div>
                </div>
              </div>
            </div>
          </b-modal> 


      </div>
</template>
<script>

import Bus from '../../utilities/EventBus'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import commerces from './Commerces-modal'

export default {
  name: 'index',
  components: {
    PulseLoader,
    commerces
  },
  data() {
    return {
      url: '/list-products',
      idcommerce: '',
      commerce: '',
      idbranch: '',
      branch: '',
      isLogged: false,
      form: {},
      userId: '',
      products: [],
      productos: [],
      branchs: [],
      typeproducts: [],
      loading: false,
      color: '#5bc0de',
      size:'30px',
      list: [],
      listproducts: [],
    }
  },
  created() {
    this.index();
  },

  methods: {
    index() {
      this.loading = true
      this.checkLogin()
      
      axios.get('api/type-products').then(response => {
          this.typeproducts = response.data.data                
        })

      this.commerceBranchSelect()

      if(this.idcommerce){
        axios.get('api/commerce/'+this.idcommerce).then(response => {
            this.commerce = response.data[0]
          })

        axios.get('api/branch/'+this.idbranch).then(response => {
            this.branch = response.data.data[0]
          })
      }

      if(this.idbranch) {
        axios.get('api'+this.url+'/'+this.idbranch).then(response => {
          this.productos = response.data.data[0].products
          console.log(this.list)
          if(this.list.length > 0) {
            let idMarketList = this.list[0].idmarketplacelisting
            axios.get('api/marketplace/'+idMarketList).then(response => {
              this.listproducts = response.data.data[0].details
              
              for(let i=0; i<this.productos.length; i++) {  
                let pos = this.listproducts.map( function(e) {
                  return (e.product_idproduct)
                }).indexOf(this.productos[i].idproduct)

                if(pos !== -1) {
                  this.productos[i].agregate = true
                }

              }
            this.products = this.productos
            this.loading = false
            })
          } else {
            this.products = this.productos
            this.loading = false            
          }
      })
      } else {
        axios.get('api'+this.url).then(response => {
          this.products = response.data.data
          this.loading = false
        })        
      }

      this.form.producttype_idproducttype = 0

    },
    commerceBranchSelect() {
      const user_config = JSON.parse(localStorage.getItem('user_config'))

      if( user_config ) {
        this.idcommerce = user_config.list[0].commerce
        this.idbranch = user_config.list[0].branch

        axios.get('api/marketplace-active/'+this.idcommerce+'/'+this.idbranch).then(response => {
          this.list = response.data.data
        }) 
      } 
    },
    addProduct(product,idmarketplacelisting = null) {
      let detalles = []

      let detalle = {
        'quantity': '1',
        'unitprice': product.price,
        'taxes': parseFloat(product.price*(product.taxpercentage/100)).toFixed(2),
        'product_idproduct': product.idproduct,
        'productunitofmeasurement_idproductunitofmeasurement': product.productunitofmeasurement_idproductunitofmeasurement,
        'statelisting_idstatelisting': '1'
      }

      detalles.push(detalle)
      
      var datos = {
        'commerce_idcommerce': this.idcommerce,
        'branch_idbranch': this.idbranch,
        'detalle': detalles
      }

      if(idmarketplacelisting !== null) {
        datos.idmarketplacelisting = idmarketplacelisting
      } 

      return datos
    },
    addOrder(product) {
      if(this.isLogged) {
        console.log('Logged')
        if(this.idcommerce && this.idbranch) {
            if(this.list.length == 0) {
              let data = this.addProduct(product)
              var idMarketList = ""
              axios.post('api/marketplace',data).then(response => {
                idMarketList = response.data.data.idmarketplacelisting
                this.redirectAddProduct(response.data.data.idmarketplacelisting)
              })
              .catch(err => {
                  console.log(err)
              })
            } else {
              idMarketList = this.list[0].idmarketplacelisting
              let data = this.addProduct(product,idMarketList)

              axios.put('api/marketplace/'+idMarketList,data).then(response => {
                this.redirectAddProduct(idMarketList)  
              })
              .catch(err => {
                  console.log(err)
              })
            }
        } else {
          this.$refs.notifyModal.show()    
        }
      } else {
        console.log(this.isLogged)
        this.$refs.loginModal.show()
      }
    },
    redirectAddProduct(idMarketList) {
      console.log(idMarketList)
      Bus.$emit('marketPlace_id', idMarketList)
      this.$router.push({name: 'shopping-list',
        params: { 'marketplace': idMarketList}
      })
    },
    closeNotifyModal() {
      this.$refs.notifyModal.show()    
    },
    login() {
      localStorage.setItem('redirect', '/list-products')
      window.location.href = '/login'
    },
    closeModal() {
      this.$refs.loginModal.hide()
    },
    filtering(id) {
      this.loading = true
      console.log(id)
      if(id == 0 && !this.idbranch) {
        axios.get('api'+this.url).then(response => {
          this.products = response.data.data
          this.loading = false
          console.log(this.products)
        })
      } else if(id == 0 && this.idbranch) {
        axios.get('api'+this.url+'/'+this.idbranch).then(response => {
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
      } else if(id > 0 && this.idbranch) {
        axios.get('api'+this.url+'/'+this.idbranch+'/'+id).then(response => {
          this.branchs = response.data.data
          this.products= []
          console.log(this.products)
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
      } else {
        axios.get('api'+this.url+'/all-branch/'+id).then(response => {
          this.branchs = response.data.data
          this.products= []
          for( let i=0; i<this.branchs.length; i++ ) {
            if(this.branchs[i].products.length != 0) {
                var productos = this.branchs[i].products
                for( let j=0; j<productos.length; j++ ) {
                  this.products.push(productos[j])
                  console.log(this.products)

                }
            }
          }
          this.loading = false
        })  
      }           
    },
    checkLogin() {
      const token = window.localStorage.getItem('access_token')

      if( !token || token  === null || token === undefined) {
        this.isLogged = false    
      } 
      
      if(token) {
        this.isLogged = true             
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
  .image-commerce {
    margin-left: 10px;
    width: 60px;
    height: 50px;
    border-radius: 45%;
  }
  .product-img {
    width: 20px;
    height: 20px;
    border-radius: 45%;
  }
</style>

