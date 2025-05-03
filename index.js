const scrollRevealOption= {
    distance: "50px",
    origin: "bottom",
    duration: 500,
};
ScrollReveal().reveal(".header_container img", {
    duration: 1000,
});
ScrollReveal().reveal(".header_container h1", {
    ...scrollRevealOption,
    delay: 300,
});
ScrollReveal().reveal(".header_container p", {
    ...scrollRevealOption,
    delay: 800,
});
ScrollReveal().reveal(".header_btns", {
    ...scrollRevealOption,
    delay: 1100,
});
ScrollReveal().reveal(".about_image img", {
    ...scrollRevealOption,
    origin: "left",
});
ScrollReveal().reveal(".about_content h3", {
    ...scrollRevealOption,
    delay: 300,
});
ScrollReveal().reveal(".about_content .section_header", {
    ...scrollRevealOption,
    delay: 800,
});
ScrollReveal().reveal(".about_content .section_subhedear", {
    ...scrollRevealOption,
    delay: 1100,
});
ScrollReveal().reveal(".about_content .about_grid", {
    ...scrollRevealOption,
    delay: 1000,
});

new Swiper('.card_wrapper', {
    loop: true,
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets : true
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        },
    }
  });
  