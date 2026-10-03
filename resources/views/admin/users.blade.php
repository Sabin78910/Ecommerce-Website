@extends('layouts.admin')
@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Users</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All User</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form method="GET" action="{{ route('admin.usersWithOrderCount') }}" class="form-search">
                            <fieldset class="name">
                                <input type="text" name="search" placeholder="Search by name, email or phone..."
                                    value="{{ old('search', $search ?? '') }}">
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="wg-table table-all-user">

                    <div class="table-responsive">
                        @if (\Illuminate\Support\Facades\Session::has('status'))
                            <p class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th class="text-center">Total Orders</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="pname">
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $user->name }}</a>
                                                <div class="text-tiny mt-3">{{ $user->usertype }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center"><a href="#"
                                                target="_blank">{{ $user->orders_count }}</a></td>
                                        <td>
                                            <div class="list-icon-function">
                                                <form action="{{ route('admin.user.remove', ['id' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
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

                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $users->links('pagination::bootstrap-5') }}
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
