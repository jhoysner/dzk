<template>
    <div>
        <div class="modal fade" id="add-branch">
          <div class="modal-dialog">
            <form @submit.prevent="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Crea una sucursal</h4>
                    </div>
                    <div class="modal-body">

                      <div class="col-lg-12">
                          <input type="text" placeholder="Nombre" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Dirección" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Horario de atención" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono principal" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <input type="text" placeholder="Telefono alternativo" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <input type="file" placeholder="Imagen corporativa" required class="common-input">
                      </div>
                      <div class="col-lg-12">
                          <div class="sorting"> Localización
                              <select required class="form-control common-input">
                                  <option value="0">Seleccione una opción</option>
                                  <option value="1">Geolocalización HTML5</option>
                                  <option value="2">Abrir Maps</option>
                                  <option value="2">Escribir dirección</option>
                              </select>
                          </div>
                      </div>
                      <!--<div class="col-lg-4">
                          <a class="primary-btn geolocation" @click="html5Location">Geolocalización HTML5</a>
                      </div>
                      <div class="col-lg-4">
                          <a class="primary-btn geolocation">Abrir Maps</a>
                      </div>
                      <div class="col-lg-4">
                          <a class="primary-btn geolocation">Escribir dirección</a>
                      </div>
                      <div class="col-lg-12 html5Map" id="html5Map">
                      </div>

                      <div class="col-lg-12 input-map">
                          <input type="text" placeholder="Ubicación" required class="common-input">
                      </div> -->
                      <div class="col-lg-12">
                          <div class="sorting"> Comercio al que pertenece
                              <select required class="form-control common-input">
                                  <option value="1">District*</option>
                                  <option value="1">Default sorting</option>
                                  <option value="1">Default sorting</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> País
                              <select required class="form-control common-input">
                                  <option value="1">District*</option>
                                  <option value="1">Default sorting</option>
                                  <option value="1">Default sorting</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> Estado
                              <select required class="form-control common-input">
                                  <option value="1">District*</option>
                                  <option value="1">Default sorting</option>
                                  <option value="1">Default sorting</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-lg-12">
                          <div class="sorting"> Ciudad
                              <select required class="form-control common-input">
                                  <option value="1">District*</option>
                                  <option value="1">Default sorting</option>
                                  <option value="1">Default sorting</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-12 text-right">
                          <a href="#" class="primary-btn">Guardar</a>
                      </div>
                  </div>

                </div>
            </form>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "create",
        data() {
            return {

            }
        },
        methods: {
          html5Location() {
            let html5Map = document.getElementById('html5Map');

            if (navigator.geolocation) {
              //html5Map.style.display = "block";
              $('#html5Map').css('display', 'block');

              navigator.geolocation.getCurrentPosition(function(position) {
                console.log(position.coords);
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
</style>
