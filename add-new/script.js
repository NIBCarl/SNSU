// Get the modal and elements
const modal = document.getElementById('modal');
const openModal = document.getElementById('openModal');
const closeModal = document.getElementById('closeModal');

// Open modal when clicking the cog icon
openModal.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Close modal when clicking the 'X' button
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal when clicking outside the modal content
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
