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
                            
                            <div class="form-group">
                              <label>Tags</label>
                              <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="Buscar o Agregar tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :searchable="true" tag-position="bottom" @tag="addTag"></multiselect>
                              <p><small class="text-danger" v-if="tagError != '' ">{{ tagError }}</small></p>
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
                options: [],
                value: [],
                discountTagNum : null,
                tagError: '',

            }
        },
        created(){
          this.getDiscountCategories();
          this.getTags();
          this.getTagsNum();
        },
        methods: {
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
            saveDiscount() {
                this.errorsDiscount = {}
                this.errorInicio= ''
                this.errorFin= ''

                if(this.value.length > this.discountTagNum ) {
                  this.tagError = 'El numero permitido de tags son: ' + this.discountTagNum + '.'; //enviamos el error,
                  return false;
                }


                this.form.tags = this.value

                axios.post('api/discount',this.form)
                .then(response => { 
                    this.form = {}            
                    this.form.outstanding = false
                    this.form.amountavailable= 0 
                    this.form.amountredeemed= 0
                    this.value = []

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
              
               // console.log(result) 

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

              var result =  100*this.form.discountprice/this.form.normalprice
              
              this.form.discountpercentage = 100-result;
            
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
            }

        }

    }
</script>

<style>
  .avatar{
    width: 20%;
  }

  fieldset[disabled] .multiselect {
  pointer-events: none;
}
.multiselect__spinner {
  position: absolute;
  right: 1px;
  top: 1px;
  width: 48px;
  height: 35px;
  background: #fff;
  display: block;
}
.multiselect__spinner:before,
.multiselect__spinner:after {
  position: absolute;
  content: "";
  top: 50%;
  left: 50%;
  margin: -8px 0 0 -8px;
  width: 16px;
  height: 16px;
  border-radius: 100%;
  border-color: #41B883 transparent transparent;
  border-style: solid;
  border-width: 2px;
  box-shadow: 0 0 0 1px transparent;
}
.multiselect__spinner:before {
  animation: spinning 2.4s cubic-bezier(0.41, 0.26, 0.2, 0.62);
  animation-iteration-count: infinite;
}
.multiselect__spinner:after {
  animation: spinning 2.4s cubic-bezier(0.51, 0.09, 0.21, 0.8);
  animation-iteration-count: infinite;
}
.multiselect__loading-enter-active,
.multiselect__loading-leave-active {
  transition: opacity 0.4s ease-in-out;
  opacity: 1;
}
.multiselect__loading-enter,
.multiselect__loading-leave-active {
  opacity: 0;
}
.multiselect,
.multiselect__input,
.multiselect__single {
  font-family: inherit;
  font-size: 14px;
  touch-action: manipulation;
}
.multiselect {
  box-sizing: content-box;
  display: block;
  position: relative;
  width: 100%;
  min-height: 40px;
  text-align: left;
  color: #35495E;
}
.multiselect * {
  box-sizing: border-box;
}
.multiselect:focus {
  outline: none;
}
.multiselect--disabled {
  pointer-events: none;
  opacity: 0.6;
}
.multiselect--active {
  z-index: 50;
}
.multiselect--active:not(.multiselect--above) .multiselect__current,
.multiselect--active:not(.multiselect--above) .multiselect__input,
.multiselect--active:not(.multiselect--above) .multiselect__tags {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.multiselect--active .multiselect__select {
  transform: rotateZ(180deg);
}
.multiselect--above.multiselect--active .multiselect__current,
.multiselect--above.multiselect--active .multiselect__input,
.multiselect--above.multiselect--active .multiselect__tags {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.multiselect__input,
.multiselect__single {
  position: relative;
  display: inline-block;
  min-height: 20px;
  line-height: 20px;
  border: none;
  border-radius: 5px;
  background: #fff;
  padding: 1px 0 0 5px;
  width: calc(100%);
  transition: border 0.1s ease;
  box-sizing: border-box;
  margin-bottom: 8px;
  vertical-align: top;
}
.multiselect__tag ~ .multiselect__input,
.multiselect__tag ~ .multiselect__single {
  width: auto;
}
.multiselect__input:hover,
.multiselect__single:hover {
  border-color: #cfcfcf;
}
.multiselect__input:focus,
.multiselect__single:focus {
  border-color: #a8a8a8;
  outline: none;
}
.multiselect__single {
  padding-left: 6px;
  margin-bottom: 8px;
}
.multiselect__tags-wrap {
  display: inline
}
.multiselect__tags {
  min-height: 40px;
  display: block;
  padding: 8px 40px 0 8px;
  border-radius: 5px;
  border: 1px solid #E8E8E8;
  background: #fff;
}
.multiselect__tag {
  position: relative;
  display: inline-block;
  padding: 4px 26px 4px 10px;
  border-radius: 5px;
  margin-right: 10px;
  color: #fff;
  line-height: 1;
  background: #5240b8;
  margin-bottom: 5px;
  white-space: nowrap;
  overflow: hidden;
  max-width: 100%;
  text-overflow: ellipsis;
}
.multiselect__tag-icon {
  cursor: pointer;
  margin-left: 7px;
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  font-weight: 700;
  font-style: initial;
  width: 22px;
  text-align: center;
  line-height: 22px;
  transition: all 0.2s ease;
  border-radius: 5px;
}
.multiselect__tag-icon:after {
  content: "×";
  color: #266d4d;
  font-size: 14px;
}
.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background: #369a6e;
}
.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
  color: white;
}
.multiselect__current {
  line-height: 16px;
  min-height: 40px;
  box-sizing: border-box;
  display: block;
  overflow: hidden;
  padding: 8px 12px 0;
  padding-right: 30px;
  white-space: nowrap;
  margin: 0;
  text-decoration: none;
  border-radius: 5px;
  border: 1px solid #E8E8E8;
  cursor: pointer;
}
.multiselect__select {
  line-height: 16px;
  display: block;
  position: absolute;
  box-sizing: border-box;
  width: 40px;
  height: 38px;
  right: 1px;
  top: 1px;
  padding: 4px 8px;
  margin: 0;
  text-decoration: none;
  text-align: center;
  cursor: pointer;
  transition: transform 0.2s ease;
}
.multiselect__select:before {
  position: relative;
  right: 0;
  top: 65%;
  color: #999;
  margin-top: 4px;
  border-style: solid;
  border-width: 5px 5px 0 5px;
  border-color: #999999 transparent transparent transparent;
  content: "";
}
.multiselect__placeholder {
  color: #ADADAD;
  display: inline-block;
  margin-bottom: 10px;
  padding-top: 2px;
}
.multiselect--active .multiselect__placeholder {
  display: none;
}
.multiselect__content-wrapper {
  position: absolute;
  display: block;
  background: #fff;
  width: 100%;
  max-height: 240px;
  overflow: auto;
  border: 1px solid #E8E8E8;
  border-top: none;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
  z-index: 50;
  -webkit-overflow-scrolling: touch;
}
.multiselect__content {
  list-style: none;
  display: inline-block;
  padding: 0;
  margin: 0;
  min-width: 100%;
  vertical-align: top;
}
.multiselect--above .multiselect__content-wrapper {
  bottom: 100%;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border-bottom: none;
  border-top: 1px solid #E8E8E8;
}
.multiselect__content::webkit-scrollbar {
  display: none;
}
.multiselect__element {
  display: block;
}
.multiselect__option {
  display: block;
  padding: 12px;
  min-height: 40px;
  line-height: 16px;
  text-decoration: none;
  text-transform: none;
  vertical-align: middle;
  position: relative;
  cursor: pointer;
  white-space: nowrap;
}
.multiselect__option:after {
  top: 0;
  right: 0;
  position: absolute;
  line-height: 40px;
  padding-right: 12px;
  padding-left: 20px;
}
.multiselect__option--highlight {
  background: #41B883;
  outline: none;
  color: white;
}
.multiselect__option--highlight:after {
  content: attr(data-select);
  background: #41B883;
  color: white;
}
.multiselect__option--selected {
  background: #F3F3F3;
  color: #35495E;
  font-weight: bold;
}
.multiselect__option--selected:after {
  content: attr(data-selected);
  color: silver;
}
.multiselect__option--selected.multiselect__option--highlight {
  background: #FF6A6A;
  color: #fff;
}
.multiselect__option--selected.multiselect__option--highlight:after {
  background: #FF6A6A;
  content: attr(data-deselect);
  color: #fff;
}
.multiselect--disabled {
  background: #ededed;
  pointer-events: none;
}
.multiselect--disabled .multiselect__current,
.multiselect--disabled .multiselect__select {
  background: #ededed;
  color: #a6a6a6;
}
.multiselect__option--disabled {
  background: #ededed;
  color: #a6a6a6;
  cursor: text;
  pointer-events: none;
}
.multiselect__option--disabled.multiselect__option--highlight {
  background: #dedede !important;
}
.multiselect-enter-active,
.multiselect-leave-active {
  transition: all 0.15s ease;
}
.multiselect-enter,
.multiselect-leave-active {
  opacity: 0;
}
.multiselect__strong {
  margin-bottom: 10px;
  display: inline-block
}
*[dir="rtl"] .multiselect {
    text-align: right;
}
*[dir="rtl"] .multiselect__select {
    right: auto;
    left: 1px;
}
*[dir="rtl"] .multiselect__tags {
    padding: 8px 8px 0px 40px;
}
*[dir="rtl"] .multiselect__content {
    text-align: right;
}
*[dir="rtl"] .multiselect__option:after {
    right: auto;
    left: 0;
}
*[dir="rtl"] .multiselect__clear {
    right: auto;
    left: 12px;
}
*[dir="rtl"] .multiselect__spinner {
    right: auto;
    left: 1px;
}
@keyframes spinning {
  from { transform:rotate(0) }
  to { transform:rotate(2turn) }
}

</style>