<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\MultipleUpload;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $dataPelanggan = $query->paginate(10);

        return view('admin.pelanggan.index', compact('dataPelanggan'));
    }


    public function create()
    {
        return view('admin.pelanggan.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthday'   => 'required',
            'gender'     => 'required',
            'email'      => 'required|email|unique:pelanggan,email',
            'phone'      => 'required'
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }


    public function show($id)
{
    $dataPelanggan = Pelanggan::findOrFail($id);

    $files = MultipleUpload::where('ref_table', 'pelanggan')
        ->where('ref_id', $dataPelanggan->pelanggan_id)
        ->get();

    return view('admin.pelanggan.show', compact('dataPelanggan', 'files'));
}



    public function edit($id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('dataPelanggan'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthday'   => 'required',
            'gender'     => 'required',
            'email'      => 'required|email|unique:pelanggan,email,' . $id . ',pelanggan_id',
            'phone'      => 'required',
            'files.*'    => 'nullable|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,mkv,webm,pdf,doc,docx,zip|max:204800'
        ]);

        $dataPelanggan = Pelanggan::findOrFail($id);
        $dataPelanggan->update($request->only(['first_name','last_name','birthday','gender','email','phone']));


        // === MULTIPLE FILE UPLOAD ===
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $path = $file->store('uploads/pelanggan', 'public');

                MultipleUpload::create([
                    'ref_table'      => 'pelanggan',
                    'ref_id'         => $dataPelanggan->pelanggan_id,
                    'file_path'      => $path,
                    'filename'       => $file->hashName(),  // 👈 FIX ERROR
                    'original_name'  => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data berhasil diperbarui & file ditambahkan');
    }


    public function destroy($id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);
        $dataPelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data berhasil dihapus');
    }

}
