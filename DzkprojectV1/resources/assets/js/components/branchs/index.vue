<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal v-can="'add_branchs'">Crear Sucursal</b-btn>
            <div class="settings-content">
                <h4>Lista de sucursales</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                    <div class="table-responsive">
                        <table class="table table-striped mt-40 stat-table">
                            <thead>
                                <tr>
                                    <!--<th class="text-center">ID Sucursal</th> -->
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
                                <!--<td>{{ branch.idbranch }}</td> -->
                                <td class="text-center">{{ branch.name }}</td>
                                <!--<td>{{ branch.address }}</td>
                                <td>{{ branch.schedule }}</td>
                                <td>{{ branch.phone1 }}</td>
                                <td>{{ branch.phone2 }}</td> -->
                                <td class="text-center">
                                  <img class="image-branch" v-if="branch.image != null" :src="'images/branch/'+branch.image" />
                                  <p v-if="branch.image == null">No posee imagen.</p>
                                </td>
                                <td v-if="branch.latitude != null" class="text-center">{{ branch.latitude }} - {{ branch.longitude }}</td>
                                <td v-else class="text-center">No posee</td>
                                <!--<td>{{ branch.commerces.name }}</td>
                                <td>{{ branch.countries.name }}</td>
                                <td>{{ branch.states.name }}</td>
                                <td>{{ branch.cities.name }}</td> -->
                                <td class="text-right">
                                    <b-btn v-b-modal="'showModal'" size="sm" @click="show(branch.idbranch)" variant="default">Detalle</b-btn>
                                    <b-btn v-b-modal="'editModal'" v-can="'edit_branchs'" size="sm" @click="edit(branch.idbranch)" variant="warning">Editar</b-btn>
                                    <button type="button" v-can="'delete_branchs'" @click="confirm(branch.idbranch)" class="btn btn-sm  btn-danger">Eliminar</button>
                                </td>
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
