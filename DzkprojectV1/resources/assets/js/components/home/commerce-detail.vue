<template>
    <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">
            Atras
        </button>
        <br />
        <!--<ul class="nav nav-tabs">
          <li class="nav-item">
             <router-link :to="`/commerce/${id}`" class="nav-link active">
                Detalle
             </router-link>
          </li>
          <li class="nav-item">
             <router-link :to="`/commerce/${id}/branchs`" class="nav-link">
                Sucursales
             </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="`/commerce/${id}/discounts`" class="nav-link">
                Descuentos
            </router-link>
          </li>
        </ul> -->
        <div class="col-lg-12">
            <h2 class="pb-30 semi-bold">{{ commerce.name }}</h2>                   
        </div> 
    
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview">
                            <!-- Overview section -->
                            <div class="overview-section">
                                <div class="theme-thumb">
                                    <img class="img-fluid" :src="'../images/commerce/'+commerce.image" />
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Overview</h4>
                                    <p>
                                        Teléfono principal: {{ commerce.phone1 }}
                                    </p>
                                    <p>
                                        Teléfono alternativo: {{ commerce.phone2 }}
                                    </p>
                                    <p>
                                        Correo electronico: {{ commerce.email }}
                                    </p>
                                    <p v-if="commerce.web != null ">
                                        web: {{ commerce.web }}
                                    </p>
                                    <!--<p>
                                        2.Get to the point – Ask your question or explain your situation right away. Don’t beat around the bush. 3.Don’t be arrogant – You are calling technical support because you need help. Don’t try and be a smart guy. 4.Call for yourself.
                                    </p> -->
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Sucursales</h4>
                                    <div class="row">
                                        <!--<div class="col-lg-6">
                                            <ul class="support-list">
                                                <li v-if="branchs.length < 1">No posee sucursales aún.</li>
                                                <li v-for="branch in branchs">
                                                    <img src="/img/bullet.png" alt="">
                                                    <router-link class="branch-link" :to="`/branch/${branch.idbranch}`">
                                                      {{ branch.name }}
                                                    </router-link>
                                                </li> -->
                                                <!--<li>
                                                    <img src="img/bullet.png" alt="">3 Simple Ways To Save A Bunch Of Money
                                                </li> 
                                            </ul>
                                        </div>-->
                                        <div class="col">
                                            <b-card-group deck>
                                                <div v-for="branch in branchs">                                          
                                                    <b-card :title="branch.name"
                                                          :img-src="'../images/branch/'+branch.image"
                                                          img-alt="Image"
                                                          img-top
                                                          tag="article"
                                                          style="width: 14rem;"
                                                          class="mb-2">
                                                        <p class="card-text">
                                                          {{branch.address}}
                                                        </p>
                                                        <!-- <b-button href="#" variant="primary" size="sm">ver</b-button> -->
                                                        <router-link :to="`/branch/${branch.idbranch}`" class="btn btn-primary btn-sm">
                                                            Ir   
                                                        </router-link>
                                                    </b-card>    
                                                </div>
                                            </b-card-group>

                                        </div>
                                    </div>
                                </div>
                                <!--<div class="other-details">
                                    <h4 class="text-uppercase">Descuentos</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="support-list">
                                                <li v-for="branch in branchs">
                                                    <img src="/img/bullet.png" alt="">{{ branch.name }}
                                                </li> -->
                                                <!--<li>
                                                    <img src="img/bullet.png" alt="">3 Simple Ways To Save A Bunch Of Money
                                                </li> -
                                            </ul>
                                        </div>->
                                        <div class="col-lg-6">
                                            <ul class="support-list">
                                                <li>
                                                    <img src="img/bullet.png" alt="">Help Finding Information Online
                                                </li>
                                                <li>
                                                    <img src="img/bullet.png" alt="">5 Reasons To Choose A Notebook Over
                                                </li>
                                                <li>
                                                    <img src="img/bullet.png" alt="">3 Simple Ways To Save A Bunch Of Money
                                                </li> 
                                            </ul>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <!-- Overview section -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 sidebar theme-details-sidebar">
                    <div class="single-sidebar">
                        <div class="price-title d-flex flex-row justify-content-between">
                            <h6>Nuestra ubicación</h6>
                            <!--<h3 class="price">$39</h3> -->
                        </div>
                        <ul>
                          <li>
                              {{commerce.country_idcountry}}
                          </li>
                          <li>
                              {{commerce.state_idstate}}
                          </li>
                          <li>
                              {{commerce.city_idcity}}
                          </li>
                        </ul>
                        <!--<a href="#" class="primary-btn">purchase only</a> -->
                    </div>

                    <!--<div class="single-sidebar d-flex flex-row justify-content-between align-items-center total-downlaod">
                        <h6>Total Downloads</h6>
                        <h3>968</h3>
                    </div> -->

                    <div class="single-sidebar theme-details">
                        <h6>Descuentos</h6>
                        <ul class="theme-details-list">
                           <!-- <li><i class="icons icon-basket-loaded"></i> eCommerce, Magazine, Writing</li>
                            <li> <i class="icons icon-bell"></i> Theme version: 4.3.5</li>
                            <li><i class="icons icon-notebook"></i>View help file</li>
                            <li><i class="icons icon-wrench"></i>Sass files included</li>
                            <li><i class="icons icon-cloud-upload"></i>Download child theme</li> -->
                            <template v-for="branch in branchs">
                              <li v-for="discount in branch.discounts">
                                <router-link :to="`/discount/${discount.iddiscount}`">
                                    {{ discount.title }} - ${{ discount.amountapproved }}
                                </router-link>
                              </li>
                            </template>
                        </ul>
                    </div>

                    <div class="single-sidebar theme-tags">
                        <h6>Tags</h6>
                        <ul class="tag-list">
                            <li v-for="tag in tags"> <i class="icons icon-tag"></i> {{tag.name}}</li>
                        </ul>
                        <div class="sidebar-social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-github" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-slack" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

            <!--<h3 class="mt-4">{{ commerce.name }}</h3>
            <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>ID Comercio</strong></label>
                        <p>{{commerce.idcommerce}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono principal</strong></label>
                        <p>{{commerce.phone1}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Telefono secundario</strong></label>
                        <p>{{commerce.phone2}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Correo Electrónico</strong></label>
                        <p>{{commerce.email}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Imagen</strong></label>
                        <p>
                          <img class="image-commerce" :src="'images/commerce/'+commerce.image" />
                        </p>
                    </div>
                    <div class="col-lg-6" v-if="commerce.web != null ">
                        <label><strong>Web</strong></label>
                        <p>{{commerce.web}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>País</strong></label>
                        <p>{{commerce.country_idcountry}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Estado</strong></label>
                        <p>{{commerce.state_idstate}}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Ciudad</label>
                        <p>{{ commerce.city_idcity }}</p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="font-weight-bold">Categoría</label>
                        <p>{{ commerce.commercecategory_idcommercecategory }}</p>
                    </div>

                    <div class="clearfix"></div>
                    <br>
              
                </div>
            
            </div> -->
        </div>
</template>

<script>
    export default {
        data() {
            return {
                id: this.$route.params.id,
                 commerce: {
                    idcommerce: '',
                    name: '',
                    phone1: '',
                    phone2: '',
                    email: '',
                    image: '',
                    web: '',
                    country_idcountry: '',
                    state_idstate: '',
                    city_idcity: '',
                    commercecategory_idcommercecategory: ''
                 },
                 branchs:[],
                 tags: []
            }
        },

        mounted() {
            this.index();
        },

        methods: {
            index() {
              axios.get('/api/detail-commerce/' + this.$route.params.id).then(response => {
                this.commerce.idcommerce = response.data.data[0].idcommerce;
                this.commerce.name = response.data.data[0].name;
                this.commerce.phone1 = response.data.data[0].phone1;
                this.commerce.phone2 = response.data.data[0].phone2;
                this.commerce.email = response.data.data[0].email;
                this.commerce.image = response.data.data[0].image;
                this.commerce.web = response.data.data[0].web;
                this.commerce.country_idcountry = response.data.data[0].countries.name;
                this.commerce.state_idstate = response.data.data[0].states.name;
                this.commerce.city_idcity = response.data.data[0].cities.name;
                this.commerce.commercecategory_idcommercecategory = response.data.data[0].ccategories.name;
                this.branchs = response.data.data[0].branchs;
                this.tags = response.data.data[0].tags;
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

    .card-img-top {
        height: 10rem;
    }
</style>