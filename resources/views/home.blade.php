@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        Welcome to Authentication's web Application

                        @if (session('status'))
                            <div>
                                {{ session('status') }}
                            </div>
                        @endif

                        @can('isAdmin')
                            <div>
                                <p>You have admin access.</p>
                            </div>
                        @else('isUser')
                            <div>
                                <p>You have user access.</p>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection