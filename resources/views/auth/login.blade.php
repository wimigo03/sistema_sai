@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card-group mb-0">
            <div class="card p-4 body-border" >
            <form class="form-horizontal was-validated" method="POST" action="{{ route('login') }}">
                {{-- csrf_field() --}}
                @csrf
                <div class="body-border">
                <h1>Acceder</h1>
                <p class="text-muted">Control de acceso al sistema</p>
                <div class="form-group mb-3({$errors->has('usuario' ? 'is-valid' : '')})">
                  <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('name')}}" autofocus name="name" id="email" class="form-control @error('name') is-invalid @enderror" placeholder="Usuario">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                </div>
                <div class="form-group mb-3({$errors->has('password' ? 'is-valid' : '')})">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input type="password" name="password" id="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
                </div>
                <div class="row row justify-content-center">

                    <button class="btn color-icon-2 font-verdana-12" type="submit" >

                      Acceder
                  </button>

                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
