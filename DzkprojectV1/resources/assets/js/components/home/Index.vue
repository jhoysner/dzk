<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
                <h4>Comercios</h4>
              <!-- <spinner :show="loadingProductos"></spinner> -->
              <div class="row justify-content-center stat-table-wrap">
                <div class="col-lg-12 stat-wrap-container">
                    <div class="stat-wrap">
                        <a class="primary-btn white-btn" @click="toggleSearch"><i class="icons icon-magnifier"></i></a>
                        <hr>
                        <input type="text" class="form-control" id="search" placeholder="Buscar" v-model="search">
                        <table class="table table-striped mt-40 stat-table">
                            <thead>
                              <tr>
                                <th>ID Comercio</th>
                                <th>Nombre</th>
                                <th>Correo</th> 
                                <th>Imagen</th>
                                <th>Categoría</th>
                                <th>Options</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="commerce in filter" :key="commerce.idcommerce">
                                <td>{{ commerce.idcommerce }}</td>
                                <td>{{ commerce.name }}</td>
                                <td>{{ commerce.email }}</td>
                                <th>
                                  <img class="image-commerce" v-if="commerce.image != null" :src="'images/commerce/'+commerce.image" />
                                    <p v-if="commerce.image == null">No posee imagen.</p>
                                </th>
                                <td>{{ commerce.ccategories.name }}</td>
                                <td>
                                  <!--<router-link :to="`commerce/${commerce.idcommerce}`">
                                    <a href="#" class="btn btn-warning btn-sm">
                                    Detalle
                                    </a>     
                                  </router-link> -->
                                  <b-btn variant="primary" v-b-modal.showModal  @click="detail(commerce.idcommerce)">
                                    Ver Detalles
                                  </b-btn>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <paginator :pagination="pagination"></paginator>
    <show></show>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';
import show from './detail';
import paginator from '../../utilities/paginator';

  export default {
    components: { show, paginator},
    data() {
      return {
        commerces: [],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
          offset: 2,
          search: '',
      }
    },

    mounted() {
      this.index();

      Bus.$on('change_page', (page) => {
        this.index(page);
      });
    },

    computed: {
        filter() {
          const search = this.search.toLowerCase();
          return this.commerces.filter((item) => item.name.toLowerCase().includes(search));
        }
    },

    methods: {
      index(page) {
        axios.get('api/all-commerces?page=' + page).then(response => {
          //console.log(response);
          this.commerces = response.data.commerce.data;
          this.pagination = response.data.paginate;
        })
        .catch(err => console.log(err))
      },

      toggleSearch() {
        $('#search').toggle();
      },

      detail(id) {
        Bus.$emit('detail_homeinit', id);
      },
    },
  }
</script>

<style>
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }

  #search {
    display: none;
  }
</style>