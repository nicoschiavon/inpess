$(document).ready(function(){	

	var adminRecords = $('#adminListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"admin_action.php",
			type:"POST",
			data:{action:'listUsers'},
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
	
	$('#addAdmin').click(function(){
		$('#adminModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#adminModal").on("shown.bs.modal", function () {
			$('#adminForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Admin");					
			$('#action').val('addAdmin');
			$('#save').val('Guardar');
		});
	});		
	
	$("#adminListing").on('click', '.update', function(){
		var idAdmin = $(this).attr("idAdmin");
		var action = 'getAdminDetails';
		$.ajax({
			url:'admin_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#adminModal").on("shown.bs.modal", function () { 
					$('#adminForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idAdmin').val(item['idAdmin']);						
						$('#usuario').val(item['usuario']);
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Usuario");
					$('#action').val('updateAdmin');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#adminModal").on('submit','#adminForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"admin_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#adminForm')[0].reset();
				$('#adminModal').modal('hide');				
				$('#save').attr('disabled', false);
				adminRecords.ajax.reload();
			}
		})
	});		

	$("#adminListing").on('click', '.delete', function(){
		var idAdmin = $(this).attr("idAdmin");		
		var action = "deleteAdmin";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"admin_action.php",
				method:"POST",
				data:{idAdmin:idAdmin, action:action},
				success:function(data) {					
					adminRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});