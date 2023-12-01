const diasDesdeDiciembre = () => {
    return Math.floor(
        (new Date() - fechaUltimoDiciembre()) / (1000 * 60 * 60 * 24)
    );
};

const depreciacionAnual = (costoInicial, vidaUtil) => {
    return costoInicial / vidaUtil;
};

const depreciacionDiaria = (costoInicial, vidaUtil) => {
    return costoInicial / vidaUtil / 365;
};

const diasTranscurridos = (fechaInicial) => {
    return Math.floor((new Date() - fechaInicial) / (1000 * 60 * 60 * 24));
};

const depreciacionAcumulada = (costoInicial, vidaUtil, fechaInicial) => {
    return (
        depreciacionDiaria(costoInicial, vidaUtil) *
        diasTranscurridos(fechaInicial)
    );
};

const valorActual = (costoInicial, vidaUtil, fechaInicial) => {
    const resultado =
        costoInicial -
        depreciacionAcumulada(costoInicial, vidaUtil, fechaInicial);
    if (resultado < 0) {
        return 1;
    }

    return resultado;
};

function fechaUltimoDiciembre() {
    return new Date(new Date().getFullYear() - 1, 11, 31);
}

const factorActual = (costoInicial, vidaUtil) => {
    return costoInicial / vidaUtil / 365;
};

const depreciacionAcumuladaGestion = (costoInicial, vidaUtil) => {
    return depreciacionDiaria(costoInicial, vidaUtil) * diasDesdeDiciembre();
};

const depreciacionAcumuladaInicial = (costoInicial, vidaUtil, fechaInicial) => {
    if (fechaInicial <= fechaUltimoDiciembre()) {
        return (
            depreciacionDiaria(costoInicial, vidaUtil) *
            fechaUltimoCorte(fechaInicial)
        );
    }
    return 0;
};

const fechaUltimoCorte = (fechaInicial) => {
    return Math.floor(
        (fechaUltimoDiciembre() - fechaInicial) / (1000 * 60 * 60 * 24)
    );
};
