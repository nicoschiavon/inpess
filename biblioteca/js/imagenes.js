$(document).ready(function(){	

	var imagenesRecords = $('#imagenesListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"imagenes_action.php",
			type:"POST",
			data:{action:'listImagenes'},
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
	
	$('#addImagen').click(function(){
		$('#imagenesModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#imagenesModal").on("shown.bs.modal", function () {
			$('#imagenesForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Imagen");					
			$('#action').val('addImagen');
			$('#save').val('Guardar');
		});
	});		
	
	$("#imagenesListing").on('click', '.update', function(){
		var idNota = $(this).attr("id");
		var action = 'getImagenDetails';
		$.ajax({
			url:'imagenes_action.php',
			method:"POST",
			data:{idNota:idNota, action:action},
			dataType:"json",
			success:function(respData){				
				$("#imagenesModal").on("shown.bs.modal", function () { 
					$('#imagenesForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idNota').val(item['idNota']);						
						$('#imagenes').val(item['imagenes']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Imagen");
					$('#action').val('updateImagen');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#imagenesModal").on('submit','#imagenesForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"imagenes_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#imagenesForm')[0].reset();
				$('#imagenesModal').modal('hide');				
				$('#save').attr('disabled', false);
				imagenesRecords.ajax.reload();
			}
		})
	});		

	$("#imagenesListing").on('click', '.delete', function(){
		var idNota = $(this).attr("id");		
		var action = "deleteImagen";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"imagenes_action.php",
				method:"POST",
				data:{idNota:idNota, action:action},
				success:function(data) {					
					imagenesRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
