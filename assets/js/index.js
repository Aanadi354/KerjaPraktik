const container = document.getElementById('scroll-container');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');
const boxWidth = document.querySelector('.scroll-box').offsetWidth + 24; // Width of box + gap

// Set initial position to center the first content
window.addEventListener('load', () => {
    const centerPosition = (container.offsetWidth - boxWidth) / 2;
    container.scrollLeft = centerPosition;

    // Hide scroll buttons on mobile
    if (window.innerWidth <= 768) {
        document.querySelector('.scroll-buttons').style.display = 'none';
    }
});

let autoScroll = setInterval(() => {
    slideToNext();
}, 3000);

nextButton.addEventListener('click', () => {
    slideToNext();
    resetAutoScroll();
});

prevButton.addEventListener('click', () => {
    slideToPrev();
    resetAutoScroll();
});

function slideToNext() {
    const centerPosition = container.scrollLeft + boxWidth;
    if (container.scrollLeft + container.offsetWidth >= container.scrollWidth) {
        container.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
        container.scrollTo({ left: centerPosition, behavior: 'smooth' });
    }
}

function slideToPrev() {
    const centerPosition = container.scrollLeft - boxWidth;
    if (container.scrollLeft <= 0) {
        container.scrollTo({ left: container.scrollWidth, behavior: 'smooth' });
    } else {
        container.scrollTo({ left: centerPosition, behavior: 'smooth' });
    }
}

function resetAutoScroll() {
    clearInterval(autoScroll);
    autoScroll = setInterval(() => {
        slideToNext();
    }, 3000);
}

// Show full description
function showFullDescription(button) {
    const parent = button.parentElement;
    const fullDescription = parent.querySelector('.full-description');
    const truncatedText = parent.querySelector('p.description');

    if (fullDescription.classList.contains('hidden')) {
        fullDescription.classList.remove('hidden');
        fullDescription.style.display = 'block';
        truncatedText.style.display = 'none';
        button.innerText = 'Tutup';
    } else {
        fullDescription.classList.add('hidden');
        fullDescription.style.display = 'none';
        truncatedText.style.display = '-webkit-box';
        button.innerText = 'Selengkapnya';
    }
}

// Ensure all items have toggle functionality
function toggleDescription(button) {
    const parent = button.parentElement;
    const fullDescription = parent.querySelector('.full-description');
    const truncatedText = parent.querySelector('.description');

    if (fullDescription.style.display === 'block') {
        fullDescription.style.display = 'none';
        truncatedText.style.display = '-webkit-box';
        button.innerText = 'Selengkapnya';
    } else {
        fullDescription.style.display = 'block';
        truncatedText.style.display = 'none';
        button.innerText = 'Tutup';
    }
}