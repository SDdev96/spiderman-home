const buttons = document.querySelectorAll("button");
// console.log(buttons);
const submit = document.querySelector("[type='submit']");
// console.log(submit);

// console.log(document.forms[0]);

//Il forEach può essere usato solo sui NodeList, e non gli HTMLElements
//Con querySelector ho NodeList.
buttons.forEach(function (button) {
  button.addEventListener("click", function () {
    toggleVisibility(button);
  });
});

submit.addEventListener("click", function () {
  const inputPasswords = document.querySelectorAll("[name*='password']");
  // console.log(inputPasswords);

  controlPasswords(inputPasswords);
});

function toggleVisibility(button) {
  // console.log(button);

  const visibility = button.firstElementChild;
  // console.log(visibility);

  const input = button.parentElement.firstElementChild;
  // console.log(input);

  visibility.innerHTML =
    visibility.innerHTML === "visibility_off" ? "visibility" : "visibility_off";

  input.type = input.type === "password" ? "text" : "password";
}

function controlPasswords2(elementoModulo) {
  if (elementoModulo.pass.value != elementoModulo.pass2.value) {
    window.alert(elementoModulo.pass.value);
    // console.log("Le password non combaciano");
    return false;
  } else {
    window.alert("Le password combaciano");
    // console.log("Le password combaciano");

    elementoModulo.pass.style.borderBottom = "solid 3px transparent";

    elementoModulo.pass.addEventListener("focus", function () {
      elementoModulo.pass.style.borderBottom = "solid 3px white";
    });
    elementoModulo.pass.addEventListener("blur", function () {
      elementoModulo.pass.style.borderBottom = "solid 3px transparent";
    });

    elementoModulo.pass.classList.remove("shake-animation");

    elementoModulo.pass2.style.borderBottom = "solid 3px transparent";

    elementoModulo.pass2.addEventListener("focus", function () {
      elementoModulo.pass2.style.borderBottom = "solid 3px white";
    });
    elementoModulo.pass2.addEventListener("blur", function () {
      elementoModulo.pass2.style.borderBottom = "solid 3px transparent";
    });

    elementoModulo.pass2.classList.remove("shake-animation");
    return true;
  }
}
