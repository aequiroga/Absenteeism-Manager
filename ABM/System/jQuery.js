$(document).ready(function() {
  //Separa por color las filas
  $("tbody tr:odd td").addClass("tdEven");
  $("tbody tr:even td").addClass("tdEven");
  //fadeOut para mensajes
  setTimeout(()=>{$(".Exito").fadeOut();},3000);
  setTimeout(()=>{$(".Error").fadeOut();},3000);
  
  //Mostrar o esconder filtros
  $("#MostrarFiltros").click(()=>{$(".Filtros").slideToggle();});
  
  //AutoSubmit del filtro de InicioCoordinador
  $("#SelectInicioCoordinador").change(function() {
	this.form.submit();
  });
  
  $("#CheckBox1").click(()=>{
	$("#FileUpload").toggle("slow");
  });
  
  $("#ModNotificacionSubmit").click(()=>{
	  $("#FormModNotificacionGET").submit();
  });
});
