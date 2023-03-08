@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Species</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('specie.store') }}">
                            <div class="form-group">
                                <label>Name: </label>
                                <input type="text" class="form-control" name="specie_name"
                                    value="{{ old('specie_name') }}">
                                <small class="form-text text-muted">Enter new specie name.</small>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary">Add new</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    New Species
@endsection
