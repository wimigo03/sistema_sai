const diasDesdeDiciembre = () => {
    return Math.floor(
        (new Date() - fechaUltimoDiciembre()) / (1000 * 60 * 60 * 24)
    );
};

const diasTranscurridos = (fechaInicial) => {
    return Math.floor((new Date() - fechaInicial) / (1000 * 60 * 60 * 24)) +1;
};

const fechaUltimoCorte = (fechaInicial) => {
    return Math.floor(
        (fechaUltimoDiciembre() - fechaInicial) / (1000 * 60 * 60 * 24)
    );
};

function fechaUltimoDiciembre() {
    return new Date(new Date().getFullYear() - 1, 11, 31);
}

const factorActual = (ufInicial, ufActual) => {
    return ufActual / ufInicial;
};

const coeficienteDep = (vidaUtil) => {
    return (1 / vidaUtil) * 100;
};

const valorActual = (costoInicial, ufInicial, ufActual) =>{
    return costoInicial * factorActual(ufInicial, ufActual)
}

const costoInicialActualizado = (costoInicial, ufInicial, ufActual) => {
    return costoInicial * factorActual(ufInicial, ufActual);
};

const depreciacionDiaria = (costoInicial, vidaUtil, ufInicial, ufActual) => {
    const factor = factorActual(ufInicial, ufActual);
    const depreciacionDiaria =  costoInicial / vidaUtil / 365;
    return depreciacionDiaria * factor;
};

const depreciacionAcumulada = (costoInicial, vidaUtil, fechaInicial, ufInicial,ufActual) => {
    if(vidaUtil == 0){
        return 0;
    }
    var resultado =  depreciacionDiaria(costoInicial, vidaUtil, ufInicial,ufActual) *
    diasTranscurridos(fechaInicial)
    if(resultado> valorActual(costoInicial, ufInicial, ufActual)){
        resultado = valorActual(costoInicial, ufInicial, ufActual) - 1
    }
    return (
       resultado
    );
};

const depreciacionAcumuladaGestion = (costoInicial, vidaUtil, ufInicial, ufActual) => {
    if(vidaUtil == 0){
        return 0;
    }
    return depreciacionDiaria(costoInicial, vidaUtil, ufInicial, ufActual) * diasDesdeDiciembre();
};

const depreciacionAcumuladaInicial = (costoInicial, vidaUtil, fechaInicial, ufInicial, ufActual) => {
    if(vidaUtil == 0){
        return 0;
    }
    if (fechaInicial <= fechaUltimoDiciembre()) {
        return (
            depreciacionDiaria(costoInicial, vidaUtil, ufInicial, ufActual) *
            fechaUltimoCorte(fechaInicial)
        );
    }
    return 0;
};

const valorNeto = (costoInicial, vidaUtil, fechaInicial,ufInicial,ufActual) => {
    if(vidaUtil == 0){
        return costoInicialActualizado(costoInicial,ufInicial, ufActual);
    }
    const resultado =
        valorActual(costoInicial, ufInicial, ufActual) -
        depreciacionAcumulada(costoInicial, vidaUtil, fechaInicial, ufInicial,ufActual);
    if (resultado < 0) {
        return 1;
    }

    return resultado;
};