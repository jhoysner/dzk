<template>
    <div>
        <b-modal v-model="show" id="createModal" ref="createtModal" title="Creatr Descuento" hide-footer>
                <form @submit.prevent="saveDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" class="form-control" v-model="form.title" >
                                <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" class="form-control" v-model="form.description">
                                <span class="text-danger" v-if="!!errorsDiscount.description"> {{errorsDiscount.description[0]}} </span>
                            </div>
                            
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" placeholder="Imagen corporativa" @change="getImage" accept="image/*" class="common-input">
                                <span class="text-danger" v-if="!!errorsDiscount.costo_venta"> {{errorsDiscount.image[0]}} </span>                           
                                <img v-if="!!form.image" :src="form.image" class="avatar" alt="Image">                                  
                            </div>

                             <div class="form-group">
                                <label>Inicio</label>
                                 <input type="date" placeholder="image"  class="form-control"  v-model="form.startdate" @change="handleChangeInicio($event)">
                                 <p class="text-danger">{{errorInicio}}</p>
                                 <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            
                            </div>

                             <div class="form-group">
                                <label>Fin</label>
                                <input type="date"   class="form-control" v-model="form.enddate"  @change="handleChangeFin($event)">
                                <p class="text-danger">{{errorFin}}</p>
                                <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            </div>
                            <div class="form-group">
                                <label>Destacado</label>
                                <!-- <input type="number" class="form-control"  v-model="form.outstanding" > -->
                                <toggle-button :value="form.outstanding" v-model="form.outstanding" :sync="true"/>
                                <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Condiciones</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.conditions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                            </div>  

                             <div class="form-group">
                                <label>Restrcciones</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="form.restrictions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>

                            </div>


                            <div class="form-group">
                                <label>Cantidad Aprobada</label>
                                <input type="number" class="form-control" v-model="form.amountapproved">
                                <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            </div>
                            
                            <div class="form-group">
                                <label>Precio Normal</label>
                                <input type="number" step='0.01' value='0.00' placeholder='0.00'  class="form-control" v-model="form.normalprice">
                                <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Precio Descuento</label>
                                <input type="number" step='0.01' value='0.00' placeholder='0.00'  class="form-control" v-model="form.discountprice"  @change="handleChangePrecioDescuento($event)">
                                <p class="text-danger">{{errorpreciodescuento}}</p>
                                <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Porcentaje Descuento</label>
                                <input type="number"  step='0.01' value='0.00' placeholder='0.00'  class="form-control" v-model="form.discountpercentage"  @change="handleChangePorcentaje($event)">
                                <p class="text-danger">{{errorporcentaje}}</p>

                                <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Categoria Descuento</label>
                                  <select class="form-control" v-model="form.discountcategory_iddiscountcategory" >
                                      <option v-for="category in discountCategories" :value="category.iddiscountcategory">{{category.name}}</option>
                                  </select>
                                <span class="text-danger" v-if="!!errorsDiscount.discountcategory_iddiscountcategory"> {{errorsDiscount.discountcategory_iddiscountcategory[0]}} </span>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <b-btn  @click="show=false">Cerrar</b-btn>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guardar Descuento</button>
                        </div>
                    </div>
                </form>
        </b-modal> 
        <branch-discount></branch-discount>
    </div>
</template>

<script>
   import branchdiscount from './BranchDiscount'
   import Bus from '../../utilities/EventBus';
   import moment from 'moment'

    export default {
        name: "create",
        components: { 'branch-discount':branchdiscount},
        data() {
            return {
                form: { 
                  title: '', 
                  image: '', 
                  startdate: '', 
                  enddate: '', 
                  outstanding: false, 
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
                discountCategories: [],
                errorInicio: '',
                errorFin: '',
                errorpreciodescuento: '',
                errorporcentaje: '',


            }
        },
        created(){
          this.getDiscountCategories();
        },
        methods: {
            saveDiscount() {
                this.errorsDiscount = {}
                this.errorInicio= ''
                this.errorFin= ''
                axios.post('api/discount',this.form)
                .then(response => { 
                    this.form = {}            
                    this.form.outstanding = false
                    this.form.amountavailable= 0 
                    this.form.amountredeemed= 0

                    this.$parent.cargarDiscount()
                    $('#createModal').trigger("reset");
                    this.$refs.createtModal.hide()
                    console.log('bien')
                    swal({
                      title: "Creado",
                      text: "Registro creado con exito",
                      icon: "success",
                    })
                    Bus.$emit('branch_discount',response);
                })
                .catch(error => {
                    console.log(error.response.data)
                    this.errorsDiscount = error.response.data.errors;

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
            getDiscountCategories() {
            axios.get('api/discount-categories').then(data => {
                this.discountCategories = data.data.data;
              })
              .catch(err => console.log(err))
            },
            handleChangeInicio(e){
              this.errorInicio= ''
               var inicio = e.target.value
               var now =  moment(new Date()).format('YYYY-MM-DD')

               if( inicio >= now ){
                  this.form.startdate = inicio
               }

              else{
                this.form.startdate = ''
                this.errorInicio = "La fecha debe ser mayor al dia actual"
              }
            },              
            handleChangeFin(e){
              this.errorfin= ''
               var fin = e.target.value
               var now =  moment(new Date()).format('YYYY-MM-DD')
               if(this.form.startdate == ''){
                  this.form.enddate = ''
                  this.errorFin = "Debes introducir primero la fecha de inicio."
                  return
               }
               if( fin >= this.form.startdate){
                  this.form.enddate = fin
               }
               else{
                  this.form.enddate = ''
                  this.errorFin = "La fecha debe ser maryor a la fecha inicio."
               }
            },       

            handleChangePorcentaje(e){
              this.errorpreciodescuento = ''
              this.errorporcentaje = ''

               if(this.form.normalprice == ''){
                  this.form.discountpercentage = ''
                  this.errorporcentaje = "Debes introducir primero el precio normal."
                  return
               }

              var precio = this.form.normalprice

               var result = precio*this.form.discountpercentage/100
              
               console.log(result) 

               this.form.discountprice = precio-result;
              
            },              
            handleChangePrecioDescuento(e){
              this.errorpreciodescuento = ''
              this.errorporcentaje = ''

              if(this.form.normalprice == ''){
                  this.form.discountprice = ''
                  this.errorpreciodescuento = "Debes introducir primero el precio normal."
                  return
              }

              var precio = this.form.normalprice

              var result = this.form.discountprice*100/precio
              
              this.form.discountpercentage =result;
              
            },  

        }

    }
</script>

<style>
  .avatar{
    width: 20%;
  }
</style>