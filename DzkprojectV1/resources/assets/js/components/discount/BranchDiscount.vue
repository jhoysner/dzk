<template>
    <div>
        <b-modal v-model="show" id="branchDiscountModal" ref="branchDiscountModal" title="Sucursales Descuentos" hide-footer>
                <form @submit.prevent="saveBranchDiscount" id="formBranchDiscount">
                      <div class="modal-content">
                        <div class="container">
                              
                              <h3>Sucursales : </h3>
                              

                            <div class="form-group" >
                                <label>Seleccionar sucursal</label>
                                  <select class="form-control"  id="selectSucursal" v-on:input="onChange($event.target.value)">
                                    <option value="all">Todas</option>
                                    <option value="one">Elegir</option>
                                  </select>
                            </div>
                            
                            <div v-show="one">
                              
                                <div v-for="branch in branchs">
                                      
                                     <input class="" type="checkbox" id="branch.name" @change="handleChangeId($event)" :value="branch.idbranch" >
                                     <span>{{branch.name}}</span>

                                    <div>
                                      <div class="form-group mt-4">
                                        <label>Unidades</label>
                                        <input type="text" class="form-control" @change="handleChangeUnidad($event.target.value, branch.idbranch)">
                                      </div>                                      

                                      <div class="form-group mt-4">
                                        <label>Horario</label>
                                        <input type="text" class="form-control" @change="handleChangeHorario($event.target.value, branch.idbranch)">
                                      </div>
                                    </div>

                                </div>                            
                            </div>
                            <div v-show="all">
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

    export default {
        data() {
            return {
                form: { 
                  discount_iddiscount: '',
                  sucursales: [],
                  discounthours:'',
                  amountapproved:'',
                },
                errorsDiscount: {},
                show: false,
                branchs: {},
                all:true,
                one:false,
            }
        },
        created(){
           Bus.$on('branch_discount', (response) => {
              this.form.discount_iddiscount = response.data.data.iddiscount;
              this.getDiscountBranch()
              this.$refs.branchDiscountModal.show()
          });
        },
        methods: {
          getDiscountBranch() {
            axios.get('api/branch').then(data => {
              this.branchs = data.data.data;
            })
            .catch(err => console.log(err))
          },
          saveBranchDiscount(){
              axios.post('api/branch-discount',this.form)
                .then(response => { 
                  console.log(response)
                    this.form = { 
                      discount_iddiscount: '',
                      sucursales: [],
                      discounthours:'',
                      amountapproved:'',
                    },
                    this.all = true
                    this.one = false
                    $('#formBranchDiscount').trigger("reset");
                    this.$refs.branchDiscountModal.hide()
                    console.log('bien')
                    swal({
                      title: "Creado",
                      text: "Registro Descuento por sucursales con exito",
                      icon: "success",
                    })
                })
                .catch(error => {
                    console.log(error.response.data)
                    this.errorsDiscount = error.response.data.errors;
                });
          },
          onChange(e){
            
            if(e == 'all'){
              this.one = false;
              this.all = true;
            }
            else  {
               this.all = false;
               this.one = true;
            }
          },
          handleChangeId(e){
            let data = {
              'branch_idbranch': e.target.value,
              'amountapproved': '',
              'discounthours': '',
            }
            this.form.sucursales.push(data)

          },          
          handleChangeUnidad(e, id){
            var obj = this.findObjectByKey(this.form.sucursales, 'branch_idbranch', id);
            obj.amountapproved = e;
          },           
          handleChangeHorario(e, id){
            var obj = this.findObjectByKey(this.form.sucursales, 'branch_idbranch', id);
            obj.discounthours = e;
          },  
          
          findObjectByKey(array, key, value) {
              for (var i = 0; i < array.length; i++) {
                  if (array[i][key] === value) {
                      return array[i];
                  }
              }
              return null;
          }


        }

    }
</script>

<style>

</style>