$(document).ready(function() {
    var revistaData = $('#revistaListing').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "revista_action.php",
            type: "POST",
            data: {action: 'listRevistas'},
            dataType: "json"
        },
        "columnDefs": [
            {
                "targets": [0, 3, 4, 5, 6, 7, 8, 9],
                "orderable": false,
            },
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });


    var revistaData = $('#revistaListingBiblio').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "biblioteca/revista_action.php",
            type: "POST",
            data: {action: 'listRevistasBiblio'},
            dataType: "json"
        },
        "columnDefs": [
            {
                "targets": [0, 3, 4, 5, 6, 7, 8, 9],
                "orderable": false,
            },
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $('#addRevista').click(function() {
        $('#revistaForm')[0].reset();
        $('#action').val('addRevista');
        $('#save').val('Guardar');
        $('#revistaModal').modal('show');
        $('#revistaModal .modal-title').text("Agregar Revista");
    });

    $("#revistaListing").on('click', '.update', function() {
        var idRevista = $(this).attr("idRevista");
        var action = 'getRevistaDetails';
        $.ajax({
            url: 'revista_action.php',
            method: "POST",
            data: {idRevista: idRevista, action: action},
            dataType: "json",
            success: function(data) {
                $('#revistaModal').modal('show');
                $('#idRevista').val(data[0].idRevista);
                $('#titulo').val(data[0].titulo);
                $('#isbn_issn_acta').val(data[0].isbn_issn_acta);
                $('#resumen').val(data[0].resumen);
                $('#tipo').val(data[0].tipo);
                $('#nombRev').val(data[0].nombRev);
                $('#nroRev').val(data[0].nroRev);
                $('#primPag').val(data[0].primPag);
                $('#ultPag').val(data[0].ultPag);
                $('#mesPub').val(data[0].mesPub);
                $('#anioPub').val(data[0].anioPub);
                $('#action').val('updateRevista');
                $('#save').val('Guardar');
                $('#revistaModal .modal-title').text("Editar Revista");
            }
        });
    });

    

    $("#revistaModal").on('submit', '#revistaForm', function(event) {
        event.preventDefault();
        $('#save').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "revista_action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#revistaForm')[0].reset();
                $('#revistaModal').modal('hide');
                $('#save').attr('disabled', false);
                revistaData.ajax.reload();
            }
        })
    });

    $("#revistaListing").on('click', '.delete', function() {
        var idRevista = $(this).attr("idRevista");
        var action = "deleteRevista";
        if (confirm("¿Estás seguro de que deseas eliminar esta revista?")) {
            $.ajax({
                url: "revista_action.php",
                method: "POST",
                data: {idRevista: idRevista, action: action},
                success: function(data) {
                    revistaData.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});
