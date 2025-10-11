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
        $obra = Obra::findOrFail(1);
        $capitulos = $obra->capitulos()->orderBy('numero', 'asc')->get();
        return view('obra1', compact('obra', 'capitulos'));
    }

    public function obra2()
    {
        $obra = Obra::findOrFail(2);
        $capitulos = $obra->capitulos()->orderBy('numero', 'asc')->get();
        return view('obra2', compact('obra', 'capitulos'));
    }

    public function obra3()
    {
        $obra = Obra::findOrFail(3);
        $capitulos = $obra->capitulos()->orderBy('numero', 'asc')->get();
        return view('obra3', compact('obra', 'capitulos'));
    }

    public function obra4()
    {
        $obra = Obra::findOrFail(4);
        $capitulos = $obra->capitulos()->orderBy('numero', 'asc')->get();
        return view('obra4', compact('obra', 'capitulos'));
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
