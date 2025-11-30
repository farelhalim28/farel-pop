@extends('layouts.admin.app')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail User</h4>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Foto Avatar -->
                        <div class="col-md-3 text-center mb-4">
                            @if($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}"
                                     alt="{{ $user->name }}"
                                     class="rounded-circle img-thumbnail mb-3"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=random"
                                     alt="{{ $user->name }}"
                                     class="rounded-circle img-thumbnail mb-3"
                                     style="width: 200px; height: 200px;">
                            @endif

                            <!-- Status Verifikasi -->
                            <div class="mt-3">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success p-2">
                                        <i class="fas fa-check-circle"></i> Email Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning p-2">
                                        <i class="fas fa-clock"></i> Belum Verifikasi
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Detail -->
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%" class="bg-light">
                                            <i class="fas fa-user"></i> Nama Lengkap
                                        </th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            <i class="fas fa-envelope"></i> Email
                                        </th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            <i class="fas fa-calendar-check"></i> Email Verified At
                                        </th>
                                        <td>
                                            @if($user->email_verified_at)
                                                {{ $user->email_verified_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">Belum diverifikasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            <i class="fas fa-calendar-plus"></i> Tanggal Dibuat
                                        </th>
                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            <i class="fas fa-calendar-alt"></i> Terakhir Diupdate
                                        </th>
                                        <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            <i class="fas fa-clock"></i> Lama Bergabung
                                        </th>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('user.edit', $user->id) }}"
                                   class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Hapus User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
