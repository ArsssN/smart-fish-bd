document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("form");
    const formInterval = setInterval(() => {
        const switches = form.querySelectorAll("[data-repeatable-identifier='switches'] [data-repeatable-input-name='number']");

        if (!switches) {
            return;
        }

        clearInterval(formInterval);

        switches.forEach((switchElement, index) => {
            // if no value is set, set it to index + 1
            if (!switchElement.value) {
                switchElement.value = index + 1;
            }
        });
    }, 100);
});
