<!-- Modal -->
<div class="modal fade" id="editTaskModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form id="edit-task-Form" class="modal-content" method="POST" action="{{ route('tasks.update') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" class="form-control id">

            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalTitle">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input name="title" type="text" id="title"
                            class="title form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="description" class="form-label">Descriptions</label>
                        <input name="description" type="text" id="description"
                            class="description form-control @error('description') is-invalid @enderror"
                            placeholder="Enter description">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="status form-control @error('status') is-invalid @enderror"
                            name="status">
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <select id="categories" name="categories[]"
                            class="form-control @error('categories') is-invalid @enderror" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>
</div>
