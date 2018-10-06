@extends('layouts.main')

@section('content')
<!-- Start theme-details -->
    <section class="theme-details pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pb-120 top-nav-wrap">
                    <!-- details Tab navs -->
                    <ul class="top-nav d-flex justify-content-center offwhite-color-bg">
                        <li class="active">
                            <a href="user-account-profile.html">Profile</a>
                        </li>
                        <li>
                            <a href="user-account-settings.html">Settings</a>
                        </li>
                        <li>
                            <a href="user-account-download.html">Downloads</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <!-- details Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <!-- Overview section -->
                            <div class="overview-section cover-section">
                                <div class="theme-thumb ">
                                    <img class="img-fluid" src="img/theme-img.jpg" alt="">
                                </div>
                                <p class="mt-30 pt-30">
                                    We do not sell or share your details without your permission. Find out more in our Privacy Policy. Your username, email and password can be updated via your Codepixar Account settings.
                                </p>
                            </div>
                            <!-- Overview section -->
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 sidebar">
                    <div class="single-sidebar theme-tags">
                        <h6 class="text-uppercase">Social Profiles</h6>
                        <div class="sidebar-social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-github" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-slack" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End theme-details -->
    
    @endsection