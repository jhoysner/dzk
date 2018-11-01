<template>
  <div id="section-profile" class="settings-content">
        <button type="button" class="btn btn-outline-dark pull-right" @click="$router.go(-1)">Atras</button>
            <h3 class="my-4">Descuento:
              <router-link :to="`/discount/${discount.iddiscount}`">
                {{ discount.title }}
              </router-link>
           </h3>
     
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
                                    <h4 class="text-uppercase">Descripcion</h4>
                                    <p>
                                        {{discount.description}}
                                    </p>
                                    <h4 class="text-uppercase">Charcode</h4>

                                    <p>
                                      {{ discount.charcode }}
                                    </p>

                                    <h4 class="text-uppercase">QR Code</h4>

                                    <p>
                                         <img class="img-fluid" :src="'/storage/qr/'+discount.qr" />
                                    </p>
                                </div>         
                                <div class="other-details">
                                    <h4 class="text-uppercase">Sucursal</h4>
                                    <div class="row">
                                      <router-link :to="`/branch/${branch.idbranch}`">
                                          <span>{{branch.name}}</span>
                                      </router-link>    
                                      <br> 
                                    </div>
                                    <div class="row">
                                      
                                      <p>Direccion : {{branch.address}}</p>                          
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
                    </div>

                    <div v-show="discount.outstanding">
                         <h3 class="alert alert-success text-center">Destacado</h3>
                            
                    </div>

                    <div class="single-sidebar theme-details">
                        <h6>Comercio</h6>
                        <router-link :to="`/commerce/${commerce.idcommerce}`">
                            <span>{{commerce.name}}</span>
                        </router-link>

                    </div>                    

                    <div class="single-sidebar theme-details">
                        <h6>Detalle Fecha</h6>
                        <ul class="theme-details-list">
                            <li> <i class="icons icon-tag"></i>Desde: {{discount.startdate}}</li>
                            <li> <i class="icons icon-tag"></i>Hasta: {{discount.enddate}}</li>
                        </ul>
                    </div>

                    <div class="single-sidebar theme-tags">
                        <h6>Estado</h6>
                        {{discount.state}}
              
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
              amountapproved: '',
              amountavailable: '',
              amountredeemed: '',
              normalprice: '',
              discountprice: '',
              charcode: '',
              qr: '',
              state: '',

          },
        commerce:{},
        branch:{},
      }
    },

    mounted() {
      this.index();
    },

    methods: {
            index() {
              axios.get('/api/client-user-discount/' +this.id).then(response => {
                console.log(response.data.data)
                this.discount.iddiscount = response.data.data.discounts.iddiscount;
                this.discount.title = response.data.data.discounts.title;
                this.discount.description = response.data.data.discounts.description;
                this.discount.image = response.data.data.discounts.image;
                this.discount.startdate = response.data.data.discounts.startdate;
                this.discount.enddate = response.data.data.discounts.enddate;
                this.discount.normalprice = response.data.data.discounts.normalprice;
                this.discount.discountprice = response.data.data.discounts.discountprice;
                this.discount.discountpercentage = response.data.data.discounts.discountpercentage;

                this.discount.charcode = response.data.data.charcode;
                this.discount.qr = response.data.data.qrcode;
                this.discount.state = response.data.data.discounts_status.name;
                this.commerce = response.data.data.commerce;
                this.branch = response.data.data.branch;

                // this.branchs = response.data.data.branchs;
                // this.tags = response.data.data.tags;
                // this.commerce = response.data.data.branchs[0].commerces;

                // console.log(response.data.data)
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