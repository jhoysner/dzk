<template>
    <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">
            Atras
        </button>
        <br />
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

                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Sucursales</h4>
                                    <div class="row">
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

                    <div class="single-sidebar theme-details">
                        <h6>Descuentos</h6>
                        <ul class="theme-details-list">
                            <li v-for="discount in discounts">
                                <router-link :to="`/discount/${discount.iddiscount}`">
                                    {{ discount.title }} - ${{ discount.amountapproved }}
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <div class="single-sidebar theme-tags">
                        <h6>Tags</h6>
                        <ul class="tag-list">
                            <li v-for="tag in tags"> 
                                <router-link class="tag" :to="`/commerce/${tag.idtags}/tag`">
                                    <i class="icons icon-tag"></i> {{tag.name}}
                                </router-link>
                            </li>
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
                    <div class="single-sidebar theme-tags">
                      <button type="button" class="btn btn-outline-primary"  v-b-modal.showMessage @click="contact(commerce)" >Contactar</button>
                    </div>
                </div>
            </div>

        </div>
        
    <message></message> 

    </div>
</template>

<script>
import Bus from '../../utilities/EventBus.js';
import $ from 'jquery';
import message from '../message/message';

    export default {
        components: { message},
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
                 tags: [],
                 discounts: [],
                 user:{},
            }
        },

        mounted() {
            this.index();
            this.auth();
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
            auth() {
              axios.get('/api/profile').then((response) => {
                console.log(response)
                this.user = response.data.user;
              })
              .catch(err => console.log(err))
            },  
            contact(commerce) {
                let data = {
                      client: this.user.id,
                      commerce: commerce,
                    };

                Bus.$emit('contact', data);
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