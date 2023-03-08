@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New manager</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manager.store') }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="manager_name"
                                    value="{{ old('manager_name') }}">
                                <small class="form-text text-muted">Name of the manager.</small>
                            </div>
                            <div class="form-group">
                                <label>Surname</label>
                                <input type="text" class="form-control" name="manager_surname"
                                    value="{{ old('manager_surname') }}">
                                <small class="form-text text-muted">Surname of the manager.</small>
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
    New manager
@endsection
