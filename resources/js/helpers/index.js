import {format, parseISO} from 'date-fns';

// export const obtenerNombreCompleto = usuario => usuario.id ? `${usuario.apellido_paterno} ${usuario.apellido_materno} ${usuario.nombre}, ${usuario.grado}` : '';

export const obtenerNombreCompleto = (usuario, orden='apellido', con_grado=true) => {
    let nombreCompleto = '';
    if(usuario.nombre) {
        if(orden === 'apellido') nombreCompleto = `${usuario.apellido_paterno} ${usuario.apellido_materno} ${usuario.nombre}`;
        else nombreCompleto = `${usuario.nombre} ${usuario.apellido_paterno} ${usuario.apellido_materno}`;
        if(con_grado) nombreCompleto += `, ${usuario.grado}`; 
    } 
    return nombreCompleto;
}

export const uuidv4 = function b(a){return a?(a^Math.random()*16>>a/4).toString(16):([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g,b)};

export const formatoFecha = ISOstring => format(parseISO(ISOstring), 'dd/MM/y');