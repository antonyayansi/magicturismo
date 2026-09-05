@extends('layout.admin')
@section('titulo', 'Paquetes - Magic Tours')

@section('contenido')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12 mt-5 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0">LISTA DE PAQUETES</h1>
                    <a href="{{ route('admin.create_paquete') }}" class="btn btn-primary">Agregar Paquete</a>
                </div>
            </div>

            <div class="col-12 card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Buscar Paquete</h3>
                </div>

                <!-- Formulario de búsqueda -->
                <form action="{{ route('paquetes.search') }}" method="GET">
                    <div class="input-group my-3">
                        <input type="text" class="form-control" name="search" placeholder="Buscar Paquete"
                            aria-label="Buscar Paquete">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>

                <!-- Mostrar resultados de la búsqueda -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4 class="mb-0">Resultados: <span class="badge badge-info">{{ $paquetes->count() }}</span></h4>
                </div>


            </div>


            <div class="col-12 mt-3 card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Duración</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Imágenes</th>
                                <th scope="col">Itinerario</th>
                                <th scope="col">Inluye</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paquetes as $paquete)
                                <tr>
                                    <td scope="row" class="text-uppercase">{{ $paquete->titulo }}</td>

                                    <td>{{ $paquete->duracion }}</td>
                                    <td>{{ $paquete->tipo }}</td>
                                    <td>{{ $paquete->precio }}</td>
                                    <td>{{ $paquete->slug }}</td>
                                    <td>
                                        @if ($paquete->galeria->isEmpty())
                                            <a href="{{ route('admin.paquetes.imagenes', $paquete->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-times" style="color:white;"></i>
                                                Sin imágenes
                                            </a>
                                        @else
                                            <a href="{{ route('admin.paquetes.imagenes', $paquete->id) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-check"
                                                    style="color:white;"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($paquete->itinerarios->isEmpty())
                                            <a href="{{ route('admin.paquetes.itinerario', $paquete->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-times" style="color:white;"></i>
                                                Sin Itinerario
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-check"
                                                    style="color:white;"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($paquete->incluye->isEmpty())
                                            <a href="{{-- {{ route('admin.paquetes.incluye', $paquete->id) }} --}}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times" style="color:white;"></i>
                                                Sin Incluye
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-check"
                                                    style="color:white;"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Botón para editar -->
                                        <a href="{{ route('admin.paquetes.edit', $paquete->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Formulario para eliminar con confirmación -->
                                        <form id="delete-form-{{ $paquete->id }}"
                                            action="{{ route('admin.paquetes.destroy', $paquete->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirmDelete({{ $paquete->id }});">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                {{-- Pagination --}}
                {{ $paquetes->links() }}
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
