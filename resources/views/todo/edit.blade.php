@extends('layouts.app')

@section('title')
    Edit ToDo List
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Edit To-Do List</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Edit To-Do List</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('todo.update', ['todo_list' => $todoList->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="task">Task</label>
                    <input type="text" class="form-control @error('task') is-invalid @enderror" id="task"
                        name="task" required value="{{ old('task', $todoList->task) }}" placeholder="Enter Task">
                    @error('task')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                        name="deadline" required value="{{ old('deadline', $todoList->deadline) }}"
                        min="{{ date('Y-m-d') }}">
                    @error('deadline')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('home') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Update</button>
            </div>
        </form>
    </div>
@endsection
