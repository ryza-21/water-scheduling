// Dashboard Interactivity Script
document.addEventListener('DOMContentLoaded', () => {
    console.log("Water Seeker Dashboard loaded successfully.");

    // Simple interactivity example for approval buttons
    const approveButtons = document.querySelectorAll('.btn-approve');
    const declineButtons = document.querySelectorAll('.btn-decline');

    approveButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            alert('Request approved successfully!');
            row.style.opacity = '0.5';
        });
    });

    declineButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            alert('Request declined.');
            row.style.opacity = '0.5';
        });
    });
});