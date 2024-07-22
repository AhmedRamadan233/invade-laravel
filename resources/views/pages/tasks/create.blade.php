<!-- Modal -->
<div class="modal fade" id="createTaskModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form id="create-task-Form" class="modal-content" method="POST" action="{{ route('tasks.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalTitle">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Start title --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input name="title" type="text" id="title"
                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End title --}}

                {{-- Start Descriptions --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="description" class="form-label">Descriptions</label>
                        <input name="description" type="text" id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter Description">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End Descriptions --}}

                {{-- Start status --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-control @error('status') is-invalid @enderror"
                            name="status">
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End status --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>
</div>
