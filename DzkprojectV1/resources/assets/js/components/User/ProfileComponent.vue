<template>

    <div id="section-profile" class="settings-content">
        <h1>Profile</h1>
        <div class="lg-12">
            <div v-if="errors.length">
                <ul>
                    <li role="alert" v-for="error in errors">
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          {{error}}
                        </div>
                    </li>
                </ul>
            </div>
            <div v-if="success.length">
                <ul>
                    <li role="alert" v-for="tmp in success">
                        <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          {{tmp}}
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        <form action="" class="billing-form" v-on:submit.prevent="submitUpdate()" novalidate>
            <div class="row pt-30">
                <div class="col-lg-6">
                    <input type="text" placeholder="First name*" onfocus="this.placeholder=''" onblur="this.placeholder = 'First name*'" class="common-input" v-model="user.firstname">
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Middle name" onfocus="this.placeholder=''" onblur="this.placeholder = 'Middle name'" class="common-input" v-model="user.middlename">
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Last name*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Last name*'" class="common-input" v-model="user.lastname">
                </div>
                <div class="col-lg-6">
                    <input type="email" placeholder="Email Address*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Email Address*'" class="common-input" v-model="user.email">
                </div>
                <div class="col-lg-6">
                    <input type="password" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password*'" class="common-input" v-model="password">
                </div>
                <div class="col-lg-6">
                    <input type="password" placeholder="Password confirmation*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password confirmation*'" class="common-input" v-model="password_confirmation">
                </div>
                <div class="col-lg-6">
                    <input type="text" placeholder="Phone" onfocus="this.placeholder=''" onblur="this.placeholder = 'Phone'" class="common-input" v-model="user.phone">
                </div>
                <div class="col-lg-6">
                    <input type="date" class="common-input date" v-model="user.birthday">
                </div>
                <div class="col-lg-12">
                    <input type="text" placeholder="Address" onfocus="this.placeholder=''" onblur="this.placeholder = 'Address'" class="common-input" v-model="user.address">
                </div>
                <div class="col-lg-6">
                    <div class="sorting">
                        <select v-model="user.country_idcountry" @change="country(user.country_idcountry)" class="form-control common-input">
                            <option v-for="option in countries" :value="option.id">{{option.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6" >
                    <div class="sorting">
                        <select v-model="user.state_idstate" @change="state(user.state_idstate)" required class="form-control common-input">
                            <option v-for="option in states" :value="option.id">{{option.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-lg-6">
                    <div class="sorting">
                        <select v-model="user.city_idcity" required class="form-control common-input">
                            <option v-for="option in cities" :value="option.id">{{option.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex ">                        
                        
                        <div class="col-md-6">
                            <div class="upload-fleid">
                                <p>Upload an avatar</p>
                                <div class="input-group input-file">
                                    <input class="form-control" type="file" accept="image/*" @change="previewImage">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 text-center avatar-wrap">
                            <div class="avatar-thumb mr-20">
                                <img :src="imageData" alt="" >
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12">
                
                    <div class="sorting"> Localización
                      <select class="form-control common-input" id="geocoders" @change="selectGeo()">
                          <option value="" selected>Seleccione</option>
                          <option value="1">Geolocalización HTML5</option>
                          <option value="2">Abrir Maps</option>
                          <option value="3">Escribir dirección</option>
                      </select>
                    </div>

                      <div class="col-lg-12 html5Map" id="html5Map"></div>
                      <div class="col-lg-12 mapPicker" id="mapPicker"></div>

                      <input type="text" placeholder="Escriba la dirección" id="textMap" @change="addressMap" required class="common-input">
                      <div class="col-lg-12 textLocation" id="textLocation"></div>

                </div>
            

                <div class="clearfix"></div>
                <br>
                <div class="col-lg-12 text-right" id="buttons-form">
                    <a class="primary-btn white-btn" v-on:click="desactivate()">Account Desactivate</a>
                    <button class="primary-btn">Update</button>
                </div>
            </div>
        </form>
    </div>


</template>

<script>
    export default {
        props : ['auth'],
        mounted() {
            this.user = JSON.parse(this.auth);
            document.getElementById('textLocation').style.display = "block";
            document.getElementById('textLocation').style.display = "none";

            axios.get('/getcountries')
                .then(
                    (response) => {
                        this.countries = response.data;
                    }   
                )

            this.country(this.user.country_idcountry)
            this.state(this.user.state_idstate)
            this.imageData = this.user.image
            this.html5Location()

        },
        data() {
            return {
                'firstname':"",
                'middlename':"",
                'lastname':"",
                'email': "",
                'password': "",
                'password_confirmation': "",
                'phone': "",
                'birthday': "",
                'address' : "", 
                'country_id': 0,
                'state_id': 0,
                'city_id' : 0,
                'imageData' : "", 
                'latitude' : "",
                'longitude' : "",
                'countries': [],
                'states': [],
                'cities': [],
                'user' : { },
                'errors':[],
                'success' : [],
                'localizacion' : "",
                'reg': /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },
        methods: {
            submitUpdate() {
                this.errors = [];
                if(!this.user.firstname) this.errors.push('Firstname required.');
                if(!this.user.lastname) this.errors.push('Lastname required.');
                if(!this.user.email) this.errors.push('Email required.');

                if (this.password !== this.password_confirmation) {
                    this.password = ""
                    this.password_confirmation = ""
                    this.errors.push('Passwords do not match')
                }

                if(!this.user.country_idcountry) this.errors.push('Country required.');
                if(!this.user.state_idstate) this.errors.push('State required.');
                if(!this.user.city_idcity) this.errors.push('City required.');
                let params = new FormData();
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
                console.log(file)
                if(file !== undefined || file !== NULL || file.type.match(/image.*/)) params.append('imagen', file);

                axios.post('/profile', params)
                   .then(response => {
                        console.log(response)
                        this.success = [];
                        this.success.push(response.data.success)
                   })
                   .catch(errors => {
                        console.log(errors.response)
                        //this.errors.push(errors.response)

                   });     
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
            desactivate() {
                let id = this.user.id

                swal({
                  title: "Are you sure?",
                  text: "Once delete, you will not be able to activate account!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                        if (result) {
                            axios.get('/desactivateaccount/'+id) 
                                 .then((response) => {
                                swal(response.data.success, {
                                icon: "success",
                                });
                                window.location.href = '/login';
                             })
                        }
                });

            },
            obtCoordGeo(){
                navigator.geolocation.getCurrentPosition(function(objPosition)
                {
                    let lon = objPosition.coords.longitude;
                    let lat = objPosition.coords.latitude;
                    console.log(lon + ' ,' + lat) 

                }, function(objPositionError)
                {
                    switch (objPositionError.code)
                    {
                        case objPositionError.PERMISSION_DENIED:
                            this.errors.push("No se ha permitido el acceso a la posición del usuario.");
                        break;
                        case objPositionError.POSITION_UNAVAILABLE:
                            this.errors.push("No se ha podido acceder a la información de su posición.");
                        break;
                        case objPositionError.TIMEOUT:
                            this.errors.push("El servicio ha tardado demasiado tiempo en responder.");
                        break;
                        default:
                            this.errors.push("Error desconocido.");
                    }
                }, {
                    maximumAge: 75000,
                    timeout: 15000
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
            html5Location() {
                let html5Map = document.getElementById('html5Map');
                document.getElementById('textMap').style.display = "none";
                document.getElementById('mapPicker').style.display = "none";

                let vm = this;

                if (navigator.geolocation) {
                  html5Map.style.display = "block";

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

                        vm.form.latitude = '';
                        vm.form.longitude = '';
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
                const params = {
                    id: id 
                }

                axios.get('/getcities/'+id)
                    .then(
                        (response) => {
                            this.cities = response.data;
                        }   
                    )
            },
            validEmail:function(email) {
                return (this.reg.test(email))
            }
        }
    }
</script>
<style>
#section-profile: {
 margin-top: 100px;
}
#buttons-form{
    margin-top: 15px;
}
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

.input-map {
  display: none;
}

img {
  width: 150px;
}
</style>
