$(document).ready(function(){	

	var miembroRecords = $('#miembroListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"miembro_action.php",
			type:"POST",
			data:{action:'listMiembros'},
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
	
	$('#addMiembro').click(function(){
		$('#miembroModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#miembroModal").on("shown.bs.modal", function () {
			$('#miembroForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Miembro");					
			$('#action').val('addMiembro');
			$('#save').val('Guardar');
		});
	});		
	
	$("#miembroListing").on('click', '.update', function(){
		var idMiembro = $(this).attr("idMiembro");
		var action = 'getMiembroDetails';
		$.ajax({
			url:'miembro_action.php',
			method:"POST",
			data:{idMiembro:idMiembro, action:action},
			dataType:"json",
			success:function(respData){				
				$("#miembroModal").on("shown.bs.modal", function () { 
					$('#miembroForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idMiembro').val(item['idMiembro']);						
						$('#usuario').val(item['usuario']);	
						$('#password').val(item['password']);
						$('#apellido').val(item['apellido']);	
						$('#nombre').val(item['nombre']);	
						$('#cuit').val(item['cuit']);
						$('#telefono').val(item['telefono']);	
						$('#correoElec').val(item['correoElec']);	
						$('#fechaNac').val(item['fechaNac']);	
						$('#tipoMiembro').val(item['tipoMiembro']);	
						$('#estado').val(item['estado']);	
						$('#idRevisor').val(item['idRevisor']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Miembro");
					$('#action').val('updateMiembro');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#miembroModal").on('submit','#miembroForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"miembro_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#miembroForm')[0].reset();
				$('#miembroModal').modal('hide');				
				$('#save').attr('disabled', false);
				miembroRecords.ajax.reload();
			}
		})
	});		

	$("#miembroListing").on('click', '.delete', function(){
		var idMiembro = $(this).attr("idMiembro");		
		var action = "deleteMiembro";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"miembro_action.php",
				method:"POST",
				data:{idMiembro:idMiembro, action:action},
				success:function(data) {					
					miembroRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$("#miembroListing").on('click', '.deactivate', function(){
		var idMiembro = $(this).attr("idMiembro");
		var action = 'desactivarMiembro';
		if(confirm("¿Deseas desactivar este registro?")) {
			$.ajax({
				url: 'miembro_action.php',
				method: "POST",
				data: {idMiembro: idMiembro, action: action},
				success: function(data) {
					miembroRecords.ajax.reload();
				}
			});
		} else {
			return false;
		}
	});
	
});
