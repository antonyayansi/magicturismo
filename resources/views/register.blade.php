@extends('layout.es')
@section('titulo', 'Registro')
@section('palabras', 'Bienvenido a nuestra plataforma')
@section('descripcion', 'Inicia sesión para acceder a tu cuenta')

@section('contenido')
    <div class="d-flex justify-content-center align-items-center py-5 bg-light">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Registrate</h3>
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="text" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="th-btn btn-fw th-radius2">Registrarse</button>
                </div>
                <div class="text-center">
                    <a href="{{route('login')}}">¿Ya tienes una cuenta? Inicia sesión</a>
                </div>
                <p class="form-messages mt-3 text-center"></p>
            </form>
        </div>
    </div>
@endsection
