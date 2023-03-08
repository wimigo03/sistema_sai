@extends('layouts.admin')
@section('content')
<style>
    .div-1 {
        background-color: #FFDA67;
        padding: 16px;
    }
    
    .div-2 {
    	background-color: #ABBAEA;
    }
    
    .div-3 {
    	background-color: #FBD603;
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex justify-content-center" style="color:black;font-weight: bold;font-size: 18px;"><font >FORMULARIO DE INGRESO</font></div>

            <div class="row">

               
                <a href="{{url()->previous()}}" class="btn blue darken-4 text-black "><i
                        style="color:#55CE63;font-weight: bold;" class="fa fa-plus-square"></i> Volver atras</a>

                     
            </div>

            <div class="card-body div-1 ">
                <font size="2" face="Courier New">
                    <form method="POST" >
                        @csrf
                        @method('POST')
                  

                        <div class="form-group row">
                            <span class="input-group col-md-1" style="color:black;font-weight: bold;">ENTIDAD:</span>

                            <div class="col-md-1">
                                <input required type="text" name="nombres" class="form-control"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" 
                                    ></input>
                            </div>



                            <span class="input-group  col-md-1"
                                style="color:black;font-weight: bold;">DIR.ADMIN.:</span>
                            <div class="col-md-1">
                                <input required type="text" name="ap_pat" class="form-control "
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    ></input>
                            </div>


                            <span class="input-group  col-md-1"
                                style="color:black;font-weight: bold;">F.INCORP.:</span>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fechaincorporacion" >
                            </div>

                        <span class="input-group  col-md-1"
                         style="color:black;font-weight: bold;">N.ORDEN.:</span>
                        <div class="col-md-1">
                            <input required type="text" name="ap_mat" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                        </div>

                        
                        <span class="input-group  col-md-1"
                         style="color:black;font-weight: bold;">N.PREV.:</span>
                        <div class="col-md-1">
                            <input required type="text" name="ap_mat" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                        </div>

                        </div>



                        <div class="form-group row">


                            <span class="input-group col-md-1"
                                style="color:black;font-weight: bold;">CODIGO:</span>
                            <div class="col-md-1">
                                <input required type="text" name="codigo" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                            </div>

                            <span class="input-group 1 col-md-1"
                                style="color:black;font-weight: bold;">UN.SOLIC.:</span>

                            <div class="col-md-2 ">
                                <input required type="text" name="unidadsolicitante" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                            </div>


                            <span class="input-group 1 col-md-1"
                                style="color:black;font-weight: bold;">UFV:</span>

                            <div class="col-md-1">
                                <input required type="text" name="ufv" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                            </div>

                            <span class="input-group 1 col-md-1"
                                style="color:black;font-weight: bold;">N.H.CIRCUL.:</span>

                            <div class="col-md-1">
                                <input required type="text" name="ufv" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                ></input>
                            </div>

                            <span class="input-group 1 col-md-1"
                            style="color:black;font-weight: bold;">ORG.FIN.:</span>

                        <div class="col-md-1">
                            <input required type="text" name="hojacirculacion" class="form-control"
                            onkeyup="javascript:this.value=this.value.toUpperCase();"
                            ></input>
                        </div>




                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:black;font-weight: bold;">PROVEEDOR:</span>
                            <div class="col-md-2 ">
                                <input type="text" name="proveedor" class="form-control" >
                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">NOMB.SOLIC.:</span>
                            <div class="col-md-2">
                                <input type="text" name="nombresolicitante" class="form-control" >
                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">TITULARIDAD:</span>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="titulariad" >

                            </div>

                            <span class="input-group col-md-1 "
                            style="color:black;font-weight: bold;">N.CONV.:</span>
                        <div class="col-md-1">
                            <input type="text" class="form-control" name="numconvenio" >

                        </div>


                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:black;font-weight: bold;">DESCRIPCION:</span>
                            <div class="col-md-10">
                                <input type="text" name="descripcion" class="form-control"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" >

                           </div>

                        
                        </div>



                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">G.CONTABLE:</span>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="gcontable"
                                   >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">MARCA:</span>

                            <div class="col-md-1">
                                <input type="text" name="marca" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">MOTOR:</span>

                            <div class="col-md-1">
                                <input type="text" name="motor" class="form-control" >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">CHASIS:</span>

                            <div class="col-md-1">
                                <input type="text" name="chasis" class="form-control" >

                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">POLIZA:</span>

                            <div class="col-md-1">
                                <input type="text" name="poliza" class="form-control" >

                            </div>


                        </div>



                        <div class="form-group row">
                            <span class="input-group col-md-1 " style="color:black;font-weight: bold;">AUX.GRUPO:</span>

                            <div class="col-md-2">
                                <input type="text" name="auxgrupo" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1"
                                style="color:black;font-weight: bold;">MODELO:</span>

                            <div class="col-md-1">
                                <input type="text" class="form-control" name="modelo"
                                   >

                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">RADICATORIA:</span>

                            <div class="col-md-1">
                                <input type="text" name="radicatoria" class="form-control"
                                    >

                            </div>
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">TRACCION:</span>

                            <div class="col-md-1">
                                <input type="text" name="traccion" class="form-control"
                                    >

                            </div>
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">CILINDRADA:</span>

                            <div class="col-md-1">
                                <input type="text" name="cilindrada" class="form-control"
                                    >

                            </div>


                        </div>




                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">OFICINA:</span>

                            <div class="col-md-2">
                                <input type="text" class="form-control" name="expprogvacacion"
                                   >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">SERIE:</span>

                            <div class="col-md-1">
                                <input required type="text" name="vacganadas" class="form-control"
                                    ></input>
                            </div>

                            

                        </div>





                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">RESPONSABLE:</span>

                            <div class="col-md-2">
                                <input type="text" name="vacusasdas" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1"
                                style="color:black;font-weight: bold;">COLOR:</span>

                            <div class="col-md-1">
                                <input type="text" name="segsalud" class="form-control"
                                    >

                            </div>

                         


                        </div>





                        <div class="form-group row">

                            <span class="input-group col-md-1 " style="color:black;font-weight: bold;">CARGO:</span>

                            <div class="col-md-2">
                                <input type="text" name="aservicios" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1"
                                style="color:black;font-weight: bold;">CAPACIDAD:</span>

                            <div class="col-md-1">
                                <input type="text" name="cvitae" class="form-control" >

                            </div>

                    


                        </div>



                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">ESTADO:</span>

                            <div class="col-md-2">
                                <input type="text" name="biometrico" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">PLACA:</span>

                            <div class="col-md-1">
                                <input type="text" name="gradacademico" class="form-control" >

                            </div>

                          
                        </div>

                        <div class="form-group row">

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">OBSERV.:</span>

                            <div class="col-md-4">
                                <input type="text" name="regprofesional" class="form-control"
                                    >

                            </div>

                            

                         

                        </div>
                        </br>

                        

                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">COSTO INICIAL:</span>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="gcontable"
                                   >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">VERIFICACION:</span>

                            <div class="col-md-1">
                                <input type="text" name="marca" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">FACTOR ACTUAL:</span>

                            <div class="col-md-1">
                                <input type="text" name="motor" class="form-control" >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">VALOR ACTUAL:</span>

                            <div class="col-md-1">
                                <input type="text" name="chasis" class="form-control" >

                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">DEP. ACUMULADA:</span>

                            <div class="col-md-1">
                                <input type="text" name="poliza" class="form-control" >

                            </div>


                        </div>
                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">VIDA UTIL:</span>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="gcontable"
                                   >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">% DEPRECIACION:</span>

                            <div class="col-md-1">
                                <input type="text" name="marca" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">DIAS CONSUMIDOS:</span>

                            <div class="col-md-1">
                                <input type="text" name="motor" class="form-control" >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">DEP. GESTION:</span>

                            <div class="col-md-1">
                                <input type="text" name="chasis" class="form-control" >

                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">VALOR NETO:</span>

                            <div class="col-md-1">
                                <input type="text" name="poliza" class="form-control" >

                            </div>


                        </div>


                        <div class="form-group row">
                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">CALCULADO AL:</span>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="gcontable"
                                   >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">UFV ACTUAL:</span>

                            <div class="col-md-1">
                                <input type="text" name="marca" class="form-control"
                                    >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">Nro. PARTIDA:</span>

                            <div class="col-md-1">
                                <input type="text" name="motor" class="form-control" >

                            </div>

                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">Nro. SUBPARTIDA:</span>

                            <div class="col-md-1">
                                <input type="text" name="chasis" class="form-control" >

                            </div>


                            <span class="input-group col-md-1 "
                                style="color:black;font-weight: bold;">DAR BAJA O REVALUO:</span>

                            <div class="col-md-1">
                                <input type="text" name="poliza" class="form-control" >

                            </div>


                        </div>


                        







                        <div class="box-footer" align="center">
                            <button type="submit" class="btn btn-info btn-sm">Guardar</button>
                        </div>
    
                    </form>
                </font>


            </div>
        </div>
    </div>
</div>
@endsection