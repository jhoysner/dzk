<template>
    <div>
        <div class="modal fade" id="modal-agregar-producto">
            <div class="modal-dialog">
                <form @submit.prevent="saveDiscount">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> ADD DISCOUNT</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.iddiscount }">
                                <label>Id</label>
                                <input type="text" class="form-control" v-model="form.iddiscount" autofocus>
            
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.iddiscount"> {{errorsDiscount.iddiscount[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.title }">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="form.title">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.description }">
                                <label>Description</label>
                                <input type="text" class="form-control" v-model="form.description">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.description"> {{errorsDiscount.description[0]}} </span>
<!-- 
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.image }">
                                <label>Image</label>
                                 <input type="file" placeholder="image"  class="form-control" v-model="form.image">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.costo_venta"> {{errorsDiscount.image[0]}} </span> -->                           

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.startdate }">
                                <label>Start date</label>
                                 <input type="date" placeholder="image"  class="form-control" v-model="form.startdate">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.enddate }">
                                <label>End date</label>
                                 <input type="date"   class="form-control" v-model="form.enddate">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.outstanding }">
                                <label>outstanding</label>
                                 <input type="number" class="form-control"  v-model="form.startdate" >
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.conditions }">
                                <label>Condition</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.conditions"></textarea>

                            </div>  
                            <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                             <div class="form-group" :class="{ 'has-danger' : errorsDiscount.restrictions }">
                                <label>Restrictions</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.restrictions"></textarea>

                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>


                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.amountapproved }">
                                <label>Amount Approved</label>
                                <input type="number" class="form-control" v-model="form.amountapproved">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            
                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.normalprice }">
                                <label>Normal Price</label>
                                <input type="number" class="form-control" v-model="form.normalprice">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountprice }">
                                <label>Discountprice</label>
                                <input type="number" class="form-control" v-model="form.discountprice">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountpercentage }">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control" v-model="form.discountpercentage">
                            </div>
                            <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>

                            <div class="form-group" :class="{ 'has-danger' : errorsDiscount.discountcategory_iddiscountcategory }">
                                <label>Category Discount</label>
                                  <select class="form-control" v-model="form.discountcategory_iddiscountcategory" >
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
    </div>
</template>

<script>
    export default {
        name: "create",
        data() {
            return {
                form: { 
                  iddiscount: '', 
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
                },
                errorsDiscount: {},
            }
        },
        methods: {
            saveDiscount() {
              
              console.log(this.form);
            },

        }

    }
</script>