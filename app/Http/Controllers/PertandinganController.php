<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // PDF package
use Maatwebsite\Excel\Facades\Excel; // Excel package
use Maatwebsite\Excel\Concerns\FromCollection; // Excel export concern

class PertandinganController extends Controller
{
    // Menampilkan daftar pertandingan
    public function ViewPertandingan()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['You need to log in first.']);
        }

        // Semua pengguna bisa melihat semua data pertandingan
        $pertandingans = Pertandingan::all();

        // Kirim role ke view
        return view('pertandingan', [
            'pertandingans' => $pertandingans,
            'role' => $user->role,
        ]);
    }

    // Menampilkan form untuk menambah pertandingan (khusus admin)
    public function ViewAddPertandingan()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors(['Access denied.']);
        }
        return view('addpertandingan');
    }

    // Menambahkan pertandingan baru (khusus admin)
    public function CreatePertandingan(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors(['Access denied.']);
        }
    
        $request->validate([
            'tim_1' => 'required|string|max:100',
            'tim_2' => 'required|string|max:100',
            'gol_tim_1' => 'required|integer|min:0',
            'gol_tim_2' => 'required|integer|min:0',
            'pencetak_gol_tim_1' => 'nullable|string|max:255',
            'pencetak_gol_tim_2' => 'nullable|string|max:255',
            'home_away' => 'required|in:home,away',
            'tanggal_pertandingan' => 'required|date',
        ]);
    
        Pertandingan::create([
            'tim_1' => $request->tim_1,
            'tim_2' => $request->tim_2,
            'gol_tim_1' => $request->gol_tim_1,
            'gol_tim_2' => $request->gol_tim_2,
            'pencetak_gol_tim_1' => $request->pencetak_gol_tim_1,
            'pencetak_gol_tim_2' => $request->pencetak_gol_tim_2,
            'home_away' => $request->home_away,
            'tanggal_pertandingan' => $request->tanggal_pertandingan,
            'user_id' => Auth::user()->id, // Menambahkan user_id
        ]);
    
        return redirect('admin/pertandingan')->with('success', 'Pertandingan created successfully.');
    }

    // Menampilkan form untuk mengedit pertandingan
    public function ViewEditPertandingan($pertandingan_id)
    {
        $editPertandingan = Pertandingan::find($pertandingan_id);
        if (!$editPertandingan) {
            return redirect()->back()->withErrors(['Pertandingan not found.']);
        }
        return view('editpertandingan', compact('editPertandingan'));
    }

    // Memperbarui pertandingan
    public function UpdatePertandingan(Request $request, $pertandingan_id)
    {
        $pertandingan = Pertandingan::find($pertandingan_id);
        if (!$pertandingan) {
            return redirect()->back()->withErrors(['Pertandingan not found.']);
        }

        $request->validate([
            'tim_1' => 'required|string|max:100',
            'tim_2' => 'required|string|max:100',
            'gol_tim_1' => 'required|integer|min:0',
            'gol_tim_2' => 'required|integer|min:0',
            'pencetak_gol_tim_1' => 'nullable|string|max:255',
            'pencetak_gol_tim_2' => 'nullable|string|max:255',
            'home_away' => 'required|in:home,away',
            'tanggal_pertandingan' => 'required|date',
        ]);

        $pertandingan->update([
            'tim_1' => $request->tim_1,
            'tim_2' => $request->tim_2,
            'gol_tim_1' => $request->gol_tim_1,
            'gol_tim_2' => $request->gol_tim_2,
            'pencetak_gol_tim_1' => $request->pencetak_gol_tim_1,
            'pencetak_gol_tim_2' => $request->pencetak_gol_tim_2,
            'home_away' => $request->home_away,
            'tanggal_pertandingan' => $request->tanggal_pertandingan,
        ]);

        return redirect(Auth::user()->role . '/pertandingan')->with('success', 'Pertandingan updated successfully.');
    }

    // Menghapus pertandingan (khusus admin)
    public function DeletePertandingan($pertandingan_id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors(['Access denied.']);
        }

        $pertandingan = Pertandingan::find($pertandingan_id);
        if (!$pertandingan) {
            return redirect()->back()->withErrors(['Pertandingan not found.']);
        }

        $pertandingan->delete();

        return redirect('admin/pertandingan')->with('success', 'Pertandingan deleted successfully.');
    }

      /**
     * Menampilkan laporan pertandingan berdasarkan peran pengguna.
     */
    public function ViewLaporan()
    {
        // Semua pengguna melihat semua data pertandingan
        $pertandingans = Pertandingan::all();
    
        return view('laporan', ['pertandingans' => $pertandingans]);
    }
    
    public function print($format = 'pdf')
    {
        // Semua pengguna melihat semua data pertandingan
        $pertandingans = Pertandingan::all();
    
        // Ekspor ke PDF
        if ($format == 'pdf') {
            $pdf = Pdf::loadView('report', compact('pertandingans'));
            return $pdf->stream('laporan-pertandingan.pdf');
        }
    
        // Redirect untuk format yang tidak valid
        return redirect()->back()->withErrors(['format' => 'Format tidak valid. Gunakan "pdf" untuk PDF atau "csv" untuk CSV.']);
    }
    /**
     * Menyediakan file CSV untuk diunduh.
     */
    public function download()
    {
        $pertandingans = Pertandingan::all();
    
        $data = $pertandingans->map(function ($pertandingan) {
            return [
                'Tim 1' => $pertandingan->tim_1,
                'Tim 2' => $pertandingan->tim_2,
                'Gol Tim 1' => $pertandingan->gol_tim_1,
                'Gol Tim 2' => $pertandingan->gol_tim_2,
                'Pencetak Gol Tim 1' => $pertandingan->pencetak_gol_tim_1,
                'Pencetak Gol Tim 2' => $pertandingan->pencetak_gol_tim_2,
                'Home/Away' => $pertandingan->home_away,
                'Tanggal Pertandingan' => $pertandingan->tanggal_pertandingan,
            ];
        });
    
        $fileName = 'laporan-pertandingan.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];
    
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
    
            // Tambahkan header kolom CSV
            fputcsv($file, array_keys($data->first()));
    
            // Tambahkan data baris
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }



}
