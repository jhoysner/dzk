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
              <div class="settings-content">
                  <h4>Dashboard Principal</h4>
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur.
                  </p>
              </div>
          </div>
      </div>

    </div>
  </div>
</template>
<script>
import Bus from '../utilities/EventBus';
export default {
  name: "",
  data() {
    return {

    }
  },

  created() {
    let data = {
      title: 'dashboard',
      subtitle: 'Dashboard'
    };
    Bus.$emit('jumbo-msg', data);
  }
}
</script>
<style lang="scss" scoped>
</style>
