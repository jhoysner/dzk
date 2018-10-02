<template>
  <div>
    <div class="row" id="tabs">
      <div class="col-lg-3">
          <div class="options-sidebar">
              <h4 class="text-uppercase pb-20">Personal Details</h4>
              <ul>
                  <li><a href="#tabs-1">Presonal Information</a></li>
                  <li><a href="#tabs-2">Profile</a></li>
                  <li><a href="#tabs-3">Email Settings</a></li>
                  <li><a href="#tabs-4">Saved Credit Card</a></li>
                  <li><a href="#tabs-5">Social Networks</a></li>
              </ul>
          </div>
      </div>
      <div class="col-lg-9">
          <div id="tabs-1">
              <!--<div class="settings-content">
                  <h4>Sucursales</h4>
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur.
                  </p>
              </div> -->
              <div class="settings-content">
                  <h4>Crear una nueva Sucursal</h4>
                  <form action="#" class="billing-form">
                      <div class="row pt-30">
                          <div class="col-lg-6">
                              <input type="text" placeholder="Nombre" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Dirección" required class="common-input">
                          </div>
                          <div class="col-lg-12">
                              <input type="text" placeholder="Horario de atención" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Telefono principal" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Telefono alternativo" required class="common-input">
                          </div>
                          <div class="col-lg-12">
                              <input type="file" placeholder="Imagen corporativa" required class="common-input">
                          </div>
                          <div class="col-lg-4">
                              <button class="primary-btn" @click="html5Location">Geolocalización HTML5</button>
                          </div>
                          <div class="col-lg-4">
                              <button href="#" class="primary-btn">Abrir Maps</button>
                          </div>
                          <div class="col-lg-4">
                              <button href="#" class="primary-btn">Escribir dirección</button>
                          </div>
                          <div class="col-lg-12 html5Map" id="html5Map">
                          </div>

                          <div class="col-lg-12 input-map">
                              <input type="text" placeholder="Ubicación" required class="common-input">
                          </div>
                          <div class="col-lg-12">
                              <div class="sorting"> Comercio al que pertenece
                                  <select>
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
                  </form>
              </div>
          </div>
      </div>
  </div>
  </div>
</template>
<script>
import Bus from '../../utilities/EventBus';

export default {
  name: "",
  data() {
    return {

    }
  },

  created() {
    let data = {
      title: 'Sucursales',
      subtitle: 'Crea una sucursal'
    };
    Bus.$emit('jumbo-msg', data);
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
<style lang="scss" scoped>
  .html5Map {
    width: 100%;
    height: 200px;
    display: none;
  }

  .input-map {
    display: none;
  }
</style>
