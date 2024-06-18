$(document).ready(function(){	

	var informeTecnicoRecords = $('#informeTecnicoListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"informetecnico_action.php",
			type:"POST",
			data:{action:'listInformeTecnicos'},
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
	
	$('#addInformeTecnico').click(function(){
		$('#informeTecnicoModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#informeTecnicoModal").on("shown.bs.modal", function () {
			$('#informeTecnicoForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Informe Técnico");					
			$('#action').val('addInformeTecnico');
			$('#save').val('Guardar');
		});
	});		
	
	$("#informeTecnicoListing").on('click', '.update', function(){
		var idTexto = $(this).attr("idTexto");
		var nroInf = $(this).attr("nroInf");
		var action = 'getInformeTecnicoDetails';
		$.ajax({
			url:'informetecnico_action.php',
			method:"POST",
			data:{idTexto:idTexto, nroInf:nroInf, action:action},
			dataType:"json",
			success:function(respData){				
				$("#informeTecnicoModal").on("shown.bs.modal", function () { 
					$('#informeTecnicoForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idTexto').val(item['idTexto']);						
						$('#nroInf').val(item['nroInf']);	
						$('#centroPub').val(item['centroPub']);	
						$('#anioPub').val(item['anioPub']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Informe Técnico");
					$('#action').val('updateInformeTecnico');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#informeTecnicoModal").on('submit','#informeTecnicoForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"informetecnico_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#informeTecnicoForm')[0].reset();
				$('#informeTecnicoModal').modal('hide');				
				$('#save').attr('disabled', false);
				informeTecnicoRecords.ajax.reload();
			}
		})
	});		

	$("#informeTecnicoListing").on('click', '.delete', function(){
		var idTexto = $(this).attr("idTexto");
		var nroInf = $(this).attr("nroInf");		
		var action = "deleteInformeTecnico";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"informetecnico_action.php",
				method:"POST",
				data:{idTexto:idTexto, nroInf:nroInf, action:action},
				success:function(data) {					
					informeTecnicoRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
