// public/js/home-banner.js

document.addEventListener('DOMContentLoaded', function () {


    console.log("home page js added ")
    const desktopBanner = document.querySelector('#desktopBanner');
    const mobileBanner  = document.querySelector('#mobileBanner');

    /* Desktop Banner - 10 Seconds */
    if (desktopBanner) {
        new bootstrap.Carousel(desktopBanner, {
            interval: 10000,
            ride: 'carousel',
            pause: 'hover',
            wrap: true,
            touch: true
        });
    }

    /* Mobile Banner - 10 Seconds */
    if (mobileBanner) {
        new bootstrap.Carousel(mobileBanner, {
            interval: 10000,
            ride: 'carousel',
            pause: false,
            wrap: true,
            touch: true
        });
    }

});