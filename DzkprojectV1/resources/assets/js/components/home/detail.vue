<template>
  <div>
        <b-modal id="showModal" ref="showModal" :title="commerce.name" hide-footer>
          <div class="modal-content">
              <div class="modal-body">
                <div class="row pt-30">
                  <!--<div class="col-lg-12">
                        <label><strong>ID Comercio</strong></label>
                        <p>{{commerce.idcommerce}}</p>
                    </div> -->
                    <div class="col-lg-6">
                        <label><strong>Telefono principal</strong></label>
                        <p>{{commerce.phone1}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Categoría</strong></label>
                        <p>{{commerce.commercecategory_idcommercecategory}}</p>
                    </div>
                    <div class="col-lg-9">
                        <label><strong>Correo Electrónico</strong></label>
                        <p>{{commerce.email}}</p>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label class="font-weight-bold">Imagen</label>
                          <p>
                            <img class="image-commerce" :src="'images/commerce/'+commerce.image" />
                          </p>
                      </div>
                    </div>
                   <div class="col-lg-12">
                        <label>
                          <strong>
                            Sucursales
                          </strong>
                        </label>
                        <p>
                          <ul>
                            <li class="pl-2" v-for="branch in branchs" :key="branch.idbranch">
                              {{ branch.name }} - {{ branch.phone1 }} - {{ branch.address }}
                            </li>
                          </ul>
                          <span class="pl-2" v-if="branchs.length > 1"> <!-- Cambiar en su momento por un minimo de 5 -->
                            <a href="#">
                              <router-link :to="`/commerce/${commerce.idcommerce}/branchs`">
                                Leer más
                              </router-link>
                            </a>
                          </span>
                        </p>
                        <hr>
                    </div>
                    <div class="col-lg-12">
                        <label>
                          <strong>
                           Descuentos
                          </strong>
                        </label>
                        <p>
                          <ul>
                            <!--<template v-for="branch in branchs"> -->
                             <!-- <li class="pl-2" v-for="discount in branch.discounts">
                                {{ discount.title }} - ${{ discount.amountapproved }}
                              </li> -->
                              <li class="pl-2" v-for="discount in discounts">
                                {{ discount.title }} - ${{ discount.amountapproved }}
                              </li>
                              <span class="pl-2" v-if="discounts.length > 1" > <!-- Cambiar en su momento por un minimo de 5 -->
                                <a href="#">
                                  <router-link :to="`/commerce/${commerce.idcommerce}/discounts`">
                                    Leer más
                                  </router-link>
                                </a>
                              </span>
                            <!--</template> -->
                          </ul>
                        </p>
                    </div>

                </div>             
              </div>
              <div class="modal-footer">
                <router-link :to="`commerce/${commerce.idcommerce}`">
                  <a href="#" class="btn btn-primary btn-sm">
                   Detalle
                  </a>     
                </router-link>
              </div>
          </div>
        </b-modal> 
    </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
  export default {
    data() {
      return {
        commerce: {
          idcommerce: '',
          name: '',
          phone1: '',
          email: '',
          commercecategory_idcommercecategory: ''
        },
        //countbranchs: '',
        branchs: [],
        discounts: [],
      }
    },

    created() {
      Bus.$on('detail_homeinit', (id) => {
          this.showCommerce(id);
        });
    },

    methods: {
      showCommerce(id) {

        axios.get('/api/detail-commerce/' + id + '/random').then(response => {
          this.commerce.idcommerce = response.data.data[0].idcommerce;
          this.commerce.name = response.data.data[0].name;
          this.commerce.phone1 = response.data.data[0].phone1;
          this.commerce.email = response.data.data[0].email;
          this.commerce.image = response.data.data[0].image;
          this.commerce.commercecategory_idcommercecategory = response.data.data[0].ccategories.name;
          this.branchs = response.data.data[0].branchs;
          //this.countbranchs = response.data.data[0].branchs.length;
          
          let unification = []; //Unificacion de descuentos repetidos vacío.

          response.data.data[0].branchs.forEach(res => {
              unification.push(JSON.stringify(res.discounts)); //Se unifican.
          });

          let ids = []; //Variables id para comparar
          let clean = []; //Variable de descuentos sin repetir vacía.

          $.each(unification, (index, value) => {
              if($.inArray(value.iddiscount, ids) == -1) //Comparamos el id con los del array.
              {
                  ids.push(value.iddiscount); //Sino se repiten lo guardamos en el array ids.
                  clean.push(value); // Y guardamos todo la data en clean.
              }
          });

          this.discounts = JSON.parse(clean); //Parseamos y añadimos a discounts para mostrarlos.
        })
        .catch(err => console.log(err))
      },  
    }
  }
</script>

<style>
  .image-commerce {
    width: 80px;
    height: 50px;
    border-radius: 50%;
  }
</style>