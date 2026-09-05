<?php

namespace App\Services;

use App\Models\Paquetes;
use App\Models\Reservas;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardMetrics
{
    public static function forget(): void
    {
        Cache::forget('admin.dashboard');
        Cache::forget('admin.reservas.pendientes');
    }

    public static function all(): array
    {
        return Cache::remember('admin.dashboard', 120, function () {
            $pendientes = Reservas::query()->where('estado', 'pendiente')->count();
            $hoy = Reservas::query()->whereDate('created_at', today())->count();
            $semana = Reservas::query()->where('created_at', '>=', now()->startOfWeek())->count();
            $mes = Reservas::query()->where('created_at', '>=', now()->startOfMonth())->count();

            $proximosQuery = Reservas::query()
                ->whereDate('fecha_reserva', '>=', today())
                ->whereDate('fecha_reserva', '<=', today()->addDays(14))
                ->whereIn('estado', ['pendiente', 'pagado']);

            $proximos = (clone $proximosQuery)->count();
            $proximosPersonas = (int) (clone $proximosQuery)->sum('cantidad_personas');

            $personasMes = (int) Reservas::query()
                ->whereDate('fecha_reserva', '>=', now()->startOfMonth())
                ->whereDate('fecha_reserva', '<=', now()->endOfMonth())
                ->whereIn('estado', ['pendiente', 'pagado', 'atendido'])
                ->sum('cantidad_personas');

            $estimado = 0;
            if (Schema::hasColumn('paquetes', 'precio') && Schema::hasColumn('reservas', 'cantidad_personas')) {
                $estimado = (float) Reservas::query()
                    ->join('paquetes', 'paquetes.id', '=', 'reservas.paquete_id')
                    ->whereDate('reservas.fecha_reserva', '>=', now()->startOfMonth())
                    ->whereIn('reservas.estado', ['pagado', 'atendido'])
                    ->selectRaw('COALESCE(SUM(paquetes.precio * reservas.cantidad_personas), 0) as total')
                    ->value('total');
            }

            $catalogo = Paquetes::query()
                ->select('tipo', DB::raw('count(*) as total'))
                ->where(function ($q) {
                    $q->where('estado', 'activo')->orWhereNull('estado')->orWhere('estado', '');
                })
                ->groupBy('tipo')
                ->pluck('total', 'tipo');

            $dias = [];
            $desde = now()->subDays(13)->startOfDay();
            for ($i = 0; $i < 14; $i++) {
                $dias[$desde->copy()->addDays($i)->toDateString()] = 0;
            }

            $porDia = Reservas::query()
                ->selectRaw('DATE(created_at) as dia, COUNT(*) as total')
                ->where('created_at', '>=', $desde)
                ->groupBy('dia')
                ->pluck('total', 'dia');

            foreach ($porDia as $dia => $total) {
                $key = \Illuminate\Support\Carbon::parse($dia)->toDateString();
                if (array_key_exists($key, $dias)) {
                    $dias[$key] = (int) $total;
                }
            }

            return [
                'pendientes' => $pendientes,
                'hoy' => $hoy,
                'semana' => $semana,
                'mes' => $mes,
                'proximos' => $proximos,
                'proximos_personas' => $proximosPersonas,
                'personas_mes' => $personasMes,
                'estimado_mes' => $estimado,
                'tours' => (int) ($catalogo['tour'] ?? 0),
                'paquetes' => (int) ($catalogo['paquete'] ?? 0),
                'caminatas' => (int) (($catalogo['caminata'] ?? 0) + ($catalogo['treks'] ?? 0)),
                'activos' => (int) $catalogo->sum(),
                'por_dia' => $dias,
            ];
        });
    }

    public static function pendientes(): int
    {
        return (int) Cache::remember('admin.reservas.pendientes', 60, function () {
            return Reservas::query()->where('estado', 'pendiente')->count();
        });
    }
}
