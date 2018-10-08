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
                          <li class="menu-has-children"><a href="">Pages</a>
                              <ul>
                                  <li><a href="upload-item.html">Upload Item</a></li>
                                  <li><a href="theme-details-subscriber.html">Theme Details Subscriber</a></li>
                                  <li><a href="cart.html">Cart</a></li>
                                  <li><a href="checkout.html">Checkout</a></li>
                                  <li><a href="confirmation.html">Confirmation</a></li>
                                  <li><a href="coupon-all.html">Coupon</a></li>
                              </ul>
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
                  <a class="login-btn" href="/login">Login</a>
              </div>
              <!-- #nav-menu-container -->
          </div>
      </div>
    </header>
    <!-- start Header Area -->
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
