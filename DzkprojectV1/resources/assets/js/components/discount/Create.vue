<template>
    <div>
        <b-modal v-model="show" id="createModal" ref="createtModal" title="Create Discount" hide-footer>
                <form @submit.prevent="saveDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group" :class="{ 'is-invalid' : errorsDiscount.title }">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="form.title" >
                                <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>
                            </div>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.description }">
                                <label>Description</label>
                                <input type="text" class="form-control" v-model="form.description">
                                <span class="text-danger" v-if="!!errorsDiscount.description"> {{errorsDiscount.description[0]}} </span>
                            </div>
                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.image }">
                                <label>Image</label>
                                <input type="file" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                                <span class="text-danger" v-if="!!errorsDiscount.costo_venta"> {{errorsDiscount.image[0]}} </span>                           
                                <img v-if="!!form.image" :src="form.image" class="avatar" alt="Image">                                  
                            </div>

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.startdate }">
                                <label>Start date</label>
                                 <input type="date" placeholder="image"  class="form-control" v-model="form.startdate">
                                 <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            
                            </div>

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.enddate }">
                                <label>End date</label>
                                <input type="date"   class="form-control" v-model="form.enddate">
                                <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            </div>
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.outstanding }">
                                <label>outstanding</label>
                                <input type="number" class="form-control"  v-model="form.outstanding" >
                                <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>
                            </div>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.conditions }">
                                <label>Condition</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.conditions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                            </div>  

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.restrictions }">
                                <label>Restrictions</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.restrictions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>

                            </div>


                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.amountapproved }">
                                <label>Amount Approved</label>
                                <input type="number" class="form-control" v-model="form.amountapproved">
                                <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            </div>
                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.normalprice }">
                                <label>Normal Price</label>
                                <input type="number" class="form-control" v-model="form.normalprice">
                                <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  
                            </div>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountprice }">
                                <label>Discountprice</label>
                                <input type="number" class="form-control" v-model="form.discountprice">
                                <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  
                            </div>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountpercentage }">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control" v-model="form.discountpercentage">
                                <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>
                            </div>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountcategory_iddiscountcategory }">
                                <label>Category Discount</label>
                                  <select class="form-control" v-model="form.discountcategory_iddiscountcategory" >
                                      <!-- <option v-for="option in cities" :value="option.id">{{option.name}}</option> -->
                                      <option value="1">1</option>
                                  </select>
                                <span class="text-danger" v-if="!!errorsDiscount.discountcategory_iddiscountcategory"> {{errorsDiscount.discountcategory_iddiscountcategory[0]}} </span>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <b-btn  @click="show=false">Close</b-btn>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Save Discount</button>
                        </div>
                    </div>
                </form>
        </b-modal> 
    </div>
</template>

<script>
   import bModal from 'bootstrap-vue/es/components/modal/modal'
   import bModalDirective from 'bootstrap-vue/es/directives/modal/modal'


    export default {
        name: "create",
        components: {'b-modal': bModal},
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
                url: '/discount',
                errorsDiscount: {},
                show: false,
            }
        },
        methods: {
            saveDiscount() {
                this.errorsDiscount = {}
                axios.post('api/discount/',this.form)
                .then(response => { 
                    this.form = {}
                    this.$parent.cargarDiscount()
                    this.$refs.createtModal.hide()
                    console.log('bien')
                    swal({
                      title: "Creado",
                      text: "Registro creado con exito",
                      icon: "success",
                    })
                })
                .catch(error => {
                    console.log(error.response.data)
                    this.errorsDiscount = error.response.data.errors;
                     // let errors = this.$laravelErrors.handle(error)
                     // this.errorsDiscount = errors.errors.errors
                     // console.log(this.errorsDiscount)

                });
            },         
            getImage(e) {
              let image = e.target.files[0];
              let reader = new FileReader();

              reader.readAsDataURL(image);
              reader.onload = e => {
                this.form.image = e.target.result;
              }
            },

        }

    }
</script>

<style>
  .avatar{
    width: 20%;
  }
</style>