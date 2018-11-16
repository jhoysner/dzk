<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <router-link to="/" class="nav-link">
                      TIENDAS
                  </router-link>
                </li>
                <li class="nav-item">
                   <router-link to="/home-discounts" class="nav-link">
                      DESCUENTOS
                   </router-link>
                </li>
                <li class="nav-item">
                   <router-link to="/branchs-map" class="nav-link active">
                      SUCURSALES
                   </router-link>
                </li>
              </ul>
              
              <div class="row justify-content-center stat-table-wrap">
                <div class="col-lg-12 stat-wrap-container">
                    <div class="stat-wrap my-4">
                        <pulse-loader id="spinner" :loading="loading" :color="color" :size="size"></pulse-loader>
                        <div class="col-lg-12 branchsMap" id="branchsMap"></div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    </div>
</template>


<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import GoogleMapsLoader from 'google-maps'

    export default {
        data() {
			return {
        branchs:[],
        loading: false,
        color: '#5bc0de',
        size:'30px',
			}
		},
    components: {
      PulseLoader
    },
		mounted() {
			this.index();
		},

		methods: {
            index() {
                this.loading = true
                axios.get('api/branchs-near').then(response => {
                  var branchs = response.data.data
                  this.loading = false
                
                    GoogleMapsLoader.load(function(google) {
                        var bounds = new google.maps.LatLngBounds();
                        var map = new google.maps.Map(document.getElementById('branchsMap'), {                    
                            zoom: 8,
                            mapTypeId: 'roadmap'
                        })

                        var markers = [];
                        markers = branchs

                        var infoWindow = new google.maps.InfoWindow(), marker, i;

                        for(let i=0; i < markers.length; i++ ) {
                            var position = new google.maps.LatLng(markers[i]['latitude'],markers[i]['longitude']);
                            var pos = i+1;
                            bounds.extend(position);
                            var marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                title: markers[i]['name'] + ' ' + '(Posición '+ pos + ')'
                            });

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infoWindow.setContent(markers[i]['name']);
                                    infoWindow.open(map, marker);
                                }
                            })(marker, i));

                            map.fitBounds(bounds);
                        }
/*
                        var marker = new google.maps.Marker({
                            position: {
                                lat: 4.710988599999999,
                                lng: -74.072092
                            },
                            map: map,
                            //draggable: true
                        });
*/
                      })
                })
                .catch(err => console.log(err))

            
            },	

		}
	}
</script>

<style media="screen">
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
  #spinner {
    text-align: center;
    padding-top: 10vh;
    height: 80vh;
  }

</style>