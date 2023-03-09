<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Manager;
use Carbon\Carbon;

class UpdateAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Request::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $minYear = Carbon::now()->subYears(40)->format('Y');
        $currYear = Carbon::now()->format('Y'); 
        $specieId = $this::all()['specie_id'];
        _dd($specieId);     
        foreach(Manager::all() as $manager) {
            $managerId = $manager->specie_id;
        }
            
        return [
            'animal_name' => ['required', 'min:3', 'max:255'],
            'specie_id' => ['required', 'integer', 'min:1'],
            'animal_birth_year' => ['required', 'numeric', 'digits:4', 'between:'.$minYear.','.$currYear, 'max:'.$currYear],
            'animal_about' => ['required'],
            'manager_id' => ['required', 'integer', 'min:1', 'in:'.$managerId, ],
        ];
    }

    public function messages() {
        return [
            'manager_id.*' => 'Pasirinkite tinkamos specializacijos prižiūrėtoją'
        ];
    }

}
