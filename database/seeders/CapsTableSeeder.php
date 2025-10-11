<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obra;
use App\Models\Capitulos;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CapsTableSeeder extends Seeder
{
    public function run(): void
    {
        Capitulos::query()->delete();

        $obras = Obra::all();

        foreach ($obras as $obra) {
            $obraSlug = Str::slug($obra->titulo);
            $basePath = public_path("assets/images/{$obraSlug}");

            if (!File::exists($basePath)) continue;

            $capitulosPastas = collect(File::directories($basePath))->sort()->values();

            if ($capitulosPastas->isEmpty()) {
                $capitulosPastas = collect([$basePath]);
            }

            foreach ($capitulosPastas as $index => $capPath) {
                $imagens = collect(File::files($capPath))
                    ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'webp']))
                    ->sort()
                    ->map(function ($file) {
                        // Caminho relativo: remove o "public_path()" e adiciona "/" no início
                        $relativePath = str_replace(public_path(), '', $file->getPathname());
                        $relativePath = str_replace('\\', '/', $relativePath);
                        return $relativePath; // exemplo: /assets/images/obra/1/pg1.jpg
                    })
                    ->values()
                    ->toArray();

                if (!empty($imagens)) {
                    Capitulos::create([
                        'obra_id' => $obra->id,
                        'nome' => "Capítulo " . ($index + 1),
                        'numero' => $index + 1,
                        'imagens' => $imagens,
                    ]);
                }
            }
        }
    }
}
