const dropdown = document.querySelector(".dropdown");
const dropdownMenuItem = document.querySelector(".wrapper-dropdown")

dropdown?.addEventListener("click", event=>{
    event.preventDefault();
    dropdownMenuItem.classList.toggle("open-dropdown");
});