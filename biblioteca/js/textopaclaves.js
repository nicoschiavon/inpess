$(document).ready(function(){	

	var textoPalClavesRecords = $('#textoPalClavesListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"textopalclaves_action.php",
			type:"POST",
			data:{action:'listTextoPalClaves'},
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
	
	$('#addTextoPalClaves').click(function(){
		$('#textoPalClavesModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#textoPalClavesModal").on("shown.bs.modal", function () {
			$('#textoPalClavesForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Texto Pal Claves");					
			$('#action').val('addTextoPalClaves');
			$('#save').val('Guardar');
		});
	});		
	
	$("#textoPalClavesListing").on('click', '.update', function(){
		var idTexto = $(this).attr("idTexto");
		var textoPalClaves = $(this).attr("textoPalClaves");
		var action = 'getTextoPalClavesDetails';
		$.ajax({
			url:'textopalclaves_action.php',
			method:"POST",
			data:{idTexto:idTexto, textoPalClaves:textoPalClaves, action:action},
			dataType:"json",
			success:function(respData){				
				$("#textoPalClavesModal").on("shown.bs.modal", function () { 
					$('#textoPalClavesForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idTexto').val(item['idTexto']);						
						$('#textoPalClaves').val(item['textoPalClaves']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Texto Pal Claves");
					$('#action').val('updateTextoPalClaves');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#textoPalClavesModal").on('submit','#textoPalClavesForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"textopalclaves_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#textoPalClavesForm')[0].reset();
				$('#textoPalClavesModal').modal('hide');				
				$('#save').attr('disabled', false);
				textoPalClavesRecords.ajax.reload();
			}
		})
	});		

	$("#textoPalClavesListing").on('click', '.delete', function(){
		var idTexto = $(this).attr("idTexto");		
		var textoPalClaves = $(this).attr("textoPalClaves");		
		var action = "deleteTextoPalClaves";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"textopalclaves_action.php",
				method:"POST",
				data:{idTexto:idTexto, textoPalClaves:textoPalClaves, action:action},
				success:function(data) {					
					textoPalClavesRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
