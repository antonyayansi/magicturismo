@extends('layout.admin')
@section('titulo', 'Crear Paquete - Magic Tours')

@section('contenido')
    <br><br><br><br>
    <div class="page-header pl-5">
        <h2 class="header-title">Administrador</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i
                        class="anticon anticon-home m-r-5"></i>Dashboard</a>
                <a class="breadcrumb-item" href="{{ route('admin.paquetes') }}">Paquetes</a>
                <span class="breadcrumb-item">Galería de Paquete</span>
                <span class="breadcrumb-item active">{{ $paquete->titulo }}</span>
            </nav>
        </div>
    </div>


    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.paquetes.imagenes.store', $paquete->id) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <h4>Formulario de creación de paquete</h4>

                <div class="row">

                    <div class="col-12 col-md-6 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Imagen Principal</span>
                        </div>
                        <!-- Input file -->
                        <input type="file" class="form-control" id="imageInput" aria-describedby="basic-addon3"
                            placeholder="imagen" name="imagen" required accept="image/*">
                    </div>
                    <div class="col-12 col-md-6 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Descripción</span>
                        </div>
                        <!-- Input file -->
                        <textarea name="desc" id="desc" cols="80" rows="3"> </textarea>
                    </div>
                </div>

            </div>
        </div>




        <div class="card">
            <div class="col-12 col-md-12 input-group mb-3">
                <input type="submit" value="Crear Paquete" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <h4>Galería de Paquete</h4>
            <div class="row">
                @foreach ($galeria as $imagen)
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ Storage::url('paquetes/' . $imagen->img) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">{{ $imagen->desc }}</p>
                                <form
                                    action="{{ route('admin.paquetes.imagenes.destroy', ['id' => $paquete->id, 'id_imagen' => $imagen->id]) }}"
                                    method="POST" id="delete-form-{{ $imagen->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete({{ $imagen->id }})">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>











@endsection
@section('js')
    <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(imagenId) {
            // Llamada a SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, se envía el formulario
                    document.getElementById('delete-form-' + imagenId).submit();
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif


@endsection
