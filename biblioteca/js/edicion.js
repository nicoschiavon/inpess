$(document).ready(function(){	

	var edicionRecords = $('#edicionListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"edicion_action.php",
			type:"POST",
			data:{action:'listEdiciones'},
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
	
	$('#addEdicion').click(function(){
		$('#edicionModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#edicionModal").on("shown.bs.modal", function () {
			$('#edicionForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Edición");					
			$('#action').val('addEdicion');
			$('#save').val('Guardar');
		});
	});		
	
	$("#edicionListing").on('click', '.update', function(){
		var idNota = $(this).attr("id");
		var idMiembro = $(this).attr("idMiembro");
		var action = 'getEdicionDetails';
		$.ajax({
			url:'edicion_action.php',
			method:"POST",
			data:{idNota:idNota, idMiembro:idMiembro, action:action},
			dataType:"json",
			success:function(respData){				
				$("#edicionModal").on("shown.bs.modal", function () { 
					$('#edicionForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idNota').val(item['idNota']);						
						$('#idMiembro').val(item['idMiembro']);
						$('#dateTime').val(item['dateTime']);
						$('#usuario').val(item['usuario']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Edición");
					$('#action').val('updateEdicion');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#edicionModal").on('submit','#edicionForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"edicion_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#edicionForm')[0].reset();
				$('#edicionModal').modal('hide');				
				$('#save').attr('disabled', false);
				edicionRecords.ajax.reload();
			}
		})
	});		

	$("#edicionListing").on('click', '.delete', function(){
		var idNota = $(this).attr("id");		
		var idMiembro = $(this).attr("idMiembro");		
		var action = "deleteEdicion";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"edicion_action.php",
				method:"POST",
				data:{idNota:idNota, idMiembro:idMiembro, action:action},
				success:function(data) {					
					edicionRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
