@extends('layouts.admin')
@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Categories</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.category') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Categories</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <!-- Search form -->
                        <form method="GET" action="{{ route('admin.category') }}" class="form-search">
                            <fieldset class="name">
                                <input type="text" name="name" placeholder="Search here..."
                                    value="{{ old('name', $name ?? '') }}">
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.category.create') }}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    @if (\Illuminate\Support\Facades\Session::has('status'))
                        <p class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($category as $cat)
                            <tbody>
                                <tr>
                                    <td>{{ $cat->id }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/category_images') }}/{{ $cat->image }}"
                                                alt="{{ $cat->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{ $cat->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $cat->slug }}</td>
                                    <td><a href="#" target="_blank">2</a></td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.category.modify', ['id' => $cat->id]) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.category.remove', ['id' => $cat->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('Delete')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $category->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('website-script')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var form = $(this).closest('form'); // Correctly fetch the closest form
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, it cannot be undone!",
                    icon: "warning", // Warning icon for alert
                    buttons: {
                        cancel: {
                            text: "No",
                            visible: true,
                            closeModal: true
                        },
                        confirm: {
                            text: "Delete",
                            value: true,
                            visible: true,
                            className: "btn-danger", // Adds danger styling to the "Delete" button
                        }
                    },
                    dangerMode: true // Highlights the "Delete" button as dangerous
                }).then(function(result) {
                    if (result) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
@endpush
