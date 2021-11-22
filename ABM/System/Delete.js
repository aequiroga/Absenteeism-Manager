$(document).ready(function () {
  $('#Surprise').hide(); //Esconder pedido de confirmacion

  $('#BotonDelete').on('click', function() {
    if($('#DeleteConfirmacion').is(':checked'))
      alert("Usuario eliminado");
    else{
    $('#Surprise').toggle(); //Mostrar advertencia de confirmacion
	e.preventDefault();
	}
  }).on('mouseleave', function () {
    if($('#DeleteConfirmacion').is(':not(:checked)'))
    $('#Surprise').fadeOut(); //Esconder advertencia de confirmacion
  })
});
