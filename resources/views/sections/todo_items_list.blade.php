{{-- <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="card-title">
        @lang('modules.module.todos.todoList')
    </h3>
    <a href="{{ route('admin.todo-items.index') }}" class="btn btn-sm btn-custom">
        @lang('modules.module.todos.viewAll')
    </a>
</div> --}}

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="mb-3" style="display: flex; align-items: center; justify-content: space-between;">
                    <h3 class="card-title" style="font-weight: 600;">
                        @lang('modules.module.todos.pendingTasks')
                    </h3>
                    <a href="javascript:showNewTodoForm();" style="display: flex; align-items: center;"><i class="material-symbols-outlined text-primary" style="font-size: 24px;">add_circle</i></a>
                </div>
                <ul class="list-group py-2" id="pending-tasks" style="height: 260px; overflow-y: scroll;">
                    @forelse ($pendingTodos as $todo)
                        <!-- style="background-color: white;" -->
                        <li data-id="{{ $todo->id }}" data-position="{{ $todo->position }}" class="draggable list-group-item">
                            <div class="handle">
                                <i class="fa fa-bars"></i>
                            </div>
                            <div class="m-2">
                                <div class="row">
                                    <div class="col-8" style="display: flex; align-items: center;">
                                        <div class="d-flex">
                                            <span>
                                                <input data-id="{{ $todo->id }}" type="checkbox" name="status" id="status-{{ $todo->id }}">
                                                <label for="status-{{ $todo->id }}">{{ $todo->title }}</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div style="display: flex; flex-direction: column;">
                                            <p class="mb-0 text-right" style="font-size: 14px;">{{ $todo->created_at->format('Y-m-d') }}</p>
                                            <div class="mt-1" style="display: flex; align-items: center; justify-content: right;">
                                                <a href="javascript:showUpdateTodoForm('{{ $todo->id }}');" class="mx-1"><i class="material-symbols-outlined" style="font-size: 16px;">edit</i></a>
                                                <a href="javascript:deleteTodoItem('{{ $todo->id }}');"><i class="material-symbols-outlined" style="font-size: 16px;">delete</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item" id="no-pending-task" style="background-color: white;">
                            <div style="font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                                @lang('modules.module.todos.noPendingTasks')
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="mb-3" style="display: flex; align-items: center; justify-content: space-between;">
                    <h3 class="card-title" style="font-weight: 600;">
                        @lang('modules.module.todos.completedTasks')
                    </h3>
                    <a class="text-primary" href="{{ route('admin.todo-items.index') }}" style="display: flex; align-items: center;">@lang('modules.module.todos.viewAll')</a>
                </div>
                <ul class="list-group py-2" id="completed-tasks" style="height: 260px; overflow-y: scroll;">
                    @forelse ($completedTodos as $todo)
                        <li data-id="{{ $todo->id }}" data-position="{{ $todo->position }}" class="draggable list-group-item">
                            <div class="handle">
                                <i class="fa fa-bars"></i>
                            </div>
                            <div class="m-2">
                                <div class="row">
                                    <div class="col-8" style="display: flex; align-items: center;">
                                        <div class="d-flex">
                                            <span>
                                                <input data-id="{{ $todo->id }}" checked type="checkbox" name="status" id="status-{{ $todo->id }}">
                                                <label for="status-{{ $todo->id }}">{{ $todo->title }}</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div style="display: flex; flex-direction: column;">
                                            <p class="mb-0 text-right" style="font-size: 14px;">{{ $todo->created_at->format('Y-m-d') }}</p>
                                            <div class="mt-1" style="display: flex; align-items: center; justify-content: right;">
                                                <a href="javascript:showUpdateTodoForm('{{ $todo->id }}');" class="mx-1"><i class="material-symbols-outlined" style="font-size: 16px;">edit</i></a>
                                                <a href="javascript:deleteTodoItem('{{ $todo->id }}');"><i class="material-symbols-outlined" style="font-size: 16px;">delete</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item" id="no-completed-task" style="background-color: white;">
                            <div style="font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                                @lang('modules.module.todos.noCompletedTasks')
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

