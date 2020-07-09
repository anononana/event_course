@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-7">
                <div class="card border-info">
                    <div class="card-header border-info">{{$result->task->title}}</div>

                    <div class="card-body">
                        <h5 class="card-title">Задание: {{$result->task->task}}</h5>
                        @if(isset($result->task->link))
                            <a href="{{$result->task->link}}" class="btn btn-outline-secondary btn-sm">Дополнительные
                                материалы</a>
                        @else
                            <p class="card-text">Дополнительных материалов нет.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Группа, ответившая на этот вопрос</div>

                    <div class="card-body">
                        <div class="card text-white bg-dark mb-3" style="">
                            <div class="card-header">Мероприятие: {{$result->group->event->title}}</div>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src={{$result->group->logo}} class="card-img" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Название: {{$result->group->name}}</h5>
                                    <p class="card-text">{{$result->group->description}}</p>
                                    <a href={{$result->group->event->path()}} type="button"
                                       class="btn btn-outline-light btn-sm">Смотреть мероприятие</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ответ группы "{{$result->group->name}}"</div>

                    <div class="card-body">
                        <div class="card border-info mb-3">
                            <div class="card-header">{{$result->task->title}}</div>
                            <div class="card-body text-info">
                                <p class="card-text">Ответ: {{$result->answer}}</p>
                                @if(isset($result->link))
                                    <a href="{{$result->link}}" target="_blank" class="">Дополнительные
                                        материалы</a>
                                @else
                                    <p class="card-text">Дополнительных материалов нет.</p>
                                @endif
                                @if($result->task->event->isUserExpert() && !$result->isExpertReviewed())
                                    <a data-toggle="modal" data-target="#exampleModalCenter"
                                       class="btn btn-outline-secondary">Оценить работу</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($result->task->event->isUserExpert() && $result->isExpertReviewed())
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Не знаю как назвать эту колонку</div>

                        <div class="card-body">
                            <div class="card border-info mb-3">
                                <div class="card-header">Ваша оценка ответа</div>
                                <div class="card-body text-info">
                                    <p class="card-text">Ваш фидбек: {{$result->expertReview()->body}}</p>
                                    @if(in_array($result->expertReview()->rate % 10, [2,3,4]))
                                        <p class="card-text">Вы поставили {{$result->expertReview()->rate}} балла.</p>
                                    @elseif(in_array($result->expertReview()->rate % 10, [1]))
                                        <p class="card-text">Вы поставили {{$result->expertReview()->rate}} балл.</p>
                                    @else
                                        <p class="card-text">Вы поставили {{$result->expertReview()->rate}} баллов.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($result->task->event->isUserParticipant() && $result->task->event->dt_exp < \Carbon\Carbon::now(+3))
                <div class="col-md-6">
                    @foreach($result->reviews as $review)
                    <div class="card">
                        <div class="card-header">Оценка {{$review->expert->getCredentials()->name}} {{$review->expert->getCredentials()->surname}}</div>

                        <div class="card-body">
                            <div class="card border-info mb-3">
                                <div class="card-header">Оценка ответа</div>
                                <div class="card-body text-info">
                                    <p class="card-text">Фидбек: {{$review->body}}</p>
                                    @if(in_array($review->rate % 10, [2,3,4]))
                                        <p class="card-text">Вам поставили {{$review->rate}} балла.</p>
                                    @elseif(in_array($review->rate % 10, [1]))
                                        <p class="card-text">Вам поставили {{$review->rate}} балл.</p>
                                    @else
                                        <p class="card-text">Вам поставили {{$review->rate}} баллов.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Оцените
                        работу, {{Auth::user()->name}} {{Auth::user()->surname}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action=/reviews/{{$result->id}} method="POST">

                        @csrf

                        <div class="form-group">
                            <label for="body">Фидбек *</label>
                            <textarea value="{{old("body")}}" name="body" type="text" required
                                      class="form-control" id="body" aria-describedby="bodyHelp"
                                      taskholder="Enter the body"
                                      rows="3">{{old("body")}}</textarea>
                            <small id="bodyHelp" class="form-text text-muted">Ваш комментарий</small>
                            @error('body')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rate">Ваша оценка * </label>
                            <input value="{{old("rate")}}" name="rate" type="number" max="{{$result->task->rate}}"
                                   class="form-control" id="rate" aria-describedby="rateHelp"
                                   linkholder="Enter the rate"
                                   rows="3"/>
                            <small id="rateHelp" class="form-text text-muted">Ваша оценка</small>
                            @error('rate')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Оценить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
