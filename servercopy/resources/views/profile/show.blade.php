@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card box-shadow">
                    <img class="card-img-top" src="{{$user->image}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">@ {{$user->login}}</h5>
                        <p class="card-text">{{$user->name}} {{$user->surname}}</p>
                        <a href="/events/create"  class="btn btn-outline-dark btn-sm">Создать мероприятие</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Мероприятия, в которых вы являетесь жюри</div>

                    <div class="card-body">
                        @foreach($user->events as $event)
                        <div class="card border-dark mb-3">
                            <div class="card-header">{{$event->title}}</div>
                            <div class="card-body text-dark">
                                <h5 class="card-title">{{$event->place}}</h5>
                                <p class="card-text">{{$event->description}}</p>
                                <a href={{$event->path()}}  type="button" class="btn btn-outline-dark btn-sm">Смотреть мероприятие</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Мероприятия, в которых вы участвуете</div>

                    <div class="card-body">
                        @foreach($user->groups as $group)
                            <div class="card text-white bg-dark mb-3" style="">
                                <div class="card-header">{{$group->event->title}}</div>
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src={{$group->logo}} class="card-img" alt="...">
                                    </div>
                                <div class="card-body">
                                    <h5 class="card-title">Ваша группа: {{$group->name}}</h5>
                                    <p class="card-text">{{$group->description}}</p>
                                    <a href={{$group->event->path()}} type="button" class="btn btn-outline-light btn-sm">Смотреть мероприятие</a>
                                    <div class="mt-2"> <a href={{$group->path()}} type="button" class="btn btn-outline-light btn-sm">Смотреть группу</a></div>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
