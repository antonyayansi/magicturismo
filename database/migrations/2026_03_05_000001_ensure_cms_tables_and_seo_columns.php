<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contenidos')) {
            Schema::create('contenidos', function (Blueprint $table) {
                $table->id();
                $table->string('clave')->unique();
                $table->string('grupo')->nullable()->index();
                $table->string('titulo')->nullable();
                $table->longText('texto')->nullable();
                $table->string('imagen')->nullable();
                $table->json('extra')->nullable();
                $table->unsignedInteger('orden')->default(0);
                $table->string('estado')->default('activo')->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->id();
                $table->string('ubicacion')->default('header')->index();
                $table->string('label');
                $table->string('url')->nullable();
                $table->string('ruta')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable()->index();
                $table->unsignedInteger('orden')->default(0);
                $table->boolean('visible')->default(true);
                $table->string('target')->default('_self');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('paginas')) {
            Schema::create('paginas', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('titulo');
                $table->text('extracto')->nullable();
                $table->longText('contenido')->nullable();
                $table->string('imagen')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->string('estado')->default('activo')->index();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('paquetes')) {
            $paqueteCols = [
                'slug' => fn (Blueprint $t) => $t->string('slug')->nullable()->index(),
                'excerpt' => fn (Blueprint $t) => $t->text('excerpt')->nullable(),
                'meta_title' => fn (Blueprint $t) => $t->string('meta_title')->nullable(),
                'meta_description' => fn (Blueprint $t) => $t->text('meta_description')->nullable(),
                'meta_keywords' => fn (Blueprint $t) => $t->string('meta_keywords')->nullable(),
                'canonical_url' => fn (Blueprint $t) => $t->string('canonical_url')->nullable(),
            ];
            foreach ($paqueteCols as $name => $adder) {
                if (! Schema::hasColumn('paquetes', $name)) {
                    Schema::table('paquetes', function (Blueprint $table) use ($adder) {
                        $adder($table);
                    });
                }
            }
        }

        if (Schema::hasTable('categorias')) {
            $catCols = [
                'descripcion' => fn (Blueprint $t) => $t->text('descripcion')->nullable(),
                'meta_title' => fn (Blueprint $t) => $t->string('meta_title')->nullable(),
                'meta_description' => fn (Blueprint $t) => $t->text('meta_description')->nullable(),
                'meta_keywords' => fn (Blueprint $t) => $t->string('meta_keywords')->nullable(),
            ];
            foreach ($catCols as $name => $adder) {
                if (! Schema::hasColumn('categorias', $name)) {
                    Schema::table('categorias', function (Blueprint $table) use ($adder) {
                        $adder($table);
                    });
                }
            }
        }

        if (Schema::hasTable('datos_empresa')) {
            $empresaCols = [
                'logo' => fn (Blueprint $t) => $t->string('logo')->nullable(),
                'favicon' => fn (Blueprint $t) => $t->string('favicon')->nullable(),
                'desc_corto' => fn (Blueprint $t) => $t->text('desc_corto')->nullable(),
                'facebook' => fn (Blueprint $t) => $t->string('facebook')->nullable(),
                'twitter' => fn (Blueprint $t) => $t->string('twitter')->nullable(),
                'instagram' => fn (Blueprint $t) => $t->string('instagram')->nullable(),
                'linkedin' => fn (Blueprint $t) => $t->string('linkedin')->nullable(),
                'whatsapp' => fn (Blueprint $t) => $t->string('whatsapp')->nullable(),
                'youtube' => fn (Blueprint $t) => $t->string('youtube')->nullable(),
                'footer_texto' => fn (Blueprint $t) => $t->text('footer_texto')->nullable(),
                'meta_title' => fn (Blueprint $t) => $t->string('meta_title')->nullable(),
                'meta_description' => fn (Blueprint $t) => $t->text('meta_description')->nullable(),
                'meta_keywords' => fn (Blueprint $t) => $t->string('meta_keywords')->nullable(),
                'url_frances' => fn (Blueprint $t) => $t->string('url_frances')->nullable(),
                'copyright' => fn (Blueprint $t) => $t->string('copyright')->nullable(),
                'faq_url' => fn (Blueprint $t) => $t->string('faq_url')->nullable(),
                'soporte_url' => fn (Blueprint $t) => $t->string('soporte_url')->nullable(),
            ];
            foreach ($empresaCols as $name => $adder) {
                if (! Schema::hasColumn('datos_empresa', $name)) {
                    Schema::table('datos_empresa', function (Blueprint $table) use ($adder) {
                        $adder($table);
                    });
                }
            }
        }
    }

    public function down(): void
    {
        // Non-destructive: do not drop tables or columns.
    }
};
