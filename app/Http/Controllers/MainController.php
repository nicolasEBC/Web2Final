<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Capitulos;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $nome = $request->input('nome');

        $obrasQuery = Obra::query();

        if ($nome) {
            $obrasQuery->where('titulo', 'LIKE', "%{$nome}%")
                ->orWhere('autor', 'LIKE', "%{$nome}%");
        } else {
            $obrasQuery->orderBy('nota', 'desc');
            $obrasQuery->limit(4);
        }

        $obras = $obrasQuery->get();
        return view('home', compact('obras'));
    }

    public function newNote()
    {
        return "Criando uma Nova Nota";
    }

    public function obra1()
    {
        return view('obra1');
    }

    public function obra2()
    {
        return view('obra2');
    }

    public function obra3()
    {
        $obra = Obra::findOrFail(3);
        $capitulos = $obra->capitulos()->orderBy('numero', 'asc')->get();
        return view('obra3', compact('obra', 'capitulos'));
    }

    public function obra4()
    {
        return view('obra4');
    }

    public function capitulo(string $obraSlug, int $numero)
{
    $obra = Obra::where('slug', $obraSlug)->firstOrFail();
    $capitulo = Capitulos::where('obra_id', $obra->id)
                         ->where('numero', $numero)
                         ->firstOrFail();
    return view('capitulo', compact('obra', 'capitulo'));
}

}
