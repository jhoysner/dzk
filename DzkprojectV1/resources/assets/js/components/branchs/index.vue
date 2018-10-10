<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal>Crear Sucursal</b-btn>
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
                                    <!--<th class="text-center">Dirección</th>
                                    <th class="text-center">Horario de atención</th>
                                    <th class="text-center">Teléfono principal</th>
                                    <th class="text-center">Teléfono alternativo</th>-->
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Latitud y Longitud</th>
                                    <!--<th class="text-center">Comercio</th>
                                    <th class="text-center">País</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Ciudad</th> -->
                                    <th class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr v-for="branch in branchs">
                                <th>{{ branch.idbranch }}</th>
                                <th>{{ branch.name }}</th>
                                <!--<th>{{ branch.address }}</th>
                                <th>{{ branch.schedule }}</th>
                                <th>{{ branch.phone1 }}</th>
                                <th>{{ branch.phone2 }}</th> -->
                                <th>
                                  <img class="image-branch" v-if="branch.image != null" :src="'images/branch/'+branch.image" />
                                  <p v-if="branch.image == null">No posee imagen.</p>
                                </th>
                                <th v-if="branch.latitude != null">{{ branch.latitude }} - {{ branch.longitude }}</th>
                                <th v-else>No posee</th>
                                <!--<th>{{ branch.commerces.name }}</th>
                                <th>{{ branch.countries.name }}</th>
                                <th>{{ branch.states.name }}</th>
                                <th>{{ branch.cities.name }}</th> -->
                                <th>
                                  <td class="text-right">
                                      <b-btn v-b-modal="'showModal'" @click="show(branch.idbranch)" variant="default">Detalle</b-btn>
                                      <b-btn v-b-modal="'editModal'" @click="edit(branch.idbranch)" variant="warning">Editar</b-btn>
                                      <button type="button" @click="confirm(branch.idbranch)" class="btn btn-sm  btn-danger">Eliminar</button>
                                  </td>
                                </th>
                              </tr>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
        </div>
    </div>
    <create></create>
    <show></show>
    <edit></edit>

  </div>
</template>
<script>
import Bus from '../../utilities/EventBus';
import create from './Create';
import show from './Show';
import edit from './Edit';


export default {
  components: {
    create, show, edit
  },
  data() {
    return {
      url: '/branch',
      branchs: [],
      showBranch: [],
    }
  },

  created() {
    let data = {
      title: 'Sucursales',
      subtitle: 'Crea una sucursal'
    };
    Bus.$emit('jumbo-msg', data);

    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(data => {
        this.branchs = data.data.data;
      })
      .catch(err => console.log(err))
    },

    show(id) {
      Bus.$emit('id_branch', id);
    },

    edit(id) {
      Bus.$emit('id_branch', id);
    },

    confirm(id) {
        swal({
          title: "Seguro quieres eliminar la sucursal?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.destroy(id)
          }
        });
    },

    destroy(id) {
      axios.delete('api' + this.url + '/' + id).then(data => {
        console.log(data);
        this.index();
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
