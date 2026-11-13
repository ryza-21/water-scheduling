
document.addEventListener('DOMContentLoaded', function () {
    const roleCards = document.querySelectorAll('.role-card');
    const selectedRole = document.getElementById('selectedRole');

    function chooseRole(card) {
        roleCards.forEach(function (item) {
            item.classList.remove('active');
            item.setAttribute('aria-pressed', 'false');
        });

        card.classList.add('active');
        card.setAttribute('aria-pressed', 'true');

        if (selectedRole) {
            selectedRole.value = card.dataset.role;
        }
    }

    roleCards.forEach(function (card) {
        card.style.cursor = 'pointer';

        card.addEventListener('click', function () {
            chooseRole(card);
        });

        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                chooseRole(card);
            }
        });
    });

    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
            const show = password.type === 'password';

            password.type = show ? 'text' : 'password';
            togglePassword.classList.toggle('fa-eye', !show);
            togglePassword.classList.toggle('fa-eye-slash', show);
        });
    }
});
