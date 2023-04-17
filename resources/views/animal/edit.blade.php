@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Animal edit</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('animal.update', $animal) }}" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="animal_name"
                                    value="{{ old('animal_name', $animal->name) }}">
                                <small class="form-text text-muted">Enter name of the animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Species</label>
                                <select class="form-control" name="specie_id">
                                    @foreach ($species as $specie)
                                        <option value="{{ $specie->id }}"
                                            @if (old('specie_id', $animal->specie_id) == $specie->id) selected @endif>
                                            {{ $specie->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the species from the list.</small>
                            </div>
                            <div class="form-group">
                                <label>Birth Year</label>
                                <input type="text" class="form-control" name="animal_birth_year"
                                    value="{{ old('animal_birth_year', $animal->birth_year) }}">
                                <small class="form-text text-muted">Enter birth year of the animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <div class="img mb-2">
                                    @if ($animal->photo)
                                        <img src="{{ $animal->photo }}" alt="{{ $animal->name }}">
                                    @else
                                        <img src="{{ asset('img/no-img.png') }}" alt="{{ $animal->name }}">
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" class="form-check-input me-1" name="animal_photo_deleted"
                                        id="df">
                                    <label for="df">Delete photo</label>
                                </div>
                                <input type="file" class="form-control" name="animal_photo">
                                <small class="form-text text-muted">Animal image.</small>
                            </div>
                            <div class="form-group">
                                <label>Animal Book</label>
                                <textarea class="form-control" name="animal_about">{{ old('animal_about', $animal->animal_book) }}</textarea>
                                <small class="form-text text-muted">About animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Manager</label>
                                <select class="form-control" name="manager_id">
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}"
                                            @if (old('manager_id', $animal->manager_id) == $manager->id) selected @endif>
                                            {{ $manager->name }}
                                            {{ $manager->surname }}
                                            ({{ $manager->getSpecie->name }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the manager from the list.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Update animal info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Animal edit
@endsection
