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
                otherButton.classList.remove('active');
            }
        });

        // Toggle current answer
        button.classList.toggle('active');
        if (button.classList.contains('active')) {
            answer.style.maxHeight = answer.scrollHeight + 30 + "px";
        } else {
            answer.style.maxHeight = '0';
        }
    });
});