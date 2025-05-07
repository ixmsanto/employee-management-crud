@extends('layouts.app')

@section('content')
    <h1>Employee Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $employee->name }}</h5>
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Mobile:</strong> {{ $employee->mobile_number }}</p>
            <p><strong>Address:</strong> {{ $employee->address }}</p>
            <p><strong>Gender:</strong> {{ $employee->gender }}</p>
            @if ($employee->profile_picture)
                <p><strong>Profile Picture:</strong><br>
                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile" width="100">
                </p>
            @endif
            <h5>Education Details</h5>
            <ul>
                @foreach ($employee->educations as $education)
                    <li>{{ $education->degree }} from {{ $education->institution }} ({{ $education->year }})</li>
                @endforeach
            </ul>
            <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection
