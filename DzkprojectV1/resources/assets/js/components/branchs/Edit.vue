<template>
    <div>
        <b-modal id="editModal" ref="editModal" title="Editar Sucursal" hide-footer>
          <form>
              <div class="modal-content">
                  <div class="modal-body">
                    <div class="row pt-30">
                        <div class="col-lg-12">
                            <input type="text" placeholder="Nombre" v-model="branch.name" class="common-input">
                            <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Dirección" v-model="branch.address" class="common-input">
                            <small class="text-danger" v-if="error.address">{{ error.address[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Horario de atencion" v-model="branch.schedule" class="common-input">
                            <small class="text-danger" v-if="error.schedule">{{ error.schedule[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Telefono principal" v-model="branch.phone1" class="common-input">
                            <small class="text-danger" v-if="error.phone1">{{ error.phone1[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="text" placeholder="Telefono alternativo" v-model="branch.phone2" class="common-input">
                            <small class="text-danger" v-if="error.phone2">{{ error.phone2[0] }}</small>
                        </div>
                        <div class="col-lg-12">
                          <label for="">Imagen actual</label>
                          <p>
                            <img class="image-branch" :src="'images/branch/'+picAct" />
                          </p>
                        </div>
                        <div class="col-lg-12">
                            <input type="file" id="image" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                            <img :src="branch.image" class="avatar" alt="Image">
                            <p><small class="text-danger" v-if="imageError != '' ">{{ imageError }}</small></p>

                        </div>
                        <div class="col-lg-12">
                            <div class="sorting"> Localización
                                <select class="form-control common-input" id="geocoder" @change="selectGeo()">
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

                            <div class="col-lg-12 mapHtml5" id="mapHtml5"></div>
                            <div class="col-lg-12 pickerMap" id="pickerMap"></div>
                            <input type="text" placeholder="Escriba la dirección" id="textlocation" @keyup.enter="addressMap" class="common-input">
                            <div class="col-lg-12 locationText" id="locationText"></div>
                        </div>
                        <div class="col-lg-12">
                            <div class="sorting"> Comercio al que pertenece
                                <select class="form-control common-input" v-model="branch.commerce_idcommerce">
                                  <option v-for="commerce in commerces" :value="commerce.idcommerce">
                                    {{ commerce.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.commerce_idcommerce">{{ error.commerce_idcommerce[0] }}</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sorting"> País
                              <select class="form-control common-input" v-model="branch.country_idcountry" @change="getStates()">
                                  <option v-for="country in countries" :value="country.id">
                                    {{ country.name }}
                                  </option>
                              </select>
                              <small class="text-danger" v-if="error.country_idcountry">{{ error.country_idcountry[0] }}</small>
                          </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="sorting"> Estado
                                <select class="form-control common-input" v-model="branch.state_idstate" @change="getCities()">
                                  <option v-for="state in states" :value="state.id">
                                    {{ state.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.state_idstate">{{ error.state_idstate[0] }}</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="sorting"> Ciudad
                                <select class="form-control common-input" v-model="branch.city_idcity">
                                  <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                  </option>
                                </select>
                                <small class="text-danger" v-if="error.city_idcity">{{ error.city_idcity[0] }}</small>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="button" v-can="'edit_branchs'" @click.prevent="update" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar</button>
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
      url: '/branch',
      branch: [],
      error: [],
      countries: [],
      states: [],
      cities: [],
      commerces: [],
      branchMaxSize: null,
      branchMinSize: null,
      validExtensions: [],
      imageError: '',
      picture: '',
      picsize: '',
      picAct: '',
    }
  },

  mounted() {
    Bus.$on('id_branch', (data) => {
      this.editId = data;
      this.edit(this.editId);
      this.getCountries();
    });

    this.markerMap();
    this.getCommerces();

    this.getBranchSize();
    this.getBranchExt();
  },

  methods: {
    getImage(e) {
      let image = e.target.files[0];
      let reader = new FileReader();
      this.picture = image.name;
      this.picsize = image.size;

      reader.readAsDataURL(image);
      reader.onload = e => {
        this.branch.image = e.target.result;
      }
    },

    edit(id) {
      axios.get('api' + this.url + '/' + id + '/edit').then(data => {
        this.branch = data.data.data[0];
        this.StateAct(data.data.data[0].country_idcountry);
        this.CityAct(data.data.data[0].state_idstate);
        this.picAct = data.data.data[0].image;
      })
      .catch(err => console.log(err))
    },

    getCountries() {
      axios.get('api/countries').then(data => {
        this.countries = data.data;
        //this.form.country_idcountry = data.data[0].id;
      })
      .catch(err => console.log(err))
    },

    StateAct(id) {
      axios.get('api/states/' + id).then(data => {
        this.states = data.data;
      })
      .catch(err => console.log(err))
    },

    getStates() {
      axios.get('api/states/' + this.commerce.country_idcountry).then(data => {
        this.states = data.data;
        this.branch.state_idstate = data.data[0].id;
      })
      .catch(err => console.log(err))
    },

    CityAct(id) {
      axios.get('api/cities/' + id).then(data => {
        this.cities = data.data;
      })
      .catch(err => console.log(err))
    },

    getCities() {
      axios.get('api/cities/' + this.branch.state_idstate).then(data => {
        this.cities = data.data;
        this.branch.city_idcity = data.data[0].id;
      })
      .catch(err => console.log(err))
    },

    getCommerces() {
      axios.get('api/commerce').then(data => {
        this.commerces = data.data.data;
        this.branch.commerce_idcommerce = data.data.data[0].idcommerce;
      })
      .catch(err => console.log(err))
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

          vm.branch.latitude = position.coords.latitude;
          vm.branch.longitude = position.coords.longitude;

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
      document.getElementById('mapHtml5').style.display = "none";
      document.getElementById('textlocation').style.display = "none";
      document.getElementById('pickerMap').style.display = "block";

      let map = new google.maps.Map(document.getElementById('pickerMap'), {
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
        this.branch.latitude = marker.getPosition().lat();
        this.branch.longitude = marker.getPosition().lng();
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

              vm.branch.latitude = latitude;
              vm.branch.longitude = longitude;

            let map = new google.maps.Map(document.getElementById('locationText'), {
                  center: {
                      lat: latitude,
                      lng: longitude
                  },
                  zoom: 17
              });
          } else {
              document.getElementById('locationText').style.display = "none";

              vm.branch.latitude = '';
              vm.branch.longitude = '';
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
      this.error = {};
      this.imageError = '';

      this.validateExtensionImage();

      if(this.validateExtensionImage()) {
        this.imageError = 'La imagen no cumple con el formato adecuado.'; //enviamos el error,
        return false;
      }


      if(this.validateSizeImage()) {
        this.imageError = 'La imagen no cumple con las dimensiones esperadas. Debe estar entre: ' + this.branchMinSize + ' a ' + this.branchMaxSize + 'KB'; //enviamos el error,
        return false;
      }

      axios.put('api' + this.url + '/' + this.branch.idbranch, this.branch)
      .then(data => {
        this.$refs.editModal.hide();
        this.$parent.index()
        swal({
          title: "Sucursal actualizada",
          text: "Sucursal actualizada con exito",
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
        if(this.picture != "") {
          let ext = this.picture.split('.').pop();
        
          let found = this.validExtensions.indexOf(ext.toLowerCase());

          if(found == -1) {
            return true;
          } else {
            return false;
          }
        }

    },

    validateSizeImage() {
      if(this.picsize != "") {
        let fileSize = this.picsize; //Tamaño de la imagen subida.
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
.avatar {
  width: 150px;
}
.image-branch {
  width: 80px;
  height: 50px;
  border-radius: 50%;
}
</style>
