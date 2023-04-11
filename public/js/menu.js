let burgerBtn = document.querySelector("#burger_btn");
let navLinksContainer = document.querySelector("#nav_links_container");
let container = document.querySelector("#container");
burgerBtn.addEventListener("click", () => {
  navLinksContainer.classList.toggle("hidden-custom");
  burgerBtn.classList.toggle("is-active");
  if(navLinksContainer.classList.contains("hidden-custom") === false) {
    container.style.height = "100vh";
  } else {
    container.style.height = "auto";
  }
})
