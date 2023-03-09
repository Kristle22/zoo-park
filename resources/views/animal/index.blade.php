@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Animals list</div>

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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Animals list
@endsection
