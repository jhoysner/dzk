<template>
    <div>
        <b-modal id="editLocModal" ref="editLocModal" title="Actualizar Localización" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="col-lg-12">
                          <div class="sorting"> Localización
                              <select class="form-control common-input" id="geocoders" @change="selectGeo()">
                                  <option value="1" selected>Geolocalización HTML5</option>
                                  <option value="2" >Abrir Maps</option>
                                  <option value="3">Escribir dirección</option>
                              </select>
                              <p>
                                <small class="text-danger" v-if="error.latitude">
                                  {{ error.latitude[0] }}
                                </small>
                              <p>
                              <p>
                                <small class="text-danger" v-if="error.longitude">
                                  {{ error.longitude[0] }}
                                </small>
                              </p>

                          </div>

                          <div class="col-lg-12 html5Map" id="html5Map"></div>
                          <div class="col-lg-12 mapPicker" id="mapPicker"></div>
                          <input type="text" placeholder="Escriba la dirección" id="textMap" @change="addressMap()" required class="common-input">
                          <div class="col-lg-12 textLocation" id="textLocation"></div>
                      </div>

                      <div class="col-lg-12 text-right">
                          <button type="button" @click.prevent="update()" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                      </div>
                  </div>     
              </div>
          </form>
        </b-modal> 
    </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      user: [],
      error: [],
    }
  },

  mounted() {
    this.html5Location();
  },

  methods: {
    html5Location() {
      let html5Map = document.getElementById('html5Map');
      document.getElementById('textMap').style.display = "none";
      document.getElementById('mapPicker').style.display = "none";

      let vm = this;

      if (navigator.geolocation) {
        html5Map.style.display = "block";

        navigator.geolocation.getCurrentPosition(function(position) {
          //console.log(position.coords);
          vm.user.latitude = position.coords.latitude;
          vm.user.longitude = position.coords.longitude;

          let lat = position.coords.latitude;
          let ln = position.coords.longitude;

          let gLatLn = new google.maps.LatLng( lat, ln );
          let objConfig = {
            zoom: 14,
            center: gLatLn
          };

          let gMap = new google.maps.Map( html5Map, objConfig );
          let objConfigMarker = {
            position: gLatLn,
            map: gMap
          };
          let gMarker = new google.maps.Marker( objConfigMarker );
        });
      } else {
          console.log("Geolocation is not supported by this browser.");
      }
    },

    markerMap() {
      document.getElementById('html5Map').style.display = "none";
      document.getElementById('textMap').style.display = "none";
      document.getElementById('mapPicker').style.display = "block";

      let vm = this;

      let map = new google.maps.Map(document.getElementById('mapPicker'), {
          center: {
              lat: 4.710988599999999,
              lng: -74.072092
          },
          zoom: 5
      });

      //marker
      let marker = new google.maps.Marker({
          position: {
              lat: 4.710988599999999,
              lng: -74.072092
          },
          map: map,
          draggable: true
      });

      //dragged event of marker
      google.maps.event.addListener(marker, 'dragend', () => {
          vm.user.latitude = marker.getPosition().lat();
          vm.user.longitude = marker.getPosition().lng();
      });
    },

    showInputAddress() {
      document.getElementById('html5Map').style.display = "none";
      document.getElementById('mapPicker').style.display = "none";
      document.getElementById('textMap').style.display = "block";
    },

    addressMap() {

      let latitude;
      let longitude;
      let vm = this;

      let geocoder = new google.maps.Geocoder();

      let address = document.getElementById('textMap').value;

      geocoder.geocode({'address': address}, function(results, status) {

         if (status == google.maps.GeocoderStatus.OK) {
           document.getElementById('textLocation').style.display = "block";

              latitude = results[0].geometry.location.lat();
              longitude = results[0].geometry.location.lng();

              vm.user.latitude = latitude;
              vm.user.longitude = longitude;

            let map = new google.maps.Map(document.getElementById('textLocation'), {
                  center: {
                      lat: latitude,
                      lng: longitude
                  },
                  zoom: 17
              });
          } else {
              document.getElementById('textLocation').style.display = "none";

              vm.user.latitude = '';
              vm.user.longitude = '';
          }
      });
    },

    selectGeo() {
      let val = document.getElementById('geocoders').value;
      if(val == 1) {
        this.html5Location();
      } else if (val == 2) {
        this.markerMap();
      } else {
        this.showInputAddress();
      }
    },


    update() {
    console.log(this.user)      
      let lat = this.user.latitude
      let lng = this.user.longitude
      axios.get('/api/localization/'+lat+'/'+lng)
        .then(response => {
        this.$refs.editLocModal.hide();              
        this.$parent.index()
        $('#editLocModal').trigger("reset");
        swal({
                title: "Aviso",
                text: response.data.success,
                icon: "success"
              })
      })
      .catch(err => console.log(err))
      

    },

  }
}
</script>

<style media="screen">
.html5Map {
  margin-top: 15px;
  width: 100%;
  height: 200px;
  display: none;
}

.mapPicker {
  margin-top: 15px;
  width: 100%;
  height: 200px;
}

.textLocation {
  margin-top: 15px;
  width: 100%;
  height: 200px;
  display: none;
}

.geolocation {
  cursor: pointer;
  color: #FFF !important;
}

.geolocation:hover {
  color: #42b0f2 !important;
}

#textMap {
  display: none;
}
.input-map {
  display: none;
}
</style>