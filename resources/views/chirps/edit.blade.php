@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('patch')
            <div class="mb-3">
                <textarea
                    name="message"
                    class="form-control"
                    rows="3"
                    placeholder="{{ __('What\'s on your mind?') }}"
                >{{ old('message', $chirp->message) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('chirps.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection