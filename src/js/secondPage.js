// Array dei buttons "next" e "prev" (2 elem)
const buttons = document.querySelectorAll("[data-carousel-btn]");
// Array dei dots (3 elem)
const dots = document.querySelectorAll("[data-carousel-dot]");

// Funzione che aggiorna le slide e i dots
function slide(button) {
  return () => {
    // dataset è una proprietà del dom usata per accedere e manipolare elementi del DOM
    //  che hanno gli attributi personalizzati (quelli che iniziano per "data-")
    // carouselBtn sarebbe "carousel-btn", quindi "dataset.carouselBtn" si riferisce a "data-carousel-btn"
    // Se il pulsante è "next", offset è 1, altrimenti -1
    const offset = button.dataset.carouselBtn === "next" ? 1 : -1;

    // la funzione closest cerca il primo antenato del pulsante "button"
    // che ha l'attributo "data-carousel"
    const slidesContainer = button
      .closest("[data-carousel]")
      .querySelector("[data-carousel-slides]");
    const slides = slidesContainer.querySelectorAll("[data-carousel-slide]");
    const activeSlide = slidesContainer.querySelector("[data-active]");

    // "...slides" è la spread syntax per gli oggetti iterabili,
    // permette di iterare sugli elementi dell'array "slides"
    // In questo caso, restituisce l'indice "attivo" dell'elemento
    const activeSlideIndex = [...slides].indexOf(activeSlide);
    const nextSlideIndex = activeSlideIndex + offset;

    switch (nextSlideIndex) {
      case -1:
        moveDot(2);
        break;
      case 1:
        moveDot(1);
        break;
      case 2:
        moveDot(2);
        break;
      default:
        moveDot(0);
        break;
    }
    // Condizioni per utilizzare il "prev" button se si l'indice attuale si trova a 0
    if (nextSlideIndex < 0) {
      slides[slides.length + nextSlideIndex].dataset.active = true;
      return delete activeSlide.dataset.active;
    }
    // Condizione per aggiornare l'indice a 0 quando supera la fine
    if (nextSlideIndex >= slides.length) {
      slides[0].dataset.active = true;
      return delete activeSlide.dataset.active;
    }
    slides[nextSlideIndex].dataset.active = true;
    return delete activeSlide.dataset.active;
  };
}

// Funzione che aggiorna i dots
function moveDot(i) {
  const dot = dots[i];
  dots.forEach((d) => "active" in d.dataset && delete d.dataset.active);
  dot.dataset.active = true;
}

// Funzione che, al fine del caricamento del DOM,
// associa l'evento click alla funzione slide e avvia il carousel in modo automatico.
// In particolare, essendo buttons[1] === "next", scorre in avanti lo slideshow ogni 3.5s.
// (buttons[0] scorre al contrario)
window.addEventListener("DOMContentLoaded", () => {
  buttons.forEach((button) => button.addEventListener("click", slide(button)));

  setInterval(() => {
    // Le parentesi tonde finali fanno si che la funzione "slide(..)"
    // esegua immediatamente la funzione restituita.
    slide(buttons[1])();
  }, 3500);
});
