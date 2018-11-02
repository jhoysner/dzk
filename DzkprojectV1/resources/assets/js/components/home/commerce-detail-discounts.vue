<template>
  <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.push('/')">Atras</button>
        <!--<h2 class="my-4">Comercio: {{id}}</h2> -->
        <br />

        <!--<ul class="nav nav-tabs">
          <li class="nav-item">
             <router-link :to="`/commerce/${id}`" class="nav-link">
                Detalle
             </router-link>
          </li>
          <li class="nav-item">
             <router-link :to="`/commerce/${id}/branchs`" class="nav-link">
                Sucursales
             </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="`/commerce/${id}/discounts`" class="nav-link active">
                Descuentos
             </router-link>
          </li>
        </ul> -->
        <h3 class="mt-4">Descuentos</h3>
        <h5>Tienda: {{ commerce.name }}</h5>    
        <div class="row justify-content-center stat-table-wrap">
            <div class="col-lg-12 stat-wrap-container">
                <div class="stat-wrap">
                    <div v-for="branch in branchs">
                      <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                          <div class="col-lg-3 col-md-6" v-for="discount in branch.discounts" :key="discount.iddiscount">
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
                                          <h6>
                                            <router-link :to="`/commerce/${branch.idbranch}`">
                                              <span> {{commerce.name}}</span>
                                            </router-link>
                                         </h6>
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
                                          <span class="badge badge-secondary">{{tag.name}}</span>
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
                                      <button type="button" :disabled="userHaveDiscount(discount.iddiscount)" :class="{ userHaveDiscount: userHaveDiscount(discount.iddiscount) }" class="btn btn-outline-primary" @click="obtenerDescuento(discount, branch.idbranch)">
                                          {{ userHaveDiscount(discount.iddiscount) ? 'Ya aplicaste a este descuento': 'Obetener este Descuento'}} 
                                     </button>
                                </div>
                            </div>
                          </div>
                        </div> <!-- Aqui termina -->
                    </div>
                </div>
            </div>
            <paginator :pagination="pagination"></paginator>

            <b-modal v-model="show" id="showBranchs" ref="showBranchs" title="Elegir Sucursal donde se obtendra el Descuento" hide-footer>
              <div class="modal-content">
                <div class="container">
                      
                    <h3 class="my-4">Sucursal:</h3>   
                    
                    <div v-for="branch in branchs">
                                            
                        <input class="" type="radio"  v-model="form.branch_idbranch" id="branch.name" :value="branch.idbranch" >
                         <span>{{branch.name}}</span>
                        <br><br>
                    </div>                            
                    
                </div>
              </div>
                <div class="modal-footer">
                    <b-btn @click="show=false">Cancelar</b-btn>
                    <button type="submit" @click="acceptTerms()" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Obetener</button>
                </div>
          </b-modal>    
          <!-- terminos y condiciones  -->
          <b-modal v-model="showTC" id="terminosCondiciones" ref="terminosCondiciones" title="Aceptar Terminos y Condiciones" hide-footer>
              <div class="modal-content">
                <div class="container">
                    <h4 class="mt-4">Descuento :  <span class="subtitle1"> {{discount.title}}</span></h4>  
                    <p>Vence  <span class="vence">{{formatDateHuman(discount.enddate)}}</span> </p>

                    <h4>Sucursal :<span class="subtitle1" > {{branch.name}}</span> </h4>
                    <p> Direccion {{branch.address}}</p>  
                    <hr>
                    <h3 class="my-4" v-if="discount.conditions">Condiciones</h3>
                    <p>{{discount.conditions}}</p>   

                    <h3 class="my-4" v-if="discount.restrictions">Restriccion</h3>
                    <p>{{discount.restrictions}}</p> 
                    
                    <div v-if="!discount.conditions && !discount.restrictions">   
                      <p>
                         Si esta de acuerdo en aceptar los terminos y condiciones presentadas por el descuento continue.
                      </p>               
                    </div>  
                                           
                    
                </div>
              </div>
                <div class="modal-footer">
                    <b-btn @click="showTC=false">Cancelar</b-btn>
                    <button type="submit" @click="saveUserHasDiscount()" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Continuar</button>
                </div>
          </b-modal> 

        </div>
  </div>
