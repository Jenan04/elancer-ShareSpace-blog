document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('main-header');
    const nav = header?.querySelector('nav');

    if (!header) return; 

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.remove('py-4');
            header.classList.add('py-2');
            
            nav?.classList.remove('bg-surface-container-high/80');
            nav?.classList.add('bg-white', 'shadow-md');
        } else {
            header.classList.remove('py-2');
            header.classList.add('py-4');
            
            nav?.classList.remove('bg-white', 'shadow-md');
            nav?.classList.add('bg-surface-container-high/80');
        }
    });
});