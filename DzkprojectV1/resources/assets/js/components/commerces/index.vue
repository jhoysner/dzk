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
                  <h4>Comercios</h4>
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur.
                  </p>
              </div> -->
              <div class="settings-content">
                  <h4>Crear un nuevo Comercio</h4>
                  <form action="#" class="billing-form">
                      <div class="row pt-30">
                          <div class="col-lg-6">
                              <input type="text" placeholder="Nombre" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Telefono principal" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Telefono alternativo" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="email" placeholder="Email" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="file" placeholder="Imagen corporativa" required class="common-input">
                          </div>
                          <div class="col-lg-6">
                              <input type="text" placeholder="Web" required class="common-input">
                          </div>
                          <div class="col-lg-12">
                              <div class="sorting"> Estado
                                  <select>
                                      <option value="1">District*</option>
                                      <option value="1">Default sorting</option>
                                      <option value="1">Default sorting</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="sorting"> Provincia
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
      title: 'Comercios',
      subtitle: 'Crea un comercio'
    };
    Bus.$emit('jumbo-msg', data);
  }
}
</script>
<style lang="scss" scoped>
</style>
