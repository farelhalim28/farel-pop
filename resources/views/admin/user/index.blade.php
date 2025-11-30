@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data User</h4>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- FORM FILTER & SEARCH -->
                    <div class="mb-3">
                        <form method="GET" action="{{ route('user.index') }}">
                            <div class="row g-2">
                                <!-- FILTER EMAIL VERIFIED -->
                                <div class="col-md-2">
                                    <select name="email_verified" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="verified" {{ request('email_verified') == 'verified' ? 'selected' : '' }}>Email Terverifikasi</option>
                                        <option value="unverified" {{ request('email_verified') == 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
                                    </select>
                                </div>

                                <!-- SEARCH -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                               value="{{ request('search') }}"
                                               placeholder="Cari nama atau email...">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- BUTTON RESET -->
                                <div class="col-md-2">
                                    @if(request('search') || request('email_verified'))
                                        <a href="{{ route('user.index') }}" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-times-circle"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="table-user">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status Verifikasi</th>
                                    <th>Tanggal Dibuat</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key => $item)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    @if($item->profile_picture)
                                                        <img src="{{ Storage::url($item->profile_picture) }}"
                                                             alt="{{ $item->name }}"
                                                             class="rounded-circle"
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&size=40&background=random"
                                                             alt="{{ $item->name }}"
                                                             class="rounded-circle">
                                                    @endif
                                                </div>
                                                <span>{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @if($item->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock"></i> Belum Verifikasi
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('user.show', $item->id) }}"
                                               class="btn btn-sm btn-info"
                                               title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $item->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('user.destroy', $item->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            @if(request('search'))
                                                <i class="fas fa-search"></i>
                                                Data tidak ditemukan dengan kata kunci "{{ request('search') }}"
                                            @else
                                                <i class="fas fa-inbox"></i>
                                                Belum ada data user
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="mt-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
