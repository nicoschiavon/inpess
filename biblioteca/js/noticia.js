$(document).ready(function(){	

	var noticiaRecords = $('#noticiaListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"noticia_action.php",
			type:"POST",
			data:{action:'listNoticias'},
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
	
	$('#addNoticia').click(function(){
		$('#noticiaModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#noticiaModal").on("shown.bs.modal", function () {
			$('#noticiaForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Agregar Noticia");					
			$('#action').val('addNoticia');
			$('#save').val('Guardar');
		});
	});		
	
	$("#noticiaListing").on('click', '.update', function(){
		var idNota = $(this).attr("id");
		var action = 'getNoticiaDetails';
		$.ajax({
			url:'noticia_action.php',
			method:"POST",
			data:{idNota:idNota, action:action},
			dataType:"json",
			success:function(respData){				
				$("#noticiaModal").on("shown.bs.modal", function () { 
					$('#noticiaForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#idNota').val(item['idNota']);						
						$('#titulo').val(item['titulo']);	
						$('#subtitulo').val(item['subtitulo']);
						$('#cuerpo').val(item['cuerpo']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Editar Noticia");
					$('#action').val('updateNoticia');
					$('#save').val('Guardar');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#noticiaModal").on('submit','#noticiaForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"noticia_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#noticiaForm')[0].reset();
				$('#noticiaModal').modal('hide');				
				$('#save').attr('disabled', false);
				noticiaRecords.ajax.reload();
			}
		})
	});		

	$("#noticiaListing").on('click', '.delete', function(){
		var idNota = $(this).attr("id");		
		var action = "deleteNoticia";
		if(confirm("Deseas eliminar este registro?")) {
			$.ajax({
				url:"noticia_action.php",
				method:"POST",
				data:{idNota:idNota, action:action},
				success:function(data) {					
					noticiaRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});
