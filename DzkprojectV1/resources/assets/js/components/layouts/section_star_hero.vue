<template>
  <div>
    <!-- Start hero-section2 -->
    <!-- <section class="hero-section2 relative"> -->
    <section class="">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-lg-7 text-center">
                    <p class="text-white mb-0">{{ subtitle }}</p>
                    <h1 class="text-white text-uppercase pt-30 pb-30">
                      {{ title }}
                    </h1>
                    <div class="input-group col-lg-8 mx-auto">
                        <input class="form-control py-2" placeholder="Search themes & templates" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search themes & templates'" type="search">
                        <div class="input-group-append">
                            <button class="btn" type="button">
                                <i class="icons icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End hero-section2 -->
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

  props: ['title', 'subtitle']

}
</script>
<style lang="scss" scoped>
</style>
