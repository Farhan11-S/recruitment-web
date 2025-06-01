<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Menampilkan form untuk mengunggah dokumen.
     */
    public function create()
    {
        // Ambil data dokumen yang sudah ada untuk ditampilkan di view
        $user = Auth::user()->load('application.documents');
        return view('candidate.document.create', compact('user'));
    }

    /**
     * Menyimpan dokumen yang diunggah.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'surat_lamaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah_transkrip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'skck' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_pendukung.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi untuk setiap file
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $application = Auth::user()->application;

        // Daftar dokumen yang akan di-loop
        $documentFields = [
            'Surat Lamaran' => 'surat_lamaran',
            'CV' => 'cv',
            'Fotokopi KTP dan KK' => 'ktp_kk',
            'Fotokopi Ijazah dan Transkrip Nilai' => 'ijazah_transkrip',
            'Fotokopi SKCK' => 'skck',
        ];

        // Proses upload untuk file tunggal
        foreach ($documentFields as $docName => $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $docName . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/documents/{application_id}
                $path = $file->storeAs('documents/' . $application->id, $fileName, 'public');

                // Simpan atau perbarui record di database
                $application->documents()->updateOrCreate(
                    ['document_name' => $docName], // Kunci untuk mencari
                    ['file_path' => $path]          // Data yang diupdate atau dibuat
                );
            }
        }

        // Proses upload untuk multiple file (dokumen pendukung)
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $key => $file) {
                $docName = 'Dokumen Pendukung ' . ($key + 1);
                $fileName = time() . '_' . $docName . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents/' . $application->id, $fileName, 'public');

                // Selalu buat record baru untuk dokumen pendukung
                $application->documents()->create([
                    'document_name' => $docName,
                    'file_path' => $path
                ]);
            }
        }

        // Cek apakah semua dokumen WAJIB sudah diunggah, lalu update status
        $this->updateApplicationStatus($application);

        return redirect()->route('candidate.profile')->with('status', 'Dokumen berhasil diunggah!');
    }

    /**
     * Helper function untuk update status aplikasi.
     */
    private function updateApplicationStatus($application)
    {
        $requiredDocs = [
            'Surat Lamaran',
            'CV',
            'Fotokopi KTP dan KK',
            'Fotokopi Ijazah dan Transkrip Nilai',
        ];

        // Ambil nama dokumen yang sudah diunggah oleh user
        $uploadedDocs = $application->documents()->pluck('document_name')->toArray();

        // Cek apakah semua dokumen wajib ada di dalam daftar yang sudah diunggah
        $allRequiredUploaded = empty(array_diff($requiredDocs, $uploadedDocs));

        if ($allRequiredUploaded) {
            $application->update(['status' => 'menunggu_seleksi']);
        }
    }
}