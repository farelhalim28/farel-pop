@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Pelanggan</h4>
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pelanggan
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
                    <div class="table-responsive">
                        <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-3">
                            <div class="row">
                                <!-- FILTER GENDER -->
                                <div class="col-md-2">
                                    <select name="gender" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Gender</option>
                                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <!-- SEARCH -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                               value="{{ request('search') }}"
                                               placeholder="Cari nama atau email...">
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                               class="btn btn-outline-danger">
                                                Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- TABLE -->
                        <table class="table table-bordered table-striped table-hover" id="table-pelanggan">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Depan</th>
                                    <th>Nama Belakang</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Telepon</th>
                                    <th>Tanggal Lahir</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataPelanggan as $key => $item)
                                    <tr>
                                        <td>{{ ($dataPelanggan->currentPage() - 1) * $dataPelanggan->perPage() + $key + 1 }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->gender == 'Male' ? 'primary' : ($item->gender == 'Female' ? 'danger' : 'secondary') }}">
                                                {{ $item->gender }}
                                            </span>
                                        </td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->birthday)->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('pelanggan.show', $item->pelanggan_id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pelanggan.edit', $item->pelanggan_id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pelanggan.destroy', $item->pelanggan_id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="mt-3">
                            {{ $dataPelanggan->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
