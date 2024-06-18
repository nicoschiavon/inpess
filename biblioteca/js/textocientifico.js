$(document).ready(function() {
    var textoCientificoData = $('#textoCientificoListing').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "textoCientifico_action.php",
            type: "POST",
            data: {action: 'listTextos'},
            dataType: "json"
        },
        "columnDefs": [
            {
                "targets": [0, 3, 4],
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


    var textoCientificoData = $('#textoCientificoListingBiblio').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "biblioteca/textoCientifico_action.php",
            type: "POST",
            data: {action: 'listTextosBiblio'},
            dataType: "json"
        },
        "columnDefs": [
            {
                "targets": [0, 3, 4],
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

    $('#addTextoCientifico').click(function() {
        $('#textoCientificoForm')[0].reset();
        $('#action').val('addTexto');
        $('#save').val('Guardar');
        $('#textoCientificoModal').modal('show');
        $('#textoCientificoModal .modal-title').text("Agregar Texto Científico");
    });

    $("#textoCientificoListing").on('click', '.update', function() {
        var idTextoCientifico = $(this).attr("idTextoCientifico");
        var action = 'getTextoDetails';
        $.ajax({
            url: 'textoCientifico_action.php',
            method: "POST",
            data: {idTextoCientifico: idTextoCientifico, action: action},
            dataType: "json",
            success: function(data) {
                $('#textoCientificoModal').modal('show');
                $('#idTextoCientifico').val(data[0].idTextoCientifico);
                $('#titulo').val(data[0].titulo);
                $('#isbn_issn_acta').val(data[0].isbn_issn_acta);
                $('#resumen').val(data[0].resumen);
                $('#tipo').val(data[0].tipo);
                $('#action').val('updateTexto');
                $('#save').val('Guardar');
                $('#textoCientificoModal .modal-title').text("Editar Texto Científico");
            }
        });
    });

    $("#textoCientificoModal").on('submit', '#textoCientificoForm', function(event) {
        event.preventDefault();
        $('#save').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "textoCientifico_action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#textoCientificoForm')[0].reset();
                $('#textoCientificoModal').modal('hide');
                $('#save').attr('disabled', false);
                textoCientificoData.ajax.reload();
            }
        })
    });

    $("#textoCientificoListing").on('click', '.delete', function() {
        var idTextoCientifico = $(this).attr("idTextoCientifico");
        var action = "deleteTexto";
        if (confirm("¿Estás seguro de que deseas eliminar este texto?")) {
            $.ajax({
                url: "textoCientifico_action.php",
                method: "POST",
                data: {idTextoCientifico: idTextoCientifico, action: action},
                success: function(data) {
                    textoCientificoData.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});
