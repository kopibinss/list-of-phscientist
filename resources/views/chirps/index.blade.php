@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
    <form method="POST" action="{{ route('chirps.store') }}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Post Something</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
            name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
            ></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2 mb-4 d-flex ms-auto">{{ __('Post') }}</button>
    </form>

    <div class="mt-2 rounded-lg divide-y">
        @foreach ($chirps as $chirp)
            <div class="card mt-2 shadow-sm">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-fill" viewBox="0 0 16 16">
                                <path d="M14 0a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                            </svg>
                        </div>
                        <span class="text-muted">{{ $chirp->user->name }}</span>
                        <small class="text-sm text-gray-600 p-2">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                        @unless ($chirp->created_at->eq($chirp->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                        @if ($chirp->user->is(auth()->user()))
                            <button class="btn btn-link dropdown-toggle ms-auto" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg> --}}
                            </button>
                            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                                <li><button class="dropdown-item" type="button" href="{{ route('chirps.edit', $chirp) }}">{{ __('Edit') }}</button></li>
                                <li>
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item" type="button" href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        @endif  
                    </div>
                    <p class="p-2 text-lg text-gray-900">{{ $chirp->message }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection