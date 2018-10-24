<template>
  <div>
    <div class="col-lg-12">
        <div>
            <div class="settings-content">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <router-link to="/" class="nav-link">
                      COMERCIOS
                  </router-link>
                </li>
                <li class="nav-item">
                   <router-link to="/home-discounts" class="nav-link active">
                      DESCUENTOS
                   </router-link>
                </li>
              </ul>
              <!-- <spinner :show="loadingProductos"></spinner> -->
              <div class="row justify-content-center stat-table-wrap">
                <div class="col-lg-12 stat-wrap-container">
                    <div class="stat-wrap my-4">
                        <a class="primary-btn white-btn" @click="toggleSearch"><i class="icons icon-magnifier"></i></a>
                        <hr>
                        <div class="container" id="search">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="">Categoría</label>
                                <select name="" class="form-control" v-model="category">
                                  <option v-for="category in categorydiscount" :value="category.iddiscountcategory">{{category.name}}</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Tags</label>
                                <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="Buscar o Agregar tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" @input="onChange"></multiselect>
                              </div>
                              <div class="form-group">
                                <input type="text" class="form-control" placeholder="Buscar" v-model="search">
                              </div>
                              <div class="form-group">
                                <button class="btn btn-primary btn-block" @click="filtering">Filtrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!--     <table class="table table-striped mt-40 stat-table">
                            <thead>
                              <tr>
                                  <th>ID Descuento</th>
                                  <th>Titulo</th>
                                  <th>Descripcion</th>
                                  <th>Inicio</th>
                                  <th>Fin</th>
                                  <th>Destacado</th>
                                  <th>Options</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr  v-for="discount in filter">
                                  <td>{{ discount.iddiscount}}</td>
                                  <td>{{ discount.title }}</td>
                                  <td class="text-center">{{ discount.description }}</td>
                                  <td class="text-center">{{ discount.startdate }}</td>
                                  <td class="text-center">{{ discount.enddate }}</td>
                                  <td class="text-center">
                                    {{ discount.outstanding ? "Si" : "No" }}
                                  </td>
                                  <td>
                                    <b-btn variant="primary" size="sm" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                      Ver Detalles
                                     </b-btn>
                                  </td>
                              </tr>
                           
                            </tbody>
                        </table> -->
                        <div class="row pb-120 pt-80">    <!-- Aqui empieza -->           
                          <div class="col-lg-3 col-md-6" v-for="discount in discounts" :key="discount.iddiscount">
                            <div class="single-image-thumb single-feature-item relative">   
                                <div class="thumb relative">
                                  <div class="thumb-img relative" v-if="discount.image == null">
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" src="img/f5.jpg" alt="">
                                  </div>
                                  <div class="thumb-img relative" v-else>
                                      <div class="overlay overlay-bg"></div>
                                      <img class="img-fluid" :src="'images/discount/'+discount.image" alt="">
                                  </div>
                                  <div class="link">
                                      <a class="relative showModal" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                        <i class="icons icon-eye"></i>
                                      </a>
                                  </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a class="showModal" v-b-modal.showModal  @click="detail(discount.iddiscount)">
                                            <h6>{{ discount.title }}</h6>
                                        </a>
                                        <h6 class="price">${{ discount.discountprice }}</h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                          <h6 v-if="discount.branchs.length > 0">
                                            <router-link :to="`/commerce/${discount.branchs[0].commerces.idcommerce}`">
                                              <span> {{discount.branchs[0].commerces.name}}</span>
                                            </router-link>
                                         </h6>
                                          <h6 v-if="discount.branchs.length < 1">Descuento sin Asignar</h6>
                                        </a>
                                        <h6 class="price"><s>${{ discount.normalprice }}</s></h6>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <a href="theme-details.html">
                                            <h6>{{ discount.categories.name }} </h6>
                                        </a>
                                        <i class="icons icon-share"></i>
                                    </div>
                                </div>
                                <div class="details pb-10 pt-20">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <div v-for="tag in discount.tags"> 
                                          <span class="badge badge-secondary">{{tag.name}}</span>
                                        </div>
                                        <span v-if="discount.tags.length < 1"> Sin Tags</span>
                                    </div>
                                </div>
                                <div class="meta d-flex flex-row">
                                    <!--<div class="user-img"><img src="img/user-img.png" alt=""></div> -->
                                       <button type="button" class="btn btn-outline-primary" @click="obtenerDescuento(discount)" >Obetener este Descuento</button>
                                </div>
                            </div>
                          </div>
                        </div> <!-- Aqui termina -->
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <paginator :pagination="pagination"></paginator>
    <detail></detail>
  </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';
