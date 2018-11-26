<template>
    <div>
    	<div id="section-profile" class="settings-content">
            <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>
            <br />
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
        
                                            </div>
                                        </div>
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

                                <div class="single-sidebar theme-details">
                                    <h6>Descuentos</h6>
                                    <ul class="theme-details-list">
               
                                        <li v-for="discount in discounts">
                                          <router-link :to="`/discount/${discount.iddiscount}`">
                                            {{ discount.title }} - ${{ discount.amountapproved }}
                                          </router-link>
                                        </li>
                                        <span v-if="discounts.length < 1">Sin descuentos.</span>
                                  </ul>
                                </div>

                                <div class="single-sidebar theme-tags">
       
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