<template>
	<div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>

        <h3 class="my-4">{{ discount.title}} </h3>

        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview">
                            <!-- Overview section -->
                            <div class="overview-section">
                                <div class="theme-thumb">
                                    <img class="img-fluid" :src="'../images/discount/'+discount.image" />
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Informacion</h4>
                                    <p>
                                        {{discount.description}}
                                    </p>
                                    <p v-if="discount.conditions != null">
                                        Condiciones: {{ discount.conditions }}
                                    </p>
                                    <p v-if="discount.restrictions != null">
                                        Restricciones: {{ discount.restrictions }}
                                    </p>
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Categoria</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="support-list">
                                                <li>
                                                    <img src="/img/bullet.png" alt="">{{discount.discountcategory_iddiscountcategory}}
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Sucursales</h4>
                                    <div class="row">
                                        <div class="col">
                                            <b-card-group deck>
                                                <div v-for="branch in branchs">                                          
                                                    <b-card :title="branch.name"
                                                         :img-src="'../images/branch/'+branch.image"
                                                          img-alt="Image"
                                                          img-top
                                                          tag="article"
                                                          style="max-width: 15rem;"
                                                          class="mb-2">
                                                        <p class="card-text">
                                                          {{branch.name}}
                                                        </p>
                                                        <!-- <b-button href="#" variant="primary" size="sm">ver</b-button> -->
                                                         <router-link :to="`/branch/${branch.idbranch}`">
                                                            <a href="#" class="btn btn-primary btn-sm">
                                                            Detalle
                                                            </a>     
                                                          </router-link>
                                                    </b-card>    
                                                </div>
                                            </b-card-group>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 sidebar theme-details-sidebar">
                    <div class="single-sidebar">
                        <div class="price-title d-flex flex-row justify-content-between">
                            <h3 class="price my-2">{{discount.discountprice}}</h3>
                            <h4><s>{{discount.normalprice}}</s></h4>
                            <h6>{{discount.discountpercentage}}%</h6>
                        </div>

                    <button type="button" :disabled="userHaveDiscount(discount.iddiscount)" :class="{ userHaveDiscount: userHaveDiscount(discount.iddiscount) }"  class="btn btn-outline-primary" @click="obtenerDescuento(discount)" >Obtener Descuento</button>
                    </div>

                    <div v-show="discount.outstanding">
                         <h3 class="alert alert-success text-center">Destacado</h3>
                            
                    </div>

                    <div class="single-sidebar theme-details">
                        <h6>Comercio</h6>
                        <router-link :to="`/commerce/${commerce.idcommerce}`">
                            <span>{{commerce.name}}</span>
                        </router-link>

                    </div>                    

                    <div class="single-sidebar theme-details">
                        <h6>Detalle Fecha</h6>
                        <ul class="theme-details-list">
                            <li> <i class="icons icon-tag"></i> {{discount.startdate}}</li>
                            <li> <i class="icons icon-tag"></i> {{discount.enddate}}</li>
                        </ul>
                    </div>

                    <div class="single-sidebar theme-tags">
                        <h6>Tags</h6>
                        <ul class="tag-list">
                            <li v-for="tag in tags"> <i class="icons icon-tag"></i> {{tag.name}}</li>
                        </ul>
                        <div class="sidebar-social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-github" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-slack" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="single-sidebar">
                        <h6>Ubicacion</h6>
                        <div class="col-lg-12 branchsMap" id="branchsMap"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- modal sucursal -->
        <b-modal v-model="showB" id="showBranchs" ref="showBranchs" title="Elegir Sucursal donde se obtendra el Descuento" hide-footer>
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
                <b-btn @click="showB=false">Cancelar</b-btn>
              <button type="submit"  @click="acceptTerms()" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Obetener</button>
          </div>
        </b-modal> 
        <!-- terminos y condiciones  -->
        <b-modal v-model="showTCD" id="terminosCondicionesdetail" ref="terminosCondicionesdetail" title="Aceptar Terminos y Condiciones" hide-footer>
            <div class="modal-content">
              <div class="container">
                    
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
                  <b-btn @click="showTCD=false">Cancelar</b-btn>
                  <button type="submit" @click="saveUserHasDiscount()" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Continuar</button>
              </div>
        </b-modal> 

    </div>
