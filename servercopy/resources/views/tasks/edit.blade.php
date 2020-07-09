@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавить задание</div>

                    <div class="card-body">
                        <form action=/tasks/{{$event->id}} method="POST">

                            @csrf
                            <div class="form-group">
                                <label for="title">Заголовок *</label>
                                <input value="{{old("title")}}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" linkholder="Enter title">
                                <small id="titleHelp" class="form-text text-muted">The title</small>
                                @error('title')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="rate">Оценка *</label>
                                <input value="{{old("rate")}}" name="rate" type="number" class="form-control" id="rate" aria-describedby="rateHelp" linkholder="Enter rate">
                                <small id="rateHelp" class="form-text text-muted">The rate</small>
                                @error('rate')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="task">Задание *</label>
                                <textarea value="{{old("task")}}" name="task" type="text" class="form-control" id="task" aria-describedby="taskHelp" taskholder="Enter the task of the news" rows="3">{{old("task")}}</textarea>
                                <small id="taskHelp" class="form-text text-muted">The task</small>
                                @error('task')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="link">Дополнительная ссылка </label>
                                <textarea value="{{old("link")}}" name="link" type="text" class="form-control" id="link" aria-describedby="linkHelp" linkholder="Enter the link of the news" rows="3">{{old("link")}}</textarea>
                                <small id="linkHelp" class="form-text text-muted">The link</small>
                                @error('link')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="right_answer">Правильный ответ </label>
                                <input value="{{old("right_answer")}}" name="right_answer" type="text" class="form-control" id="right_answer" aria-describedby="right_answerHelp" linkholder="Введите правильный ответ (если есть)">
                                <small id="right_answerHelp" class="form-text text-muted">Введите правильный ответ (если есть)</small>
                                @error('right_answer')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Изменить задание</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
