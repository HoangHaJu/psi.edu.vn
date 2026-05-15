const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Counter animation
const counters = document.querySelectorAll('.counter');
const speed = 300; // smaller is faster

counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText.replace(/\D/g, '');
        const inc = Math.max(Math.floor(target / speed), 1);

        if (count < target) {
            counter.innerText = new Intl.NumberFormat().format(count + inc);
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = new Intl.NumberFormat().format(target) + "+";
        }
    };

    updateCount();
});