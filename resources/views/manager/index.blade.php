@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Managers list</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($managers as $manager)
                                <li class="list-group-item">
                                    <div class="row-item">
                                        <div class="row-item__basic">
                                            <span>{{ $manager->name }} {{ $manager->surname }}
                                            </span>
                                            <small><b>Specialization:</b>
                                                {{ $manager->getSpecie->name }}
                                            </small>
                                            <small>Supervises
                                                <b>{{ $manager->getAnimals->count() }} animals</b>.
                                            </small>
                                        </div>
                                        <div class="row-item__btns">
                                            <a href="{{ route('manager.edit', $manager) }}" class="btn btn-info">Edit</a>
                                            <form method="POST" action="{{ route('manager.destroy', $manager) }}">
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
    Managers list
@endsection
