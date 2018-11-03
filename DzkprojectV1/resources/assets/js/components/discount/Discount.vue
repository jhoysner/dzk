<template>
  <div>
      <div class="col-lg-12">
          <div>
                  <b-btn v-b-modal.createModal v-can="'add_discounts'">Crear Descuento</b-btn>

                  <div class="settings-content mt-4">
                  <h4>LISTA DE DESCUENTOS</h4>
                <!-- <spinner :show="loadingProductos"></spinner> -->
                  <div class="responsive">
                      <div class="table-responsive">
                          <table class="table table-hover table-bordered table-striped table-condensed">
                              <thead>
                                  <tr>
                                      <th class="text-center">Titulo</th>
                                      <th class="text-center">Descripcion</th>
                                      <th class="text-center">Inicio</th>
                                      <th class="text-center">Fin</th>
                                      <th class="text-center">Destacado</th>
                                      <th class="text-center">Opcciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="discount in discounts">
                                      <td>{{ discount.title }}</td>
                                      <td class="text-center">{{ discount.description }}</td>
                                      <td class="text-center">{{ discount.startdate }}</td>
                                      <td class="text-center">{{ discount.enddate }}</td>
                                      <td class="text-center">
                                      {{ discount.outstanding ? "Si" : "No" }}
                                      </td>
                                      <td class="text-right">
                                          <button type="button" @click="detailsDiscount(discount)" class="btn btn-sm  btn-default"> Detalles</button>
 
                                          <button type="button" v-can="'edit_discounts'" @click="editDiscount(discount)" class="btn  btn-sm  btn-info"> Editar</button>
                                      

                                          <button type="button" v-can="'delete_discounts'" @click="confirm(discount)" class="btn btn-sm  btn-danger">Eliminar</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                </div>
              </div>
          </div>
      </div>
      <create></create> 
      <!-- modal edit -->
        <b-modal v-model="showEdit" id="editModal" ref="editModal" title="Editar Descuento"  @hidden="onHidden" hide-footer>
            <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Titutlo</label>
                                <input type="text" class="form-control" v-model="tmpDiscount.title" autofocus="">
                                <span class="text-danger" v-if="!!errorsDiscount.title"> {{errorsDiscount.title[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Descripcion</label>
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
                                <label>Inicio</label>
                                 <input type="date" placeholder="image"  class="form-control" v-model="tmpDiscount.startdate" @change="handleChangeInicio($event)">
                                <p class="text-danger">{{errorInicio}}</p>
                                <span class="text-danger" v-if="!!errorsDiscount.startdate"> {{errorsDiscount.startdate[0]}} </span>                            
                            </div>

                             <div class="form-group">
                                <label>Fin</label>
                                 <input type="date"   class="form-control" v-model="tmpDiscount.enddate" @change="handleChangeFin($event)">
                                 <p class="text-danger">{{errorFin}}</p>
                                 <span class="text-danger" v-if="!!errorsDiscount.enddate"> {{errorsDiscount.enddate[0]}} </span>                            
                            </div>
                            <div class="form-group">
                                <label>Destacado</label>
                                 <!-- <input type="number" class="form-control"  v-model="tmpDiscount.outstanding" > -->
                                 <toggle-button :value="tmpDiscount.outstanding" v-model="tmpDiscount.outstanding" :sync="true"/>
                                <span class="text-danger" v-if="!!errorsDiscount.outstanding"> {{errorsDiscount.outstanding[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Condiciones</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.conditions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.conditions"> {{errorsDiscount.conditions[0]}} </span>

                            </div>  

                             <div class="form-group">
                                <label>Restricciones</label>
                                <textarea name="" id="" cols="30" rows="4" class="common-input"  v-model="tmpDiscount.restrictions"></textarea>
                                <span class="text-danger" v-if="!!errorsDiscount.restrictions"> {{errorsDiscount.restrictions[0]}} </span>

                            </div>


                            <div class="form-group">
                                <label>Cantidad Aprobada</label>
                                <input type="number" class="form-control" v-model="tmpDiscount.amountapproved">
                                <span class="text-danger" v-if="!!errorsDiscount.amountapproved"> {{errorsDiscount.amountapproved[0]}} </span>  
                            </div>
                            
                            <div class="form-group">
                                <label>Normal Precio</label>
                                <input type="number"  step='0.01' class="form-control" v-model="tmpDiscount.normalprice">
                                <span class="text-danger" v-if="!!errorsDiscount.normalprice"> {{errorsDiscount.normalprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Precio Descuento</label>
                                <input type="number"  step='0.01' class="form-control" v-model="tmpDiscount.discountprice" @change="handleChangePrecioDescuento($event)">
                                <span class="text-danger" v-if="!!errorsDiscount.discountprice"> {{errorsDiscount.discountprice[0]}} </span>  
                            </div>

                            <div class="form-group">
                                <label>Porcentaje Descuento</label>
                                <input type="number"  step='0.01' class="form-control" v-model="tmpDiscount.discountpercentage" @change="handleChangePorcentaje($event)">
                                <span class="text-danger" v-if="!!errorsDiscount.discountpercentage"> {{errorsDiscount.discountpercentage[0]}} </span>
                            </div>

                            <div class="form-group">
                                <label>Categoria Descuento</label>
                                  <select class="form-control" v-model="tmpDiscount.discountcategory_iddiscountcategory" >
                                      <option v-for="category in discountCategories" :value="category.iddiscountcategory">{{category.name}}</option>
                                  </select>
                                <span class="text-danger" v-if="!!errorsDiscount.discountcategory_iddiscountcategory"> {{errorsDiscount.discountcategory_iddiscountcategory[0]}} </span>
                            </div>
                            <hr>
                             <button type="button" class="btn btn-default btn-sm my-4" @click="addBranchDiscount(tmpDiscount)">Agregar Sucursal</button>                        

                             <div v-if="descuentosucursal.length > 0">
                                <div class="table-responsive">
                                      <table class="table table-hover table-bordered table-striped table-condensed">
                                          <thead>
                                              <tr>
                                                  <th class="text-center">Sucursal</th>
                                                  <th class="text-center">Horaria</th>
                                                  <th class="text-center">Cantida</th>
                                                  <th class="text-center">Disponible</th>
                                                  <th class="text-center">Redimido</th>
                                                  <th class="text-center">Options</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr v-for="deescueentsucu in descuentosucursal">
                                                  <!-- <td>{{ deescueentsucu}}</td> -->
                                                  <td>{{ deescueentsucu.name}}</td>
                                                  <td>{{ deescueentsucu.pivot.discounthours}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountapproved}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountavailable}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountredeemed}}</td>
                                                  <td>
                                                      <button type="button" @click="editBranchDiscount(deescueentsucu)" class="btn  btn-sm  btn-info"> Editar</button>
                                                      <button type="button" @click="confirmBranchDiscount(deescueentsucu)" class="btn btn-sm  btn-danger">Eliminar</button>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                </div>
                             </div>
                            <div class="form-group">
                              <label>Tags</label>
                              <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="Buscar o Agregar tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" @tag="addTag"></multiselect>
                              <p><small class="text-danger" v-if="tagError != '' ">{{ tagError }}</small></p>
                            </div> 
                            
                        </div>
                        <div class="modal-footer">
                            <b-btn @click="showEdit=false">Cerrar</b-btn>
                            <button type="submit" v-can="'edit_discounts'" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Actualizar Descuento</button>
                        </div>
                    </div>
                </form>
        </b-modal>
        <!-- modal detalle -->
        <b-modal ref="detailtModal" title="Detalle Descuento" ok-only>
                <form  @submit.prevent="updatedDiscount">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="font-weight-bold">Titutlo</label>
                                <p>{{tmpDiscount.title}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Descripccion</label>
                                <p>{{tmpDiscount.description}}</p>
                            </div>                  

                            <div class="form-group">
                                <label class="font-weight-bold">Image</label>
                                <p>
                                  <img :src="'images/discount/'+ tmpDiscount.image" alt="" class="image">
                                </p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Inicio</label>
                                <p>{{tmpDiscount.startdate}}</p>
                            </div>

                             <div class="form-group">
                                <label class="font-weight-bold">Fin</label>
                                <p>{{tmpDiscount.enddate}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Destacado</label>
                                <p>{{ tmpDiscount.outstanding ? "Si" : "No" }}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Condicion</label>
                                <p>{{tmpDiscount.conditions}}</p>

                            </div>  

                             <div class="form-group">
                                <label class="font-weight-bold">Restricciones</label>
                                <p>{{tmpDiscount.restrictions}}</p>

                            </div>


                            <div class="form-group" >
                                <label class="font-weight-bold">Cantidad Aprobada</label>
                                <p>{{tmpDiscount.amountapproved}}</p>
                            </div>
                            
                            <div class="form-group" >
                                <label class="font-weight-bold">Normal Precio</label>
                                <p>{{tmpDiscount.normalprice}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Precio Descuento</label>
                                <p>{{tmpDiscount.discountprice}}</p>
                            </div>

                            <div class="form-group" >
                                <label class="font-weight-bold">Porcetaje Descuento</label>
                                <p>{{tmpDiscount.discountpercentage}}</p>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Categoria Descuento</label>
                                <p>{{tmpDiscount.discountcategory_iddiscountcategory}}</p>

                            </div>
                             
                             <div v-if="descuentosucursal.length > 0">
                              <hr>
                                <div class="table-responsive">
                                      <table class="table table-hover table-bordered table-striped table-condensed">
                                          <thead>
                                              <tr>
                                                  <th class="text-center">Sucursal</th>
                                                  <th class="text-center">Horaria</th>
                                                  <th class="text-center">Cantida</th>
                                                  <th class="text-center">Disponible</th>
                                                  <th class="text-center">Redimido</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr v-for="deescueentsucu in descuentosucursal">
                                                  <td>{{ deescueentsucu.name}}</td>
                                                  <td>{{ deescueentsucu.pivot.discounthours}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountapproved}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountavailable}}</td>
                                                  <td>{{ deescueentsucu.pivot.amountredeemed}}</td>
                                              </tr>
                                          </tbody>
                                      </table>
                                </div>

                             </div>
                             <div class="form-group">
                              <label class="font-weight-bold">Tags</label>
                              <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="No tiene Tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :disabled="true"></multiselect>
                            </div> 

                        </div>
                    </div>
                </form>
        </b-modal>

        <!-- branchsdiscount -->
        <b-modal v-model="show" id="branchDiscountEditModal" ref="branchDiscountEditModal" title="Editar Sucursales Descuentos" hide-footer>
                <form @submit.prevent="updateBranchDiscount" id="formBranchDiscount">
                      <div class="modal-content">
                        <div class="container">
                              
                            <h3>Sucursal: {{sucursalName}} </h3>   
 
                            <div>
                              <div class="form-group mt-4">
                                  <label>Unidades</label>
                                  <input type="text" class="form-control" v-model="form.amountapproved">
                              </div>
                              
                              <div class="form-group mt-4">
                                  <label>Horario</label>
                                  <input type="text" class="form-control" v-model="form.discounthours">
                              </div>
                            </div>
                            
                        </div>
                      </div>
                        <div class="modal-footer">
                            <b-btn @click="show=false">Cerrar</b-btn>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Guradar Sucursal Descuento</button>
                        </div>
                </form>
        </b-modal> 

  </div>
</template>
<script>
   import Bus from '../../utilities/EventBus';
   import Create from './Create'
   import bModal from 'bootstrap-vue/es/components/modal/modal'
   import moment from 'moment'

   export default {
        components: { Create, 'b-modal': bModal},
        data() {
            return {
                errorsDiscount: {},
                discounts: {},
                tmpDiscount: {},
                showEdit: false,
                show: false,
                changeImage: false,
                sucursalName: '',
                discountCategories: [],
                descuentosucursal: [],
                errorpreciodescuento: '',
                errorporcentaje: '',
                errorInicio: '',
                errorFin: '',
                form: {
                  discounthours: '',
                  amountapproved: '',
                  discount_iddiscount: '',
                  idbranch_has_discount:'',
                  branch_idbranch: ''
                }, 
                options: [],
                value: [],               
                discountTagNum : null,
                tagError: '',
 
 
            }
        },

        mounted() {
            this.cargarDiscount();
        },
        created(){
          this.getDiscountCategories();
          this.getTags()
        },
        methods: {
            addBranchDiscount(response){
                // console.log(response)
                Bus.$emit('branch_discount_add',response);
            },
            //Guarda tag
            addTag (newTag) {
              const tag = {
                name: this.validName(newTag),
                code: this.randomString(36)
              }

              this.value.push(tag)
              this.options.push(tag)

              axios.post('api/tags', tag).then(response =>{
                //console.log(response)
              })
            },
            //Muestra Listado de Tag
            getTags() {
               axios.get('api/tags').then(response => {
                this.options = []
                this.options = response.data.tags
                this.options.forEach(function(item) {
                  item.code = item.idtags
                })
              })
              .catch(err => console.log(err))
            },
            cargarDiscount() {
                  axios.get('api/discount/')
                    .then((response) => {
                        this.discounts = response.data.data
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
                this.tmpDiscount.outstanding = discount.outstanding == 0 ? false : true ;
                this.getBranchDiscount(this.tmpDiscount.iddiscount)
                this.getTagsNum()
                this.$refs.editModal.show()

            },             
            editBranchDiscount(data) {

                axios.get('api/branch-discount-update/'+data.pivot.discount_iddiscount+'/'+data.pivot.idbranch_has_discount)
                  .then((response) => {
                      // console.log(response.data.data.pivot)
                      this.sucursalName = response.data.data.name
                      this.form.discounthours = response.data.data.pivot.discounthours
                      this.form.amountapproved = response.data.data.pivot.amountapproved
                      this.form.branch_idbranch = response.data.data.pivot.branch_idbranch
                      this.form.idbranch_has_discount = response.data.data.pivot.idbranch_has_discount
                      this.form.discount_iddiscount = response.data.data.pivot.discount_iddiscount
                  })  
                  .catch((err) => {
  
                      console.log(err);
                });
                this.$refs.branchDiscountEditModal.show()
            },  

            formatDate(value){
              return  moment(value).format('YYYY-MM-DD')
            },
   
            updatedDiscount() {
                this.errorsDiscount = {};
                this.tagError = '';

                if(this.value.length > this.discountTagNum ) {
                  this.tagError = 'El numero permitido de tags son: ' + this.discountTagNum + '.'; //enviamos el error,
                  return false;
                }

                this.tmpDiscount.tags = this.value

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
            updateBranchDiscount() {
                axios.patch(`/api/branch-discount-update/${this.form.discount_iddiscount}/${this.form.idbranch_has_discount}`,this.form)
                    .then((response) => {
                        this.form = {}
                        this.$refs.branchDiscountEditModal.hide()
                        swal({
                          title: "Actualizado",
                          text: "Registro actualizdo con exito",
                          icon: "success",
                        })

                    })
                   .catch(error => 
                      console.log(error.response)

                    );
            },

            detailsDiscount(discount) {
                this.tmpDiscount = {}
                this.tmpDiscount = discount
                this.tmpDiscount.outstanding = discount.outstanding == 0 ? false : true ;
                this.getBranchDiscount(discount.iddiscount)
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
            confirmBranchDiscount(deescueentsucu) {
                this.$refs.editModal.hide()
                swal({
                  title: "Quieres Borrar el Registro?",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    this.deleteBranchDiscount(deescueentsucu)
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
            deleteBranchDiscount(deescueentsucu) {
                this.errorsProducto = {}
                axios.delete(`/api/branch-discount-update/${deescueentsucu.pivot.discount_iddiscount}/${deescueentsucu.pivot.idbranch_has_discount}`)
                    .then((response) => {
                        swal({
                          title: "Eliminado",
                          text: "Registro eliminado con exito",
                          icon: "success",
                        })
                        console.log(response)
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
            handleChangePorcentaje(e){
              this.errorpreciodescuento = ''
              this.errorporcentaje = ''

               if(this.tmpDiscount.normalprice == ''){
                  this.tmpDiscount.discountpercentage = ''
                  this.errorporcentaje = "Debes introducir primero el precio normal."
                  return
               }

              var precio = this.tmpDiscount.normalprice

               var result = precio*this.tmpDiscount.discountpercentage/100
              
               console.log(result) 

               this.tmpDiscount.discountprice = precio-result;
              
            },              
            handleChangePrecioDescuento(e){
              this.errorpreciodescuento = ''
              this.errorporcentaje = ''

              if(this.tmpDiscount.normalprice == ''){
                  this.tmpDiscount.discountprice = ''
                  this.errorpreciodescuento = "Debes introducir primero el precio normal."
                  return
              }

              var precio = this.tmpDiscount.normalprice
              
              var result =  100*this.tmpDiscount.discountprice/this.tmpDiscount.normalprice
              
              this.tmpDiscount.discountpercentage = 100-result;
              
            },              
            getBranchDiscount(value){
                axios.get('api/branch-discount/'+value)
                  .then((response) => {
                      this.descuentosucursal = response.data.data
                  })  
                  .catch((err) => {
  
                      console.log(err);
                });
              
            },  
            handleChangeInicio(e){
              this.errorInicio= ''
               var inicio = e.target.value
               var now =  moment(new Date()).format('YYYY-MM-DD')

               if( inicio >= now ){
                  this.tmpDiscount.startdate = inicio
               }

              else{
                this.tmpDiscount.startdate = ''
                this.errorInicio = "La fecha debe ser mayor al dia actual"
              }
            },              
            handleChangeFin(e){
              this.errorFin= ''
               var fin = e.target.value
               var now =  moment(new Date()).format('YYYY-MM-DD')
               if(this.tmpDiscount.startdate == ''){
                  this.tmpDiscount.enddate = ''
                  this.errorFin = "Debes introducir primero la fecha de inicio."
                  return
               }
               if( fin >= this.tmpDiscount.startdate){
                  this.tmpDiscount.enddate = fin
               }
               else{
                  this.tmpDiscount.enddate = ''
                  this.errorFin = "La fecha debe ser maryor a la fecha inicio."
               }
            },       
            
            getTagsNum() {
              axios.get('api/tag-num').then(data => {
                let value = data.data[0].val;
                let val = JSON.parse(value);

                this.discountTagNum = val.discount;

              })
              .catch(err => console.log(err))

            },
            randomString(len, an){
              an = an&&an.toLowerCase();
              var str="", i=0, min=an=="a"?10:0, max=an=="n"?10:62;
              for(;i++<len;){
                var r = Math.random()*(max-min)+min <<0;
                str += String.fromCharCode(r+=r>9?r<36?55:61:48);
              }
              return str;
            },
            validName(cadena) {
              let specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
              
              //Elimina los caracteres
              for (let i = 0; i < specialChars.length; i++) {
                cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
              }
              //conviente a minuscula
              cadena = cadena.toLowerCase();
              
              //eliminamso acentos y ñ
              cadena = cadena.replace(/á/gi,"a");
              cadena = cadena.replace(/é/gi,"e");
              cadena = cadena.replace(/í/gi,"i");
              cadena = cadena.replace(/ó/gi,"o");
              cadena = cadena.replace(/ú/gi,"u");
              cadena = cadena.replace(/ñ/gi,"n");
              
              return cadena
            },
            onHidden (evt) {
              // Return focus to our Open Modal button
              // See accessibility below for additional return-focus methods
              // this.$refs.btnShow.$el.focus()
              this.cargarDiscount();
            }

        }
    }
</script>
<style>
  .image{
    width: 20%;
  }
</style>