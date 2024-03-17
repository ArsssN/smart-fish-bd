const navLink = document.querySelectorAll('.nav-link')
navLink.forEach((item) => {
    item.addEventListener('click', (e) => {
        /*navLink.forEach(data => {
            data.classList.remove('active')
        });

        setTimeout(() => {
            item.classList.add('active')
        }, 1000);*/
    })
})

$(document).ready(function () {
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
