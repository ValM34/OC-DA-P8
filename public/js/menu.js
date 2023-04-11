let burgerBtn = document.querySelector("#burger_btn");
let navLinksContainer = document.querySelector("#nav_links_container");
burgerBtn.addEventListener("click", () => {
  navLinksContainer.classList.toggle("hidden-custom");
})
