// Debounce function
const debounce = (func, wait = 10) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
};

// Fade-in Animation on Scroll
const fadeInElements = document.querySelectorAll('.fade-in');

const fadeInOnScroll = () => {
    fadeInElements.forEach((element) => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;

        // Check if the element is in the viewport
        if (elementTop < window.innerHeight && elementBottom >= 0) {
            element.classList.add('active');
        } else {
            element.classList.remove('active');
        }
    });
};

window.addEventListener('scroll', debounce(fadeInOnScroll));
fadeInOnScroll();

// Hover Effects for Cards
const cards = document.querySelectorAll('.card');

cards.forEach((card) => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-10px)';
        card.style.boxShadow = '0 12px 24px rgba(0, 0, 0, 0.2)';
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
    });

    // Mobile Touch Support
    card.addEventListener('touchstart', () => {
        card.style.transform = 'translateY(-10px)';
        card.style.boxShadow = '0 12px 24px rgba(0, 0, 0, 0.2)';
    });

    card.addEventListener('touchend', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
    });
});

// Smooth Scrolling for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth',
        });
    });
});

// Button Click Animation
const buttons = document.querySelectorAll('.btn');

buttons.forEach((button) => {
    button.addEventListener('click', () => {
        button.classList.add('clicked');
        setTimeout(() => {
            button.classList.remove('clicked');
        }, 300);
    });
});

// Form Validation
const forms = document.querySelectorAll('form');
forms.forEach((form) => {
    form.addEventListener('submit', (e) => {
        const inputs = form.querySelectorAll('input[required]');
        let isValid = true;
        inputs.forEach((input) => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });
        if (!isValid) {
            e.preventDefault();
            alert('Please fill out all required fields.');
        }
    });
});

// Lazy Loading for Images
const images = document.querySelectorAll('img[data-src]');
const lazyLoad = () => {
    images.forEach((img) => {
        if (img.getBoundingClientRect().top < window.innerHeight && img.getBoundingClientRect().bottom >= 0) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        }
    });
};

window.addEventListener('scroll', debounce(lazyLoad));
lazyLoad();