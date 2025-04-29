<?php
include("header.php");
?>

<style>
    .team-two__card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* .team-two__card__img {
        height: 250px;
        overflow: hidden;
    } */

    /* .team-two__card__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    } */

    .team-two__card__content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* .team-two__card__name {
        flex: 1;
    } */

    /* Optional: Add some spacing between cards */
    .team-two__card {
        margin-bottom: 30px;
    }
</style>

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
                <h2 class="page-header__title">About page </h2>
                <ul class="pelocis-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><span>About page</span></li>
                </ul>
            </div>
            <img class="page-header__shape" src="assets/images/shapes/bannar-shape-2.png" alt="bannar-shape">
        </section>
        <!-- /.page-header -->

        <section class="about-one">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="about-one__image wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='000ms'>
                            <img src="assets/images/resources/about-img-1.png" alt="pelocis">
                            <div class="about-one__shape--one count-box">
                                <p class="about-one__experiance"><span class="count-text" data-stop="2011" data-speed="2500"></span> - SINCE</p>
                            </div>
                        </div><!-- /.about-one__image -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-7">
                        <div class="about-one__content wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='100ms'>
                            <div class="about-one__title">
                                <div class="sec-title">



                                    <div class="sec-title__shape">
                                    </div>
                                    <h6 class="sec-title__tagline">OUR ABOUT ORGANIZATION </h6><!-- /.sec-title__tagline -->

                                    <h3 class="sec-title__title">Ganapathy NSS Coimbatore District</h3><!-- /.sec-title__title -->
                                </div><!-- /.sec-title -->
                                <img src="assets/images/shapes/text-shape-2.png" alt="pelocis" class="about-one__title__shape">
                            </div>

                            <p class="about-one__text"> The strength of Ganapathy NSS lies in its passionate founders and the collective commitment of its members. Our organization was founded with the vision of creating a cohesive, culturally rich, and service-minded community. We gratefully remember and acknowledge our distinguished founding members:
                            </p>
                            <!-- /.about-one__text -->
                            <div class="about-one__content__box">
                                <div class="about-one__content__box-left">
                                    <img src="assets/images/resources/about-img-2.png" alt="pelocis">
                                </div>

                                <div class="about-one__content__box-right">
                                    <ul class="list-unstyled d-flex  flex-column m-0">
                                        <li>
                                            <span><i class="fa fa-arrow-right"></i></span>
                                            “Unity, Service, Culture – The Pillars of Our Progress”
                                            </li>
                                  
                                    </ul>
                                </div>
                            </div>
                            <ul class="list-unstyled service-details__card__list d-flex align-items-center gap-3 p-0">
                                <li>
                                    <!-- <span class="icon-arrow-circle-check"></span>
                                    The right therapist can help you develop the skills to manage your
                                    solution this is mental health to find them. -->
                                </li>

                            </ul>
                            <a href="services.html" class="pelocis-btn about-one__link"><span>About More <i class="icon-right-arrow-white"></i></span></a>
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.about-one -->

        <!-- team section -->
        <section class="team-two">
            <div class="container">
                <div class="team-two__title text-center">
                    <div class="sec-title">



                        <div class="sec-title__shape">
                        </div>
                        <h6 class="sec-title__tagline">Our Foundation and Growth
                        </h6><!-- /.sec-title__tagline -->

                        <p >The strength of Ganapathy NSS lies in its passionate founders and the collective commitment of its members. Our organization was founded with the vision of creating a cohesive, culturally rich, and service-minded community. We gratefully remember and acknowledge our distinguished founding members:
                        </p><!-- /.sec-title__title -->
                    </div><!-- /.sec-title -->
                </div>
                <div class="row gutter-y-30">
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='000ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/1.png" alt="">
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. K Gopakumar – Former President</a></h3>
                                <span class="team-two__card__designation"> Former President</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='200ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/2.png" alt="pelocis">
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. J. Ravindran</a></h3>
                                <span class="team-two__card__designation">Current President</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='300ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/3.png" alt="">
                          
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. K C Mohandas </a></h3>
                                <span class="team-two__card__designation">Former Treasurer </span>
                            </div>
                        </div>
                  
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='300ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/4.png" alt="pelocis">
                             
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. C M Shivadasan </a></h3>
                                <span class="team-two__card__designation">Former Joint Secretary </span>
                            </div>
                        </div>
                  
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='300ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/5.png" alt="pelocis">
                             
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. E Chandrasekharan Nair  </a></h3>
                                <span class="team-two__card__designation">Former Vice President & Building Committee Chairman
                                </span>
                            </div>
                        </div>
                  
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='300ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/6.png" alt="pelocis">
                             
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. P. Silleeswara Babu </a></h3>
                                <span class="team-two__card__designation">Current Secretary</span>
                            </div>
                        </div>
                  
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='100ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/7.png" alt="pelocis">
                              
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Sri. B. Prasad  </a></h3>
                                <span class="team-two__card__designation">Current Vice PresidentS</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-two__card wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='300ms'>
                            <div class="team-two__card__img">
                                <img src="assets/images/resources/8.png" alt="pelocis">
                              
                            </div>
                            <div class="team-two__card__content">
                                <h3 class="team-two__card__name"><a href="#">Late Sri. Parameswaran Nair </a></h3>
                                <span class="team-two__card__designation">Former Treasurer</span>
                            </div>
                        </div>
                  
                    </div>
                </div>
                <p >With their leadership and the wholehearted support of several eminent members, we successfully inaugurated our own building on 19th April 2015 at: No. 20, Umayalpuram, Opposite MGR Playground, 
                    Vilankuruchi Road, Saravanampatti Post, Coimbatore – 641035.This landmark was made possible through the generous contributions of our members and philanthropists who believed in our cause.

                </p><!-- /.sec-title__title -->
            </div>
        </section>



        <!-- achievement one -->
        <!-- <section class="achievement-one achievement-one--about-page">
            <div class="container">
                <div class="achievement-one__wrapper wow fadeInUp">
                    <div class="achievement-one__card count-box">
                        <div class="achievement-one__card__hover" style="background-image: url(assets/images/shapes/achievement-one-shape.png);"></div>
                        <div class="achievement-one__card__icon">
                            <span class="icon-succefull"></span>
                        </div>
                        <h3 class="achievement-one__card__count"><span class="count-text" data-stop="965" data-speed="1500"></span>k+</h3>
                        <p class="achievement-one__card__text">Projects Succefull</p>
                    </div>
                    <div class="achievement-one__card count-box">
                        <div class="achievement-one__card__hover" style="background-image: url(assets/images/shapes/achievement-one-shape.png);"></div>
                        <div class="achievement-one__card__icon">
                            <span class="icon-customers"></span>
                        </div>
                        <h3 class="achievement-one__card__count"><span class="count-text" data-stop="850" data-speed="1500"></span>+</h3>
                        <p class="achievement-one__card__text">Happy Customers</p>
                    </div>
                    <div class="achievement-one__card count-box">
                        <div class="achievement-one__card__hover" style="background-image: url(assets/images/shapes/achievement-one-shape.png);"></div>
                        <div class="achievement-one__card__icon">
                            <span class="icon-planing"></span>
                        </div>
                        <h3 class="achievement-one__card__count"><span class="count-text" data-stop="965" data-speed="1500"></span>k+</h3>
                        <p class="achievement-one__card__text">Consultants Planing</p>
                    </div>
                    <div class="achievement-one__card count-box">
                        <div class="achievement-one__card__hover" style="background-image: url(assets/images/shapes/achievement-one-shape.png);"></div>
                        <div class="achievement-one__card__icon">
                            <span class="icon-awards"></span>
                        </div>
                        <h3 class="achievement-one__card__count"><span class="count-text" data-stop="985" data-speed="1500"></span>+</h3>
                        <p class="achievement-one__card__text">Awards Win</p>
                    </div>
                </div>
            </div>
        </section> -->


        <!-- why-choose-one -->
        <section class="why-choose-one">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="why-choose-one__content wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='000ms'>
                            <div class="why-choose-one__title">
                                <div class="sec-title">



                                    <div class="sec-title__shape">
                                    </div>
                                    <h6 class="sec-title__tagline">What We Do
                                    </h6><!-- /.sec-title__tagline -->
                                    <p class="why-choose-one__text">
                            We believe in giving back to society while fostering unity and cultural pride among our members.
                            </p><!-- /.why-choose-one__text -->
                                    <h3 class="sec-title__title">Our initiatives include:
                                    </h3><!-- /.sec-title__title -->
                                </div><!-- /.sec-title -->
                                <img src="assets/images/shapes/text-shape-2.png" alt="pelocis" class="why-choose-one__title__shape">
                            </div>
                     
                            <ul class="list-unstyled why-choose-one__list">
                                <li class="why-choose-one__list__item-one">
                                    <ul class="list-unstyled  d-flex gap-1 flex-column m-0">
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a>Charity and Disaster Relief Work
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Support for Orphanages and Education for Needy Students
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Cultural Celebrations and Traditional Festivals
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Drawing & Painting Competitions for Students
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Domestic, National & International Tours and Pilgrimages
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Medical Camps & Health Awareness Programs
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Marriage Bureau & After-Death Ritual Support
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Dance, Yoga, and Self-Development Classes
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Marriage Register and Matchmaking Assistance
                                            </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Tie-up with Sri Ramakrishna Hospital for Member Benefits
                                        </a>
                                        </li>
                                        <li>
                                            <span class="fa fa-arrow-circle-right"></span>
                                            <a >Support and Collaboration with Other Like-Minded Organizations
                                        </a>
                                        </li>
                                    </ul>
                                </li>
                               
                            </ul><!-- /.list-unstyled why-choose-one__list -->
                        </div><!-- /.why-choose-one__content -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="why-choose-one__image count-box wow fadeInUp" data-wow-duration="1500ms" data-wow-delay='100ms'>
                            <img src="assets/images/resources/about-img-4.png" alt="pelocis">
                           
                        </div><!-- /.why-choose-one__image -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.why-choose-one -->

       


      



<?php
include("footer.php");
?>