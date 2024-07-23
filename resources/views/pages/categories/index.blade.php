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
                                    <label for="name" class="visually-hidden">Search by name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Search by name..." name="name" value="{{ request('name') }}">
                                </div>
                            </form>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createCategoryModal">
                                Add new Category
                            </button>
                        </div>

                    </div>

                    <div class="card-body">

                        <table id="categories-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>

                                        <td class="text-center">{{ $category->id }}</td>
                                        <td class="text-center">{{ $category->name }}</td>
                                        <td class="text-center">
                                            <button onclick="editCategory({{ $category->id }})" type="button"
                                                class="btn btn-primary m-1" data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal">
                                                Edit
                                            </button>|
                                            <button type="button" class="btn btn-danger m-1" id="confirm-color"
                                                onclick="deleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $categories->withQueryString()->appends(['search' => 1])->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('pages.categories.edit')

    @include('pages.categories.create')
@endsection
@push('AjaxScripts')
    <script>
        // added category
        $(document).ready(function() {
            $('#create-category-Form').on('submit', function(e) {
                e.preventDefault();
                var storeCategoryUrl = "{{ route('categories.store') }}";
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log(storeCategoryUrl)
                $.ajax({
                    url: storeCategoryUrl,
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
                            $('#createCategoryModal').hide();
                            $('#categories-table').load(location.href + ' #categories-table>*',
                                '');
                            location.reload();
                            $('#create-category-Form').load(location.href +
                                ' #create-category-Form>*',
                                '');
                            $('#create-category-Form')[0].reset();

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
        // Edit
        function editCategory(categoryId) {
            $.ajax({
                url: '/categories/edit/' + categoryId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('.id').val(response.editCategory.id);
                    $('.name').val(response.editCategory.name);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            $('#edit-category-Form').on('submit', function(e) {
                e.preventDefault();
                var updateCategoryUrl = "{{ route('categories.update') }}";
                console.log(updateCategoryUrl);
                var formData = new FormData(this);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: updateCategoryUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                            location.reload();
                            $('#edit-category-Form').load(location.href +
                                ' #edit-category-Form>*',
                                '');
                            $('#edit-category-Form')[0].reset();
                            $('#editCategoryModal').modal('hide');

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
        function deleteCategory(categoryId, categoryName) {


            if (confirm("Are you sure you want to delete the category: " + categoryName + "?")) {
                $.ajax({
                    url: '/categories/destroy/' + categoryId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#categories-table').load(location.href + ' #categories-table>*', '');
                        console.log("Category deleted successfully");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting category:", error);
                    }
                });
            }
        }
    </script>
@endpush
