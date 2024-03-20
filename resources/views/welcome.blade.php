<!DOCTYPE html>
@php($logo_white = "<img src='/assets/images/logo-white.svg' alt='Smart Fish' class='mr-1'><span class='text text-white'><b>Smart</b><span>Fish</span></span>")
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    {!! htmlScriptTagJsApi() !!}
</head>
<!-- Styles -->
<style>
</style>

<body>
{{-- MENU SECTION --}}
<nav id="navbar-scroll-spy" class="navbar navbar-expand-lg bg-body-tertiary position-sticky top-0 z-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#welcome">
            {!! $logo_white !!}
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
                    <a class="nav-link" href="#our-product">our products</a>
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
    <section id="welcome" class="main-banner bg-body-secondary bg-opacity-50">
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
            <h1 class="title">Welcome to Smart Fish BD</h1>
            <div>
                {!! $welcome_message !!}
            </div>
        </div>

    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="about-section py-3 py-md-5">
        <div class="container">
            <h1 class="title">About Smart Fish</h1>

            <div class="row align-items-center gap-4 gap-lg-0">
                <div class="col-lg-6">
                    <img src="{{ asset($about->image) }}" alt="Smart Fish about"
                         class="img-fluid rounded d-flex m-auto">
                </div>
                <div class="col-lg-6">
                    {!! $about->description !!}
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
                    @foreach($services as $service)
                        @php($short_description = \Illuminate\Support\Str::substr($service->description, 0, 100))
                        <div class="card h-100">
                            <img src="{{asset($service->image)}}" class="card-img-top" alt="Service {{ $loop->index }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $service->title }}
                                </h5>
                                <p class="card-text">
                                    {{ $short_description }}{{ strlen($service->description) > 100 ? '...' : ''}}
                                </p>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{$loop->index}}">
                                    Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @foreach($services as $service)
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$loop->index}}" tabindex="-1"
                         aria-labelledby="exampleModal{{$loop->index}}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModal{{$loop->index}}Label">
                                        {{ $service->title }}
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p style="white-space: pre-wrap">{!! $service->description !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- OUR PRODUCT SECTION --}}
    <section id="our-product" class="our-product-section py-3 py-md-5">
        <div class="container">
            <h1 class="title">Our Products</h1>

            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach($products as $product)
                        @php($short_description = \Illuminate\Support\Str::substr($product->description, 0, 100))
                        <div class="card h-100">
                            <img src="{{asset($product->image)}}" class="card-img-top" alt="Service {{ $loop->index }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $product->title }}
                                </h5>
                                <p class="card-text">
                                    {{ $short_description }}{{ strlen($product->description) > 100 ? '...' : ''}}
                                </p>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{$loop->index}}">
                                    Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @foreach($products as $product)
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$loop->index}}" tabindex="-1"
                         aria-labelledby="exampleModal{{$loop->index}}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModal{{$loop->index}}Label">
                                        {{ $product->title }}
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p style="white-space: pre-wrap">{!! $product->description !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- OUR TEAM SECTION --}}
    <section id="our-team" class="our-team-section py-3 py-md-5 bg-body-secondary bg-opacity-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="title">Our Team</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4 class="title">Consultants</h4>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($teamsGroup->consultants as $team)
                    <div class="col-12 col-md-4 col-xl-3 mb-4">
                        <div class="card consultant h-100">
                            <img src="{{ asset($team->image) }}" class="card-img-top p-2"
                                 alt="Team Member {{ $loop->iteration }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    {{ $team->name }}
                                </h5>
                                <p class="card-text">
                                    {{ $team->designation }}
                                </p>
                                <a href="#" class="btn btn-primary mt-3 d-none">Connect</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h4 class="title">Technicals</h4>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($teamsGroup->technicals as $team)
                    <div class="col-12 col-md-4 col-xl-3 mb-4">
                        <div class="card technical h-100">
                            <img src="{{ asset($team->image) }}" class="card-img-top p-2"
                                 alt="Team Member {{ $loop->iteration }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    {{ $team->name }}
                                </h5>
                                <p class="card-text">
                                    {{ $team->designation }}
                                </p>
                                <a href="#" class="btn btn-primary mt-3 d-none">Connect</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CONTACT SECTION --}}
    <section id="contact" class="contact-section py-3 py-md-5">
        <div class="container">
            <h1 class="title">Contact Us</h1>

            <div class="row">
                <div class="col-md-6">
                    <form id="contact-us-form" class="bg-white p-4 rounded-3 shadow-sm"
                          action="{{ route('contact.submit') }}"
                          method="POST">
                        @csrf

                        <div class="success success-message d-none mb-2">
                            <div class="alert alert-success alert-dismissible py-1 px-2 rounded mb-0">
                                <button type="button" class="btn-close p-0 translate-middle-y top-50 me-1"
                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                <span class="message"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                            >
                            <div class="error error-name d-none mt-1">
                                <div class="alert alert-danger py-0 px-1 rounded"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="john@example.com">
                            <div class="error error-email d-none mt-1">
                                <div class="alert alert-danger py-0 px-1 rounded"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4"
                                      placeholder="Write your message here"
                            ></textarea>
                            <div class="error error-message d-none mt-1">
                                <div class="alert alert-danger py-0 px-1 rounded"></div>
                            </div>
                        </div>

                        <div class="mb-3 recaptcha">
                            {!! htmlFormSnippet() !!}
                            <div class="error error-{{recaptchaFieldName()}} d-none mt-1">
                                <div class="alert alert-danger py-0 px-1 rounded"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Message</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>

                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Visit Us</h5>
                            <p class="card-text" style="white-space: pre-wrap">{!! $contact_info->address !!}</p>
                        </div>
                    </div>

                    <div class="card border-0 mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Contact Information</h5>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <strong>Phone:</strong> <a
                                        href="tel:{!! $contact_info->phone !!}">{!! $contact_info->phone !!}</a>
                                </li>
                                <li>
                                    <strong>Email:</strong> <a
                                        href="mailto:{!! $contact_info->email !!}">{!! $contact_info->email !!}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- FOOTER SECTION --}}
<footer class="text-dark bg-body-secondary bg-opacity-50 pt-4 pt-md-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <a href="#welcome" class="mb-3 d-block footer-brand">
                    {!! $logo_white !!}
                </a>
                <p>Contact Information:</p>
                <p style="white-space: pre-wrap">{!! $contact_info->address !!}</p>
                <p>
                    <strong>Phone:</strong> <a href="tel:{{ $contact_info->phone }}"
                                               class="text-dark">{{ $contact_info->phone }}</a>
                </p>
                <p>
                    <strong>Email:</strong> <a href="mailto:{{ $contact_info->email }}"
                                               class="text-dark">{{ $contact_info->email }}</a>
                </p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="mb-3">Menu</h5>
                <ul class="list-unstyled mb-0">
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
