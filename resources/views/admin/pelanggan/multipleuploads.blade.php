@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload File or Images') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('multipleupload.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Wajib kirim ref sesuai sistem --}}
                        <input type="hidden" name="ref_table" value="pelanggan">
                        <input type="hidden" name="ref_id" value="{{ $dataPelanggan->pelanggan_id }}">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Pilih File') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="files[]" multiple required>
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    {{-- Tampilkan file yang sudah diupload --}}
                    <hr>
                    <h5>File yang tersimpan</h5>
                    @php $files = \App\Models\MultipleUpload::where('ref_table','pelanggan')->where('ref_id', $dataPelanggan->pelanggan_id)->get(); @endphp

                    @if($files->count())
                        <ul class="list-group">
                            @foreach($files as $file)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                        {{ $file->original_name }}
                                    </a>

                                    <form action="{{ route('multipleupload.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Yakin hapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada file.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
