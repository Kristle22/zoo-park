@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Animals list</h2>
                        <form action="{{ route('animal.index') }}" method="get">
                            <fieldset>
                                <legend>Sort</legend>
                                <div class="block">
                                    <button type="submit" class="btn btn-info" name="sort" value="name">Name</button>
                                    <button type="submit" class="btn btn-info" name="sort" value="birth_year">Birth
                                        Year</button>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_dir" id="_1"
                                            value="asc" @if ('desc' != $sortDirection) checked @endif>
                                        <label class="form-check-label" for="_1">
                                            ASC
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_dir" id="_2"
                                            value="desc" @if ('desc' == $sortDirection) checked @endif>
                                        <label class="form-check-label" for="_2">
                                            DESC
                                        </label>
                                    </div>
                                </div>
                                <div class="block">
                                    <a href="{{ route('animal.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </fieldset>
                        </form>
                        <form action="{{ route('animal.index') }}" method="get">
                            <fieldset class="filter">
                                <legend>Filter</legend>
                                <div class="filter-block">
                                    <div class="form-group">
                                        <select class="form-control" name="specie_id">
                                            <option value="0" disabled selected>Select Species</option>
                                            @foreach ($species as $specie)
                                                <option value="{{ $specie->id }}"
                                                    @if ($specieId == $specie->id) selected @endif>{{ $specie->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Select the species from the list.</small>
                                    </div>
                                    <div class="block">
                                        <button type="submit" class="btn btn-info" name="filter"
                                            value="specie">Filter</button>
                                        <a href="{{ route('animal.index') }}" class="btn btn-warning">Reset</a>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <div class="form-group">
                                        <select class="form-control" name="manager_id">
                                            <option value="0" disabled selected>Select Manager</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}"
                                                    @if ($managerId == $manager->id) selected @endif>
                                                    {{ $manager->name }} {{ $manager->surname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Select the manager from the list.</small>
                                    </div>
                                    <div class="block">
                                        <button type="submit" class="btn btn-info" name="filter"
                                            value="manager">Filter</button>
                                        <a href="{{ route('animal.index') }}" class="btn btn-warning">Reset</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <form action="{{ route('animal.index') }}" method="get">
                            <fieldset>
                                <legend>Search</legend>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="s" value="{{ $s }}"
                                        placeholder="Search">
                                    <small class="form-text text-muted">Search in our Zoo Park.</small>
                                </div>
                                <div class="block">
                                    <button type="submit" class="btn btn-info" name="search"
                                        value="all">Search</button>
                                    <a href="{{ route('animal.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                    @if ($managerOfAnimal || $managerId == '0')
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($animals as $animal)
                                    <li class="list-group-item">
                                        <div class="row-item">
                                            <div class="row-item__basic">
                                                <span><b>Name:</b> {{ $animal->name }}</span>
                                                <span><b>Birth year:</b> {{ $animal->birth_year }}</span>
                                                <small><b>Species:</b> {{ $animal->getSpecie->name }}</small>
                                                <div><b>About:</b>
                                                    {!! $animal->animal_book !!}
                                                </div>
                                                <small> <b>Animal manager:</b> {{ $animal->getManager->name }}
                                                    {{ $animal->getManager->surname }}
                                                </small>
                                            </div>
                                            <div class="row-item__btns">
                                                <a href="{{ route('animal.edit', $animal) }}" class="btn btn-info">Edit</a>
                                                <form method="POST" action="{{ route('animal.destroy', $animal) }}">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="card-body"> <i>This manager has no animals yet...</i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Animals list
@endsection
