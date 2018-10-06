<template>
    <div>
      <b-modal v-model="show" id="showModal" ref="showModal" title="Detalle Comercio" hide-footer>
        <div class="modal-content">
            <div class="modal-body">
              
              <div class="form-group">
                  <label class="font-weight-bold">ID comercio</label>
                  <p>{{ commerce.idcommerce }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Télefono principal</label>
                  <p>{{ commerce.phone1 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Telefono Secundario</label>
                  <p>{{ commerce.phone2 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Email</label>
                  <p>{{ commerce.email }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Imagen</label>
                  <p>
                    <img class="image-commerce" :src="'images/commerce/'+commerce.image" />
                  </p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Web</label>
                  <p>{{ commerce.web }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">País</label>
                  <p>{{ commerce.countries.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Estado</label>
                  <p>{{ commerce.states.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Ciudad</label>
                  <p>{{ commerce.cities.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Categoría</label>
                  <p>{{ commerce.ccategories.name }}</p>
              </div>
            </div>     
        </div>
      </b-modal> 
    </div>
</template>
<script>
import Bus from '../../utilities/EventBus';

export default {
  data() {
    return {
      commerce: [],
      url: '/commerce',
    }
  },

  mounted() {
    Bus.$on('id_commerce', (id) => {
      this.show(id);
    });
  },


  methods: {
    show(id) {
      axios.get('api' + this.url + '/' + id).then(data => {
        this.commerce = data.data[0];
      })
      .catch(err => console.log(err))
    }
  }
}
</script>
<style lang="scss" scoped>
.image-commerce {
  width: 80px;
  height: 50px;
  border-radius: 50%;
}
</style>