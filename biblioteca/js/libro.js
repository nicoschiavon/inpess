$(document).ready(function() {
    var libroData = $('#libroListing').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "libro_action.php",
            type: "POST",
            data: {action: 'listLibros'},
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


    var libroData = $('#libroListingbiblio').DataTable({
        "lengthChange": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "biblioteca/libro_action.php",
            type: "POST",
            data: {action: 'listLibrosbiblio'},
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

    $('#addLibro').click(function() {
        $('#libroForm')[0].reset();
        $('#action').val('addLibro');
        $('#save').val('Guardar');
        $('#libroModal').modal('show');
        $('#libroModal .modal-title').text("Agregar Libro");
    });

    $("#libroListing").on('click', '.update', function() {
        var idTextoCientifico = $(this).attr("idTextoCientifico");
        var action = 'getLibroDetails';
        $.ajax({
            url: 'libro_action.php',
            method: "POST",
            data: {idTextoCientifico: idTextoCientifico, action: action},
            dataType: "json",
            success: function(data) {
                $('#libroModal').modal('show');
                $('#idTextoCientifico').val(data[0].idTextoCientifico);
                $('#titulo').val(data[0].titulo);
                $('#editorial').val(data[0].editorial);
                $('#anioPub').val(data[0].anioPub);
                $('#isbn_issn_acta').val(data[0].isbn_issn_acta);
                $('#resumen').val(data[0].resumen);
                $('#tipo').val(data[0].tipo);
                $('#action').val('updateLibro');
                $('#save').val('Guardar');
                $('#libroModal .modal-title').text("Editar Libro");
            }
        });
    });

    $("#libroModal").on('submit', '#libroForm', function(event) {
        event.preventDefault();
        $('#save').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "libro_action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#libroForm')[0].reset();
                $('#libroModal').modal('hide');
                $('#save').attr('disabled', false);
                libroData.ajax.reload();
            }
        })
    });

    $("#libroListing").on('click', '.delete', function() {
        var idTextoCientifico = $(this).attr("idTextoCientifico");
        var action = "deleteLibro";
        if (confirm("¿Estás seguro de que deseas eliminar este libro?")) {
            $.ajax({
                url: "libro_action.php",
                method: "POST",
                data: {idTextoCientifico: idTextoCientifico, action: action},
                success: function(data) {
                    libroData.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});
