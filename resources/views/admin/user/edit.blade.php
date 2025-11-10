@extends('layouts.admin.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
<div class="card border-0 shadow p-4">
    <h4 class="mb-4">Edit Data Pelanggan</h4>

    <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" id="first_name" name="first_name"
                       value="{{ old('first_name', $pelanggan->first_name) }}"
                       class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" id="last_name" name="last_name"
                       value="{{ old('last_name', $pelanggan->last_name) }}"
                       class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" id="birthday" name="birthday"
                       value="{{ old('birthday', $pelanggan->birthday) }}"
                       class="form-control">
            </div>
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="Male" {{ old('gender', $pelanggan->gender) == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Female" {{ old('gender', $pelanggan->gender) == 'Female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $pelanggan->email) }}"
                       class="form-control">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone', $pelanggan->phone) }}"
                       class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary px-4">💾 Update</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary px-4">Batal</a>
        </div>
    </form>
</div>
@endsection
