var SelectedClass;
SelectedClass = $("#SelectClass").val();

$(document).ready(function(){
          /*$("#SelectClass").on('change', function(){
            SelectedClass = $("#SelectClass").val();
            $.ajax({
                type: "POST",
                data:{
					"QS": 1
				},
				datatype : "json",
                url: "Register.php",
                cache: false,
				success: function (){
					alert("REQUEST="+SelectedClass);
					console.log(SelectedClass);
				}
            });
			
			/*
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					alert("Funca");
				}
			}
			xhttp.open("GET","Register.php?QS="+ 2, false);
			xhttp.send();*/
		  });*/
          });