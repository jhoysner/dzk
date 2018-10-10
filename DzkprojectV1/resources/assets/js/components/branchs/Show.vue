<template>
    <div>
        <b-modal id="showModal" ref="createtModal" :title="branch.name" hide-footer>
          <div class="modal-content">
              <div class="modal-body">
                <div class="form-group">
                  <label class="font-weight-bold">ID Sucursal</label>
                  <p>{{ branch.idbranch }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Dirección</label>
                  <p>{{ branch.address }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Horario de atención</label>
                  <p>{{ branch.schedule }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Télefono principal</label>
                  <p>{{ branch.phone1 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Telefono Secundario</label>
                  <p>{{ branch.phone2 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Imagen</label>
                  <p>
                    <img class="image-branch" :src="'images/branch/'+branch.image" />
                  </p>
              </div>

              <div class="form-group" v-if="branch.latitude != null">
                  <label class="font-weight-bold">Latitud y Logintud</label>
                  <p>{{ branch.latitude }} / {{ branch.longitude }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">País</label>
                  <p>{{ branch.country_idcountry }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Estado</label>
                  <p>{{ branch.state_idstate }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Ciudad</label>
                  <p>{{ branch.city_idcity }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Comercio</label>
                  <p>{{ branch.commerce_idcommerce }}</p>
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
      branch: {
        idbranch: '',
        name: '',
        address: '',
        schedule: '',
        phone1: '',
        phone2: '',
        image: '',
        latitude: '',
        longitude: '',
        commerce_idcommerce: '',
        country_idcountry: '',
        state_idstate: '',
        city_idcity: ''
      },
      url: '/branch',

    }
  },

  mounted() {
    Bus.$on('id_branch', (id) => {
      this.show(id);
    });
  },

  methods: {
    show(id) {
      axios.get('api' + this.url + '/' + id).then(data => {
        this.branch.idbranch = data.data.data[0].idbranch;
        this.branch.name = data.data.data[0].name;
        this.branch.address = data.data.data[0].address;
        this.branch.schedule = data.data.data[0].schedule;
        this.branch.phone1 = data.data.data[0].phone1;
        this.branch.phone2 = data.data.data[0].phone2;
        this.branch.image = data.data.data[0].image;
        this.branch.latitude = data.data.data[0].latitude;
        this.branch.longitude = data.data.data[0].longitude;
        this.branch.country_idcountry = data.data.data[0].countries.name;
        this.branch.state_idstate = data.data.data[0].states.name;
        this.branch.city_idcity = data.data.data[0].cities.name;
        this.branch.commerce_idcommerce = data.data.data[0].commerces.name;
      })
    .catch(err => console.log(err))
    }
  }
}
</script>
<style lang="scss" scoped>
.image-branch {
  width: 80px;
  height: 50px;
  border-radius: 50%;
}
</style>
