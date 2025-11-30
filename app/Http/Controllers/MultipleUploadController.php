<?php

namespace App\Http\Controllers;

use App\Models\MultipleUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MultipleUploadController extends Controller
{
    /**
     * Store multiple uploaded files
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx|max:2048',
            'ref_table' => 'required|string',
            'ref_id' => 'required|integer'
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\.]/', '_', $originalName);
                $filePath = $file->storeAs('uploads', $filename, 'public');

                $upload = MultipleUpload::create([
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'file_path' => $filePath,
                    'ref_table' => $request->ref_table,
                    'ref_id' => $request->ref_id
                ]);

                $uploadedFiles[] = $upload;
            }
        }

        return back()->with('success', 'File berhasil diupload!');
    }

    /**
     * Remove the specified file
     */
    public function destroy($id)
    {
        $file = MultipleUpload::findOrFail($id);

        // Hapus file dari storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        // Hapus record dari database
        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
