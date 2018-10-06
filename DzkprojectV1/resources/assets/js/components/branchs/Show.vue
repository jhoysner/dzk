<template>
    <div>
        <b-modal v-model="show" id="showModal" ref="createtModal" title="Detalle Sucursal" hide-footer>
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

              <div class="form-group">
                  <label class="font-weight-bold">Latitud y Logintud</label>
                  <p>{{ branch.latitude }} - {{ branch.longitude }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Comercio</label>
                  <p>{{ branch.commerces.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">País</label>
                  <p>{{ branch.countries.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Estado</label>
                  <p>{{ branch.states.name }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Ciudad</label>
                  <p>{{ branch.cities.name }}</p>
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
      branch: [],
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
        this.branch = data.data.data[0];
        console.log(data.data.data[0]);
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
