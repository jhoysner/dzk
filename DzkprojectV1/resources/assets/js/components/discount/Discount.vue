<template>
  <div>
      <div class="col-lg-12">
          <div>
<!--               <router-link :to="{name: 'discount.create'}" class="btn btn-success mb-4">Create Discount</router-link>
 -->              
                  <b-btn v-b-modal.createModal>Create Dicount</b-btn>

                  <div class="settings-content mt-4">
                  <h4>List Discounts</h4>
                <!-- <spinner :show="loadingProductos"></spinner> -->
                  <div class="responsive">
                      <div class="table-responsive">
                          <table class="table table-hover table-bordered table-striped table-condensed">
                              <thead>
                                  <tr>
                                      <th class="text-center">iddiscount</th>
                                      <th class="text-center">title</th>
                                      <th class="text-center">description</th>
                                      <th class="text-center">startdate</th>
                                      <th class="text-center">enddate</th>
                                      <th class="text-center">outstanding</th>
                                      <th class="text-center">Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="discount in discounts">
                                      <td>{{ discount.iddiscount}}</td>
                                      <td>{{ discount.title }}</td>
                                      <td class="text-center">{{ discount.description }}</td>
                                      <td class="text-center">{{ discount.startdate }}</td>
                                      <td class="text-center">{{ discount.enddate }}</td>
                                      <td class="text-center">{{ discount.outstanding }}</td>
                                      <td class="text-right">
                                          <button type="button" @click="detailsDiscount(discount)" class="btn btn-sm  btn-default"> Detalles</button>
 
                                          <button type="button" @click="editDiscount(discount)" class="btn  btn-sm  btn-info"> Editar</button>
                                      

                                          <button type="button" @click="confirm(discount)" class="btn btn-sm  btn-danger">Eliminar</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>

                      <!-- <pagination :pag="pagination" @anterior="cargarProductos(...arguments)" @siguiente="cargarProductos(...arguments)"></pagination> -->
                    
                </div>
              </div>
          </div>
      </div>
      <create></create> 
      <!-- modal edit -->
        <b-modal v-model="showEdit" ref="editModal" title="Edit Discount"hide-footer>
            <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="tmpDiscount.title" autofocus="">
                                <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" v-model="tmpDiscount.description">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.description"> {{errorsDiscount.description[0]}} </span>
                            

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                                <span class="text-danger" v-if="!!errorsDiscount.costo_venta"> {{errorsDiscount.image[0]}} </span>                           
                                <img :src="!changeImage ? 'images/discount/'+ tmpDiscount.image : tmpDiscount.image " alt="" class="image" >
                            </div>                      

                             <div class="form-group">
                                <label>Start date</label>
                                 <input type="date" placeholder="image"  class="form-control" v-model="tmpDiscount.startdate">
                                <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            
                            </div>

                             <div class="form-group">
                                <label>End date</label>
                                 <input type="date"   class="form-control" v-model="tmpDiscount.enddate">
                                 <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            </div>
                            <div class="form-group">
                                <label>outstanding</label>
                                 <input type="number" class="form-control"  v-model="tmpDiscount.outstanding" >
                                <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Condition</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.conditions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                            </div>  

                             <div class="form-group">
                                <label>Restrictions</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.restrictions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>

                            </div>


                            <div class="form-group">
                                <label>Amount Approved</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.amountapproved">
                                <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            </div>
                            
                            <div class="form-group">
                                <label>Normal Price</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.normalprice">
                                <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Discountprice</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.discountprice">
                                <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.discountpercentage">
                                <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Category Discount</label>
                                  <select class="form-control" v-model="tmpDiscount.discountcategory_iddiscountcategory" >
                                      <option v-for="category in discountCategories" :value="category.iddiscountcategory">{{category.name}}</option>
                                  </select>
                                <span class="text-danger" v-if="!!errorsDiscount.discountcategory_iddiscountcategory"> {{errorsDiscount.discountcategory_iddiscountcategory[0]}} </span>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <b-btn  @click="showEdit=false">Close</b-btn>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Save Discount</button>
                        </div>
                    </div>
                </form>
        </b-modal>
        <!-- modal detalle -->
        <b-modal ref="detailtModal" title="Detail Discount" ok-only>
                <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="font-weight-bold">Title</label>
                                <p>{{tmpDiscount.title}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Description</label>
                                <p>{{tmpDiscount.description}}</p>
                            </div>                  

                            <div class="form-group">
                                <label class="font-weight-bold">image</label>
                                <p>
                                  <img :src="'images/discount/'+ tmpDiscount.image" alt="" class="image">
                                </p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Start date</label>
                                <p>{{tmpDiscount.startdate}}</p>
                            </div>

                             <div class="form-group">
                                <label class="font-weight-bold">End date</label>
                                <p>{{tmpDiscount.enddate}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">outstanding</label>
                                <p>{{tmpDiscount.outstanding}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Condition</label>
                                <p>{{tmpDiscount.conditions}}</p>

                            </div>  

                             <div class="form-group">
                                <label class="font-weight-bold">Restrictions</label>
                                <p>{{tmpDiscount.restrictions}}</p>

                            </div>


                            <div class="form-group" >
                                <label class="font-weight-bold">Amount Approved</label>
                                <p>{{tmpDiscount.amountapproved}}</p>
                            </div>
                            
                            <div class="form-group" >
                                <label class="font-weight-bold">Normal Price</label>
                                <p>{{tmpDiscount.normalprice}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Discountprice</label>
                                <p>{{tmpDiscount.discountprice}}</p>
                            </div>

                            <div class="form-group" >
                                <label class="font-weight-bold">Discount Percentage</label>
                                <p>{{tmpDiscount.discountpercentage}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Category Discount</label>
                                <p>{{tmpDiscount.discountcategory_iddiscountcategory}}</p>

                            </div>
                            
                        </div>
                    </div>
                </form>
        </b-modal>
  </div>
</template>
<script>
   import Create from './Create'
   import bModal from 'bootstrap-vue/es/components/modal/modal'
   import bModalDirective from 'bootstrap-vue/es/directives/modal/modal'
   import moment from 'moment'

   export default {
        name: "discount",
        components: { Create, 'b-modal': bModal},
        directives: {'b-modal': bModalDirective},
        data() {
            return {
               form: { 
                  // iddiscount: '', 
                  title: '', 
                  image: '', 
                  startdate: '', 
                  enddate: '', 
                  outstanding: '', 
                  conditions: '', 
                  restrictions: '', 
                  amountapproved: '', 
                  amountavailable: 0, 
                  amountredeemed: 0, 
                  normalprice: '', 
                  discountprice: '', 
                  discountpercentage: '', 
                  discountcategory_iddiscountcategory: '', 
                },
                errorsDiscount: {},
                discounts: {},
                tmpDiscount: {},
                showEdit: false,
                changeImage: false,
                discountCategories: [],
            }
        },

        mounted() {
            this.cargarDiscount();
        },
        created(){
          this.getDiscountCategories();
        },
        methods: {
            cargarDiscount() {
                // this.errorsProducto = {}
                // this.loadingProductos = true
                  axios.get('api/discount/')
                    .then((response) => {
                        // this.loadingProductos = false
                        this.discounts = response.data.data
                        // this.pagination = response.data.meta.pagination
                        // console.log(response.data.data);
                    })  
                    .catch((err) => {
    
                        console.log(err);
                    });
            },                        
            editDiscount(discount) {
                this.changeImage = false;
                this.errorsDiscount = {}
                this.tmpdDiscount = {}
                this.tmpDiscount = discount
                this.tmpDiscount.startdate = this.formatDate(this.tmpDiscount.startdate);
                this.tmpDiscount.enddate = this.formatDate(this.tmpDiscount.startdate);
                this.$refs.editModal.show()

            },  

            formatDate(value){
              return  moment(value).format('YYYY-MM-DD')
            },
   
            updatedDiscount() {
                this.errorsDiscount = {};

                axios.patch(`/api/discount/${this.tmpDiscount.iddiscount}`, this.tmpDiscount)
                    .then((response) => {
                        this.tmpDiscount = {}
                        this.cargarDiscount()
                        // this.loadingProductos = true
                        this.$refs.editModal.hide()
                        console.log(response)
                        swal({
                          title: "Actualizado",
                          text: "Registro actualizdo con exito",
                          icon: "success",
                        })

                    })
                   .catch(error => {
                      console.log(error.response)
                      this.errorsDiscount = error.response.data.errors;

                    });
            },

            detailsDiscount(discount) {
                // this.errorsProducto = {}
                this.tmpDiscount = {}
                this.tmpDiscount = discount
                this.$refs.detailtModal.show()

            },
            confirm(discount) {
                swal({
                  title: "Quieres Borrar el Registro?",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    this.deleteDiscount(discount)
                  }
                });
            },
            deleteDiscount(discount) {
                this.errorsProducto = {}
                axios.delete(`/api/discount/${discount.iddiscount}`)
                    .then((response) => {
                        swal({
                          title: "Eliminado",
                          text: "Registro eliminado con exito",
                          icon: "success",
                        })
                        setTimeout(() => this.cargarDiscount(), 1000)
                    })
                    .catch((err) => console.log(err))
            },
            getImage(e) {
              let image = e.target.files[0];
              let reader = new FileReader();

              reader.readAsDataURL(image);
              reader.onload = e => {
                this.tmpDiscount.image = e.target.result;
                this.changeImage = true;
              }
            },
            getDiscountCategories() {
            axios.get('api/discount-categories').then(data => {
                this.discountCategories = data.data.data;
              })
              .catch(err => console.log(err))
            },

        }
    }
</script>
<style>
  .image{
    width: 20%;
  }
</style>