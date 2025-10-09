<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obra;
use App\Models\Capitulos;
use Illuminate\Support\Str; 

class CapsTableSeeder extends Seeder
{
    public function run(): void
    {
        Capitulos::truncate();

        $obras = Obra::all();

        foreach ($obras as $obra) {
            
            $obraSlug = Str::slug($obra->titulo); 

            for ($i = 1; $i <= 5; $i++) {
                Capitulos::create([
                    'obra_id' => $obra->id,
                    'nome' => "Capítulo $i: O Início da Jornada",
                    'numero' => $i,
                    'imagens' => [
                        "assets/images/lbpg/lbpg1.jpg",
                        "assets/images/lbpg/lbpg2.jpg",
                        "assets/images/lbpg/lbpg3.jpg",
                    ],
                ]);
            }
        }
    }
}
