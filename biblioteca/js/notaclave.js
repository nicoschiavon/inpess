$(document).ready(function(){	

	var notaClavesRecords = $('#notaClavesListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"notaClaves_action.php",
			type:"POST",
			data:{action:'listNotaClaves'},
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
	
	$('#addNotaClaves').click(function(){
		$('#notaClavesModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#notaClavesModal").on("shown.bs.modal", function () {
			$('#notaClavesForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Nota Claves");					
			$('#action').val('addNotaClaves');
			$('#save').val('Guardar');
		});
	});		
	
	$("#notaClavesListing").on('click', '.update', function(){
		var idNota = $(this).attr("id");
		var action = 'getNotaClavesDetails';
		$.ajax({
			url:'notaClaves_action.php',
			method:"POST",
			data:{idNota:idNota, action:action},
			dataType:"json",
			success:function(respData){				
				$("#notaClavesModal").on("shown.bs.modal", function () { 
					$('#notaClavesForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idNota').val(item['idNota']);						
						$('#notaClaves').val(item['notaClaves']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Nota Claves");
					$('#action').val('updateNotaClaves');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#notaClavesModal").on('submit','#notaClavesForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"notaClaves_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#notaClavesForm')[0].reset();
				$('#notaClavesModal').modal('hide');				
				$('#save').attr('disabled', false);
				notaClavesRecords.ajax.reload();
			}
		})
	});		

	$("#notaClavesListing").on('click', '.delete', function(){
		var idNota = $(this).attr("id");		
		var action = "deleteNotaClaves";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"notaClaves_action.php",
				method:"POST",
				data:{idNota:idNota, action:action},
				success:function(data) {					
					notaClavesRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
