<template>
  <div>
      <div class="col-lg-12">
          <div>
<!--               <router-link :to="{name: 'discount.create'}" class="btn btn-success mb-4">Create Discount</router-link>
 -->              
                    <a class="btn btn-success mb-4" data-toggle="modal" href='#modal-agregar-discount'>
                       ADD DISCOUNT
                    </a>
                  <div class="settings-content">
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
                                      <th class="text-center">image</th>
                                      <th class="text-center">startdate</th>
                                      <th class="text-center">enddate</th>
                                      <th class="text-center">Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="discount in discounts">
                                      <td>{{ discount.iddiscount}}</td>
                                      <td>{{ discount.title }}</td>
                                      <td class="text-center">{{ discount.description }}</td>
                                      <td class="text-center">{{ discount.image }}</td>
                                      <td class="text-center">{{ discount.startdate }}</td>
                                      <td class="text-center">{{ discount.enddate }}</td>
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
        <div class="modal fade" id="modal-edit-discount">
            <div class="modal-dialog">
                <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Edit Discount {{tmpDiscount.iddiscount}}</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.title }">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="tmpDiscount.title" autofocus="">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.description }">
                                <label>Description</label>
                                <input type="text" class="form-control" v-model="tmpDiscount.description">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.description"> {{errorsDiscount.description[0]}} </span>
<!-- 
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.image }">
                                <label>Image</label>
                                 <input type="file" placeholder="image"  class="form-control" v-model="tmpDiscount.image">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.costo_venta"> {{errorsDiscount.image[0]}} </span> -->                           

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.startdate }">
                                <label>Start date</label>
                                 <input type="date" placeholder="image"  class="form-control" v-model="tmpDiscount.startdate">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.enddate }">
                                <label>End date</label>
                                 <input type="date"   class="form-control" v-model="tmpDiscount.enddate">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.outstanding }">
                                <label>outstanding</label>
                                 <input type="number" class="form-control"  v-model="tmpDiscount.outstanding" >
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.conditions }">
                                <label>Condition</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.conditions"></textarea>

                            </div>  
                            <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.restrictions }">
                                <label>Restrictions</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.restrictions"></textarea>

                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>


                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.amountapproved }">
                                <label>Amount Approved</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.amountapproved">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.normalprice }">
                                <label>Normal Price</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.normalprice">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountprice }">
                                <label>Discountprice</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.discountprice">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountpercentage }">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.discountpercentage">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountcategory_iddiscountcategory }">
                                <label>Category Discount</label>
                                  <select class="form-control" v-model="tmpDiscount.discountcategory_iddiscountcategory" >
                                      <!-- <option v-for="option in cities" :value="option.id">{{option.name}}</option> -->
                                      <option value="1">1</option>
                                  </select>
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.discountcategory_iddiscountcategory"> {{errorsDiscount.discountcategory_iddiscountcategory[0]}} </span>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Save Discount</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- modal detalle -->
        <div class="modal fade" id="modal-detail-discount">
            <div class="modal-dialog">
                <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Detail Discount {{tmpDiscount.iddiscount}}</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="font-weight-bold">Title</label>
                                <p>{{tmpDiscount.title}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Description</label>
                                <p>{{tmpDiscount.description}}</p>
                            </div>
                          <!-- 
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.image }">
                                <label>Image</label>
                                 <input type="file" placeholder="image"  class="form-control" v-model="tmpDiscount.image">
                            </div>
                            -->                           

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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</template>
<script>
   import Create from './Create'

   export default {
        name: "discount",
        components: { Create},
        data() {
            return {
               form: { 
                  // iddiscount: '', 
                  title: '', 
                  image: 'ddsa', 
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
            }
        },

        mounted() {
            this.cargarDiscount();
        },

        watch: {
            query() {
                this.cargarDiscount()
            }
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
                        // this.loadingProductos = false
                        // let errors = this.$laravelErrors.handle(err)
                        // this.errorsProducto = errors.errors
                        console.log(err);
                    });
            },            
            editDiscount(discount) {
                // this.errorsProducto = {}
                this.tmpdDiscount = {}
                this.tmpDiscount = discount
                this.tmpDiscount.enddate =''
                this.tmpDiscount.startdate =''
                window.$("#modal-edit-discount").modal("show")
            },
            updatedDiscount() {
                this.errorsProducto = {};
                axios.patch(`/api/discount/${this.tmpDiscount.iddiscount}`, this.tmpDiscount)
                    .then((response) => {
                        this.tmpDiscount = {}
                        // this.loadingProductos = true
                        this.cargarDiscount()
                        $('#modal-edit-discount').remove()
                        $('.modal-backdrop').remove();
                        $(document.body).removeClass("modal-open");
                    })
                   .catch(error => {
                        console.log(error.response)
                    });
            },

            detailsDiscount(discount) {
                // this.errorsProducto = {}
                this.tmpDiscount = {}
                this.tmpDiscount = discount
                window.$("#modal-detail-discount").modal("show")
            },

        }
    }
</script>