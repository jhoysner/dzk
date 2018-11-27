<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-lg-12 usr-menu pb-50 menu" id="usr-menu">
        <!-- details Tab navs -->
        <ul class="top-nav d-flex justify-content-center offwhite-color-bg">
            <li>
                <router-link to='/'>
                    <a>
                      Dashboard
                    </a>
                </router-link>
            </li>
            <li>
              <router-link to='/cliente'>
                  <a>
                    cliente
                  </a>
              </router-link>
            </li>            
            <li  v-can="'seguidores'">
              <router-link to='/followers'>
                  <a>
                    Seguidores
                  </a>
              </router-link>
            </li>            
            <li  v-can="'siguiendo'">
              <router-link to='/following'>
                  <a>
                    Siguiendo
                  </a>
              </router-link>
            </li>
            <li>
              <router-link to='/list-products'>
                <a>
                  Listado Productos
                </a>
              </router-link>
            </li>
            <li>
              <router-link to='/commerces'>
                  <a>
                    Comercios
                  </a>
              </router-link>
            </li>

            <li>
              <router-link to='/branchs'>
                  <a>
                    Sucursales
                  </a>
              </router-link>
            </li>            
            <li>
              <router-link to='/discount'>
                <a>
                  Descuentos
                </a>
              </router-link>
            </li>
            
            <li v-can="'products'" v-if="isLogged">
              <router-link to='/products'>
                <a>
                  Productos
                </a>
              </router-link>
            </li>

            <li v-if="isLogged">
              <router-link to=''>
                <a title="Configuración">
                  <i class="fa fa-cogs fa-2x"></i>
                </a>
              </router-link>
              <ul>
                <li v-can="'users'">
                  <router-link to='/users'>
                    <a>
                      Usuarios
                    </a>
                  </router-link>
                </li>
                <li v-can="'roles'" v-if="isLogged">
                  <router-link to='/roles'>
                    <a>
                      Grupos
                    </a>
                  </router-link>
  
                </li>    
                <li v-can="'tags'" >
                  <router-link to='/tags'>
                      <a>
                        Tags
                      </a>
                  </router-link>
                </li>            
                <li v-can="'params'">
                  <router-link to='/params'>
                      <a>
                        Parametros
                      </a>
                  </router-link>
                </li>
              </ul>

            </li>

            <li>
              <router-link to='/shopping-list'>
                <a title="Lista de Compra">
                  <i class="fa fa-list-alt fa-2x"></i>
                  <span v-if="list.length > 0" class="badge badge-danger">.</span>
                </a>
              </router-link>
            </li>
            
            <li v-can="'orders'" v-if="isLogged">
              <router-link to='/orders'>
                <a>
                  Pedidos
                </a>
              </router-link>
            </li>
            <li v-if="isLogged">
              <router-link to='/requests'>
                <a>
                  Solicitudes
                </a>
              </router-link>
            </li>
          
            <li v-if="isLogged">
              <router-link to='/profile'>
                <a>
                  Perfil
                </a>
              </router-link>
            </li>
          
            <li>
              <router-link to='/discounts-postulated'>
                <a>
                  Descuentos postulados <!--<span class="badge badge-dark">0</span> -->
                </a>
              </router-link>
            </li>
          
            <li v-if="isLogged">
              <router-link to='/logout'>
                <a>
                  Salir
                </a>
              </router-link>
            </li>
            <li v-else>
                <a href="/login">
                  Login
                </a>
            </li>
        </ul>
    </div>
  </div>
  </div>
</template>
<script>
  
export default {  
  name: "",
  data() {
    return {
      isLogged: '',
      userId: '',
      idcommerce: '',
      idbranch: '',
      list: [],
    }
  },
  mounted() {
    this.isLogged = false
    this.index()
  },
  methods: {
    index() {
      const token = localStorage.getItem('access_token')

      if( !token) {
        this.isLogged = false
      }

      if(token) {
        axios.get('api/profile').then(response => {
            this.isLogged = true
            this.userId = response.data.user.id
          })
          .catch(err => {
            this.isLogged = false
          }) 

          const user_config = JSON.parse(localStorage.getItem('user_config'))

          if( user_config ) {
              this.idcommerce = user_config.list[0].commerce
              this.idbranch = user_config.list[0].branch

              axios.get('api/marketplace-active/'+this.idcommerce+'/'+this.idbranch).then(response => {
                this.list = response.data.data 
                if(this.list.length > 0) {
                  
                }

              }) 

            }
      }

    }
    
    
  }
}
</script>
<style lang="scss" scoped>
  .menu ul {
    list-style: none;
    margin:0;
    padding:0;
  }
  .menu ul li {
    background-color:#cccccc;
    z-index: 100;
  }
  .menu ul a {
   display:block;
   color:#ccc;
   text-decoration:none;
   padding:10px;
   letter-spacing:1px;
  }
  .menu ul li {
   position:relative;
   float:left;
   margin:0;
   padding:0;
  }
  .menu ul li:hover {
   background:#5b78a7;
  }
  .menu ul ul {
   display:none;
   position:absolute;
   top:100%;
   left:0;
   background:#ccc;
   padding:0;
  }
  .menu ul ul li {
   float:none;
   width:150px;
  }
  .menu ul ul a {
   line-height:120%;
   padding:10px 15px;
  }
  .menu ul li:hover > ul {
   display:block;
  }
  .menu ul li:hover > ul li a:hover {
   background:#5b78a7;
  }
</style>
