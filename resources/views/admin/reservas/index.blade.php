@extends('layout.admin')
@section('titulo', 'Paquetes - Magic Tours')

@section('contenido')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12 mt-5 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0">LISTA DE RESERVAS</h1>
                </div>
            </div>

            <div class="col-12 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Buscar Reserva</h3>
                </div>

                <!-- Formulario de búsqueda -->
                <form action="" method="GET">
                    <div class="input-group my-3">
                        <input type="text" class="form-control" name="search" placeholder="Buscar Reserva"
                            aria-label="Buscar Reserva">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>

                <!-- Mostrar resultados de la búsqueda -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4 class="mb-0">Resultados: <span class="badge badge-info">{{ $reservas->count() }}</span></h4>
                </div>


            </div>

            <div class="col-12 mt-3 card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Paquete</th>
                                <th scope="col">Comentario</th>
                                <th scope="col">Cant. Personas</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservas as $reserva)
                                <tr>
                                    <td scope="row" class="text-uppercase">{{ $reserva->cliente }}</td>
                                    <td>{{ $reserva->titulo }}</td>
                                    <td>{{ $reserva->comentario }}</td>
                                    <td>{{ $reserva->cantidad_personas }}</td>
                                    <td>{{ $reserva->fecha_reserva }}</td>
                                    <td>{{ $reserva->estado }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href=""
                                                class="btn btn-info btn-sm mr-2">Ver</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                {{-- Pagination --}}
                {{ $reservas->links() }}
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets-admin/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets-admin/js/pages/dashboard-default.js') }}"></script>
    <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
    <!-- Agregar Alert2 (Swal) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(paqueteId) {
            // Usar SweetAlert2 para confirmar la eliminación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este paquete después de eliminarlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario con el ID correspondiente
                    document.getElementById('delete-form-' + paqueteId)
                        .submit(); // Enviar el formulario de eliminación correspondiente
                } else {
                    // Si el usuario cancela, no hacer nada
                    return false;
                }
            });
            return false; // Prevenir el envío inmediato del formulario
        }
    </script>
    @if (session('success'))
        <script>
            // Mostrar el mensaje con SweetAlert2
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}", // El mensaje de éxito de la sesión
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif


@endsection
