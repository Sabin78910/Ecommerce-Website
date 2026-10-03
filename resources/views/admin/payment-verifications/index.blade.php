@extends('layouts.admin')

@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- Header & Breadcrumbs --}}
            <div class="flex items-center justify-between mb-27">
                <h3>Payment Verifications</h3>
                <ul class="breadcrumbs flex items-center gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Payment Verifications</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">

                {{-- Search --}}
                <div class="flex items-center mb-3">
                    <form method="GET" action="{{ route('admin.payment-verifications.index') }}"
                        class="form-search flex-grow">
                        <fieldset class="name">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                placeholder="Search by order ID or currency…">
                        </fieldset>
                        <button class="btn" type="submit"><i class="icon-search"></i></button>
                    </form>
                </div>

                {{-- Flash --}}
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Uploaded At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($verifications as $v)
                                <tr class="{{ $loop->odd ? 'bg-light' : 'bg-white' }}">
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->order_id }}</td>
                                    <td>{{ number_format($v->amount, 2) }}</td>
                                    <td>{{ $v->currency }}</td>
                                    <td>{{ $v->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function d-flex justify-content-center gap-2">
                                            {{-- View in new tab --}}
                                            <a href="{{ route('admin.payment-verifications.show', $v->id) }}"
                                                target="_blank" class="item eye" title="View">
                                                <i class="icon-eye"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('admin.payment-verifications.destroy', $v->id) }}"
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
                                    <td colspan="6" class="text-center">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="divider"></div>
                <div class="wgp-pagination">
                    {{ $verifications->withQueryString()->links('pagination::bootstrap-5') }}
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
                let form = $(this).closest('form');
                swal({
                    title: "Delete record?",
                    text: "This cannot be undone!",
                    icon: "warning",
                    buttons: {
                        cancel: true,
                        confirm: {
                            text: "Delete",
                            className: "btn-danger"
                        }
                    },
                    dangerMode: true
                }).then(ok => ok && form.submit());
            });
        });
    </script>
@endpush
