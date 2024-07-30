<div class="modal fade" id="entregaModal" tabindex="-1" role="dialog" aria-labelledby="entregaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title font-roboto-16" id="entregaModalLabel">
                    <b><span class="text-danger">[RESAGADO]</span>&nbsp;<u><span id="modalBeneficiario"></span></u></b>
                </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="form-resagado">
                    @csrf
                    <textarea name="observacion" id="observacion" placeholder="Observaciones" name="observacion" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-12 intro_entrega">{{ old('observacion') }}</textarea>
                    <input type="hidden" value="#" name="entrega_id" id="modalEntregaId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary font-roboto-12" data-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>&nbsp;Cerrar
                </button>
                <a href="#" class="btn btn-success font-roboto-12" onclick="procesar_entrega();">
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar Entrega
                </a>
            </div>
        </div>
    </div>
</div>
