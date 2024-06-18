$(document).ready(function(){	

	var autorRecords = $('#autorListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"autor_action.php",
			type:"POST",
			data:{action:'listAutor'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addAutor').click(function(){
		$('#autorModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#autorModal").on("shown.bs.modal", function () {
			$('#autorForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Autor");					
			$('#action').val('addAutor');
			$('#save').val('Guardar');
		});
	});		
	
	$("#autorListing").on('click', '.update', function(){
		var idTextoCientifico = $(this).attr("idTextoCientifico");
		var idAutor = $(this).attr("idAutor");
		var action = 'getAutoresDetails';
		$.ajax({
			url:'autores_action.php',
			method:"POST",
			data:{idTexto:idTexto, idAutor:idAutor, action:action},
			dataType:"json",
			success:function(respData){				
				$("#autoresModal").on("shown.bs.modal", function () { 
					$('#autoresForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idTexto').val(item['idTexto']);						
						$('#idAutor').val(item['idAutor']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Autores");
					$('#action').val('updateAutores');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#autoresModal").on('submit','#autoresForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"autores_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#autoresForm')[0].reset();
				$('#autoresModal').modal('hide');				
				$('#save').attr('disabled', false);
				autoresRecords.ajax.reload();
			}
		})
	});		

	$("#autoresListing").on('click', '.delete', function(){
		var idTexto = $(this).attr("idTexto");
		var idAutor = $(this).attr("idAutor");		
		var action = "deleteAutores";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"autores_action.php",
				method:"POST",
				data:{idTexto:idTexto, idAutor:idAutor, action:action},
				success:function(data) {					
					autoresRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
