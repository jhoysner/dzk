<template>
  <div>
    <div class="col-lg-12">
        <div>
            <button class="btn btn-success mb-4">Crear Sucursal</button>
            <div class="settings-content">
                <h4>Lista de sucursales</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">ID Sucursal</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Horario de atención</th>
                                    <th class="text-center">Teléfono principal</th>
                                    <th class="text-center">Teléfono alternativo</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Latitud y Longitud</th>
                                    <th class="text-center">Comercio</th>
                                    <th class="text-center">País</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Ciudad</th>
                                    <th class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr >

                                </tr>
                            </tbody>
                        </table>
                    </div>
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
