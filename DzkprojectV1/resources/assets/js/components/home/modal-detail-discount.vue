<template>
  <div>
        <b-modal id="showModal" ref="showModal" :title="discount.title" hide-footer>
          <div class="modal-content">
              <div class="modal-body">
                <div class="row pt-30">
                  <div class="col-lg-12">
                        <label><strong>ID Detail</strong></label>
                        <p>{{discount.iddiscount}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Descripcion</strong></label>
                        <p>{{discount.description}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Porcentaje Descuento</strong></label>
                        <p>{{discount.discountpercentage}}</p>
                    </div>
                    <div class="col-lg-6">
                        <label><strong>Inicio</strong></label>
                        <p>{{discount.startdate}}</p>
                    </div>                    
                    <div class="col-lg-6">
                        <label><strong>Final</strong></label>
                        <p>{{discount.enddate}}</p>
                    </div>
                   <div class="col-lg-12">
                        <label>
                          <strong>
                            Afiliado a {{ countbranchs }} sucursales
                          </strong>
                        </label>
                        <p>
                          <ul v-for="branch in branchs">
                            <li class="pl-2">{{ branch.name }}</li>
                          </ul>
                        </p>
                        <hr>
                    </div>

                </div>             
              </div>
              <div class="modal-footer">
                <router-link :to="`discount/${discount.iddiscount}`">
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
        discount: {
            title: '', 
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
            discountpercentage: '', 
            discountcategory_iddiscountcategory: '', 
            iddiscount: '', 
            description: '', 
           },
        countbranchs: '',
        branchs: [],
      }
    },

    created() {
      Bus.$on('detail_homeinit-discount', (id) => {
          this.showDiscount(id);
        });
    },

    methods: {
      showDiscount(id) {
        this.countDiscounts = 0; 

        axios.get('/api/detail-discount/' + id).then(response => {
          this.discount.iddiscount = response.data.data[0].iddiscount;
          this.discount.title = response.data.data[0].title;
          this.discount.startdate = response.data.data[0].startdate;
          this.discount.enddate = response.data.data[0].enddate;
          this.discount.normalprice = response.data.data[0].discountprice;
          this.discount.discountpercentage = response.data.data[0].discountpercentage;
          this.discount.description = response.data.data[0].description;
          this.countbranchs = response.data.data[0].branchs.length;
          this.branchs = response.data.data[0].branchs;
        })
        .catch(err => console.log(err))
      },  
    }
  }
</script>

<style>
  
</style>