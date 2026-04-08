document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const faqItem = button.parentElement;
        const answer = faqItem.querySelector('.faq-answer');

        // Close all other answers
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) {
                const otherAnswer = item.querySelector('.faq-answer');
                const otherButton = item.querySelector('.faq-question');
                otherAnswer.style.maxHeight = '0';
                otherAnswer.hidden = true;
                otherButton.classList.remove('active');
                otherButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Toggle current answer
        button.classList.toggle('active');
        if (button.classList.contains('active')) {
            answer.hidden = false;
            answer.style.maxHeight = answer.scrollHeight + 30 + "px";
            button.setAttribute('aria-expanded', 'true');
        } else {
            answer.style.maxHeight = '0';
            answer.hidden = true;
            button.setAttribute('aria-expanded', 'false');
        }
    });
});
