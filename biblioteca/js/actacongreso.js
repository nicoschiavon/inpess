$(document).ready(function(){	

	var actaCongresoRecords = $('#actaCongresoListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"actacongreso_action.php",
			type:"POST",
			data:{action:'listActasCongreso'},
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
	
	$('#addActaCongreso').click(function(){
		$('#actaCongresoModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#actaCongresoModal").on("shown.bs.modal", function () {
			$('#actaCongresoForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Acta de Congreso");					
			$('#action').val('addActaCongreso');
			$('#save').val('Guardar');
		});
	});		
	
	$("#actaCongresoListing").on('click', '.update', function(){
		var idTexto = $(this).attr("idTexto");
		var nombCong = $(this).attr("nombCong");
		var action = 'getActaCongresoDetails';
		$.ajax({
			url:'actacongreso_action.php',
			method:"POST",
			data:{idTexto:idTexto, nombCong:nombCong, action:action},
			dataType:"json",
			success:function(respData){				
				$("#actaCongresoModal").on("shown.bs.modal", function () { 
					$('#actaCongresoForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idTexto').val(item['idTexto']);						
						$('#nombCong').val(item['nombCong']);	
						$('#ediCong').val(item['ediCong']);	
						$('#fecInic').val(item['fecInic']);	
						$('#fecFin').val(item['fecFin']);	
						$('#paisCong').val(item['paisCong']);	
						$('#ciudad').val(item['ciudad']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Acta de Congreso");
					$('#action').val('updateActaCongreso');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#actaCongresoModal").on('submit','#actaCongresoForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"actacongreso_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#actaCongresoForm')[0].reset();
				$('#actaCongresoModal').modal('hide');				
				$('#save').attr('disabled', false);
				actaCongresoRecords.ajax.reload();
			}
		})
	});		

	$("#actaCongresoListing").on('click', '.delete', function(){
		var idTexto = $(this).attr("idTexto");
		var nombCong = $(this).attr("nombCong");		
		var action = "deleteActaCongreso";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"actacongreso_action.php",
				method:"POST",
				data:{idTexto:idTexto, nombCong:nombCong, action:action},
				success:function(data) {					
					actaCongresoRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
