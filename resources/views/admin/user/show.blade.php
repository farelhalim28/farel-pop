@extends('layouts.admin.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Detail Pelanggan</h4>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="row mb-4">

                {{-- Foto Auto Avatar --}}
                <div class="col-md-3 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($dataPelanggan->first_name) }}&size=200&background=random"
                        class="rounded-circle img-thumbnail mb-3"
                        style="width: 180px; height:180px; object-fit:cover;">
                </div>

                {{-- Data --}}
                <div class="col-md-9">
                    <table class="table table-striped">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $dataPelanggan->first_name }} {{ $dataPelanggan->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $dataPelanggan->birthday }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $dataPelanggan->gender }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $dataPelanggan->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $dataPelanggan->phone }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $dataPelanggan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('pelanggan.edit', $dataPelanggan->pelanggan_id) }}" class="btn btn-warning mt-3">
                        <i class="fas fa-edit"></i> Edit Pelanggan
                    </a>
                </div>
            </div>

            <hr>

            <h5 class="mt-4">File Pendukung</h5>

            @if($files->count() > 0)
                <div class="row mt-3">

                    @foreach($files as $file)
                        @php
                            $ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            $isVideo = in_array($ext, ['mp4','mov','avi','mkv','webm']);
                        @endphp

                        <div class="col-md-3 text-center mb-4">

                            {{-- IMAGE PREVIEW --}}
                            @if($isImage)
                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                     class="img-fluid rounded mb-2"
                                     style="height:160px; object-fit:cover;">

                            {{-- VIDEO PREVIEW --}}
                            @elseif($isVideo)
                                <video controls class="w-100 border rounded" style="height:160px; object-fit:cover;">
                                    <source src="{{ asset('storage/' . $file->file_path) }}" type="video/mp4">
                                </video>

                            {{-- OTHER FILE --}}
                            @else
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                   class="btn btn-outline-info w-100">
                                    📄 {{ $file->original_name }}
                                </a>
                            @endif

                            {{-- DELETE BUTTON --}}
                            <form action="{{ route('multipleupload.destroy', $file->id) }}"
                                  method="POST"
                                  class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm w-100">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>

            @else
                <p class="text-muted">Tidak ada file diupload.</p>
            @endif
        </div>
    </div>
</div>
@endsection
