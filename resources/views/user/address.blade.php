{{-- resources/views/user/address_index.blade.php --}}
@extends('layouts.app')

@section('website-content')
<div class="mb-4 pb-4"></div>

<section class="my-account container">
  <h2 class="page-title d-flex align-items-center justify-content-between flex-wrap gap-2">
    <span>Addresses</span>
    <a href="{{ route('user.address-create') }}" class="btn btn-info btn-sm">Add New</a>
  </h2>

  <div class="row">
    <div class="col-lg-3">
      @include('user.account_nav')
    </div>

    <div class="col-lg-9">
      <div class="page-content my-account__address">

        {{-- Flash messages --}}
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="text-muted small mb-3">
          Your <span class="fw-semibold">Default</span> address will be used at checkout automatically. You can change it anytime.
        </p>

        <div class="row g-3 g-md-4 my-account__address-list">
          @forelse ($addresses as $addr)
            <div class="col-12 col-sm-6 col-xl-4 d-flex">
              <div class="card shadow-sm w-100 h-100">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex align-items-start justify-content-between mb-2">
                    <h5 class="mb-0">
                      {{ Auth::user()->name }}
                      @if($addr->isdefault)
                        <span class="badge bg-success ms-2 align-middle">Default</span>
                      @endif
                    </h5>
                    {{-- Quick edit link (keep your route naming if different) --}}
                    <a href="{{ route('user.address-modify', ['id' => $addr->id]) }}" class="small text-decoration-underline">Edit</a>
                  </div>

                  <div class="text-secondary small lh-base">
                    <div>{{ $addr->address ?? 'N/A' }}</div>
                    @if(!empty($addr->locality))
                      <div>{{ $addr->locality }}</div>
                    @endif
                    <div>
                      {{ $addr->city ?? 'N/A' }},
                      {{ $addr->district ?? 'N/A' }},
                      {{ $addr->province ?? 'N/A' }},
                      {{ $addr->country ?? 'N/A' }}
                    </div>
                    @if(!empty($addr->landmark))
                      <div>Landmark: {{ $addr->landmark }}</div>
                    @endif
                    @if(!empty($addr->zip))
                      <div>ZIP: {{ $addr->zip }}</div>
                    @endif
                    <div class="mt-2">Mobile: {{ $addr->phone ? '+977 '.$addr->phone : 'N/A' }}</div>
                  </div>

                  <div class="mt-3 d-flex flex-wrap gap-2">
                    <a href="{{ route('user.address-modify', ['id' => $addr->id]) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fa fa-pencil me-1"></i>Edit
                    </a>

                    @if(!$addr->isdefault)
                      <form action="{{ route('user.address-set-default', ['id' => $addr->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-success">
                          <i class="fa fa-check-circle me-1"></i>Make Default
                        </button>
                      </form>
                    @endif

                    <form action="{{ route('user.address-destroy', ['id' => $addr->id]) }}" method="POST" class="d-inline ms-auto"
                          onsubmit="return confirm('Delete this address? This action cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash me-1"></i>Delete
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="border rounded-3 p-4 text-center text-muted">
                You haven’t added any addresses yet.
                <a href="{{ route('user.address-create') }}" class="ms-2">Add one now</a>.
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Small polish to avoid accidental horizontal scroll and keep cards tidy --}}
<style>
  html, body { max-width: 100%; overflow-x: hidden; }
  .card h5 { font-size: 1rem; }
  .card .badge { font-size: .7rem; }
  @media (max-width: 575.98px){
    .page-title { font-size: 1.25rem; }
  }
</style>
@endsection
