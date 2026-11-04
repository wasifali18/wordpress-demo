document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.request-form').forEach((form) => {
        const button = form.querySelector('.request-submit');
        const feedback = form.querySelector('.request-feedback');

        if (!(button instanceof HTMLButtonElement) || !(feedback instanceof HTMLElement)) {
            return;
        }

        button.addEventListener('click', () => {
            feedback.textContent = 'Agent integration is not connected yet. Your request was not sent or saved.';
        });
    });
});
