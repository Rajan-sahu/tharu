 <?php
require_once('./pura-common/head.php');

  if (isset($_SESSION['admin_id']) || !empty($_SESSION['admin_id'])){
    echo "<script>window.location.assign('./index.php')</script>";
    exit();
    }

?>
  
  <div class="wrapper">
      <section class="login-content">
         <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6">
               <div class="row justify-content-center">
                  <div class="col-md-10">
                     <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body z-3 px-md-0 px-lg-4">
                           <a href="../../dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
                              <!--Logo start-->
                              <div class="logo-main">
                                  <div class="logo-normal">
                                    <img src="./assets/images/auth/headerLogo.jpg" alt="logo"class=" img-fluid">
                                  </div>
                                  <div class="logo-mini">
                                    <img src="./assets/images/auth/headerLogo.jpg" alt="logo"class=" suzuka-logo">
                                  </div>
                              </div>
                              <!--logo End-->
                           </a>
                           <h2 class="mb-2 text-center">Sign In</h2>
                           <p class="text-center">Login to stay connected.</p>
                           <form id="login_form" class="suzuka-login-form">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="email" class="form-label">Email</label>
                                       <input type="email" class="form-control" name="email" id="email" aria-describedby="email" placeholder=" ">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="password" class="form-label">Password</label>
                                       <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder=" ">
                                    </div>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-center">
                                 <button type="submit" id="sub_btn" class="btn btn-primary w-100 mt-3">Sign In</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="./assets/images/auth/01.png" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
         </div>
      </section>
      </div>
<?php

include_once('./pura-common/footer.php');

?>