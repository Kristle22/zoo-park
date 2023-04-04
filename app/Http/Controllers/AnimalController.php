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
    const PAGE_COUNT = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $species = Specie::orderBy('name')->get();
        $managers = Manager::orderBy('name')->get();
        
        if ($request->sort) {
            if ('name' == $request->sort && 'asc' == $request->sort_dir) {
                $animals = Animal::orderBy('name')->paginate(self::PAGE_COUNT)->withQueryString();
            }
            else if ('name' == $request->sort && 'desc' == $request->sort_dir) {
                $animals = Animal::orderBy('name', 'desc')->paginate(self::PAGE_COUNT)->withQueryString();
            }
            else if ('birth_year' == $request->sort && 'asc' == $request->sort_dir) {
                $animals = Animal::orderBy('birth_year')->paginate(self::PAGE_COUNT)->withQueryString();
            }
            else if ('birth_year' == $request->sort && 'desc' == $request->sort_dir) {
                $animals = Animal::orderBy('birth_year', 'desc')->paginate(self::PAGE_COUNT)->withQueryString();
            }
            else {
                $animals = Animal::paginate(self::PAGE_COUNT)->withQueryString();  
            }
        }
        else if ($request->filter && 'specie' == $request->filter) {
            $animals = Animal::where('specie_id', $request->specie_id)->paginate(self::PAGE_COUNT)->withQueryString();
        }
        else if ($request->filter && 'manager' == $request->filter) {
            $animals = Animal::where('manager_id', $request->manager_id)->paginate(self::PAGE_COUNT)->withQueryString();
        }
        else if ($request->search && 'all' == $request->search) {

            $words = explode(' ', $request->s);
            if (count($words) == 1) {
            $animals = Animal::where('name', 'like', '%'.$request->s.'%')
            ->orWhere('birth_year', 'like', '%'.$request->s.'%')->paginate(self::PAGE_COUNT)->withQueryString();
            } 
            else {
                $animals = Animal::where(function($query) use ($words) {
                    $query->where('name', 'like', '%'.$words[0].'%')->orWhere('birth_year', 'like', '%'.$words[0].'%');
            })
        ->where(function($query) use ($words) {
        $query->where('name', 'like', '%'.$words[1].'%')
        ->orWhere('birth_year', 'like', '%'.$words[1].'%');
        })->paginate(self::PAGE_COUNT)->withQueryString();
    }
}
        else {
            $animals = Animal::orderBy('created_at', 'desc')->paginate(self::PAGE_COUNT)->withQueryString();
        }
  
        return view('animal.index', [
            'animals' => $animals,
            'sortDirection' => $request->sort_dir ?? 'asc',
            'species' => $species,
            'specieId' => $request->specie_id ?? '0',
            'managers' => $managers,
            'managerId' => $request->manager_id ?? '0',
            'managerOfAnimal' => Animal::where('manager_id', $request->manager_id)->paginate(self::PAGE_COUNT)->withQueryString()[0] ?? '0',
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
        $species = Specie::orderBy('name')->paginate(self::PAGE_COUNT)->withQueryString();
        $managers = Manager::orderBy('surname')->paginate(self::PAGE_COUNT)->withQueryString();
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
        $species = Specie::orderBy('name')->paginate(self::PAGE_COUNT)->withQueryString();
        $managers = Manager::orderBy('surname')->paginate(self::PAGE_COUNT)->withQueryString();
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