</template>

<script>
import GoogleMapsLoader from 'google-maps'

	export default {
		data() {
			return {
				id: this.$route.params.id,
			    discount: {
			     	iddiscount: '',
			        title: '',
			        description: '',
			        image: '',
			        startdate: '',
			        enddate: '',
			        outstanding: '',
			        conditions: '',
			        restrictions: '',
			        amountapproved: '',
			        amountavailable: '',
                    amountredeemed: '',
                    normalprice: '',
                    discountprice: '',
                    discountcategory_iddiscountcategory: ''
			    },
                branchs:[],
                commerce:[],
                tags:[],
                show:false, 
                showTCD:false, 
                showB:false, 
                length:'', 
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
                user: {}
        	}
		},

		mounted() {
        this.auth();
  
		},

		methods: {
        index() {
          axios.get('/api/discount/' +this.id).then(response => {
            // console.log(response)
            this.discount.iddiscount = response.data.data.iddiscount;
            this.discount.title = response.data.data.title;
            this.discount.description = response.data.data.description;
            this.discount.image = response.data.data.image;
            this.discount.startdate = response.data.data.startdate;
            this.discount.enddate = response.data.data.enddate;
            this.discount.outstanding = response.data.data.outstanding;
            this.discount.conditions = response.data.data.conditions;
            this.discount.restrictions = response.data.data.restrictions;
            this.discount.normalprice = response.data.data.normalprice;
            this.discount.discountprice = response.data.data.discountprice;
            this.discount.discountpercentage = response.data.data.discountpercentage;
            this.discount.discountcategory_iddiscountcategory = response.data.data.categories.name;

            this.branchs = response.data.data.branchs;
            this.tags = response.data.data.tags;
            this.commerce = response.data.data.branchs[0].commerces;

             //console.log(response.data.data.branchs)
             GoogleMapsLoader.load(function(google) {
                var bounds = new google.maps.LatLngBounds();
                var map = new google.maps.Map(document.getElementById('branchsMap'), {
                    //zoom: 8
                })

                var markers = [];
                markers = response.data.data.branchs

                var infoWindow = new google.maps.InfoWindow(), marker, i;

                for(let i=0; i < markers.length; i++ ) {
                    var position = new google.maps.LatLng(markers[i]['latitude'],markers[i]['longitude']);
                    var pos = i+1;
                    bounds.extend(position);
                    var marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: markers[i]['name']
                    });

                     google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infoWindow.setContent('<p>'+markers[i]['name']+'</p>');
                            infoWindow.open(map, marker);
                        }
                    })(marker, i));

                    map.fitBounds(bounds);
                }

                var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                    this.setZoom(9);
                    google.maps.event.removeListener(boundsListener);
                });
              })

          })
          .catch(err => console.log(err))
        },
        auth() {
          axios.get('/api/profile').then((response) => {
            console.log(response)
            this.user = response.data.user;
            this.length = this.user.discounts.length;
            this.index();
            // this.sendCharcode(this.user.id);
          })
          .catch(err => console.log(err))
        },

        obtenerDescuento(discount){
             // console.log("listo");   
             // console.log(discount)
             // this.branchs = discount.branchs;}
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
             this.form.branch_idbranch = this.branchs[0].idbranch;
             this.form.users_id = this.user.id;
      
        },

        acceptTerms(){
          this.$refs.showBranchs.hide()
          this.$refs.terminosCondicionesdetail.show()
        },
        saveUserHasDiscount(){
         this.$refs.terminosCondicionesdetail.hide() 
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
        userHaveDiscount(id){
            var i = this.length;
            // console.log(i)
            while (i--) {
               if (this.user.discounts[i].pivot.discount_iddiscount === id) {
                   return true;
               }
            }
            return false;
        }
			

		}
	}
</script>

<style>

  .userHaveDiscount{
    color: #dc3545 !important;
    background-color: transparent !important;
    background-image: none !important;
    border-color: #dc3545 !important;
  }
	.image-discount {
	  width: 80px;
	  height: 50px;
	  border-radius: 50%;
	}
  .branchsMap {
        margin-top: 15px;
        width: 100%;
        height: 400px;
        margin: 0 auto;
    }
</style>