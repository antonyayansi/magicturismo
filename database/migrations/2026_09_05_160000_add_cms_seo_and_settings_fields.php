<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('paquetes')) {
            Schema::table('paquetes', function (Blueprint $table) {
                if (! Schema::hasColumn('paquetes', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (! Schema::hasColumn('paquetes', 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (! Schema::hasColumn('paquetes', 'meta_keywords')) {
                    $table->string('meta_keywords')->nullable();
                }
                if (! Schema::hasColumn('paquetes', 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (! Schema::hasColumn('paquetes', 'excerpt')) {
                    $table->string('excerpt', 500)->nullable();
                }
            });

            if (Schema::hasColumn('paquetes', 'dificultad')) {
                $type = collect(DB::select("SHOW COLUMNS FROM paquetes LIKE 'dificultad'"))->first();
                if ($type && str_contains(strtolower((string) $type->Type), 'enum')) {
                    DB::statement('ALTER TABLE paquetes MODIFY dificultad VARCHAR(50) NULL');
                }
            }

            $indexes = collect(DB::select('SHOW INDEX FROM paquetes'))->pluck('Key_name');
            Schema::table('paquetes', function (Blueprint $table) use ($indexes) {
                if (Schema::hasColumn('paquetes', 'slug') && ! $indexes->contains('paquetes_slug_index')) {
                    $table->index('slug');
                }
                if (! $indexes->contains('paquetes_tipo_estado_index')) {
                    $table->index(['tipo', 'estado']);
                }
            });
        }

        if (Schema::hasTable('categorias')) {
            Schema::table('categorias', function (Blueprint $table) {
                if (! Schema::hasColumn('categorias', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (! Schema::hasColumn('categorias', 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (! Schema::hasColumn('categorias', 'meta_keywords')) {
                    $table->string('meta_keywords')->nullable();
                }
                if (! Schema::hasColumn('categorias', 'descripcion')) {
                    $table->text('descripcion')->nullable();
                }
            });
        }

        if (Schema::hasTable('datos_empresa')) {
            Schema::table('datos_empresa', function (Blueprint $table) {
                foreach ([
                    'facebook' => 'string',
                    'twitter' => 'string',
                    'instagram' => 'string',
                    'linkedin' => 'string',
                    'whatsapp' => 'string',
                    'youtube' => 'string',
                    'footer_texto' => 'text',
                    'meta_title' => 'string',
                    'meta_description' => 'text',
                    'meta_keywords' => 'string',
                    'url_frances' => 'string',
                    'copyright' => 'string',
                    'faq_url' => 'string',
                    'soporte_url' => 'string',
                ] as $column => $type) {
                    if (! Schema::hasColumn('datos_empresa', $column)) {
                        $table->{$type}($column)->nullable();
                    }
                }
            });
        }

        if (! Schema::hasTable('contenidos')) {
            Schema::create('contenidos', function (Blueprint $table) {
                $table->id();
                $table->string('clave')->unique();
                $table->string('grupo')->default('general')->index();
                $table->string('titulo')->nullable();
                $table->longText('texto')->nullable();
                $table->string('imagen')->nullable();
                $table->json('extra')->nullable();
                $table->unsignedInteger('orden')->default(0);
                $table->string('estado', 20)->default('activo');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('paginas')) {
            Schema::create('paginas', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('titulo');
                $table->string('extracto', 500)->nullable();
                $table->longText('contenido')->nullable();
                $table->string('imagen')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->string('estado', 20)->default('activo')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->id();
                $table->string('ubicacion', 30)->default('header')->index();
                $table->string('label');
                $table->string('url')->nullable();
                $table->string('ruta')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->unsignedInteger('orden')->default(0);
                $table->boolean('visible')->default(true);
                $table->string('target', 20)->default('_self');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        $this->dropColumns('paquetes', [
            'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'excerpt',
        ]);
        $this->dropColumns('categorias', [
            'meta_title', 'meta_description', 'meta_keywords', 'descripcion',
        ]);
        $this->dropColumns('datos_empresa', [
            'facebook', 'twitter', 'instagram', 'linkedin', 'whatsapp', 'youtube',
            'footer_texto', 'meta_title', 'meta_description', 'meta_keywords',
            'url_frances', 'copyright', 'faq_url', 'soporte_url',
        ]);

        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('paginas');
        Schema::dropIfExists('contenidos');
    }

    private function dropColumns(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        Schema::table($table, function (Blueprint $tableBlueprint) use ($table, $columns) {
            $existing = array_values(array_filter($columns, fn ($column) => Schema::hasColumn($table, $column)));
            if ($existing !== []) {
                $tableBlueprint->dropColumn($existing);
            }
        });
    }
};
