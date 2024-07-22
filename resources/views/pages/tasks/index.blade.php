@extends('master.master')



@section('content')
    <div class="container-fluid p-5 " id="tasks-table">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline shadow">
                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <form action="{{ route('tasks.index') }}" method="GET"
                                class="d-flex flex-wrap align-items-center">
                                <div class="form-group me-2 mb-2">
                                    <label for="title" class="visually-hidden">Search by title</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="Search by title..." name="title" value="{{ request('title') }}">
                                </div>

                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createTaskModal">
                                Add new Task
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>

                                        <td>{{ $task->id }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>
                                            <button
                                                class="btn {{ $task->status === 'pending' ? 'btn-success' : 'btn-secondary' }} toggle-status"
                                                data-id="{{ $task->id }}">
                                                {{ $task->status === 'pending' ? 'pending' : 'completed' }}
                                            </button>
                                        </td>

                                        <td>

                                            <button onclick="editTask({{ $task->id }})" type="button"
                                                class="btn btn-primary m-1" data-bs-toggle="modal"
                                                data-bs-target="#editTaskModal">
                                                Edit
                                            </button>|
                                            <button type="button" class="btn btn-danger m-1" id="confirm-color"
                                                onclick="deleteTask({{ $task->id }}, '{{ addslashes($task->name) }}')">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $tasks->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('pages.tasks.edit')

    @include('pages.tasks.create')
@endsection
@push('AjaxScripts')
    <script>
        // added task
        $(document).ready(function() {
            $('#create-task-Form').on('submit', function(e) {
                e.preventDefault();
                var storeTaskUrl = "{{ route('tasks.store') }}";
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log(storeTaskUrl)
                $.ajax({
                    url: storeTaskUrl,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#createTaskModal').hide();
                            $('#tasks-table').load(location.href + ' #tasks-table>*', '');
                            location.reload();
                            $('#create-task-Form').load(location.href + ' #create-task-Form>*',
                                '');
                            $('#create-task-Form')[0].reset();

                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');
                        for (var key in errors) {
                            var input = $('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + errors[key][0] +
                                '</div>');
                        }
                    }
                });
            });
            // // toggle
            $(document).on('click', '.toggle-status', function(event) {
                event.preventDefault();
                var button = $(this);
                var taskId = button.data('id');
                var toggleStatusUrl = "{{ route('tasks.toggleStatus', ':id') }}".replace(':id', taskId);

                $.ajax({
                    url: toggleStatusUrl,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'pending') {
                            button.removeClass('btn-secondary').addClass('btn-success').text(
                                'pending');
                        } else {
                            button.removeClass('btn-success').addClass('btn-secondary').text(
                                'completed');
                        }
                        $('#tasks-table').DataTable().ajax.reload(null, false);


                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });


        });
        // Edit
        function editTask(taskId) {
            $.ajax({
                url: '/tasks/edit/' + taskId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('.id').val(response.editTask.id);
                    $('.title').val(response.editTask.title);
                    $('.description').val(response.editTask.description);
                    $('.status').val(response.editTask.status);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            $('#edit-task-Form').on('submit', function(e) {
                e.preventDefault();
                var updateTaskUrl = "{{ route('tasks.update') }}";
                console.log(updateTaskUrl);
                var formData = new FormData(this);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: updateTaskUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                            location.reload();
                            $('#edit-task-Form').load(location.href + ' #edit-task-Form>*',
                                '');
                            $('#edit-task-Form')[0].reset();
                            $('#editTaskModal').modal('hide');

                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');
                        for (var key in errors) {
                            var input = $('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + errors[key][0] +
                                '</div>');
                        }
                    }
                });
            });

        });
        // delete 
        function deleteTask(taskId, taskName) {
   

            if (confirm("Are you sure you want to delete the task: " + taskName + "?")) {
                $.ajax({
                    url: '/tasks/destroy/' + taskId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#tasks-table').load(location.href + ' #tasks-table>*', '');
                        console.log("Task deleted successfully");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting task:", error);
                    }
                });
            }
        }
    </script>
@endpush
