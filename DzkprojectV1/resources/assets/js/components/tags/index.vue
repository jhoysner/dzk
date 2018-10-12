<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal>Crear Tag</b-btn>
            <div class="settings-content">
                <h4>Lista de Tags</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
                <div class="responsive">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-condensed">
                          <thead>
                            <tr>
                                <th class="text-center" width="80%">Tag</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="tag in tags">
                              <td width="80%">{{ tag.name }}</td>
                              <td class="text-right">
                                  <b-btn v-b-modal="'editModal'" @click="edit(tag.idtags)" class="btn btn-sm" variant="warning">Editar</b-btn>
                                  <button type="button" @click="eliminar(tag.idtags)" class="btn btn-sm btn-xs btn-danger">Eliminar</button>
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
    <edit></edit>
  </div>
</template>
<script>

import Bus from '../../utilities/EventBus';
import create from './Create';
import edit from './Edit';

import axios from 'axios';

export default {
  name: 'index',
  components: {
    create, edit
  },
  data() {
    return {
      url: '/tags',
      tags: [],
    }
  },

  created() {
    this.index();
  },

  methods: {
    index() {
      axios.get('api' + this.url).then(response => {
        console.log(response.data.tags)
        
        this.tags= response.data.tags
      })
      .catch(err => console.log(err))
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },

    eliminar(id) {
        swal({
          title: "Seguro quieres eliminar el tag?",
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
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }
</style>
