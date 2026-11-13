document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('.btn-add');

    console.log('Button found:', button);

    if (button) {
        button.addEventListener('click', function () {
            alert('Button is working!');
        });
    }
});