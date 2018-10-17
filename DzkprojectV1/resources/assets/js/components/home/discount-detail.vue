<template>
	<div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>
<!--         <h2 class="my-4">Descuento: {{discount.iddiscount}}</h2>
 -->
            <h3 class="my-4">{{ discount.title }}</h3>
        <!--     <div>
                <div class="row pt-30">
                    <div class="col-lg-6">
                        <label><strong>ID Descuento</strong></label>
                        <p>{{discount.iddiscount}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Descripción</strong></label>
                        <p>{{discount.description}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Inicio</strong></label>
                        <p>{{discount.startdate}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Fin</strong></label>
                        <p>{{discount.enddate}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Destacado</strong></label>
                        <p> {{ discount.outstanding ? "Si" : "No" }}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Imagen</strong></label>
                        <p>
		                  <img class="image-discount" :src="'images/discount/'+discount.image" />
		                </p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Condición</strong></label>
                        <p>{{discount.condition}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Restricciones</strong></label>
                        <p>{{discount.restrictions}}</p>
                    </div>                    
                    <div class="col-lg-6">
                        <label><strong>Normal Precio</strong></label>
                        <p>{{discount.normalprice}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Precio Descuento</strong></label>
                        <p>{{discount.discountprice}}</p>
                    </div>                    
                    <div class="col-lg-6">
                        <label><strong>Porcetaje Descuento</strong></label>
                        <p>{{discount.discountpercentage}} %</p>
                    </div>

                    <div class="clearfix"></div>
                    <br>
              
                </div>
                <div>
                    <h3 class="mt-4">Sucursales</h3>    
                    <div class="row justify-content-center stat-table-wrap">
                        <div class="col-lg-12 stat-wrap-container">
                            <div class="stat-wrap">
                                <table class="table table-striped mt-40 stat-table">
                                    <thead>
                                      <tr>
                                        <th>ID Sucursal</th>
                                        <th>Nombre</th>
                                        <th>Imagen</th>
                                        <th>Latitud y Longitud</th>
                                        <th>Options</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="branch in branchs" >
                                        <td>{{ branch.idbranch }}</td>
                                        <td>{{ branch.name }}</td>
                                        <td>
                                          <img class="image-branch" v-if="branch.image != null" :src="'images/branch/'+branch.image" />
                                          <p v-if="branch.image == null">No posee imagen.</p>
                                        </td>
                                        <td>{{ branch.latitude }} - {{ branch.longitude }}</td>
                                        <td>
                                          <router-link :to="`/branch/${branch.idbranch}`">
                                            <a href="#" class="btn btn-primary btn-sm">
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
            </div> -->
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview">
                            <!-- Overview section -->
                            <div class="overview-section">
                                <div class="theme-thumb">
                                    <img class="img-fluid" :src="'../images/discount/'+discount.image" />
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Informacion</h4>
                                    <p>
                                        {{discount.description}}
                                    </p>
                                    <p v-if="discount.conditions != null">
                                        Condiciones: {{ discount.conditions }}
                                    </p>
                                    <p v-if="discount.restrictions != null">
                                        Restricciones: {{ discount.restrictions }}
                                    </p>
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Categoria</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="support-list">
                                                <li>
                                                    <img src="/img/bullet.png" alt="">{{discount.discountcategory_iddiscountcategory}}
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="other-details">
                                    <h4 class="text-uppercase">Sucursales</h4>
                                    <div class="row">
                                        <div class="col">
                                            <b-card-group deck>
                                                <div v-for="branch in branchs">                                          
                                                    <b-card :title="branch.name"
                                                          img-src="https://picsum.photos/150/100/?image=25"
                                                          img-alt="Image"
                                                          img-top
                                                          tag="article"
                                                          style="max-width: 15rem;"
                                                          class="mb-2">
                                                        <p class="card-text">
                                                          {{branch.name}}
                                                        </p>
                                                        <!-- <b-button href="#" variant="primary" size="sm">ver</b-button> -->
                                                         <router-link :to="`/branch/${branch.idbranch}`">
                                                            <a href="#" class="btn btn-primary btn-sm">
                                                            Detalle
                                                            </a>     
                                                          </router-link>
                                                    </b-card>    
                                                </div>
                                            </b-card-group>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 sidebar theme-details-sidebar">
                    <div class="single-sidebar">
                        <div class="price-title d-flex flex-row justify-content-between">
                            <h3 class="price my-2">{{discount.discountprice}}</h3>
                            <h4><s>{{discount.normalprice}}</s></h4>
                            <h6>{{discount.discountpercentage}}%</h6>
                        </div>
  <!--                       <ul>
                            <li>01 year theme support</li>
                            <li>01 year theme updates</li>
                        </ul> -->
                        <a href="#" class="primary-btn">purchase only</a>
                    </div>

                    <div v-show="discount.outstanding">
                         <h3 class="alert alert-success text-center">Destacado</h3>
                            
                    </div>

                    <div class="single-sidebar theme-details">
                        <h6>Detalle Fecha</h6>
                        <ul class="theme-details-list">
                            <li> <i class="icons icon-tag"></i> {{discount.startdate}}</li>
                            <li> <i class="icons icon-tag"></i> {{discount.enddate}}</li>
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
    </div>
</template>

<script>
	export default {
		data() {
			return {
				id: this.$route.params.id,
			    discount: {
			     	iddiscount: '',
			        title: '',
			        description: '',
			        image: '',
			        startdate: '',
			        enddate: '',
			        outstanding: '',
			        conditions: '',
			        restrictions: '',
			        amountapproved: '',
			        amountavailable: '',
                    amountredeemed: '',
                    normalprice: '',
                    discountprice: '',
                    discountcategory_iddiscountcategory: ''
			    },
                branchs:[],
                tags:[],
			}
		},

		mounted() {
			this.index();
		},

		methods: {
            index() {
              axios.get('/api/discount/' +this.id).then(response => {
                // console.log(response)
                this.discount.iddiscount = response.data.data.iddiscount;
                this.discount.title = response.data.data.title;
                this.discount.description = response.data.data.description;
                this.discount.image = response.data.data.image;
                this.discount.startdate = response.data.data.startdate;
                this.discount.enddate = response.data.data.enddate;
                this.discount.outstanding = response.data.data.outstanding;
                this.discount.conditions = response.data.data.conditions;
                this.discount.restrictions = response.data.data.restrictions;
                this.discount.normalprice = response.data.data.normalprice;
                this.discount.discountprice = response.data.data.discountprice;
                this.discount.discountpercentage = response.data.data.discountpercentage;
                this.discount.discountcategory_iddiscountcategory = response.data.data.categories.name;

                this.branchs = response.data.data.branchs;
                this.tags = response.data.data.tags;

                console.log(response.data.data)
              })
              .catch(err => console.log(err))
            },			

		}
	}
</script>

<style>
	.image-discount {
	  width: 80px;
	  height: 50px;
	  border-radius: 50%;
	}
</style>