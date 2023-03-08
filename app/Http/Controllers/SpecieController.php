<?php

namespace App\Http\Controllers;

use App\Models\Specie;
use App\Http\Requests\StoreSpecieRequest;
use App\Http\Requests\UpdateSpecieRequest;

class SpecieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $species = Specie::orderBy('name')->get();
        return view('specie.index', ['species' => $species]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSpecieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecieRequest $request)
    {
        $specie = new Specie;
        $specie->name = $request->specie_name;
        $specie->save();
        return redirect()->route('specie.index')->with('success_message', 'Nauja gyvunų rūšis sėkmingai įrašyta.');   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function show(Specie $specie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function edit(Specie $specie)
    {
        return view('specie.edit', ['specie' => $specie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSpecieRequest  $request
     * @param  \App\Models\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecieRequest $request, Specie $specie)
    {
        $specie->name = $request->specie_name;
        $specie->save();
        return redirect()->route('specie.index')->with('success_message', 'Rūšies pavadinimas sėkmingai atnaujintas.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specie $specie)
    {
        if($specie->getManagers->count()){
            return redirect()->route('specie.index')->with('info_message', 'Šios rūšies trinti negalima, nes turi prižiūrėtojų.');
        }
        elseif($specie->getAnimals->count()){
            return redirect()->route('specie.index')->with('info_message', 'Šios rūšies trinti negalima, nes yra jai priskirtų gyvūnų.');
        }
        $specie->delete();
        return redirect()->route('specie.index')->with('success_message', 'Ši gyvūnų rūšis sėkmingai ištrinta.');
 
    }
}
