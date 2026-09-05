<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('reserva_estados')) {
            Schema::create('reserva_estados', function (Blueprint $table) {
                $table->id();
                $table->string('clave')->unique();
                $table->string('nombre');
                $table->string('color', 30)->default('gray');
                $table->unsignedInteger('orden')->default(0);
                $table->boolean('activo')->default(true);
                $table->boolean('protegido')->default(false);
                $table->timestamps();
            });
        }

        $defaults = [
            ['clave' => 'pendiente', 'nombre' => 'Pendiente', 'color' => 'warning', 'orden' => 1, 'protegido' => true],
            ['clave' => 'pagado', 'nombre' => 'Pagado', 'color' => 'success', 'orden' => 2, 'protegido' => true],
            ['clave' => 'atendido', 'nombre' => 'Atendido', 'color' => 'info', 'orden' => 3, 'protegido' => true],
        ];

        foreach ($defaults as $estado) {
            DB::table('reserva_estados')->updateOrInsert(
                ['clave' => $estado['clave']],
                $estado + ['activo' => true, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        if (Schema::hasTable('reservas') && Schema::hasColumn('reservas', 'estado')) {
            $existentes = DB::table('reservas')
                ->whereNotNull('estado')
                ->where('estado', '!=', '')
                ->distinct()
                ->pluck('estado');

            $orden = 10;
            foreach ($existentes as $clave) {
                $clave = Str::slug((string) $clave, '_');
                if ($clave === '') {
                    continue;
                }

                $exists = DB::table('reserva_estados')->where('clave', $clave)->exists();
                if (! $exists) {
                    DB::table('reserva_estados')->insert([
                        'clave' => $clave,
                        'nombre' => Str::title(str_replace('_', ' ', $clave)),
                        'color' => 'gray',
                        'orden' => $orden++,
                        'activo' => true,
                        'protegido' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_estados');
    }
};
