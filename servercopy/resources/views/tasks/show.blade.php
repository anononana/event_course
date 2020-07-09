@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-4">
                <div class="card border-info box-shadow">
                    <div class="card-header bg-transparent border-info">{{$task->title}}</div>
                    <div class="card-body">
                        <h5 class="card-title">Мероприятие: {{$task->event->title}}</h5>
                        <p class="card-text">Задание оценивается до {{$task->rate}} баллов.</p>

                            @if($task->event->isUserParticipant() && $task->event->dt_exp > \Carbon\Carbon::now(+3) && !isset($task->getGroupResult()->answer))
                                <a aria-expanded="false" aria-controls="collapseResult" data-toggle="collapse" href="#collapseResult" class="btn btn-outline-secondary">Добавить ответ на задание</a>
                            @endif
                            <a href="{{$task->event->path()}}" class="btn btn-outline-secondary">View</a>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">Название: {{$task->title}}</div>

                    <div class="card-body">
                        <h5 class="card-title">Задание: {{$task->task}}</h5>
                        @if(isset($task->link))
                            <a href="{{$task->link}}" class="btn btn-outline-secondary btn-sm">Дополнительные
                                материалы</a>
                        @else
                            <p class="card-text">Дополнительных материалов нет.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="collapse" id="collapseResult">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Ответ на задание</div>

                        <div class="card-body">
                            <form action=/results/{{$task->id}} method="POST">

                                @csrf

                                <div class="form-group">
                                    <label for="answer">Ответ *</label>
                                    <textarea value="{{old("answer")}}" name="answer" type="text"
                                              class="form-control" id="answer" aria-describedby="answerHelp"
                                              taskholder="Enter the answer"
                                              rows="3">{{old("answer")}}</textarea>
                                    <small id="answerHelp" class="form-text text-muted">The answer</small>
                                    @error('answer')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="link">Дополнительная ссылка </label>
                                    <textarea value="{{old("link")}}" name="link" type="text"
                                              class="form-control" id="link" aria-describedby="linkHelp"
                                              linkholder="Enter the link of the news"
                                              rows="3">{{old("link")}}</textarea>
                                    <small id="linkHelp" class="form-text text-muted">The link</small>
                                    @error('link')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Ответить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        @if($task->event->isUserParticipant() && isset($task->getGroupResult()->answer))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ваш ответ</div>

                    <div class="card-body">
                        <div class="card border-info mb-3">
                            <div class="card-header">{{$task->title}}</div>
                            <div class="card-body text-info">
                                <p class="card-text">Ваш ответ: {{$task->getGroupResult()->answer}}</p>
                                @if(isset($task->getGroupResult()->link))
                                    <a href="{{$task->getGroupResult()->link}}" target="_blank" class="">Дополнительные
                                        материалы</a>
                                @else
                                    <p class="card-text">Дополнительных материалов нет.</p>
                                @endif
                                <a href="{{$task->getGroupResult()->path()}}" class="btn btn-outline-secondary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            @if($task->event->isUserExpert() && $task->event->dt_exp < \Carbon\Carbon::now(+3))

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Ответы: </div>

                        <div class="card-body">
                            @foreach($task->results as $result)
                            <div class="card border-info mb-3">
                                <div class="card-header">Ответ группы {{$result->group->name}}</div>
                                <div class="card-body text-info">
                                    @if($result->isExpertReviewed())
                                        <p class="float-right">Вы уже оценили эту работу.</p>
                                    @endif
                                    <p class="card-text">Ответ: {{$result-> answer}} </p>
                                    @if(isset($result->link))
                                        <a href="{{$result->link}}" target="_blank" class="">Дополнительные
                                            материалы</a>
                                    @else
                                        <p class="card-text">Дополнительных материалов нет.</p>
                                    @endif
                                    @if($task->event->isUserExpert() && $task->event->dt_exp < \Carbon\Carbon::now(+3) && !$task->event->finished && !isset($task->right_answer) && !$result->isExpertReviewed())
                                        <a href="{{$result->path()}}" class="btn btn-outline-secondary">Оценить ответ</a>
                                    @endif
                                        <a href="{{$result->path()}}" class="btn btn-outline-secondary">View</a>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
