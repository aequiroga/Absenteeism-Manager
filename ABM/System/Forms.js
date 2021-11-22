var keyPress = "";
$(document).ready(function() {

  //Form para nombres/apellidos
  $('.FormAlfabetico').keydown(function (event) {
    keyPress = event.keyCode; //Guarda en variable el codigo de la tecla apretada
    if (keyPress == 8) {} //Revisa que el keyCode sea backspace
    else if(keyPress > 64 && keyPress < 91) { //Revisa reglas especificas del input
      console.log(keyPress);
    }
    else { //Si no se cumplieron las reglas, se cancela el evento
      event.preventDefault();
      console.log(keyPress);
    }
  })
  
//Form para DNIs
  $('.FormDNI').keydown(function (event) {
    keyPress = event.keyCode; //Guarda en variable el codigo de la tecla apretada
    if (keyPress == 8) {} //Revisa que el keyCode sea backspace
    else if (keyPress > 47 && keyPress < 59 || keyPress == 190 || keyPress > 95 && keyPress < 107 || keyPress == 110) { //Revisa reglas especificas del input
      console.log(keyPress);
    }
    else { //Si no se cumplieron las reglas, se cancela el evento
      console.log(keyPress);
      event.preventDefault();
    }
  })

//Form para telefonos
  $('.FormTelefono').keydown(function (event) {
    keyPress = event.keyCode; //Guarda en variable el codigo de la tecla apretada
    if (keyPress == 8) {} //Revisa que el keyCode sea backspace
    else if (keyPress > 47 && keyPress < 59 && keyPress > 95 && keyPress < 107) {}//Revisa reglas especificas del input
    else { //Si no se cumplieron las reglas, se cancela el evento
      console.log(keyPress);
      event.preventDefault();
    }
  })

  });
