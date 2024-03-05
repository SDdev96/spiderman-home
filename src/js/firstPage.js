const backBtn = document.getElementById("backBtn");
// console.log(backBtn);

// La funzione rende visibile/invisibile il pulsante
window.addEventListener("scroll", function () {
  let posY = window.scrollY;
  // console.log(posY);

  if (posY < 300) {
    backBtn.classList.remove("visible");
  } else {
    backBtn.classList.add("visible");
  }
});

// Ritorna all'inizio
backBtn.addEventListener("click", function () {
  // console.log(backBtn.id + " click");
  window.scrollTo(0, 0);
});
