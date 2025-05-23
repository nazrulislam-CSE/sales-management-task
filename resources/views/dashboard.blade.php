@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="text-success">You're logged in!</p>
                        <a href="{{ route('sales.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-file-alt me-1"></i> View Sales List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