import detail from './modal-detail-discount';
import paginator from '../../utilities/paginator';

  export default {
    components: { detail, paginator},
    data() {
      return {
        discounts: [],
        // commerce: '',
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        offset: 2,
        search: null,
        options: [],
        value: [],
        tags: [],
        categorydiscount: [],
        category: null,
        form: { 
          'validfrom': '',
          'validto':'',
          'amount':'',
          'normalprice':'',
          'discountprice':'',
          'discountpercentage': '',
          'discount_iddiscount': '',
          'userhasdiscountstatus_iduserhasdiscountstatus': '',
          'commerce_idcommerce': '',
          'branch_idbranch': '',
          'users_id': '',
        },
      }
    },

    mounted() {
      this.index();
      this.getTags();
      this.getDiscountCategories();

      Bus.$on('change_page', (page) => {
        this.filtering(page);
      });
    },
    // computed: {
    //     filter() {
    //       const search = this.search.toLowerCase();
    //       return this.discounts.filter((item) => item.title.toLowerCase().includes(search));
    //     }
    // },

    methods: {
      onChange(val) {
        let list=[];
        val.map(function(value, key) {
          let tag = {
            id : value.idtags
          }
          list.push(tag);
        });
        this.tags = list;
      },

      //Muestra Listado de Tag
      getTags() {
         axios.get('api/tags').then(response => {
          this.options = []
          this.options = response.data.tags
          this.options.forEach(function(item) {
              item.code = item.idtags
          })
        })
        .catch(err => console.log(err))
      },
      index(page) {
        axios.get('api/all-discounts?page=' + page).then(response => {
          //console.log(response);
          this.discounts = response.data.discount.data;
          this.pagination = response.data.paginate;
          // this.commerce = response.data.discount.data[0].branchs[0].commerces.name;
          // console.log(response)
        })
        .catch(err => console.log(err))
      },

      toggleSearch() {
        $('#search').toggle();
      },

      detail(id) {
        Bus.$emit('detail_homeinit-discount', id);
      },

      getDiscountCategories() {
        axios.get('api/discount-categories').then(data => {
          // console.log(data)
          this.categorydiscount = data.data.data;
          this.categorydiscount.unshift({iddiscountcategory: null, name: 'Seleccione una opcion'});
          this.category = data.data.data[0].iddiscountcategory;
        })
        .catch(err => console.log(err))
      },

      filtering(page) {
        let data = {
          category_discount: this.category,
          tags: this.tags,
          word: this.search,
          type: 'discount'
        };

        console.log(data);

        //axios.post('api/all-discounts?page=' + page, data).then(response => {
        axios.post('api/search', data).then(response => {
          console.log(response)
          this.discounts = response.data.discount.data;
          this.pagination = response.data.paginate;
        })
        .catch(err => console.log(err));
      },
      obtenerDescuento(discount){

         this.form.validfrom = discount.startdate;
         this.form.validto = discount.enddate;
         this.form.amount = 1;
         this.form.normalprice = discount.normalprice;
         this.form.discountprice = discount.discountprice;
         this.form.discountpercentage = discount.discountpercentage;
         this.form.discount_iddiscount = discount.iddiscount;
         this.form.userhasdiscountstatus_iduserhasdiscountstatus = 'eada8935-d7cc-11e8-86bd-74c63b1404ed';
         this.form.commerce_idcommerce = discount.branchs[0].commerce_idcommerce;
         this.form.branch_idbranch = discount.branchs[0].idbranch;
         this.form.users_id = 'abcd1234';
   
        console.log(discount)

        axios.post('api/user-has-discount', this.form).
          then(response => {
              this.form = {};
              swal({
                title: "Obtenido",
                text: "Se obtuvo Descuento Satifactoriamente",
                icon: "success",
              })
          })
          .catch(error => {
            console.log(error.response.data)

          });
      }
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

  .showModal {
    cursor: pointer;
  }

  .thumb-img {
    width: 250px;
    height: 125px;
  }

  .branch-link {
    color: #333;
  }

  .view-branch {
    margin-top: 5px;
  }

  .view-branch:hover {
    color: #FFF;
  }

  fieldset[disabled] .multiselect {
  pointer-events: none;
  }
  .multiselect__spinner {
    position: absolute;
    right: 1px;
    top: 1px;
    width: 48px;
    height: 35px;
    background: #fff;
    display: block;
  }
  .multiselect__spinner:before,
  .multiselect__spinner:after {
    position: absolute;
    content: "";
    top: 50%;
    left: 50%;
    margin: -8px 0 0 -8px;
    width: 16px;
    height: 16px;
    border-radius: 100%;
    border-color: #41B883 transparent transparent;
    border-style: solid;
    border-width: 2px;
    box-shadow: 0 0 0 1px transparent;
  }
  .multiselect__spinner:before {
    animation: spinning 2.4s cubic-bezier(0.41, 0.26, 0.2, 0.62);
    animation-iteration-count: infinite;
  }
  .multiselect__spinner:after {
    animation: spinning 2.4s cubic-bezier(0.51, 0.09, 0.21, 0.8);
    animation-iteration-count: infinite;
  }
  .multiselect__loading-enter-active,
  .multiselect__loading-leave-active {
    transition: opacity 0.4s ease-in-out;
    opacity: 1;
  }
  .multiselect__loading-enter,
  .multiselect__loading-leave-active {
    opacity: 0;
  }
  .multiselect,
  .multiselect__input,
  .multiselect__single {
    font-family: inherit;
    font-size: 14px;
    touch-action: manipulation;
  }
  .multiselect {
    box-sizing: content-box;
    display: block;
    position: relative;
    width: 100%;
    min-height: 40px;
    text-align: left;
    color: #35495E;
  }
  .multiselect * {
    box-sizing: border-box;
  }
  .multiselect:focus {
    outline: none;
  }
  .multiselect--disabled {
    pointer-events: none;
    opacity: 0.6;
  }
  .multiselect--active {
    z-index: 50;
  }
  .multiselect--active:not(.multiselect--above) .multiselect__current,
  .multiselect--active:not(.multiselect--above) .multiselect__input,
  .multiselect--active:not(.multiselect--above) .multiselect__tags {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
  }
  .multiselect--active .multiselect__select {
    transform: rotateZ(180deg);
  }
  .multiselect--above.multiselect--active .multiselect__current,
  .multiselect--above.multiselect--active .multiselect__input,
  .multiselect--above.multiselect--active .multiselect__tags {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }
  .multiselect__input,
  .multiselect__single {
    position: relative;
    display: inline-block;
    min-height: 20px;
    line-height: 20px;
    border: none;
    border-radius: 5px;
    background: #fff;
    padding: 1px 0 0 5px;
    width: calc(100%);
    transition: border 0.1s ease;
    box-sizing: border-box;
    margin-bottom: 8px;
    vertical-align: top;
  }
  .multiselect__tag ~ .multiselect__input,
  .multiselect__tag ~ .multiselect__single {
    width: auto;
  }
  .multiselect__input:hover,
  .multiselect__single:hover {
    border-color: #cfcfcf;
  }
  .multiselect__input:focus,
  .multiselect__single:focus {
    border-color: #a8a8a8;
    outline: none;
  }
  .multiselect__single {
    padding-left: 6px;
    margin-bottom: 8px;
  }
  .multiselect__tags-wrap {
    display: inline
  }
  .multiselect__tags {
    min-height: 40px;
    display: block;
    padding: 8px 40px 0 8px;
    border-radius: 5px;
    border: 1px solid #E8E8E8;
    background: #fff;
  }
  .multiselect__tag {
    position: relative;
    display: inline-block;
    padding: 4px 26px 4px 10px;
    border-radius: 5px;
    margin-right: 10px;
    color: #fff;
    line-height: 1;
    background: #5240b8;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    max-width: 100%;
    text-overflow: ellipsis;
  }
  .multiselect__tag-icon {
    cursor: pointer;
    margin-left: 7px;
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    font-weight: 700;
    font-style: initial;
    width: 22px;
    text-align: center;
    line-height: 22px;
    transition: all 0.2s ease;
    border-radius: 5px;
  }
  .multiselect__tag-icon:after {
    content: "×";
    color: #266d4d;
    font-size: 14px;
  }
  .multiselect__tag-icon:focus,
  .multiselect__tag-icon:hover {
    background: #369a6e;
  }
  .multiselect__tag-icon:focus:after,
  .multiselect__tag-icon:hover:after {
    color: white;
  }
  .multiselect__current {
    line-height: 16px;
    min-height: 40px;
    box-sizing: border-box;
    display: block;
    overflow: hidden;
    padding: 8px 12px 0;
    padding-right: 30px;
    white-space: nowrap;
    margin: 0;
    text-decoration: none;
    border-radius: 5px;
    border: 1px solid #E8E8E8;
    cursor: pointer;
  }
  .multiselect__select {
    line-height: 16px;
    display: block;
    position: absolute;
    box-sizing: border-box;
    width: 40px;
    height: 38px;
    right: 1px;
    top: 1px;
    padding: 4px 8px;
    margin: 0;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: transform 0.2s ease;
  }
  .multiselect__select:before {
    position: relative;
    right: 0;
    top: 65%;
    color: #999;
    margin-top: 4px;
    border-style: solid;
    border-width: 5px 5px 0 5px;
    border-color: #999999 transparent transparent transparent;
    content: "";
  }
  .multiselect__placeholder {
    color: #ADADAD;
    display: inline-block;
    margin-bottom: 10px;
    padding-top: 2px;
  }
  .multiselect--active .multiselect__placeholder {
    display: none;
  }
  .multiselect__content-wrapper {
    position: absolute;
    display: block;
    background: #fff;
    width: 100%;
    max-height: 240px;
    overflow: auto;
    border: 1px solid #E8E8E8;
    border-top: none;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    z-index: 50;
    -webkit-overflow-scrolling: touch;
  }
  .multiselect__content {
    list-style: none;
    display: inline-block;
    padding: 0;
    margin: 0;
    min-width: 100%;
    vertical-align: top;
  }
  .multiselect--above .multiselect__content-wrapper {
    bottom: 100%;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    border-bottom: none;
    border-top: 1px solid #E8E8E8;
  }
  .multiselect__content::webkit-scrollbar {
    display: none;
  }
  .multiselect__element {
    display: block;
  }
  .multiselect__option {
    display: block;
    padding: 12px;
    min-height: 40px;
    line-height: 16px;
    text-decoration: none;
    text-transform: none;
    vertical-align: middle;
    position: relative;
    cursor: pointer;
    white-space: nowrap;
  }
  .multiselect__option:after {
    top: 0;
    right: 0;
    position: absolute;
    line-height: 40px;
    padding-right: 12px;
    padding-left: 20px;
  }
  .multiselect__option--highlight {
    background: #41B883;
    outline: none;
    color: white;
  }
  .multiselect__option--highlight:after {
    content: attr(data-select);
    background: #41B883;
    color: white;
  }
  .multiselect__option--selected {
    background: #F3F3F3;
    color: #35495E;
    font-weight: bold;
  }
  .multiselect__option--selected:after {
    content: attr(data-selected);
    color: silver;
  }
  .multiselect__option--selected.multiselect__option--highlight {
    background: #FF6A6A;
    color: #fff;
  }
  .multiselect__option--selected.multiselect__option--highlight:after {
    background: #FF6A6A;
    content: attr(data-deselect);
    color: #fff;
  }
  .multiselect--disabled {
    background: #ededed;
    pointer-events: none;
  }
  .multiselect--disabled .multiselect__current,
  .multiselect--disabled .multiselect__select {
    background: #ededed;
    color: #a6a6a6;
  }
  .multiselect__option--disabled {
    background: #ededed;
    color: #a6a6a6;
    cursor: text;
    pointer-events: none;
  }
  .multiselect__option--disabled.multiselect__option--highlight {
    background: #dedede !important;
  }
  .multiselect-enter-active,
  .multiselect-leave-active {
    transition: all 0.15s ease;
  }
  .multiselect-enter,
  .multiselect-leave-active {
    opacity: 0;
  }
  .multiselect__strong {
    margin-bottom: 10px;
    display: inline-block
  }
  *[dir="rtl"] .multiselect {
      text-align: right;
  }
  *[dir="rtl"] .multiselect__select {
      right: auto;
      left: 1px;
  }
  *[dir="rtl"] .multiselect__tags {
      padding: 8px 8px 0px 40px;
  }
  *[dir="rtl"] .multiselect__content {
      text-align: right;
  }
  *[dir="rtl"] .multiselect__option:after {
      right: auto;
      left: 0;
  }
  *[dir="rtl"] .multiselect__clear {
      right: auto;
      left: 12px;
  }
  *[dir="rtl"] .multiselect__spinner {
      right: auto;
      left: 1px;
  }
  @keyframes spinning {
    from { transform:rotate(0) }
    to { transform:rotate(2turn) }
  }

</style>