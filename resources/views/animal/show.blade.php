@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex"><b>{{ $animal->name }}</b> <small>Species:
                            {{ $animal->getSpecie->name }}</small></div>
                    <div class="card-body">
                        <div class="item-container">
                            <div class="item-container__img">
                                @if ($animal->photo)
                                    <img src="{{ $animal->photo }}" alt="{{ $animal->type }}">
                                @else
                                    <img src="{{ asset('img/no-img.png') }}" alt="{{ $animal->name }}">
                                @endif
                            </div>
                            <div class="item-container__basic">
                                <p>Birth Year: <b> {{ $animal->birth_year }}</b>
                                <p>
                                    <small>Manager:
                                        {{ $animal->getManager->name }} {{ $animal->getManager->surname }}</small>
                            </div>
                        </div>
                        <div class="item-container__about">
                            {!! $animal->animal_book !!}
                        </div>
                        <a href="{{ route('animal.edit', $animal) }}" class="btn btn-info mt-2">Edit</a>
                        <a href="{{ route('animal.pdf', $animal) }}" class="btn btn-info mt-2">PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    {{ $animal->name }}
@endsection
