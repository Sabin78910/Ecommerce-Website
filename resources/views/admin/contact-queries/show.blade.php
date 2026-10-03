{{-- resources/views/admin/contact-queries/show.blade.php --}}
@extends('layouts.admin')

@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- Header & Breadcrumbs --}}
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Query #{{ $query->id }} Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('contact-queries.index') }}">
                            <div class="text-tiny">Contact Queries</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">View Query</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">

                {{-- Details Card --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Query Details</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Name</dt>
                            <dd class="col-sm-9">{{ $query->name }}</dd>

                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9">
                                <a href="mailto:{{ $query->email }}">{{ $query->email }}</a>
                            </dd>

                            <dt class="col-sm-3">Phone</dt>
                            <dd class="col-sm-9">{{ $query->phone }}</dd>

                            <dt class="col-sm-3">Subject</dt>
                            <dd class="col-sm-9">{{ $query->subject }}</dd>

                            <dt class="col-sm-3">Message</dt>
                            <dd class="col-sm-9">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $query->message }}</p>
                            </dd>

                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">{{ ucfirst($query->status) }}</dd>

                            <dt class="col-sm-3">Received</dt>
                            <dd class="col-sm-9">{{ $query->created_at->format('d M Y, g:i a') }}</dd>
                        </dl>
                    </div>
                </div>

                {{-- Reply Card --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Reply to User</h5>
                        <form method="POST" action="{{ route('contact-queries.reply', $query->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label for="reply_message" class="form-label">Your Reply <span
                                        class="text-danger">*</span></label>
                                <textarea id="reply_message" name="reply_message" rows="5"
                                    class="form-control @error('reply_message') is-invalid @enderror" required>{{ old('reply_message') }}</textarea>
                                @error('reply_message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Send Reply &amp; Mark Solved</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
