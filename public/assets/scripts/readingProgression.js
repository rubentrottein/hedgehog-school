document.addEventListener('scroll', function() {
    const article = document.querySelector('body');
    const progressBar = document.querySelector('.scroll-bar');

    const articleRect = article.getBoundingClientRect();
    const articleTop = articleRect.top;
    const articleHeight = articleRect.height;

    const windowHeight = window.innerHeight;
    const totalScroll = articleHeight - windowHeight;

    if (articleTop < 0 && Math.abs(articleTop) <= totalScroll) {
        const progress = (Math.abs(articleTop) / totalScroll) * 100;
        progressBar.style.width = `${progress}%`;
    } else if (Math.abs(articleTop) > totalScroll) {
        progressBar.style.width = '100%';
    } else {
        progressBar.style.width = '0%';
    }
});