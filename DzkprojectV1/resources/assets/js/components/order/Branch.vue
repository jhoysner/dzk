<template>
  <div>
        <b-modal id="branchModal" ref="branchModal" hide-header hide-footer>
          <div class="modal-content">
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                    <button type="button" class="close text-right" @click="closeModal()">
                      <span>x</span>
                    </button>
                  </div>
                  <div class="col-lg-12" >
                    <h4>Sucursal</h4>
                      <select v-model="idbranch" class="form-control common-input">
                        <option v-for="opt in branchs" :value="opt.idbranch">{{opt.name}}</option>
                      </select>                  
                      <small class="text-danger" v-if="error">{{ error }}</small>
                  </div>
                  <div class="col-lg-12 text-right" v-if="branch">
                    <button class="btn primary-btn" @click="selectCommerceBranch(idcommerce,idbranch)">Guardar</button>
                  </div>
                </div>             
              </div>
          </div>
        </b-modal> 
    </div>
</template>

<script>

  export default {
    data() {
      return {
        idcommerce: '',
        idbranch: '',
        commerces: [],
        branchs: [],
        branch: false,
        error: ''
      }
    },
    created() {
      this.index();
    },

    methods: {
      index() {
        this.error = ''
        axios.get('api/commerce').then(response => {
            this.commerces = response.data.data         
            
            const user_config = JSON.parse(localStorage.getItem('user_config'))

            if( user_config != false && user_config != null ) {
              this.idcommerce = user_config.list[0].commerce
              this.idbranch = user_config.list[0].branch
              
              this.branchDetail(this.idcommerce)

              this.branch = true      
            }
          })    
      },
      selectCommerceBranch(commerce,branch) {
        if(branch == '') {
          this.error = "La sucursal es requerida"
          return 
        }
        var data = {}
        data.list = []
        data.list.push({
          'commerce': commerce,
          'branch': branch
        })

        localStorage.setItem('user_config', JSON.stringify(data))
        this.$parent.index()
        this.error = ''
        this.$refs.commercesModal.hide()
      },
      view(id) {
        localStorage.removeItem('user_config')
        this.idbranch = ''
        this.branchDetail(id)
        this.branch = true
      },
      branchDetail(id) {
        this.branchs=[]
        axios.get('api/detail-commerce/'+id).then(response => {
            this.branchs = response.data.data[0].branchs
          })
      },
      closeModal() {
        this.$refs.branchModal.hide()
      },
    }
  }
</script>

<style>
  
</style>