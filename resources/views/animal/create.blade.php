@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New animal</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('animal.store') }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="animal_name"
                                    value="{{ old('animal_name') }}">
                                <small class="form-text text-muted">Name of the animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Species</label>
                                <select class="form-control" name="specie_id">
                                    @foreach ($species as $specie)
                                        <option value="{{ $specie->id }}"
                                            @if (old('specie_id') == $specie->id) selected @endif>
                                            {{ $specie->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the species from the list.</small>
                            </div>
                            <div class="form-group">
                                <label>Birth Year</label>
                                <input type="text" class="form-control" name="animal_birth_year"
                                    value="{{ old('animal_birth_year') }}">
                                <small class="form-text text-muted">Birth year of the animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Animal Book</label>
                                <textarea class="form-control" name="animal_about">{{ old('animal_about') }}</textarea>
                                <small class="form-text text-muted">About animal.</small>
                            </div>
                            <div class="form-group">
                                <label>Manager</label>
                                <select class="form-control" name="manager_id">
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}"
                                            @if (old('manager_id') == $manager->id) selected @endif>
                                            {{ $manager->name }}
                                            {{ $manager->surname }}
                                            ({{ $manager->getSpecie->name }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the manager from the list.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Create new</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    New animal
@endsection
