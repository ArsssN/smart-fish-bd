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

    $("#our-product .owl-carousel").owlCarousel({
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

const contactUsForm = document.querySelector('#contact-us-form');
contactUsForm?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(contactUsForm);
    const data = Object.fromEntries(formData);

    const route = contactUsForm.getAttribute('action');

    const successSelector = contactUsForm.querySelector(`.success.success-message`);
    if (!successSelector.classList.contains('d-none')) {
        successSelector.classList.add('d-none');
    }

    const errorSelectors = contactUsForm.querySelectorAll(`.error`);
    errorSelectors.forEach((errorSelector) => {
        if (!errorSelector.classList.contains('d-none')) {
            errorSelector.classList.add('d-none');
        }
    });

    await fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then((response) => {
        grecaptcha.reset();

        if (!response.ok) {
            return response.json().then((error) => {
                throw error;
            });
        }

        return response.json();
    }).then((data) => {
        successSelector.classList.remove('d-none');
        successSelector.querySelector('.message').innerHTML = data.message;
        contactUsForm.reset();
    }).catch((error) => {
        Object.entries(error.errors).forEach(([name, messages]) => {
            const errorSelector = document.querySelector(`.error.error-${name}`);
            errorSelector.classList.toggle('d-none');
            errorSelector.querySelector('.alert').innerHTML = messages.join('<br>');
        });
    });
});
