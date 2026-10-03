{{-- resources/views/admin/contact-queries/index.blade.php --}}
@extends('layouts.admin')

@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- Header & Breadcrumbs --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Contact Queries</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Contact Queries</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">

                {{-- Search --}}
                <div class="flex items-center justify-between gap10 flex-wrap mb-3">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="GET" action="{{ route('contact-queries.index') }}">
                            <fieldset class="name">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                    placeholder="Search by name or subject…">
                            </fieldset>
                            <div class="button-submit">
                                <button class="btn" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Flash Message --}}
                @if (session('status'))
                    <p class="alert alert-success">{{ session('status') }}</p>
                @endif

                {{-- Table --}}
                <div class="table-responsive wg-table table-all-user">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Received At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($queries as $query)
                                <tr
                                    class="
                            {{ $i % 2 === 0 ? 'bg-light' : 'bg-white' }}
                            {{ $query->status === 'unread' ? 'table-warning' : '' }}
                            ">
                                    <td>{{ $query->id }}</td>
                                    <td>{{ $query->name }}</td>
                                    <td>{{ $query->email }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($query->subject, 30) }}</td>
                                    <td>{{ ucfirst($query->status) }}</td>
                                    <td>{{ $query->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="list-icon-function d-flex justify-content-center gap-2">
                                            {{-- View --}}
                                            <a href="{{ route('contact-queries.show', $query->id) }}" class="item eye"
                                                title="View">
                                                <i class="icon-eye"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('admin.contact-queries.destroy', $query->id) }}"
                                                method="POST" class="m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="item text-danger delete" title="Delete">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No queries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {!! $queries->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@push('website-script')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "This query will be permanently deleted!",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "No",
                            value: false,
                            visible: true
                        },
                        confirm: {
                            text: "Delete",
                            value: true,
                            visible: true,
                            className: "btn-danger"
                        }
                    },
                    dangerMode: true
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
