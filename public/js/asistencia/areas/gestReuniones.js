
function construirSelectDia(name) {
    var select = '<select class="form-control" name="' + name + '">';
    for (var i = 0; i < dias.length; i++) {
        select += '<option value="' + dias[i] + '">' + dias[i] + '</option>';
    }

    select += '</select>';
    return select
}

function construirSelectDisponibilidad(name) {
    var select = '<select class="form-control" name="' + name + '">';
    for (var i = 0; i < disponibilidades.length; i++) {
        select += '<option value="' + disponibilidades[i] + '">' + disponibilidades[i] + '</option>';
    }

    select += '</select>';
    return select
}

function construirSelectHora(name) {
    var select = '<select class="form-control" name="' + name + '">';
    for (var i = 0; i < horas.length; i++) {
        select += '<option value="' + horas[i] + '">' + horas[i] + '</option>';
    }
    select += '</select>';
    return select;
}

function eliminarFila(boton) {
    var fila = boton.parentNode.parentNode;
    fila.parentNode.removeChild(fila);
}
