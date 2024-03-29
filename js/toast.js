/* TOAST */
const toastPlacementExample = document.querySelector('.toast-placement-ex');


let selectedType, selectedPlacement, toastPlacement;

function toastDispose(toast) {
  if (toast && toast._element !== null) {
    toast.dispose();
  }
}

function toast(type, text) {

    let bg, toast_header;

    switch (type) {
        case 'a':
            bg = 'bg-primary';
            toast_header = 'Éxito!';
            break;
        case 'g':
            bg = 'bg-success';
            toast_header = 'Información';
            break;
        case 'r':
            bg = 'bg-danger';
            toast_header = 'Atención';
            break;
    }
  toastDispose(toastPlacement);

  toastPlacementExample.classList.remove('bg-primary');
  toastPlacementExample.classList.remove('bg-success');
  toastPlacementExample.classList.remove('bg-danger');

  toastPlacementExample.classList.add(bg);

  $('.toast-header-t').html(toast_header)
  $('.toast-body').html(text)

  toastPlacement = new bootstrap.Toast(toastPlacementExample);
  toastPlacement.show();

}
/* NOTICIA */
function noticia(title, text, img) {
  $('#modalIlustration').attr('src', img)

  $('#modalTextHeader').html(title)
  $('#modalAlertBody').html(text)
  $('#modalAlert').modal('toggle')
}