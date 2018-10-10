<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Perfil" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <label>Primer Nombre</label>
                            <input type="text" placeholder="Primer Nombre" v-model="user.firstname" class="common-input">
                            <small class="text-danger" v-if="error.firstname">{{ error.firstname[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Segundo Nombre</label>
                            <input type="text" placeholder="Segundo Nombre" v-model="user.middlename" class="common-input">
                            <small class="text-danger" v-if="error.middlename">{{ error.middlename[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Apellidos</label>
                            <input type="text" placeholder="Apellidos" v-model="user.lastname" class="common-input">
                            <small class="text-danger" v-if="error.lastname">{{ error.lastname[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="password" placeholder="Contraseña" v-model="password" class="common-input">
                            <small class="text-danger" v-if="error.password">{{ error.password[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="password" placeholder="Confirmación Contraseña" v-model="password_confirmation" class="common-input">
                            <small class="text-danger" v-if="error.password_confirmation">{{ error.password_confirmation[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Teléfono</label>
                            <input type="text" placeholder="Teléfono" v-model="user.phone" class="common-input">
                            <small class="text-danger" v-if="error.phone">{{ error.phone[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" v-model="user.birthday" v-bind:max="datemax" class="common-input">
                            <small class="text-danger" v-if="error.birthday" >{{ error.birthday[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <label>Dirección</label>
                            <textarea  v-model="user.address" row="2" class="common-input" cols="30"></textarea>
                            <small class="text-danger" v-if="error.address">{{ error.address[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">País
                            <select v-model="user.country_idcountry" @change="country(user.country_idcountry)" class="form-control common-input">
                                <option v-for="option in countries" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.country">{{ error.country[0] }}</small>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">Estado
                            <select v-model="user.state_idstate" @change="state(user.state_idstate)" required class="form-control common-input">
                                <option v-for="option in states" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.state">{{ error.state[0] }}</small>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting">Ciudad
                            <select v-model="user.city_idcity" required class="form-control common-input">
                                <option v-for="option in cities" :value="option.id">{{option.name}}</option>
                            </select>
                            <small class="text-danger" v-if="error.city">{{ error.city[0] }}</small>
                           </div> 
                        </div>
                        <div class="col-lg-12">
                          <div class="upload-fleid"> Seleccionar imagen de Perfil
                            <div class="input-group input-file">
                              <input class="form-control" type="file" accept="image/*" @change="previewImage">
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12 text-center avatar-wrap">
                          <div class="avatar-thumb mr-20">
                              <img :src="imageData" alt="" >
                          </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="sorting"> Localización
                                <select class="form-control common-input" id="geocoder" @change="selectGeo()">
                                    <option value="1" >Geolocalización HTML5</option>
                                    <option value="2"selected>Abrir Maps</option>
                                    <option value="3">Escribir dirección</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mapHtml5" id="mapHtml5"></div>
                            <div class="col-lg-12 pickerMap" id="pickerMap"></div>
                            <input type="text" placeholder="Escriba la dirección" id="textlocation" @change="addressMap" class="common-input">
                            <div class="col-lg-12 locationText" id="locationText"></div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="button" @click.prevent="update" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                        </div>
                      </div>
                  </div>     
              </div>
          </form>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus';

export default {
  data() {
    return {
      editId: '',
      url: '/profile',
      user: [],
      error: [],
      countries: [],
      states: [],
      cities: [],
      password: "",
      password_confirmation: "",
      imageData : "", 
      datemax : "",
      datemin : ""

    }
  },

  mounted() {
    Bus.$on('id_user', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getCountries();
    });
  },

  methods: {
    edit(id) {
      axios.get('api' + this.url + '/' + id ).then(response => {
        this.user = response.data.user[0];
        this.datemax = new Date(this.fecha(-5320)).toISOString().slice(0,10);
      console.log(this.datemax)
        this.country(this.user.country_idcountry)
        this.state(this.user.state_idstate)
        this.imageData = this.user.image
        this.html5Location()
             
      })
      .catch(err => console.log(err))
    },
    fecha(dias) {
      let fecha = new Date()
      fecha.setDate(fecha.getDate() + dias)
      return fecha
    },
    getCountries() {
      axios.get('api/countries').then(data => {
        this.countries = data.data;
      })
      .catch(err => console.log(err))
    },
    previewImage: function(event) {
      let input = event.target

      if(input.files && input.files[0]) {
          let reader = new FileReader();

          reader.onload = (e) => {
              this.imageData = e.target.result
          }

          reader.readAsDataURL(input.files[0])
      }
    },

    html5Location() {
      let mapHtml5 = document.getElementById('mapHtml5');
      document.getElementById('textlocation').style.display = "none";
      document.getElementById('pickerMap').style.display = "none";

      let vm = this;

      if (navigator.geolocation) {
        mapHtml5.style.display = "block";

        navigator.geolocation.getCurrentPosition(function(position) {
          console.log(position.coords);

          vm.user.latitude = position.coords.latitude;
          vm.user.longitude = position.coords.longitude;

          let lat = position.coords.latitude;
          let ln = position.coords.longitude;

          let gLatLn = new google.maps.LatLng( lat, ln );
          let objConfig = {
            zoom: 14,
            center: gLatLn
          };

          let gMap = new google.maps.Map( mapHtml5, objConfig );
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

      console.log('ingreso')
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
          this.user.latitude = marker.getPosition().lat();
          this.user.longitude = marker.getPosition().lng();
      });

    },

    inputAddress() {
      document.getElementById('mapHtml5').style.display = "none";
      document.getElementById('pickerMap').style.display = "none";
      document.getElementById('textlocation').style.display = "block";
    },

    addressMap() {

      let latitude;
      let longitude;
      let vm = this;

      let geocoder = new google.maps.Geocoder();

      document.getElementById('textlocation').style.display = 'block';
      let address = document.getElementById('textlocation').value;

      geocoder.geocode({'address': address}, function(results, status) {

         if (status == google.maps.GeocoderStatus.OK) {
           document.getElementById('locationText').style.display = "block";

              latitude = results[0].geometry.location.lat();
              longitude = results[0].geometry.location.lng();

              vm.user.latitude = latitude;
              vm.user.longitude = longitude;

            let map = new google.maps.Map(document.getElementById('locationText'), {
                  center: {
                      lat: latitude,
                      lng: longitude
                  },
                  zoom: 17
              });
          } else {
              document.getElementById('locationText').style.display = "none";

              vm.user.latitude = '';
              vm.user.longitude = '';
          }
      });
    },

    selectGeo() {
      let val = document.getElementById('geocoder').value;
      if(val == 1) {
        this.html5Location();
      } else if (val == 2) {
        this.markerMap();
      } else {
        this.inputAddress();
      }
    },

    update() {
      this.errors = {};
console.log(this.user.birthday)
      let params = new FormData();
      params.append('userId', this.user.id);
      params.append('firstname', this.user.firstname);  
      this.user.middlename? params.append('middlename', this.user.middlename): "";     
      params.append('lastname', this.user.lastname);
      params.append('email', this.user.email);
      this.user.phone? params.append('phone', this.user.phone): "";
      this.user.birthday? params.append('birthday', this.user.birthday): "";
      this.user.address? params.append('address', this.user.address): "";
      this.user.latitude? params.append('latitude', this.user.latitude): "";
      this.user.longitude? params.append('longitude', this.user.longitude): "";
      params.append('country_idcountry', this.user.country_idcountry);
      params.append('state_idstate', this.user.state_idstate);
      params.append('city_idcity', this.user.city_idcity);

      if(this.user.password) {
          params.append('password', this.password)
          params.append('password_confirmation', this.password_confirmation)
      }

      let input = document.querySelector('input[type=file]')                
      let file = (input.files[0] ? input.files[0]: null)
      if(file !== undefined || file !== NULL || file.type.match(/image.*/)) params.append('imagen', file);

      axios.post('api'+this.url, params)
         .then(response => {
              localStorage.setItem('userdata',JSON.stringify(response.data.user));
              this.$refs.editModal.hide();              
              swal({
                title: "Aviso",
                text: response.data.success,
                icon: "success"
              })
              //router.go({path:"/"})              
              //router.push({ name: 'profile' })
              //this.$router.push('/profile') 
              //this.$route.router.go('/profile');
              //router.go('/')
              //this.$router.reload()

         })
         .catch(errors => {
              console.log(errors.response)
            if(errors.response.status === 422) {
              this.error = errors.response.data.error;
              console.log(this.error)
            }
         });

    },
    country(id) {
      this.cities = []
      axios.get('/getstates/'+id)
          .then(
              (response) => {
                  this.states = response.data;
              }   
          )
    },
    state(id) {
      axios.get('/getcities/'+id)
        .then(
            (response) => {
                this.cities = response.data;
            }   
        )
    },

  }
}
</script>

<style lang="scss" scoped>
.mapHtml5 {
  margin-top: 15px;
  width: 100%;
  height: 200px;
  display: none;
}

.pickerMap {
  margin-top: 15px;
  width: 100%;
  height: 200px;
}

.locationText {
  margin-top: 15px;
  width: 100%;
  height: 200px;
  display: none;
}

.geolocation {
  cursor: pointer;
  color: #FFF !important;
}

#textlocation {
  display: none;
}

.geolocation:hover {
  color: #42b0f2 !important;
}

.input-map {
  display: none;
}

img {
  width: 30%;
}
</style>