<!-- Modal -->
<div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form id="edit-category-Form" class="modal-content" method="POST" action="{{ route('categories.update') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" class="form-control id">

            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalTitle">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Start name --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" id="name"
                            class="name form-control @error('name') is-invalid @enderror" placeholder="Enter name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End name --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>z
</div>
