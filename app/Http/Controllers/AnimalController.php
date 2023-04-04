<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Specie;
use App\Models\Manager;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $species = Specie::all();
        $managers = Manager::all();
        
        if ($request->sort) {
            if ('name' == $request->sort && 'asc' == $request->sort_dir) {
                $animals = Animal::orderBy('name')->get();
            }
            else if ('name' == $request->sort && 'desc' == $request->sort_dir) {
                $animals = Animal::orderBy('name', 'desc')->get();
            }
            else if ('birth_year' == $request->sort && 'asc' == $request->sort_dir) {
                $animals = Animal::orderBy('birth_year')->get();
            }
            else if ('birth_year' == $request->sort && 'desc' == $request->sort_dir) {
                $animals = Animal::orderBy('birth_year', 'desc')->get();
            }
            else {
                $animals = Animal::all();  
            }
        }
        else if ($request->filter && 'specie' == $request->filter) {
            $animals = Animal::where('specie_id', $request->specie_id)->get();
        }
        else if ($request->filter && 'manager' == $request->filter) {
            $animals = Animal::where('manager_id', $request->manager_id)->get();
        }
        else if ($request->search && 'all' == $request->search) {

            $words = explode(' ', $request->s);
            if (count($words) == 1) {
            $animals = Animal::where('name', 'like', '%'.$request->s.'%')
            ->orWhere('birth_year', 'like', '%'.$request->s.'%')->get();
            } 
            else {
                $animals = Animal::where(function($query) use ($words) {
                    $query->where('name', 'like', '%'.$words[0].'%')->orWhere('birth_year', 'like', '%'.$words[0].'%');
            })
        ->where(function($query) use ($words) {
        $query->where('name', 'like', '%'.$words[1].'%')
        ->orWhere('birth_year', 'like', '%'.$words[1].'%');
        })->get();
    }
}
        else {
            $animals = Animal::orderBy('created_at', 'desc')->get();
        }
  
        return view('animal.index', [
            'animals' => $animals,
            'sortDirection' => $request->sort_dir ?? 'asc',
            'species' => $species,
            'specieId' => $request->specie_id ?? '0',
            'managers' => $managers,
            'managerId' => $request->manager_id ?? '0',
            'managerOfAnimal' => Animal::where('manager_id', $request->manager_id)->get()[0] ?? '0',
            's' => $request->s ?? ''
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $species = Specie::orderBy('name')->get();
        $managers = Manager::orderBy('surname')->get();
        return view('animal.create', compact('species'), compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnimalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnimalRequest $request)
    {
        $animal = new Animal;
        $animal->name = $request->animal_name;
        $animal->specie_id = $request->specie_id;
        $animal->birth_year = $request->animal_birth_year;
        $animal->animal_book = $request->animal_about;
        $animal->manager_id = $request->manager_id;
        $animal->save();
        return redirect()->route('animal.index')->with('success_message', 'Naujas gyvūnas sėkmingai įrašytas.');   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $species = Specie::orderBy('name')->get();
        $managers = Manager::orderBy('surname')->get();
        return view('animal.edit',compact('animal'), ['species' => $species, 'managers' =>$managers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnimalRequest  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $animal->name = $request->animal_name;
        $animal->specie_id = $request->specie_id;
        $animal->birth_year = $request->animal_birth_year;
        $animal->animal_book = $request->animal_about;
        $animal->manager_id = $request->manager_id;
        $animal->save();
        return redirect()->route('animal.index')->with('success_message', 'Gyvūno info sėkmingai atnaujinta.');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return redirect()->route('animal.index')->with('success_message', 'Gyvūnas sėkmingai ištrintas.');
    }
}