</template>

<script>
  import Bus from '../../utilities/EventBus.js';
  import paginator from '../../utilities/paginator';
  import moment from 'moment';
  moment.locale('es');

  export default {
    components: { paginator },
    data() {
      return {
        id: this.$route.params.id,
        commerce: {
          idcommerce: '',
          name: '',
        },
        form: { 
          'validfrom': '',
          'validto':'',
          'amount':'',
          'normalprice':'',
          'discountprice':'',
          'discountpercentage': '',
          'discount_iddiscount': '',
          'userhasdiscountstatus_iduserhasdiscountstatus': '',
          'commerce_idcommerce': '',
          'branch_idbranch': '',
          'users_id': '',
        },
        branchs:[],
        branch: {},
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        show:false, 
        showTC:false, 
        discount: {},
        user:{},
        length: ''
      }
    },

    mounted() {
      this.auth();
      this.getCommerce();
      this.index();

      Bus.$on('change_page', (page) => {
        this.index(page);
      });
    },

    methods: {
      auth() {
        axios.get('/api/profile').then((response) => {
          this.user = response.data.user;
          this.length = this.user.discounts.length
          // console.log(this.user.id);
          // this.index();
        })
        .catch(err => console.log(err))
      },

      getCommerce() {
        axios.get('/api/detail-commerce/' + this.$route.params.id).then(data => {
          this.commerce.idcommerce = data.data.data[0].idcommerce;
          this.commerce.name = data.data.data[0].name;
        })
        .catch(err => console.log(err))
      },

      index(page) {
        axios.get('/api/commerce-detail-discounts/' + this.$route.params.id+ '?page=' + page).then(response => {
          console.log(response.data.branchs.data)
          this.branchs = response.data.branchs.data;
          this.pagination = response.data.paginate;        
        })
        .catch(err => console.log(err))
      },

      formatDateHuman(value){
        return  moment(value).endOf('day').fromNow()
      },

      acceptTerms(){
        this.$refs.showBranchs.hide()

          var i = this.branchs.length;
          while (i--) {
             if (this.branchs[i].idbranch === this.form.branch_idbranch) {
                this.branch = this.branchs[i]
             }
          }

        this.$refs.terminosCondiciones.show()
      },

      userHaveDiscount(id){
          var i = this.length;
          while (i--) {
             if (this.user.discounts[i].pivot.discount_iddiscount === id) {
                 return true;
             }
          }
          return false;
      },

      obtenerDescuento(discount, branch_id){
          
         //this.branchs = discount.branchs;
         this.$refs.showBranchs.show()
         this.form.validfrom = discount.startdate;
         this.form.validto = discount.enddate;
         this.form.amount = 1;
         this.form.normalprice = discount.normalprice;
         this.form.discountprice = discount.discountprice;
         this.form.discountpercentage = discount.discountpercentage;
         this.form.discount_iddiscount = discount.iddiscount;
         this.form.userhasdiscountstatus_iduserhasdiscountstatus = '2';
         this.form.commerce_idcommerce = this.commerce.idcommerce;
         this.form.branch_idbranch = branch_id;
         this.form.users_id = this.user.id;
         this.discount = discount;
  
      },

      saveUserHasDiscount(){
         this.$refs.terminosCondiciones.hide() 
         axios.post('/api/user-has-discount', this.form).
          then(response => {
             const id = response.data.data.idusers_has_discount 
              this.form = {};
              swal({
                title: "Obtenido",
                text: "Se obtuvo Descuento Satifactoriamente",
                icon: "success",
              })
            this.$router.push({ path: `/client-discount/${id}` })
          })
          .catch(error => {
            console.log(error)

          });

      },

    }
  }
</script>

<style>
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }
</style>