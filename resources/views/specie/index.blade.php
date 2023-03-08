@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Species list</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($species as $specie)
                                <li class="list-group-item">
                                    <div class="row-item">
                                        <div class="row-item__basic">
                                            <span>{{ $specie->name }}</span>
                                            @if ($specie->getManagers->count())
                                                <small>Supervised by {{ $specie->getManagers->count() }} manager(s).</small>
                                            @else
                                                <small>Currently has no managers.</small>
                                            @endif
                                            @if ($specie->getAnimals->count())
                                                <small>There is/are {{ $specie->getAnimals->count() }} animals of this
                                                    species in total.</small>
                                            @else
                                                <small>Currently has no animals.</small>
                                            @endif
                                        </div>
                                        <div class="row-item__btns">
                                            <a href="{{ route('specie.edit', $specie) }}" class="btn btn-info">Edit</a>
                                            <form method="POST" action="{{ route('specie.destroy', $specie) }}">
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
    Species list
@endsection
