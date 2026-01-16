<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkPenurunanUkt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SkPenurunanUktController extends Controller
{
    public function index()
    {
        $skList = SkPenurunanUkt::orderBy('tahun', 'desc')
                                ->orderBy('tanggal_terbit', 'desc')
                                ->get();

        return view('dashboard.sk.index', compact('skList'));
    }

    public function create()
    {
        return view('dashboard.sk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_sk' => 'required|string|max:255|unique:sk_penurunan_ukt,nomor_sk',
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tanggal_terbit' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240',
        ], [
            'nomor_sk.required' => 'Nomor SK wajib diisi.',
            'nomor_sk.unique' => 'Nomor SK sudah terdaftar.',
            'judul.required' => 'Judul SK wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.min' => 'Tahun minimal 2000.',
            'tahun.max' => 'Tahun maksimal ' . (date('Y') + 1) . '.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_terbit.date' => 'Format tanggal tidak valid.',
            'file.required' => 'File SK wajib diupload.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($validated['nomor_sk']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sk-penurunan-ukt', $fileName, 'public');

            SkPenurunanUkt::create([
                'nomor_sk' => $validated['nomor_sk'],
                'judul' => $validated['judul'],
                'tahun' => $validated['tahun'],
                'tanggal_terbit' => $validated['tanggal_terbit'],
                'keterangan' => $validated['keterangan'],
                'file_path' => $path,
            ]);

            return redirect()->route('dashboard')->with('success', 'SK berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error saat menambah SK: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menambah SK.'])->withInput();
        }
    }

    public function edit($id)
    {
        $sk = SkPenurunanUkt::findOrFail($id);
        return view('dashboard.sk.edit', compact('sk'));
    }

    public function update(Request $request, $id)
    {
        $sk = SkPenurunanUkt::findOrFail($id);

        $validated = $request->validate([
            'nomor_sk' => 'required|string|max:255|unique:sk_penurunan_ukt,nomor_sk,' . $id,
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tanggal_terbit' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'nomor_sk.required' => 'Nomor SK wajib diisi.',
            'nomor_sk.unique' => 'Nomor SK sudah terdaftar.',
            'judul.required' => 'Judul SK wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $data = [
                'nomor_sk' => $validated['nomor_sk'],
                'judul' => $validated['judul'],
                'tahun' => $validated['tahun'],
                'tanggal_terbit' => $validated['tanggal_terbit'],
                'keterangan' => $validated['keterangan'],
            ];

            if ($request->hasFile('file')) {
                if (Storage::disk('public')->exists($sk->file_path)) {
                    Storage::disk('public')->delete($sk->file_path);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . Str::slug($validated['nomor_sk']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('sk-penurunan-ukt', $fileName, 'public');
                $data['file_path'] = $path;
            }

            $sk->update($data);

            return redirect()->route('sk.index')->with('success', 'SK berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui SK: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui SK.'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $sk = SkPenurunanUkt::findOrFail($id);

            if (Storage::disk('public')->exists($sk->file_path)) {
                Storage::disk('public')->delete($sk->file_path);
            }

            $sk->delete();

            return redirect()->route('sk.index')->with('success', 'SK berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus SK: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus SK.']);
        }
    }

    public function download($id)
    {
    $sk = SkPenurunanUkt::findOrFail($id);

    if (Storage::disk('public')->exists($sk->file_path)) {

        // Hilangkan karakter yang tidak boleh: / dan \
        $safeName = str_replace(['/', '\\'], '-', $sk->nomor_sk) . '.pdf';

        return Storage::disk('public')->download($sk->file_path, $safeName);
    }

    return back()->withErrors(['error' => 'File tidak ditemukan.']);
    }

}