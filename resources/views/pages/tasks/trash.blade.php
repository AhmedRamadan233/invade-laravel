@extends('master.master')



@section('content')
    <div class="container-fluid p-5 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline shadow">
                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <form id="search-form" class="d-flex flex-wrap align-items-center">
                                <div class="form-group me-2 mb-2">
                                    <label for="title" class="visually-hidden">Search by title</label>
                                    <input type="text" class="form-control" id="title"
                                        placeholder="Search by title..." name="title" value="{{ request('title') }}">
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="card-body">

                        <table id="tasks-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="text-center">{{ $task->id }}</td>
                                        <td class="text-center">{{ $task->title }}</td>
                                        <td class="text-center">{{ $task->description }}</td>
                                        <td class="text-center">{{ $task->status }}</td>
                                        <td class="text-center">
                                            <button onclick="restoreTask({{ $task->id }})"
                                                class="btn btn-success m-1">Restore</button>
                                            <button onclick="forceDeleteTask({{ $task->id }})"
                                                class="btn btn-warning m-1">Force Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $tasks->withQueryString()->appends(['search' => 1])->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('AjaxScripts')
    <script>
        function restoreTask(taskId) {
            if (confirm('Are you sure you want to restore this task?')) {
                $.ajax({
                    url: '{{ route('tasks.restore', ':id') }}'.replace(':id', taskId),
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (confirm('Are you sure you want to go to the tasks page?')) {
                            window.location.href = '{{ route('tasks.index') }}';
                        } else {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred while restoring the task.');
                    }
                });
            }
        }

        function forceDeleteTask(taskId) {
            if (confirm('Are you sure you want to force delete this task? This action cannot be undone.')) {
                $.ajax({
                    url: '{{ route('tasks.forceDelete', ':id') }}'.replace(':id', taskId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (confirm('Are you sure you want to go to the tasks page?')) {
                            window.location.href = '{{ route('tasks.index') }}';
                        } else {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred while force deleting the task.');
                    }
                });
            }
        }
    </script>
@endpush
