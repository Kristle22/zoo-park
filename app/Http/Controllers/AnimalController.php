<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Specie;
use App\Models\Manager;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManagerStatic as Image;

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

        $file = $request->file('animal_photo');
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $name = rand(1000000, 9999999).'_'.rand(1000000, 9999999);
            $name .= '.'.$ext;

            $destinationPath = public_path().'/animals-images/';
            $file->move($destinationPath, $name);
            $animal->photo = asset('/animals-images/'.$name);

            // image intervention
            $img = Image::make($destinationPath.$name);
            $img->gamma(5.6)->flip('v');
            $img->save($destinationPath.$name);
        }
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
        return view('animal.show', compact('animal'));
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
        $file = $request->file('animal_photo');

        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $name = rand(1000000, 9999999).'_'.rand(1000000, 9999999);
            $name .= '.'.$ext;
            $destinationPath = public_path().'/animals-images/';

            $file->move($destinationPath, $name);

            $oldPhoto = $animal->photo ?? '@@@';
            $animal->photo = asset('/animals-images/'.$name);

            // Trinam sena, jeigu ji yra
            $oldName = explode('/', $oldPhoto);
            $oldName = array_pop($oldName);
            if (file_exists($destinationPath.$oldName)) {
                unlink($destinationPath.$oldName);
            }
        }
        if ($request->animal_photo_deleted) {
            $destinationPath = public_path().'/animals-images/';
            $oldPhoto = $animal->photo ?? '@@@';
            $animal->photo = null;
            $oldName = explode('/', $oldPhoto);
            $oldName = array_pop($oldName);
            if (file_exists($destinationPath.$oldName)) {
                unlink($destinationPath.$oldName);
            }
        }
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
        $destinationPath = public_path().'/animals-images/';
        $oldPhoto = $animal->photo ?? '@@@';

        // Trinam sena, jeigu ji yra
        $oldName = explode('/', $oldPhoto);
        $oldName = array_pop($oldName);
        if (file_exists($destinationPath.$oldName)) {
            unlink($destinationPath.$oldName);
         }
        $animal->delete();
        return redirect()->route('animal.index')->with('success_message', 'Gyvūnas sėkmingai ištrintas.');
    }
    public function pdf(Animal $animal) {
        $pdf = Pdf::loadView('animal.pdf', compact('animal'));
        return $pdf->download(ucfirst($animal->name).'-'.$animal->getSpecie->name.'.pdf');
    }

}
