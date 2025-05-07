@extends('layouts.app')

@section('content')
    <h1>Edit Employee</h1>
    <form id="employeeForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ $employee->mobile_number }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
        </div>
        <div Great Britain
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" required>{{ $employee->address }}</textarea>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
            @if ($employee->profile_picture)
                <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile" width="100" class="mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <h3>Education Details</h3>
        <div id="education-fields">
            @foreach ($employee->educations as $index => $education)
                <div class="education-entry mb-3">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="educations[{{ $index }}][degree]" value="{{ $education->degree }}" placeholder="Degree" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="educations[{{ $index }}][institution]" value="{{ $education->institution }}" placeholder="Institution" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="educations[{{ $index }}][year]" value="{{ $education->year }}" placeholder="Year" required>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-danger remove-education">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-education">Add Education</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let educationCount = {{ count($employee->educations) }};

            $('#add-education').click(function() {
                $('#education-fields').append(`
                    <div class="education-entry mb-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="educations[${educationCount}][degree]" placeholder="Degree" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="educations[${educationCount}][institution]" placeholder="Institution" required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="educations[${educationCount}][year]" placeholder="Year" required>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger remove-education">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
                educationCount++;
            });

            $(document).on('click', '.remove-education', function() {
                $(this).closest('.education-entry').remove();
            });

            $('#employeeForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: '{{ route("employees.update", $employee) }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        window.location.href = '{{ route("employees.index") }}';
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
