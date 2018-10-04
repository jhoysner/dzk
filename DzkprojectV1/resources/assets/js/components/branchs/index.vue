<template>
  <div>
    <div class="col-lg-12">
        <div>
            <a class="btn btn-success mb-4" data-toggle="modal" href='#add-branch'>Crear Sucursal</a>
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
    <Create/>
  </div>
</template>
<script>
import Bus from '../../utilities/EventBus';
// import Create from './Create';

export default {
  name: "",
  components: {
    // Create
  },
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

  }
}
</script>
<style lang="scss" scoped>

</style>
