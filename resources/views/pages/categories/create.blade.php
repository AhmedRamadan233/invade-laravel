<!-- Modal -->
<div class="modal fade" id="createCategoryModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form id="create-category-Form" class="modal-content" method="POST" action="{{ route('categories.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-name" id="createCategoryModalTitle">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Start name --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter name">
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

    </div>
</div>
