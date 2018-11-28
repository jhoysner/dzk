<template>
    <!-- start Header Area -->
    <header id="header">
      <div class="container">
          <div class="row align-items-center justify-content-between">
              <div class="col-lg-2" id="logo">
                  <a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
              </div>
              <div class="col-lg-10 nav-wrap d-flex flex-row align-items-center">
                  <nav id="nav-menu-container" class="ml-auto">
                      <ul class="nav-menu">
                          <li class="menu-has-children"><a href="">Home</a>
                              <ul>
                                  <li><a href="index.html">Home One</a></li>
                                  <li><a href="index2.html">Home Two</a></li>
                              </ul>
                          </li>
                          <li><a href="category.html">Category</a></li>
                          <li><a href="user-account-profile.html">User Profile</a></li>
                          <li><a href="author-account-profile.html">Author Profile</a></li>
                          <li> 
  <!--                             <router-link to='/imbox'>
                                  <a>
                                    Mensajes
                                  </a>
                              </router-link> -->
<!--                                 <div class="top-message mr-0">
                                  <router-link to='/imbox'>
                                    <a>
                                      <span class="icons icon-envelope"></span>
                                    </a>
                                  </router-link> 
                                  <span  v-if="messageTrue" class="badge badge-danger">_</span>
                                </div> -->
                          </li>
                      </ul>
                  </nav>
                  <div class="cart relative">
                      <div class="single-shortcut top-cart mr-0">
                          <span class="icons icon-handbag"></span>
                          <span class="badge badge-light">04</span>
                      </div>
                      <div class="mini-cart">
                          <div class="total-amount d-flex justify-content-between">
                              <div class="title">
                                  <h6>My Cart</h6>
                              </div>
                              <div class="amount">$1149.00</div>
                          </div>
                          <div class="single-cart-item d-flex justify-content-between align-items-center">
                              <a href="#"><img src="img/cart/ct1.jpg" alt=""></a>
                              <div class="middle">
                                  <h5><a href="#">Minimalistic shop</a></h5>
                                  <h6><span class="lnr lnr-tag"></span> $189.00 x 1</h6>
                              </div>
                              <div class="cross"><span class="lnr lnr-cross"></span></div>
                              <input type="radio" name="gender" value="male" checked>
                          </div>
                          <div class="single-cart-item d-flex justify-content-between align-items-center">
                              <a href="#"><img src="img/cart/ct2.jpg" alt=""></a>
                              <div class="middle">
                                  <h5><a href="#">Real corporate</a></h5>
                                  <h6><span class="lnr lnr-tag"></span> $120.00 x 2</h6>
                              </div>
                              <div class="cross"><span class="lnr lnr-cross"></span></div>
                              <input type="radio" name="gender" value="male" checked>
                          </div>
                          <div class="single-cart-item border-0 d-flex justify-content-between align-items-center">
                              <a href="#"><img src="img/cart/ct3.jpg" alt=""></a>
                              <div class="middle">
                                  <h5><a href="#">Multipurpose</a></h5>
                                  <h6><span class="lnr lnr-tag"></span> $240.00 x 3</h6>
                              </div>
                              <div class="cross"><span class="lnr lnr-cross"></span></div>
                              <input type="radio" name="gender" value="male" checked>
                          </div>
                          <div class="proceed-btn text-center"><a href="checkout.html" class="primary-btn primary-btn-wr"><span>Proceed to checkout</span></a></div>
                      </div>
                  </div>
                  <!--<a class="login-btn" href="/login">Login</a>-->
              </div>
              <!-- #nav-menu-container -->
          </div>
      </div>
    </header>
    <!-- start Header Area -->
</template>
<script>
import Bus from '../../utilities/EventBus.js';

export default {
  data() {

      return {
         'user': {},
         'messages': [],
         'messageTrue': false,
         'length': '',
      }

  },
  mounted(){
      Bus.$on('header-mesasge-false', () => {
          this.messageTrue = false;
      });      
      Bus.$on('header-message-true', () => {
         this.messageTrue = true;

      });      
      this.auth();
  },
  methods: {
      auth() {
          axios.get('api/profile').then((response) => {
            this.user = response.data.user;
            this.index();
          })
          .catch(err => console.log(err))
      },
      index() {
        axios.get('api/all-messages/' + this.user.id).then(response => {  
          this.messages = response.data.data
          
          for (var key in this.messages) {
             this.messageState(this.messages[key]);
          }          
        })
        .catch(err => console.log(err))
      },
      messageState(item) {

          if (item.users_id_from != this.user.id){

              if (item.read_at == null ){

                this.messageTrue = true; 
              }
          }
          // return this.message = false;
      }, 
     
  },

}
</script>
<style lang="scss" scoped>

.badge-danger{
  color: #dc3545;
}

.top-message .badge {
    position: absolute;
    color: #42b0f2;
    font-weight: 300;
    border-radius: 20px;
    padding: -13px;
    line-height: initial;
    top: 0px;
    right: 13px ;
    height: 10px;
    width: 10px;
}

.top-message {
    margin-left: 40px;
    color: #fff;
    // border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 6px 10px;
    border-radius: 50px;
}

.icon-envelope {
  font-size :20px;
}
</style>
