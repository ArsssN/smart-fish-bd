<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Smart Fish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<!-- Styles -->
<style>
    :root {
        --primary: #0d6efd
    }

    .navbar-nav .nav-link.active,
    .navbar-nav .nav-link.show {
        color: var(--primary)
    }

    .title {
        color: var(--primary);
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    #heroCarousel .carousel-item {
        height: 450px;
    }

    #heroCarousel .carousel-item img {
        height: 100%;
        object-fit: cover;
    }

    img.card-img-top {
        height: 280px;
        object-fit: cover
    }

    .owl-nav button {
        position: absolute;
        top: 50%;
        background: #0a58ca !important;
        width: 36px;
        height: 36px;
        border-radius: 50% !important;
        color: #fff !important;
        opacity: .5;
        transition: all .4s;
    }

    .owl-nav button:hover {
        opacity: 1;
    }

    .owl-nav .owl-prev {
        left: 0;
    }

    .owl-nav .owl-next {
        right: 0;
    }

    @media (max-width:768) {
        #heroCarousel .carousel-item {
            height: 250px;
        }
    }
</style>

<body>
    {{-- MENU SECTION --}}
    <nav id="navbar-scroll-spy" class="navbar navbar-expand-lg bg-body-tertiary position-sticky top-0 z-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <svg id="logo-52" width="170" height="41" viewBox="0 0 170 41" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M51.2775 29.3232H63.2295V25.7232H55.5255V12.1632H51.2775V29.3232Z" class="cneutral"
                        fill="#2F234F"></path>
                    <path
                        d="M70.3106 26.9232C68.6066 26.9232 67.7186 25.4352 67.7186 23.2032C67.7186 20.9712 68.6066 19.4592 70.3106 19.4592C72.0146 19.4592 72.9266 20.9712 72.9266 23.2032C72.9266 25.4352 72.0146 26.9232 70.3106 26.9232ZM70.3346 29.7072C74.2946 29.7072 76.8866 26.8992 76.8866 23.2032C76.8866 19.5072 74.2946 16.6992 70.3346 16.6992C66.3986 16.6992 63.7586 19.5072 63.7586 23.2032C63.7586 26.8992 66.3986 29.7072 70.3346 29.7072Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M83.741 33.5712C85.565 33.5712 87.173 33.1632 88.253 32.2032C89.237 31.3152 89.885 29.9712 89.885 28.1232V17.0352H86.141V18.3552H86.093C85.373 17.3232 84.269 16.6752 82.637 16.6752C79.589 16.6752 77.477 19.2192 77.477 22.8192C77.477 26.5872 80.045 28.6512 82.805 28.6512C84.293 28.6512 85.229 28.0512 85.949 27.2352H86.045V28.4592C86.045 29.9472 85.349 30.8112 83.693 30.8112C82.397 30.8112 81.749 30.2592 81.533 29.6112H77.741C78.125 32.1792 80.357 33.5712 83.741 33.5712ZM83.717 25.7472C82.253 25.7472 81.293 24.5472 81.293 22.6992C81.293 20.8272 82.253 19.6272 83.717 19.6272C85.349 19.6272 86.213 21.0192 86.213 22.6752C86.213 24.4032 85.421 25.7472 83.717 25.7472Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M97.5834 26.9232C95.8794 26.9232 94.9914 25.4352 94.9914 23.2032C94.9914 20.9712 95.8794 19.4592 97.5834 19.4592C99.2874 19.4592 100.199 20.9712 100.199 23.2032C100.199 25.4352 99.2874 26.9232 97.5834 26.9232ZM97.6074 29.7072C101.567 29.7072 104.159 26.8992 104.159 23.2032C104.159 19.5072 101.567 16.6992 97.6074 16.6992C93.6714 16.6992 91.0314 19.5072 91.0314 23.2032C91.0314 26.8992 93.6714 29.7072 97.6074 29.7072Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M105.302 29.3232H109.214V17.0352H105.302V29.3232ZM105.302 15.3312H109.214V12.1632H105.302V15.3312Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M110.911 33.3792H114.823V28.0512H114.871C115.639 29.0832 116.767 29.7072 118.351 29.7072C121.567 29.7072 123.703 27.1632 123.703 23.1792C123.703 19.4832 121.711 16.6752 118.447 16.6752C116.767 16.6752 115.567 17.4192 114.727 18.5232H114.655V17.0352H110.911V33.3792ZM117.343 26.6832C115.663 26.6832 114.703 25.3152 114.703 23.3232C114.703 21.3312 115.567 19.8192 117.271 19.8192C118.951 19.8192 119.743 21.2112 119.743 23.3232C119.743 25.4112 118.831 26.6832 117.343 26.6832Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M130.072 29.7072C133.288 29.7072 135.664 28.3152 135.664 25.6272C135.664 22.4832 133.12 21.9312 130.96 21.5712C129.4 21.2832 128.008 21.1632 128.008 20.2992C128.008 19.5312 128.752 19.1712 129.712 19.1712C130.792 19.1712 131.536 19.5072 131.68 20.6112H135.28C135.088 18.1872 133.216 16.6752 129.736 16.6752C126.832 16.6752 124.432 18.0192 124.432 20.6112C124.432 23.4912 126.712 24.0672 128.848 24.4272C130.48 24.7152 131.968 24.8352 131.968 25.9392C131.968 26.7312 131.224 27.1632 130.048 27.1632C128.752 27.1632 127.936 26.5632 127.792 25.3392H124.096C124.216 28.0512 126.472 29.7072 130.072 29.7072Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M140.978 29.6832C142.682 29.6832 143.762 29.0112 144.65 27.8112H144.722V29.3232H148.466V17.0352H144.554V23.8992C144.554 25.3632 143.738 26.3712 142.394 26.3712C141.146 26.3712 140.546 25.6272 140.546 24.2832V17.0352H136.658V25.0992C136.658 27.8352 138.146 29.6832 140.978 29.6832Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path
                        d="M150.168 29.3232H154.08V22.4352C154.08 20.9712 154.8 19.9392 156.024 19.9392C157.2 19.9392 157.752 20.7072 157.752 22.0272V29.3232H161.664V22.4352C161.664 20.9712 162.36 19.9392 163.608 19.9392C164.784 19.9392 165.336 20.7072 165.336 22.0272V29.3232H169.248V21.3312C169.248 18.5712 167.856 16.6752 165.072 16.6752C163.488 16.6752 162.168 17.3472 161.208 18.8352H161.16C160.536 17.5152 159.312 16.6752 157.704 16.6752C155.928 16.6752 154.752 17.5152 153.984 18.7872H153.912V17.0352H150.168V29.3232Z"
                        class="cneutral" fill="#2F234F"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M20.1014 40.3232C31.1472 40.3232 40.1014 31.3689 40.1014 20.3232C40.1014 9.27754 31.1472 0.323242 20.1014 0.323242C9.05573 0.323242 0.10144 9.27754 0.10144 20.3232C0.10144 31.3689 9.05573 40.3232 20.1014 40.3232ZM23.1884 15.7758C24.8932 14.0709 24.8932 11.3068 23.1884 9.6019C21.4835 7.89702 18.7194 7.89702 17.0145 9.6019C15.3097 11.3068 15.3097 14.0709 17.0145 15.7758L20.1014 18.8627L23.1884 15.7758ZM24.6489 23.4102C26.3538 25.1151 29.1179 25.1151 30.8228 23.4102C32.5276 21.7053 32.5276 18.9412 30.8228 17.2363C29.1179 15.5315 26.3538 15.5315 24.6489 17.2363L21.562 20.3233L24.6489 23.4102ZM23.1884 31.0446C24.8932 29.3397 24.8932 26.5756 23.1884 24.8707L20.1014 21.7838L17.0145 24.8707C15.3097 26.5756 15.3097 29.3397 17.0145 31.0446C18.7194 32.7495 21.4835 32.7495 23.1884 31.0446ZM9.38007 23.4102C7.67523 21.7053 7.67523 18.9412 9.38007 17.2363C11.085 15.5315 13.8491 15.5315 15.554 17.2363L18.6409 20.3233L15.554 23.4102C13.8491 25.1151 11.085 25.1151 9.38007 23.4102Z"
                        class="ccustom" fill="#7F57F1"></path>
                </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-uppercase">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#welcome">Welcome</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#our-service">our services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#our-team">our team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div data-bs-spy="scroll" data-bs-target="#navbar-scroll-spy" data-bs-smooth-scroll="true">
        {{-- HERO SLIDER SECTION --}}
        <section id="welcome" class="main-banner">
            <div id="heroCarousel" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://picsum.photos/640/360" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/640/360" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/640/360" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        {{-- ABOUT SECTION --}}
        <section id="about" class="about-section py-3 py-md-5">
            <div class="container">
                <h1 class="title">About Smart Fish</h1>

                <div class=" row align-items-center gap-4 gap-lg-0">
                    <div class="col-lg-6">
                        <img src="https://picsum.photos/640/360" alt="Smart Fish" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-6">
                        <p>Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to
                            revolutionize
                            the way
                            people experience and interact with fishkeeping. As avid enthusiasts of marine life, we
                            understand
                            the importance of creating a harmonious environment for both fish and their owners.</p>

                        <p>At Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for
                            fish
                            care. Whether you're a seasoned aquarist or just starting, our products are designed to make
                            fish
                            keeping not only enjoyable but also sustainable.</p>

                        <p>Our team of marine biologists, engineers, and designers work collaboratively to develop
                            state-of-the-art devices that monitor and optimize the conditions of your aquarium. From
                            smart
                            feeders to water quality sensors, we have everything you need to ensure the well-being of
                            your
                            aquatic companions.</p>

                        <p>Join us on this journey as we strive to create a world where fishkeeping is not just a hobby
                            but
                            a
                            seamless integration of nature and technology. Explore the Smart Fish experience and
                            discover a
                            new
                            era in aquatic living.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- OUR SERVICE SECTION --}}
        <section id="our-service" class="our-service-section py-3 py-md-5 bg-body-secondary bg-opacity-50">
            <div class="container">
                <h1 class="title">Our Services</h1>

                <div class="row">
                    <div class="owl-carousel owl-theme">
                        <?php
                        for ($i = 0; $i < 4; $i++) {
                            echo '<div class="card h-100">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <img src="https://picsum.photos/640/360" class="card-img-top" alt="Service 1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="card-body">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <h5 class="card-title">Automated Feeding Solutions</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <p class="card-text">Experience hassle-free fish feeding with our smart automated feeding solutions. Set schedules and portions to keep your fish healthy and well-fed.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="" class="btn btn-primary mt-3">Details</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        {{-- OUR TEAM SECTION --}}
        <section id="our-team" class="our-team-section py-3 py-md-5">
            <div class="container">
                <h1 class="title">Our Team</h1>
                <div class="owl-carousel owl-theme">
                    <?php
                    for ($i = 0; $i < 4; $i++) {
                        echo '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <div class="card h-100">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="https://i.pravatar.cc/150?img=56" class="card-img-top" alt="Team Member 1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="card-body text-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <h5 class="card-title">John Doe</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <p class="card-text">Marine Biologist</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <a href="#" class="btn btn-primary mt-3">Connect</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        {{-- CONTACT SECTION --}}
        <section id="contact" class="contact-section py-3 py-md-5 bg-body-secondary bg-opacity-50">
            <div class="container">
                <h1 class="title">Contact Us</h1>

                <div class="row">
                    <div class="col-md-6">
                        <form class="bg-white p-4 rounded-3 shadow-sm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="name" placeholder="John Doe"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="john@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea class="form-control" id="message" rows="4" placeholder="Write your message here" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>

                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Visit Us</h5>
                                <p class="card-text">123 Smart Fish Lane<br> Aquacity, Oceanland</p>
                            </div>
                        </div>

                        <div class="card border-0 mt-4">
                            <div class="card-body">
                                <h5 class="card-title">Contact Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                                    <li><strong>Email:</strong> info@smartfish.com</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- FOOTER SECTION --}}
    <footer class="bg-white text-dark pt-4 pt-md-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <a href="#welcome" class="mb-3 d-block">
                        <svg id="logo-52" width="170" height="41" viewBox="0 0 170 41" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M51.2775 29.3232H63.2295V25.7232H55.5255V12.1632H51.2775V29.3232Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M70.3106 26.9232C68.6066 26.9232 67.7186 25.4352 67.7186 23.2032C67.7186 20.9712 68.6066 19.4592 70.3106 19.4592C72.0146 19.4592 72.9266 20.9712 72.9266 23.2032C72.9266 25.4352 72.0146 26.9232 70.3106 26.9232ZM70.3346 29.7072C74.2946 29.7072 76.8866 26.8992 76.8866 23.2032C76.8866 19.5072 74.2946 16.6992 70.3346 16.6992C66.3986 16.6992 63.7586 19.5072 63.7586 23.2032C63.7586 26.8992 66.3986 29.7072 70.3346 29.7072Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M83.741 33.5712C85.565 33.5712 87.173 33.1632 88.253 32.2032C89.237 31.3152 89.885 29.9712 89.885 28.1232V17.0352H86.141V18.3552H86.093C85.373 17.3232 84.269 16.6752 82.637 16.6752C79.589 16.6752 77.477 19.2192 77.477 22.8192C77.477 26.5872 80.045 28.6512 82.805 28.6512C84.293 28.6512 85.229 28.0512 85.949 27.2352H86.045V28.4592C86.045 29.9472 85.349 30.8112 83.693 30.8112C82.397 30.8112 81.749 30.2592 81.533 29.6112H77.741C78.125 32.1792 80.357 33.5712 83.741 33.5712ZM83.717 25.7472C82.253 25.7472 81.293 24.5472 81.293 22.6992C81.293 20.8272 82.253 19.6272 83.717 19.6272C85.349 19.6272 86.213 21.0192 86.213 22.6752C86.213 24.4032 85.421 25.7472 83.717 25.7472Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M97.5834 26.9232C95.8794 26.9232 94.9914 25.4352 94.9914 23.2032C94.9914 20.9712 95.8794 19.4592 97.5834 19.4592C99.2874 19.4592 100.199 20.9712 100.199 23.2032C100.199 25.4352 99.2874 26.9232 97.5834 26.9232ZM97.6074 29.7072C101.567 29.7072 104.159 26.8992 104.159 23.2032C104.159 19.5072 101.567 16.6992 97.6074 16.6992C93.6714 16.6992 91.0314 19.5072 91.0314 23.2032C91.0314 26.8992 93.6714 29.7072 97.6074 29.7072Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M105.302 29.3232H109.214V17.0352H105.302V29.3232ZM105.302 15.3312H109.214V12.1632H105.302V15.3312Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M110.911 33.3792H114.823V28.0512H114.871C115.639 29.0832 116.767 29.7072 118.351 29.7072C121.567 29.7072 123.703 27.1632 123.703 23.1792C123.703 19.4832 121.711 16.6752 118.447 16.6752C116.767 16.6752 115.567 17.4192 114.727 18.5232H114.655V17.0352H110.911V33.3792ZM117.343 26.6832C115.663 26.6832 114.703 25.3152 114.703 23.3232C114.703 21.3312 115.567 19.8192 117.271 19.8192C118.951 19.8192 119.743 21.2112 119.743 23.3232C119.743 25.4112 118.831 26.6832 117.343 26.6832Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M130.072 29.7072C133.288 29.7072 135.664 28.3152 135.664 25.6272C135.664 22.4832 133.12 21.9312 130.96 21.5712C129.4 21.2832 128.008 21.1632 128.008 20.2992C128.008 19.5312 128.752 19.1712 129.712 19.1712C130.792 19.1712 131.536 19.5072 131.68 20.6112H135.28C135.088 18.1872 133.216 16.6752 129.736 16.6752C126.832 16.6752 124.432 18.0192 124.432 20.6112C124.432 23.4912 126.712 24.0672 128.848 24.4272C130.48 24.7152 131.968 24.8352 131.968 25.9392C131.968 26.7312 131.224 27.1632 130.048 27.1632C128.752 27.1632 127.936 26.5632 127.792 25.3392H124.096C124.216 28.0512 126.472 29.7072 130.072 29.7072Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M140.978 29.6832C142.682 29.6832 143.762 29.0112 144.65 27.8112H144.722V29.3232H148.466V17.0352H144.554V23.8992C144.554 25.3632 143.738 26.3712 142.394 26.3712C141.146 26.3712 140.546 25.6272 140.546 24.2832V17.0352H136.658V25.0992C136.658 27.8352 138.146 29.6832 140.978 29.6832Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path
                                d="M150.168 29.3232H154.08V22.4352C154.08 20.9712 154.8 19.9392 156.024 19.9392C157.2 19.9392 157.752 20.7072 157.752 22.0272V29.3232H161.664V22.4352C161.664 20.9712 162.36 19.9392 163.608 19.9392C164.784 19.9392 165.336 20.7072 165.336 22.0272V29.3232H169.248V21.3312C169.248 18.5712 167.856 16.6752 165.072 16.6752C163.488 16.6752 162.168 17.3472 161.208 18.8352H161.16C160.536 17.5152 159.312 16.6752 157.704 16.6752C155.928 16.6752 154.752 17.5152 153.984 18.7872H153.912V17.0352H150.168V29.3232Z"
                                class="cneutral" fill="#2F234F"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20.1014 40.3232C31.1472 40.3232 40.1014 31.3689 40.1014 20.3232C40.1014 9.27754 31.1472 0.323242 20.1014 0.323242C9.05573 0.323242 0.10144 9.27754 0.10144 20.3232C0.10144 31.3689 9.05573 40.3232 20.1014 40.3232ZM23.1884 15.7758C24.8932 14.0709 24.8932 11.3068 23.1884 9.6019C21.4835 7.89702 18.7194 7.89702 17.0145 9.6019C15.3097 11.3068 15.3097 14.0709 17.0145 15.7758L20.1014 18.8627L23.1884 15.7758ZM24.6489 23.4102C26.3538 25.1151 29.1179 25.1151 30.8228 23.4102C32.5276 21.7053 32.5276 18.9412 30.8228 17.2363C29.1179 15.5315 26.3538 15.5315 24.6489 17.2363L21.562 20.3233L24.6489 23.4102ZM23.1884 31.0446C24.8932 29.3397 24.8932 26.5756 23.1884 24.8707L20.1014 21.7838L17.0145 24.8707C15.3097 26.5756 15.3097 29.3397 17.0145 31.0446C18.7194 32.7495 21.4835 32.7495 23.1884 31.0446ZM9.38007 23.4102C7.67523 21.7053 7.67523 18.9412 9.38007 17.2363C11.085 15.5315 13.8491 15.5315 15.554 17.2363L18.6409 20.3233L15.554 23.4102C13.8491 25.1151 11.085 25.1151 9.38007 23.4102Z"
                                class="ccustom" fill="#7F57F1"></path>
                        </svg>
                    </a>
                    <p>Contact Information:</p>
                    <p>123 Smart Fish Lane<br> Aquacity, Oceanland</p>
                    <p><strong>Email:</strong> info@smartfish.com</p>
                    <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-3">Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark">Home</a></li>
                        <li><a href="#" class="text-dark">About Us</a></li>
                        <li><a href="#" class="text-dark">Our Services</a></li>
                        <li><a href="#" class="text-dark">Our Team</a></li>
                        <li><a href="#" class="text-dark">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-3">Follow Us</h5>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#" class="text-dark">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a></li>
                        <li class="list-inline-item"><a href="#" class="text-dark">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube">
                                    <path
                                        d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                                    </path>
                                    <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                                </svg>
                            </a></li>
                        <li class="list-inline-item"><a href="#" class="text-dark">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin">
                                    <path
                                        d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                    </path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- jQuery (necessary for Owl Carousel) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        const navLink = document.querySelectorAll('.nav-link')
        navLink.forEach((item) => {
            item.addEventListener('click', (e) => {
                navLink.forEach(data => {
                    data.classList.remove('active')
                })
                e.target.classList.add('active')
            })
        })

        $(document).ready(function() {

            $("#our-service .owl-carousel").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
            $("#our-team .owl-carousel").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });


        });
    </script>
</body>

</html>
