tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0B1D2C",
        orange: "#F26E1C",
      },
    },
  },
};

AOS.init();
hljs.highlightAll();

const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");

menuToggle.addEventListener("click", () => {
  menuToggle.classList.toggle("open");
  mobileMenu.classList.toggle("translate-x-full");
  mobileMenu.classList.toggle("translate-x-0");
});
