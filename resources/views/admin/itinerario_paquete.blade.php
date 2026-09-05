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


    <form method="POST" action="{{ route('admin.paquetes.itinerario.store', $paquete->id) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <h4>Formulario de creación de itinerarios</h4>

                <div class="row">

                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Título</span>
                        </div>
                        <input type="text" class="form-control" name="titulo" required
                            placeholder="Título del itinerario">
                    </div>

                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Descripción</span>
                        </div>
                        <textarea name="desc" class="form-control" rows="3" required placeholder="Descripción del itinerario"></textarea>
                    </div>

                    <div class="col-12 col-md-4 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Orden</span>
                        </div>
                        <input type="number" class="form-control" name="orden" required
                            placeholder="Orden del itinerario">
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Agregar Itinerario</button>
            </div>
        </div>
    </form>


    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Itinerarios de paquete</h4>

            <div class="accordion" id="itinerariosAccordion">
                @foreach ($itinerarios->sortBy('orden') as $imagen)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $imagen->id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $imagen->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $imagen->id }}">
                                <strong>Itinerario:</strong> {{ $imagen->titulo }} (Orden: {{ $imagen->orden }})
                            </button>
                        </h2>
                        <div id="collapse{{ $imagen->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $imagen->id }}" data-bs-parent="#itinerariosAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p><strong>Descripción:</strong> {{ $imagen->desc }}</p>
                                        <div class="d-flex justify-content-between">
                                            <form action="{{ route('admin.paquetes.itinerario.destroy', ['id' => $paquete->id, 'id_itinerario' => $imagen->id]) }}" method="POST" id="delete-form-{{ $imagen->id }}">

                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $imagen->id }})">Eliminar</button>
                                            </form>

                                            <!-- Botón de Editar -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $imagen->id }}">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Modal para editar itinerario -->
    @foreach ($itinerarios as $imagen)
        <div class="modal fade" id="editModal{{ $imagen->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $imagen->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $imagen->id }}">Editar Itinerario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="{{ route('admin.paquetes.itinerario.update', ['id' => $paquete->id, 'id_itinerario' => $imagen->id]) }}"
                            method="POST">

                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    value="{{ $imagen->titulo }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Descripción</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3" required>{{ $imagen->desc }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="orden" class="form-label">Orden</label>
                                <input type="number" class="form-control" id="orden" name="orden"
                                    value="{{ $imagen->orden }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach













@endsection
@section('js')
    <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
