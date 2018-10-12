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
                                  <router-link :to="`commerce/${commerce.idcommerce}`">
                                    <a href="#" class="btn btn-warning btn-sm">
                                    Detalle
                                    </a>     
                                  </router-link>
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
    <ul class="pagination d-flex justify-content-center pt-20 pb-20">
        <li class="page-item"><a class="page-link" href="#" v-if="pagination.current_page > 1"@click.prevent="changePage(pagination.current_page - 1)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>
        <li class="page-item" v-for="page in pagesNumber" :class="[page == isActived ? 'active' : '']">
          <a class="page-link" href="#" @click.prevent="changePage(page)">
            {{ page }}
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" v-if="pagination.current_page < pagination.last_page" @click.prevent="changePage(pagination.current_page + 1)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
    </ul>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';

  export default {
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

    created() {
      this.index();
    },

    computed: {
        isActived() {
            return this.pagination.current_page; //Función para la pagina actual.
        },

        pagesNumber() {
            if(!this.pagination.to) { //Si no hay pagina adonde ir (Más de una) retorna array vacío.
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if(from < 1) { //Si "from" es menor a 1, no se puede. No existe una página menor a 1.
                from = 1; //Así que siempre será 1.
            }

            var to = from + (this.offset * 2); 

            if(to >= this.pagination.last_page) { //Si "to" es mayor, al maximo de páginas que existe en laravel.
                to = this.pagination.last_page; //Le decimos que el maximo es el q dice laravel.
            }

            let pageArray = []; //Definimos las paginas en un array.

            while (from <= to) { //Recorremos "from" hasta que llegue a la ultima en "to"
                pageArray.push(from); //Mientras recorre, la añadimos al pagesArray.
                from++; //Y aumentamos el numero de páginas que va avanzando en from.
            }

            return pageArray; //Por último, retornamos la data del n° de páginas guardada en pagesArray.
        },

        filter() {
          const search = this.search.toLowerCase();
          return this.commerces.filter((item) => item.name.toLowerCase().includes(search));
        }
    },

    methods: {
      index(page) {
        axios.get('api/all-commerces?page=' + page).then(response => {
          console.log(response);
          this.commerces = response.data.commerce.data;
          this.pagination = response.data.paginate;
        })
        .catch(err => console.log(err))
      },

      changePage(page) {
          this.pagination.current_page = page;
          this.index(page);
      },

      toggleSearch() {
        $('#search').toggle();
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