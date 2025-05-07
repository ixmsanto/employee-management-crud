@extends('layouts.app')

@section('content')
    <h1>Employees</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->mobile_number }}</td>
                    <td>{{ $employee->gender }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-employee" data-id="{{ $employee->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-employee').click(function() {
                if (confirm('Are you sure?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '/employees/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
