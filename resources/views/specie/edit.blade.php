@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Species edit</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('specie.update', $specie) }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="specie_name" class="form-control"
                                    value="{{ old('specie_name', $specie->name) }}">
                                <small class="form-text text-muted">Enter new species name.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-info">Update species info</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Species edit
@endsection
