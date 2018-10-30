<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-lg-12 usr-menu pb-50" id="usr-menu">
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
            <li>
              <router-link to='/tags'>
                  <a>
                    Tags
                  </a>
              </router-link>
            </li>            
            <li>
              <router-link to='/params'>
                  <a>
                    Parametros
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
            <li>
              <router-link to='/users'>
                <a>
                  Usuarios
                </a>
              </router-link>
            </li>
            <li>
              <router-link to='/roles'>
                <a>
                  Grupos
                </a>
              </router-link>
            </li>
            <li>
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
            <li>
              <router-link to='/logout'>
                <a>
                  Salir
                </a>
              </router-link>
            </li>
          <!--  <li>
                <a href="author-account-download.html">Downloads</a>
            </li>
            <li>
                <a href="author-account-review.html">Reviews</a>
            </li>
            <li>
                <a href="author-account-earnings.html">Earnings</a>
            </li>
            <li>
                <a href="author-account-statements.html">Statements</a>
            </li> -->
        </ul>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: "",
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
