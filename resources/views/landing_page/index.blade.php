@extends('landing_page.layout.index')

@section('content')
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav">
        <div class="container">
            <div class="menu-bg-wrap">
                <div class="site-navigation">
                    <div class="row g-0 align-items-center">
                        <div class="col-2">
                            <a href="index.html" class="logo m-0 float-start">Kelas-ku<span
                                    class="text-primary">.</span></a>
                        </div>
                        <div class="col-8 text-center ">
                            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
                                <li class="active"><a href="index.html">Home</a></li>
                                {{-- <li class="has-children">
                                    <a href="financing.html">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="financing.html">Financing</a></li>
                                        <li><a href="single.html">Blog Single</a></li>
                                        <li><a href="case-study.html">Case Study Detail</a></li>
                                        <li><a href="#">Menu One</a></li>
                                        <li><a href="#">Menu Two</a></li>
                                        <li class="has-children">
                                            <a href="#">Dropdown</a>
                                            <ul class="dropdown">
                                                <li><a href="#">Sub Menu One</a></li>
                                                <li><a href="#">Sub Menu Two</a></li>
                                                <li><a href="#">Sub Menu Three</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li> --}}
                                <li><a href="about.html">About</a></li>
                                <li><a href="services.html">Services</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-2 text-end">
                            <a href="#"
                                class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
                                <span></span>
                            </a>
                            @if (Auth::check())
                                <div class="call-us d-flex align-items-center justify-content-between gap-4">
                                    <a class="btn btm-sm" href="/welcome" style="background-color: #8a00c2; color:white">Dashboard</a>
                                </div>
                            @else
                                <div class="call-us d-flex align-items-center justify-content-between gap-4">
                                    <a class="btn btm-sm" href="/login" style="background-color: #8a00c2; color:white">Get
                                        started</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero overlay">
        <img src="images/blob.svg" alt="" class="img-fluid blob">
        <div class="container">
            <div class="row align-items-center justify-content-between pt-5">
                <div class="col-lg-6 text-center text-lg-start pe-lg-5">
                    <h1 class="heading text-white mb-3" data-aos="fade-up">Kelas-Ku, mempermudah mengelola kas kelas.</h1>
                    <p class="text-white mb-5" data-aos="fade-up" data-aos-delay="100">Kelas Ku, mempermudah dalam segala
                        pengelolaan uang kas Kelas Ku.</p>
                    <div class="align-items-center mb-5 mm" data-aos="fade-up" data-aos-delay="200">
                        <a href="contact.html" class="btn btn-white me-4">Contact us</a>
                        <a href="https://www.youtube.com/watch?v=Mb1zrW_zra4" class="text-white glightbox">Watch the
                            video</a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="img-wrap">
                        <img src="{{ asset('landing_page/images/img-1.jpg') }}" alt="Image" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <img src="{{ asset('landing_page/images/img-3.jpg') }}" alt="Image"
                        class="img-fluid rounded
                ">
                </div>
                <div class="col-lg-4 ps-lg-2">
                    <div class="mb-5">
                        <h2 class="text-black h4">Make payment fast and smooth.</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the blind texts.</p>
                    </div>
                    <div class="d-flex mb-3 service-alt">
                        <div>
                            <span class="bi-wallet-fill me-4"></span>
                        </div>
                        <div>
                            <h3>Build financial</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3 service-alt">
                        <div>
                            <span class="bi-pie-chart-fill me-4"></span>
                        </div>
                        <div>
                            <h3>Invest for the future</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="section sec-features">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature d-flex">
                        <span class="bi-bag-check-fill"></span>
                        <div>
                            <h3>Build financial</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature d-flex">
                        <span class="bi-wallet-fill"></span>
                        <div>
                            <h3>Invest for the future</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature d-flex">
                        <span class="bi-pie-chart-fill"></span>
                        <div>
                            <h3>Responsible banking</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 order-lg-2 mb-4 mb-lg-0">
                    <img src="{{ asset('landing_page/images/img-1.jpg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-lg-5 pe-lg-5">
                    <div class="mb-5">
                        <h2 class="text-black h4">Straight-forward way of financing</h2>
                    </div>
                    <div class="d-flex mb-3 service-alt">
                        <div>
                            <span class="bi-wallet-fill me-4"></span>
                        </div>
                        <div>
                            <h3>Build financial</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3 service-alt">
                        <div>
                            <span class="bi-pie-chart-fill me-4"></span>
                        </div>
                        <div>
                            <h3>Invest for the future</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3 service-alt">
                        <div>
                            <span class="bi-bag-check-fill me-4"></span>
                        </div>
                        <div>
                            <h3>Responsible banking</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="section sec-services">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-5 mx-auto text-center" data-aos="fade-up">
                    <h2 class="heading text-primary">Our Services</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts. </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up">

                    <div class="service text-center">
                        <span class="bi-cash-coin"></span>
                        <div>
                            <h3>Faster payments</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service text-center">
                        <span class="bi-chat-text"></span>
                        <div>
                            <h3>Grow your business</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service text-center">
                        <span class="bi-fingerprint"></span>
                        <div>
                            <h3>Investments</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">

                    <div class="service text-center">
                        <span class="bi-gear"></span>
                        <div>
                            <h3>Payment & Cards</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service text-center">
                        <span class="bi-graph-up-arrow"></span>
                        <div>
                            <h3>Strategic Finance</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service text-center">
                        <span class="bi-layers"></span>
                        <div>
                            <h3>Digital Currency</h3>
                            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                and Consonantia, there live the blind texts. </p>
                            <p><a href="#" class="btn btn-outline-primary py-2 px-3">Read more</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="section sec-cta overlay" style="background-image: url('images/img-3.jpg')">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="0">
                    <h2 class="heading">Wanna Talk To Us?</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts. </p>
                </div>
                <div class="col-lg-5 text-end" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="btn btn-outline-white-reverse">Contact us</a>
                </div>
            </div>
        </div>
    </div>


    <div class="section sec-testimonial bg-light">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="heading text-primary">Testimonials</h2>
                </div>

            </div>


            <div class="testimonial-slider-wrap">
                <div class="testimonial-slider" id="testimonial-slider">
                    <div class="item">
                        <div class="testimonial-half d-lg-flex bg-white">
                            <div class="img"
                                style="background-image: url('{{ asset('landing_page/images/img-4.jpg') }}')">

                            </div>
                            <div class="text">
                                <blockquote>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right at the coast of the Semantics, a large language ocean.</p>
                                </blockquote>
                                <div class="author">
                                    <strong class="d-block text-black">John Campbell</strong>
                                    <span>CEO & Co-founder</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial-half d-lg-flex bg-white">
                            <div class="img"
                                style="background-image: url('{{ asset('landing_page/images/img-3.jpg') }}')">

                            </div>
                            <div class="text">
                                <blockquote>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right at the coast of the Semantics, a large language ocean.</p>
                                </blockquote>
                                <div class="author">
                                    <strong class="d-block text-black">John Campbell</strong>
                                    <span>CEO & Co-founder</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial-half d-lg-flex bg-white">
                            <div class="img"
                                style="background-image: url('{{ asset('landing_page/images/img-2.jpg') }}')">

                            </div>
                            <div class="text">
                                <blockquote>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right at the coast of the Semantics, a large language ocean.</p>
                                </blockquote>
                                <div class="author">
                                    <strong class="d-block text-black">John Campbell</strong>
                                    <span>CEO & Co-founder</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="widget">
                        <h3>About</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                            there live the blind texts.</p>
                    </div> <!-- /.widget -->
                    <div class="widget">
                        <address>43 Raymouth Rd. Baltemoer, <br> London 3910</address>
                        <ul class="list-unstyled links">
                            <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
                            <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
                            <li><a href="mailto:info@mydomain.com">info@mydomain.com</a></li>
                        </ul>
                    </div> <!-- /.widget -->
                </div> <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="widget">
                        <h3>Company</h3>
                        <ul class="list-unstyled float-start links">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Vision</a></li>
                            <li><a href="#">Mission</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Privacy</a></li>
                        </ul>
                        <ul class="list-unstyled float-start links">
                            <li><a href="#">Partners</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Creative</a></li>
                        </ul>
                    </div> <!-- /.widget -->
                </div> <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="widget">
                        <h3>Navigation</h3>
                        <ul class="list-unstyled links mb-4">
                            <li><a href="#">Our Vision</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>

                        <h3>Social</h3>
                        <ul class="list-unstyled social">
                            <li><a href="#"><span class="icon-instagram"></span></a></li>
                            <li><a href="#"><span class="icon-twitter"></span></a></li>
                            <li><a href="#"><span class="icon-facebook"></span></a></li>
                            <li><a href="#"><span class="icon-linkedin"></span></a></li>
                            <li><a href="#"><span class="icon-pinterest"></span></a></li>
                            <li><a href="#"><span class="icon-dribbble"></span></a></li>
                        </ul>
                    </div> <!-- /.widget -->
                </div> <!-- /.col-lg-4 -->
            </div> <!-- /.row -->

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <!--
                                                                                                              **==========
                                                                                                              NOTE:
                                                                                                              Please don't remove this copyright link unless you buy the license here https://untree.co/license/
                                                                                                              **==========
                                                                                                            -->

                    <p>Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>. All Rights Reserved. &mdash; Designed with love by <a
                            href="https://untree.co">Untree.co</a> Distributed By <a
                            href="https://themewagon.com">ThemeWagon</a>
                        <!-- License information: https://untree.co/license/ -->
                    </p>
                </div>
            </div>
        </div> <!-- /.container -->
    </div> <!-- /.site-footer -->

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
@endsection
