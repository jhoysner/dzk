<template>
  <div>
    <div class="col-lg-12">
        <div>
            <button class="btn btn-success mb-4">Crear Comercio</button>
            <div class="settings-content">
                <h4>Lista de comercios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">ID Comercio</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Teléfono principal</th>
                                    <th class="text-center">Teléfono alternativo</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Web</th>
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
      title: 'Comercios',
      subtitle: 'Crea un comercio'
    };
    Bus.$emit('jumbo-msg', data);
  }
}
</script>
<style lang="scss" scoped>
</style>
