<template>
    <div>
        <b-modal id="createModal" ref="createModal" title="Crear Sucursal" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">

                      <div class="col-lg-12">
                          <input type="text" placeholder="Nombre" v-model="form.name" required class="common-input">
                          <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Dirección" v-model="form.address" required class="common-input">
                          <small class="text-danger" v-if="error.address">{{ error.address[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Horario de atención" v-model="form.schedule" required class="common-input">
                          <small class="text-danger" v-if="error.schedule">{{ error.schedule[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono principal" v-model="form.phone1" required class="common-input">
                          <small class="text-danger" v-if="error.phone1">{{ error.phone1[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono alternativo" v-model="form.phone2" required class="common-input">
                          <small class="text-danger" v-if="error.phone2">{{ error.phone2[0] }}</small>
                      </div>
                      <div class="col-lg-12">
                          <input type="file" id="image" placeholder="Imagen corporativa" @change="getImage" accept="image/*" ref="image" class="common-input">
                          <img v-if="!!form.image" :src="form.image" class="avatar" alt="Image">
                          <p><small class="text-danger" v-if="imageError != '' ">{{ imageError }}</small></p>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Localización
                              <select class="form-control common-input" id="geocoders" @change="selectGeo()">
                                  <option value="1">Geolocalización HTML5</option>
                                  <option value="2" selected>Abrir Maps</option>
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
                          <input type="text" placeholder="Escriba la dirección" id="textMap" @keyup.enter="addressMap()" required class="common-input">
                          <div class="col-lg-12 textLocation" id="textLocation"></div>
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Comercio al que pertenece
                              <select class="form-control common-input" v-model="form.commerce_idcommerce">
                                <option v-for="commerce in commerces" :value="commerce.idcommerce">
                                  {{ commerce.name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="error.commerce_idcommerce">{{ error.commerce_idcommerce[0] }}</small>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> País
                              <select class="form-control common-input" v-model="form.country_idcountry" @change="getStates()">
                                  <option v-for="country in countries" :value="country.id">
                                    {{ country.name }}
                                  </option>
                              </select>
                              <small class="text-danger" v-if="error.country_idcountry">{{ error.country_idcountry[0] }}</small>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> Estado
                              <select class="form-control common-input" v-model="form.state_idstate" @change="getCities()">
                                <option v-for="state in states" :value="state.id">
                                  {{ state.name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="error.state_idstate">{{ error.state_idstate[0] }}</small>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> Ciudad
                              <select class="form-control common-input" v-model="form.city_idcity">
                                <option v-for="city in cities" :value="city.id">
                                  {{ city.name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="error.city_idcity">{{ error.city_idcity[0] }}</small>
                          </div>
                      </div>

                      <div class="col-lg-12 text-right">
                          <button type="button" @click.prevent="store" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
                      </div>
                  </div>
                  
              </div>
          </form>
  </b-modal> 
    </div>
</template>

<script>
    export default {
        name: "create",
        data() {
            return {
              form: {
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
              url: '/branch',
              error: {},
              countries: [],
              states: [],
              cities: [],
              commerces: [],
              branchMaxSize: null,
              branchMinSize: null,
              validExtensions: [],
              imageError: '',
            }
        },

        mounted() {
          this.getCountries();
          this.getCommerces();

          this.markerMap();

          this.getBranchSize();
          this.getBranchExt();
        },

        methods: {
          getImage(e) {
            let image = e.target.files[0];
            let reader = new FileReader();

            reader.readAsDataURL(image);
            reader.onload = e => {
              this.form.image = e.target.result;
            }
          },

          html5Location() {
            let html5Map = document.getElementById('html5Map');
            document.getElementById('textMap').style.display = "none";
            document.getElementById('mapPicker').style.display = "none";

            let vm = this;

            if (navigator.geolocation) {
              html5Map.style.display = "block";

              navigator.geolocation.getCurrentPosition(function(position) {
                console.log(position.coords);
                vm.form.latitude = position.coords.latitude;
                vm.form.longitude = position.coords.longitude;

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
                this.form.latitude = marker.getPosition().lat();
                this.form.longitude = marker.getPosition().lng();
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

                    vm.form.latitude = latitude;
                    vm.form.longitude = longitude;

                  let map = new google.maps.Map(document.getElementById('textLocation'), {
                        center: {
                            lat: latitude,
                            lng: longitude
                        },
                        zoom: 17
                    });
                } else {
                    document.getElementById('textLocation').style.display = "none";

                    vm.form.latitude = '';
                    vm.form.longitude = '';
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

          getCountries() {
            axios.get('api/countries').then(data => {
              this.countries = data.data;
              this.form.country_idcountry = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getStates() {
            axios.get('api/states/' + this.form.country_idcountry).then(data => {
              this.states = data.data;
              this.form.state_idstate = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getCities() {
            axios.get('api/cities/' + this.form.state_idstate).then(data => {
              this.cities = data.data;
              this.form.city_idcity = data.data[0].id;
            })
            .catch(err => console.log(err))
          },

          getCommerces() {
            axios.get('api/commerce').then(data => {
              this.commerces = data.data.data;
              this.form.commerce_idcommerce = data.data.data[0].idcommerce;
            })
            .catch(err => console.log(err))
          },

          store() {
            this.error = {};
            this.imageError = '';

            if(this.validateExtensionImage()) {
              this.imageError = 'La imagen no cumple con el formato adecuado.'; //enviamos el error,
              return false;
            }


            if(this.validateSizeImage()) {
              this.imageError = 'La imagen no cumple con las dimensiones esperadas. Debe estar entre: ' + this.branchMinSize + ' a ' + this.branchMaxSize + 'KB'; //enviamos el error,
              return false;
            }

            axios.post('api' + this.url, this.form)
            .then(data => {
              console.log(data);
              this.$refs.createModal.hide();
              this.form = {};
              this.getCountries();
              this.getCommerces();
              this.form.image = null;
              this.$refs.image.value = null
              this.$parent.index()
              swal({
                title: "Sucursal creado",
                text: "Sucursal creado con exito",
                icon: "success",
              })
            })
            .catch(err => {
              if(err.response.status === 422) {
                  this.error = err.response.data.errors;
              }
            });
          },

          validateExtensionImage() {
            if($("#image").val() != "") {
              let ext = $("#image").val().split('.').pop();
            
              let found = this.validExtensions.indexOf(ext.toLowerCase());

              if(found == -1) {
                return true;
              } else {
                return false;
              }
            }

          },

          validateSizeImage() {
            if($("#image").val() != "") {
              let fileSize = $('#image')[0].files[0].size; //Tamaño de la imagen subida.
              var sizeKB = parseInt(fileSize / 1024); //Tamaño de la imagen, en kb.
              if(sizeKB > this.branchMaxSize || sizeKB < this.branchMinSize) { //si el tamaño de la imagen, es mayorr al max del establecido en la base de datos o menor al min
                return true;
              } else {
                return false;
              }
            }
          },

          getBranchSize() {
            axios.get('api/branch-size').then(data => {
              let value = data.data[0].val;
              let val = JSON.parse(value);

              this.branchMaxSize = val.maxsize;
              this.branchMinSize = val.minsize;

              console.log('El minimo permitido es: ' + this.branchMinSize + 'KB Y el maximo es: ' + this.branchMaxSize + 'KB');

            })
            .catch(err => console.log(err))
          },

          getBranchExt() {
            axios.get('api/branch-ext').then(data => {
              let value = data.data[0].val;
              this.validExtensions = value;

            })
            .catch(err => console.log(err))

          }


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

.avatar {
  width: 150px;
}
</style>
