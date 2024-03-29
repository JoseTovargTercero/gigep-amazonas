document.onkeydown = desabilitar; // Teclas Precionada
//  document.onselectstart = selecionar; //Anular la Selecion de Texto
//  document.oncontextmenu = selecionar; //Anular el Boton Der del Mouse

  function selecionar() {
    return false;
  }

  function desabilitar() {
    // Combinacion de Teclas con el Control


    if (event.key) {
      switch (window.event.key) {
        case '~': 
        case ';': 
        case '"': 
        case "'": 
        case '"': 
        case '*': 
        toast_s('warning', 'Carácter no permitido')
          return false;

          // aqui puede poner todas las tecla de combinacion que tiene programado el ie, para anularlo.

        default:
          break;
      }
    }
  }
  
//  console.clear();



/**
Esta función se encarga de ocultar el elemento con la clase "container-loader"
Cuando la pagina se carga
 */

  function activar() {
    $(".container-loader").hide();
  }
  $(window).on("load", activar);




/* TOAST */
const toastPlacementExample = document.querySelector('.toast-placement-ex');


let selectedType, selectedPlacement, toastPlacement;

function toastDispose(toast) {
  if (toast && toast._element !== null) {
    toast.dispose();
  }
}

/* NOTICIA */
function noticia(title, text, img) {
  $('#modalIlustration').attr('src', img);

  $('#modalTextHeader').html(title);
  $('#modalAlertBody').html(text);
  $('#modalAlert').modal('toggle');
}
/* TOAST */


/* Desactivar right click */
//document.addEventListener('contextmenu', event => event.preventDefault());
/* Desactivar right click */

/* Maximo de caracteres por campos */

function max_caracteres(value, text_rest, input, max) {
  let restante = max - value.length;
  let n_value = value;

  if (restante == 0 || restante < 1) {
    n_value = n_value.substring(0, max)
    $('#' + input).val(n_value)
  }

  if (text_rest != 'empty') {
    $('#' + text_rest).html(max - n_value.length)
  }

}
/* Maximo de caracteres por campos */

/** * Main */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();







function checkField(f, t) {
  let field= $('#'+f).val();
  if (field === "") {
    // Detener la ejecución de la función
    toast_s('warning', 'Campo vacío: ' + t)
    return false;

  }
  // Continuar con la ejecución de la función
  return true;
}




/* Este código toma tres argumentos: el número que se desea verificar, el mínimo y el máximo valor permitidos en el rango. La función devuelve true si el número está dentro del rango especificado y false en caso contrario. */

function isNumberInRange(number, min, max) {
  return number >= min && number <= max;
}

function isNumberInRangeRealTime(number, min, max, campo) {
  if(number >= min && number <= max){
    return true
  }else{
    toast_s('error', 'Error: el valor indicado no es correcto')
    $('#'+campo).val('');
  }
}




function verify(params) {
  const now = new Date();

  if (Date.parse($('#fecha').val()) <= Date.parse(now)) {
    document.getElementById('fecha').value = '';
    toast_s('error', 'La fecha indicada no es correcta')
  }
}


/*
The function phoneFormat takes a string as input and returns a string with the phone number formatted as (###) ###-####*/
function phoneFormat(input) {//returns (###) ###-####
  input = input.replace(/\D/g,'').substring(0,10); //Strip everything but 1st 10 digits
  var size = input.length;
  if (size>0) {input="("+input}
  if (size>3) {input=input.slice(0,4)+") "+input.slice(4)}
  if (size>6) {input=input.slice(0,9)+"-" +input.slice(9)}
  return input;
}


                              $(".container-loader").hide();
