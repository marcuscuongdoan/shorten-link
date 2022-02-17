@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>

            <div class="card">
                <div class="card-header">Input your link to shorten it!</div>

                <div class="card-body">
                    <form class="form-inline" method="POST" action="{{ route('shorten.create') }}">
                        @csrf
                        <input type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" aria-describedby="full-link" placeholder="Enter your link here!">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @if(session()->has('link'))
                        <div class="alert alert-success">
                            Your link is here: {{ request()->getHost() ."\\". session("link") }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
</div>
@endsection
