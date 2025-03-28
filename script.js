function openModal(modalId) {
    document.getElementById(modalId).style.display = "flex";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

window.onclick = function(event) {
    if (event.target.className === "modal") {
        event.target.style.display = "none";
    }
}

const underline = document.getElementById("nav-underline");
const links = document.querySelectorAll("#nav-links a");

function moveUnderline(el) {
  const rect = el.getBoundingClientRect();
  const headerRect = document.getElementById("header").getBoundingClientRect();
  underline.style.width = `${rect.width}px`;
  underline.style.left = `${rect.left + window.scrollX}px`;
  underline.style.top = `${headerRect.bottom + window.scrollY}px`;
}

links.forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    links.forEach(l => l.classList.remove("active"));
    link.classList.add("active");
    moveUnderline(link);
  });
});

window.addEventListener("load", () => {
  const activeLink = document.querySelector("#nav-links a.active");
  if (activeLink) moveUnderline(activeLink);
});

window.addEventListener("resize", () => {
  const activeLink = document.querySelector("#nav-links a.active");
  if (activeLink) moveUnderline(activeLink);
});