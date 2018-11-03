<template>
  <div>
    <div class="col-lg-12">
        <div>
            <b-btn v-b-modal.createModal v-can="'add_tags'">Crear Tag</b-btn>
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
                                  <b-btn v-b-modal="'editModal'" v-can="'edit_tags'" @click="edit(tag.idtags)" class="btn btn-sm" variant="warning">Editar</b-btn>
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
        this.tags= response.data.tags
      })
      .catch(err => console.log(err))
    },

    edit(id) {
      Bus.$emit('edit_id', id);
    },
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
