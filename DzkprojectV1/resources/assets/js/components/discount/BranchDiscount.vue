<template>
    <div>
        <b-modal v-model="show" id="branchDiscountModal" ref="branchDiscountModal" title="Brabch Discount" hide-footer>
                <form @submit.prevent="saveBranchDiscount">
                      <div class="modal-content">
                        <div class="container">
                              
                              <h3>Sucursales : </h3>
      
                              <div v-for="branch in branchs">
                                    
                                   <input class="" type="checkbox" id="branch.name" :value="branch.idbranch" v-model="form.branch_idbranch">
                                   <span>{{branch.name}}</span>

                              </div>                            
                            
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
                        <div class="modal-footer">
                            <b-btn @click="show=false">Close</b-btn>
                            <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-plus"></i> Save Branch Discount</button>
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
                  branch_idbranch: [],
                  discounthours:'',
                  amountapproved:'',

                },
                errorsDiscount: {},
                show: false,
                branchs: {},
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
                    this.form = {}
                    this.$refs.branchDiscountModal.hide()
                    console.log('bien')
                    swal({
                      title: "Creado",
                      text: "Registro Descuento por sucursales con exito",
                      icon: "success",
                    })
                })
                    // this.$refs.branchDiscountModal.show()
                .catch(error => {
                    console.log(error.response.data)
                    this.errorsDiscount = error.response.data.errors;
                     // let errors = this.$laravelErrors.handle(error)
                     // this.errorsDiscount = errors.errors.errors
                     // console.log(this.errorsDiscount)

                });
          }
        }

    }
</script>

<style>

</style>