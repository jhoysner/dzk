<template>
    <div>
      <b-modal id="showModal" ref="showModal" :title="commerce.name" hide-footer>
        <div class="modal-content">
            <div class="modal-body">
              
              <!--<div class="form-group">
                  <label class="font-weight-bold">ID comercio</label>
                  <p>{{ commerce.idcommerce }}</p>
              </div> -->

              <div class="form-group">
                  <label class="font-weight-bold">Télefono principal</label>
                  <p>{{ commerce.phone1 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Telefono Secundario</label>
                  <p>{{ commerce.phone2 }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Email</label>
                  <p>{{ commerce.email }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Imagen</label>
                  <p>
                    <img class="image-commerce" :src="'images/commerce/'+commerce.image" />
                  </p>
              </div>

              <div class="form-group" v-if="commerce.web != null ">
                  <label class="font-weight-bold">Web</label>
                  <p>{{ commerce.web }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">País</label>
                  <p>{{ commerce.country_idcountry }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Departamento</label>
                  <p>{{ commerce.state_idstate }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Ciudad</label>
                  <p>{{ commerce.city_idcity }}</p>
              </div>

              <div class="form-group">
                  <label class="font-weight-bold">Categoría</label>
                  <p>{{ commerce.commercecategory_idcommercecategory }}</p>
              </div> 

              <div class="form-group">
                <label class="font-weight-bold">Tags</label>
                <multiselect v-model="value" tag-placeholder="Agregar tag" placeholder="No tiene Tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" :disabled="true"></multiselect>
              </div> 

            </div>     
        </div>
      </b-modal> 
    </div>
</template>
<script>
import Bus from '../../utilities/EventBus';

export default {
  name: 'show',
  data() {
    return {
      commerce: {
        name: '',
        phone1: '',
        phone2: '',
        email: '',
        image: '',
        web: '',
        country_idcountry: '',
        state_idstate: '',
        city_idcity: '',
        commercecategory_idcommercecategory: '',
      },
      url: '/commerce',
      options: [],
      value: []
 
    }
  },

  mounted() {
    Bus.$on('id_commerce', (id) => {
      this.getTagsCommerce(id)
      axios.get('api' + this.url + '/' + id).then(data => {
        this.commerce.idcommerce = data.data[0].idcommerce;
        this.commerce.name = data.data[0].name;
        this.commerce.phone1 = data.data[0].phone1;
        this.commerce.phone2 = data.data[0].phone2;
        this.commerce.email = data.data[0].email;
        this.commerce.image = data.data[0].image;
        this.commerce.web = data.data[0].web;
        this.commerce.country_idcountry = data.data[0].countries.name;
        this.commerce.state_idstate = data.data[0].states.name;
        this.commerce.city_idcity = data.data[0].cities.name;
        this.commerce.commercecategory_idcommercecategory = data.data[0].ccategories.name;
      })
      .catch(err => console.log(err))
    });
        

  },


  methods: {
    show(id) {
      
    },
    getTagsCommerce(value){
      console.log(value)
      axios.get('api/tags-commerce/'+value)
        .then((response) => {
            this.value = response.data.data
            this.value.forEach(function(item) {
              item.code = item.idtags
            })
            console.log(this.value)
        })  
        .catch((err) => {

            console.log(err);
      });
    
    },


  }
}
</script>
<style lang="scss" scoped>
.image-commerce {
  width: 80px;
  height: 50px;
  border-radius: 50%;
}
</style>