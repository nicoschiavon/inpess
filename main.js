$(document).ready(function() {
    // Mostrar solo el primer elemento 'todo' al cargar la página
    $('.event_box > div').hide(); // Ocultar todos los elementos
    $('.event_box > div.todo').first().show(); // Mostrar solo el primer elemento 'todo'

    // Manejador de eventos para los enlaces de filtro
    $('.event_filter a').on('click', function(e) {
        e.preventDefault();
        var filter = $(this).data('filter');
        
        if (filter === '.todo') {
            // Mostrar solo el primer elemento 'todo'
            $('.event_box > div').hide();
            $('.event_box > div.todo').first().show();
        } else {
            // Filtrar los elementos según la clase
            $('.event_box > div').hide();
            $('.event_box > div' + filter).show();
        }
    });
});
