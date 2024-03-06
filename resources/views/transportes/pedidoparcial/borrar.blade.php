<div class="form-group row">
    <label style="color:black;font-weight: bold;" for="fecha"
        class="required col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>
    <div class="col-md-7">
        <textarea id="fecha" required type="date" name="fecha" placeholder="fecha..." cols="50"
            rows="2" class="form-control"
            onkeyup="javascript:this.value=this.value.toUpperCase();">{{$vales->fechavaleserv}}</textarea>
    </div>
</div>

<div class="col-md-2">
    <label for="fechasalida" class="d-inline font-verdana-bg">
        <b> fechasalida</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
    </label>
    <textarea required type="date" name="fechasalida" placeholder="dd/mm/aaaa"

    class="form-control" 
    id="fechasalida" onkeyup="javascript:this.value=this.value.toUpperCase();">{{$soluconsumos->fechasalida}}</textarea>
</div>