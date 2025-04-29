


<?php
include("header.php");
?>

<section class="page-header">
            <div class="page-header__bg">
                <div class="page-header__bg__img" style="background-image: url(assets/images/backgrounds/page-header-img-1.png);">
                </div>
                <div class="page-header__bg__shape-1">
                </div>
                <div class="page-header__bg__shape-2">
                </div>
            </div>
            <div class="container">
                <h2 class="page-header__title">Contact Page </h2>
                <ul class="pelocis-breadcrumb list-unstyled">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Contact page</span></li>
                </ul>
            </div>
            <img class="page-header__shape" src="assets/images/shapes/bannar-shape-2.png" alt="bannar-shape">
        </section>
<section class="contact-one">
            <div class="container">
                <div class="text-center">
                    <div class="sec-title">



                        <div class="sec-title__shape">
                        </div>
                        <h6 class="sec-title__tagline">Contact with us</h6><!-- /.sec-title__tagline -->

                        <h3 class="sec-title__title">If Your Problem Contact Us For<br> Immediately Center</h3><!-- /.sec-title__title -->
                    </div><!-- /.sec-title -->
                </div><!-- /.contact-one__form__top -->
                <form class="contact-one__form contact-form-validated form-one  wow fadeInUp" data-wow-duration="1500ms" action="https://bracketweb.com/pelocishtml/inc/sendemail.php">
                    <div class="form-one__group row">
                        <div class="form-one__control col-md-6">
                            <input type="text" name="name" placeholder="Select Name *">
                        </div><!-- /.form-one__control -->
                        <div class="form-one__control col-md-6">
                            <input type="email" name="email" placeholder="Select Email *">
                        </div><!-- /.form-one__control -->
                        <div class="form-one__control col-md-6">
                            <input type="text" name="phone" placeholder="Select a Phone">
                        </div><!-- /.form-one__control -->
                        <div class="form-one__control form-one__control--full col-md-6">
                            <div class="form-one__control__select">
                                <label class="sr-only" for="language-select">Select a Program</label>
                                <!-- /#language-select.sr-only -->
                                <select class="selectpicker" id="language-select">
                                    <option value="Select program">Select a Program</option>
                                    <option value="Select program 01">Select Program 01</option>
                                    <option value="Select program 02">Select Program 02</option>
                                </select>
                            </div><!-- /.main-menu__language -->
                        </div><!-- /.form-one__control -->
                        <div class="form-one__control col-md-12">
                            <textarea name="message" placeholder="Write  a Message"></textarea><!-- /# -->
                        </div><!-- /.form-one__control -->
                        <div class="form-one__control form-one__control--full text-center">
                            <button type="submit" class="pelocis-btn"><span>SEND REQUEST <i class="icon-right-arrow-white"></i></span></button>
                        </div><!-- /.form-one__control -->
                    </div><!-- /.form-one__group -->
                </form>
            </div><!-- /.container -->
        </section><!-- /.contact-one -->


        


<?php
include("footer.php");
?>