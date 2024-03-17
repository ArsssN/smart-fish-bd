<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {!! $contact_info->title !!}
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link rel="icon"
          href="{{ asset($contact_info->favicon) }}"
          type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/pages/welcome.css') }}" rel="stylesheet">

    <link href="{{ asset('packages/bootstrap-iconpicker/icon-fonts/font-awesome-5.12.0-1/css/all.min.css') }}"
          rel="stylesheet">
</head>
<!-- Styles -->
<style>
</style>

<body>
{{-- MENU SECTION --}}
<nav id="navbar-scroll-spy" class="navbar navbar-expand-lg bg-body-tertiary position-sticky top-0 z-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#welcome">
            {!! config('backpack.base.project_logo') !!}
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
    <section id="welcome" class="main-banner bg-body-secondary">
        <div id="heroCarousel2" class="carousel slide mb-4">
            <div class="carousel-indicators">
                @foreach($banner_images as $banner_image)
                    <button type="button" data-bs-target="#heroCarousel2" data-bs-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"
                            aria-label="Slide {{ $loop->index }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($banner_images as $banner_image)
                    <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                        <img
                            src="{{ asset($banner_image) }}"
                            class="d-block w-100" alt="{{ $loop->iteration }} slide">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel2"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel2"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container">
            <h1 class="title">Welcome message</h1>
            <p>
                Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the
                way
                people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the
                importance of creating a harmonious environment for both fish and their owners.
            </p>
        </div>

    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="about-section py-3 py-md-5">
        <div class="container">
            <h1 class="title">About Smart Fish</h1>

            <div class="row align-items-center gap-4 gap-lg-0">
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

                    @for ($i = 0; $i < 4; $i++)
                        <div class="card h-100">
                            <img src="https://picsum.photos/640/360" class="card-img-top" alt="Service 1">
                            <div class="card-body">
                                <h5 class="card-title">Automated Feeding Solutions</h5>
                                <p class="card-text">Experience hassle-free fish feeding with our smart automated
                                    feeding solutions. Set schedules and portions to keep your fish healthy and
                                    well-fed.</p>
                                <a href="" class="btn btn-primary mt-3">Details</a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    {{-- OUR TEAM SECTION --}}
    <section id="our-team" class="our-team-section py-3 py-md-5">
        <div class="container">
            <h1 class="title">Our Team</h1>
            <div class="owl-carousel owl-theme">
                @for ($i = 0; $i < 4; $i++)
                    <div class="card h-100">
                        <img src="https://i.pravatar.cc/150?img=56" class="card-img-top" alt="Team Member 1">
                        <div class="card-body text-center">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">Marine Biologist</p>
                            <a href="#" class="btn btn-primary mt-3">Connect</a>
                        </div>
                    </div>
                @endfor
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
                            <textarea class="form-control" id="message" rows="4" placeholder="Write your message here"
                                      required></textarea>
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
                <a href="#welcome" class="mb-3 d-block footer-brand">
                    {!! config('backpack.base.project_logo') !!}
                </a>
                <p>Contact Information:</p>
                <p>
                    {!! $contact_info->address !!}
                </p>
                <p><strong>Email:</strong> {!! $contact_info->email !!}</p>
                <p><strong>Phone:</strong> {!! $contact_info->phone !!}</p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="#welcome" class="text-dark">Home</a></li>
                    <li><a href="#about" class="text-dark">About Us</a></li>
                    <li><a href="#our-service" class="text-dark">Our Services</a></li>
                    <li><a href="#our-team" class="text-dark">Our Team</a></li>
                    <li><a href="#contact" class="text-dark">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="mb-3">Follow Us</h5>
                <ul class="list-inline">
                    @foreach($socials as $social)
                        <li class="list-inline-item" title="{{$social->title}}">
                            <a href="{{ $social->url }}" class="text-dark d-flex text-decoration-none" target="_blank">
                                <i class="fa-2x {{ $social->icon }}"></i>
                            </a>
                        </li>
                    @endforeach
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

<script src="{{ asset('assets/js/pages/welcome.js') }}"></script>

<script>
</script>
</body>

</html>
