/* faq.js */

document.addEventListener('DOMContentLoaded', function() {

    var questions = document.querySelectorAll('.faq-question');
    for (var i = 0; i < questions.length; i++) {
        questions[i].addEventListener('click', function() {
            var item = this.closest('.faq-item');
            var isOpen = item.classList.contains('open');

            var openItems = document.querySelectorAll('.faq-item.open');
            for (var j = 0; j < openItems.length; j++) {
                openItems[j].classList.remove('open');
            }

            if (!isOpen) {
                item.classList.add('open');
            }
        });
    }

});
