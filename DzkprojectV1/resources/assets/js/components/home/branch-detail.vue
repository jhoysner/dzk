<template>
    <div>
    	<div id="section-profile" class="settings-content">
            <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>
            <!--<h2 class="my-4">Surcursal: {{branch.idbranch}}</h2> -->
            <br />

                <!--<div>
                    <div class="row pt-30">
                        <div class="col-lg-6">
                            <label><strong>ID Sucursal</strong></label>
                            <p>{{branch.idbranch}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Dirección</strong></label>
                            <p>{{branch.address}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Horarios de atención</strong></label>
                            <p>{{branch.schedule}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Telefono principal</strong></label>
                            <p>{{branch.phone1}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Telefono secundario</strong></label>
                            <p>{{branch.phone2}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Imagen</strong></label>
                            <p>
    		                  <img class="image-branch" :src="'images/branch/'+branch.image" />
    		                </p>
                        </div>
                        <div class="col-lg-6" v-if="branch.latitude != null ">
                            <label><strong>Latitud y Longitud</strong></label>
                            <p>{{branch.latitude}} / {{ branch.longitude }}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Comercio</strong></label>
                            <p>{{ branch.commerce_idcommerce }}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>País</strong></label>
                            <p>{{branch.country_idcountry}}</p>
                        </div>
                        <div class="col-lg-6">
                            <label><strong>Estado</strong></label>
                            <p>{{branch.state_idstate}}</p>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="font-weight-bold">Ciudad</label>
                            <p>{{ branch.city_idcity }}</p>
                        </div>

                        <div class="clearfix"></div>
                        <br> 
                  
                    </div>-->
                    <div class="col-lg-12">
                        <h2 class="pb-30 semi-bold">{{ branch.name }}</h2>                   
                    </div> 

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="overview">
                                        <!-- Overview section -->
                                        <div class="overview-section">
                                            <div class="theme-thumb">
                                                <img class="img-fluid" :src="'../images/branch/'+branch.image" />
                                            </div>
                                            <div class="other-details">
                                                <h4 class="text-uppercase">Overview</h4>
                                                <p>
                                                    Dirección: {{ branch.address }}
                                                </p>
                                                <p>
                                                    Horario de atención: {{ branch.schedule }}
                                                </p>
                                                <p>
                                                    Teléfono principal: {{ branch.phone1 }}
                                                </p>
                                                <p>
                                                    Teléfono alternativo: {{ branch.phone2 }}
                                                </p>
                                                <p v-if="branch.latitude != null ">
                                                    Latitud y Longitud: {{branch.latitude}} / {{ branch.longitude }}
                                                </p>
                                                <!--<p>
                                                    2.Get to the point – Ask your question or explain your situation right away. Don’t beat around the bush. 3.Don’t be arrogant – You are calling technical support because you need help. Don’t try and be a smart guy. 4.Call for yourself.
                                                </p> -->
                                            </div>
                                        </div>
                                        <!-- Overview section -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 sidebar theme-details-sidebar">
                                <div class="single-sidebar">
                                    <b-btn v-b-modal="'editLocModal'" class="btn btn-primary" v-if="isLogged">Cambiar Dirección</b-btn>
                                    <div class="clear-fix"></div>
                                    <br>

                                    <div class="price-title d-flex flex-row justify-content-between">
                                        <h6>Nuestra ubicación</h6>
                                        <!--<h3 class="price">$39</h3> -->
                                    </div>
                                    <ul>
                                      <li>
                                        {{branch.country_idcountry}}
                                      </li>
                                      <li>
                                        {{branch.state_idstate}}
                                      </li>
                                      <li>
                                        {{branch.city_idcity}}
                                      </li>
                                    </ul>
                                   <!-- <a href="#" class="primary-btn">purchase only</a> -->
                                </div>

                               <!-- <div class="single-sidebar d-flex flex-row justify-content-between align-items-center total-downlaod">
                                    <h6>Total Downloads</h6>
                                    <h3>968</h3>
                                </div> -->

                                <div class="single-sidebar theme-details">
                                    <h6>Descuentos</h6>
                                    <ul class="theme-details-list">
                                        <!--<li><i class="icons icon-basket-loaded"></i> eCommerce, Magazine, Writing</li>
                                        <li> <i class="icons icon-bell"></i> Theme version: 4.3.5</li>
                                        <li><i class="icons icon-notebook"></i>View help file</li>
                                        <li><i class="icons icon-wrench"></i>Sass files included</li>
                                        <li><i class="icons icon-cloud-upload"></i>Download child theme</li> -->
                                        <li v-for="discount in discounts">
                                          <router-link :to="`/discount/${discount.iddiscount}`">
                                            {{ discount.title }} - ${{ discount.amountapproved }}
                                          </router-link>
                                        </li>
                                        <span v-if="discounts.length < 1">Sin descuentos.</span>
                                  </ul>
                                </div>

                                <div class="single-sidebar theme-tags">
                                    <!--<h6>Tags</h6>
                                    <ul class="tag-list">
                                        <li> <i class="icons icon-folder"></i> <a href="#">Bootstrap templates</a>,<a href="#"> business & services</a>, Marketing</li>
                                        <li> <i class="icons icon-tag"></i> <a href="#">Agency</a>,<a href="#"> business</a>,<a href="#"> corporate</a></li>
                                    </ul> -->
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
                    <!--<div v-if="discounts"> 
                        <h3 class="mt-4">Descuentos</h3>    
                        <div class="row justify-content-center stat-table-wrap">
                            <div class="col-lg-12 stat-wrap-container">
                                <div class="stat-wrap">
                                    <table class="table table-striped mt-40 stat-table">
                                        <thead>
                                          <tr>
                                            <th>ID Descuento</th>
                                            <th>Titulo</th>
                                            <th>Descripcion</th>
                                            <th>Inicio</th>
                                            <th>Fin</th>
                                            <th>Destacado</th>
                                            <th>Opcciones</th>
                                            </tr>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="discount in discounts">
                                                      <td>{{ discount.iddiscount}}</td>
                                                      <td>{{ discount.title }}</td>
                                                      <td>{{ discount.description }}</td>
                                                      <td>{{ discount.startdate }}</td>
                                                      <td>{{ discount.enddate }}</td>
                                                      <td>
                                                      {{ discount.outstanding ? "Si" : "No" }}
                                                      </td>
                                                      <td>
                                                        <router-link :to="`/discount/${discount.iddiscount}`">
                                                          <a href="#" class="btn btn-primary btn-sm">
                                                          Detalle
                                                          </a>     
                                                        </router-link>
                                                      </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                
        </div>
    <localization></localization>
    </div>
</template>

<script>
import GoogleMapsLoader from 'google-maps'
import localization from '../maps/Map';

    export default {
        components: {
            localization
        },
        data() {
			return {
				id: this.$route.params.id,
			     branch: {
                    idbranch: '',
                    name: '',
                    address: '',
                    schedule: '',
                    phone1: '',
                    phone2: '',
                    image: '',
                    latitude: '',
                    longitude: '',
                    commerce_idcommerce: '',
                    country_idcountry: '',
                    state_idstate: '',
                    city_idcity: ''
                  },
                 discounts:[],
                 isLogged: '',
                 user: []
			}
		},

		mounted() {
			this.index();
            
		},

		methods: {
            index() {



              axios.get('/api/branch/' + this.$route.params.id).then(response => {
                this.branch.idbranch = response.data.data[0].idbranch;
                this.branch.name = response.data.data[0].name;
                this.branch.address = response.data.data[0].address;
                this.branch.schedule = response.data.data[0].schedule;
                this.branch.phone1 = response.data.data[0].phone1;
                this.branch.phone2 = response.data.data[0].phone2;
                this.branch.image = response.data.data[0].image;
                this.branch.latitude = response.data.data[0].latitude;
                this.branch.longitude = response.data.data[0].longitude;
                this.branch.country_idcountry = response.data.data[0].countries.name;
                this.branch.state_idstate = response.data.data[0].states.name;
                this.branch.city_idcity = response.data.data[0].cities.name;
                this.branch.commerce_idcommerce = response.data.data[0].commerces.name;
                this.discounts = response.data.data[0].discounts;
                })
                .catch(err => console.log(err))

                var isLogged = this.checkLogin();

                GoogleMapsLoader.load(function(google) {

                    var bounds = new google.maps.LatLngBounds();

                    var map = new google.maps.Map(document.getElementById('branchsMap'), {})
                    
                    var markers = [];

                    let row={}
                    
                    if(isLogged) {
                        axios.get('/api/profile').then(response => {
                            this.user = response.data.user
                            console.log(1)
                        })
                        
                        var latuser = this.user.latitude
                        var lnguser = this.user.longitude

                        row.latitude = latuser
                        row.longitude = lnguser
                        row.name = "Mi Ubicación"
                        markers.push(row)
                        row={}
                    
                    var gLatlng = new google.maps.LatLng(latuser,lnguser)

                    }

                    row.latitude = response.data.data[0].latitude
                    row.longitude = response.data.data[0].longitude
                    row.name = response.data.data[0].name
                    markers.push(row)

                    console.log(markers)

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

                        //marker.setIcon('../images/branch/'+markes[i]['image']);

                         google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                infoWindow.setContent('<p>'+markers[i]['name']+'</p>');
                                infoWindow.open(map, marker);
                            }
                        })(marker, i));

                    }

                    map.fitBounds(bounds);

                    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                        this.setZoom(6);
                        google.maps.event.removeListener(boundsListener);
                    });

                    if(isLogged) {
                        var objConfigDR = {
                            map: map
                        }

                        var objConfigDS = {
                            origin: gLatlng,
                            destination: gLatlng,
                            travelMode: google.maps.TravelMode.DRIVING
                        }

                        var ds= new google.maps.DirectionsService()

                        var dr= new google.maps.DirectionsRenderer( objConfigDR )

                        ds.route( objConfigDS, fnRutear )

                        function fnRutear(resultados, status) {
                            if( status == 'OK' ) {
                                dr.setDirections( resultados )
                            } else {
                                console.log( status )
                            }
                        }
                    }

                })
            },	
            checkLogin() {
              const token = localStorage.getItem('access_token')
              if( !token) {
                return this.isLogged = false
              } else {
                return this.isLogged = true
              }

            },            

		}
	}
</script>

<style>
	.image-branch {
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