<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    // Menampilkan daftar pemain
    public function ViewPlayer()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['You need to log in first.']);
        }

        // Admin or Pelatih can see all players
        $players = Player::all();  // Fetch all players

        return view('player', ['players' => $players]);
    }

    // Menampilkan form untuk menambah pemain
    public function ViewAddPlayer()
    {
        return view('addplayer');
    }

    // Menambahkan pemain baru
    public function CreatePlayer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'team' => 'required|string|max:100',
            'age' => 'required|integer|min:15|max:50',
            'jersey_number' => 'required|integer|unique:players,jersey_number',
            'image' => 'nullable|image|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images', $imageName); 
        }

        Player::create([
            'name' => $request->name,
            'position' => $request->position,
            'team' => $request->team,
            'age' => $request->age,
            'jersey_number' => $request->jersey_number,
            'image' => $imageName,
            'user_id' => Auth::user()->id
        ]);

        return redirect(Auth::user()->role . '/player')->with('success', 'Player created successfully.');
    }

    // Menampilkan form untuk mengedit pemain
    public function ViewEditPlayer($player_id)
    {
        $editPlayer = Player::find($player_id);
        if (!$editPlayer) {
            return redirect()->back()->withErrors(['Player not found.']);
        }
        return view('editplayer', compact('editPlayer'));
    }

    public function UpdatePlayer(Request $request, $player_id)
    {
        $player = Player::find($player_id);
    
        // Pastikan pemain ada
        if (!$player) {
            return redirect()->back()->withErrors(['Player not found.']);
        }
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'team' => 'required|string|max:100',
            'age' => 'required|integer|min:15|max:50',
            'jersey_number' => 'required|integer|unique:players,jersey_number,' . $player_id,
            'image' => 'nullable|image|max:2048',
        ]);
    
        // Proses gambar jika ada
        $imageName = $player->image;
        if ($request->hasFile('image')) {
            // Tentukan nama file gambar baru
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            // Simpan gambar
            $request->file('image')->storeAs('public/images', $imageName);
    
            // Hapus gambar lama jika ada
            if ($player->image && Storage::exists('public/images/' . $player->image)) {
                Storage::delete('public/images/' . $player->image);
            }
        }
    
        // Update data pemain
        $player->update([
            'name' => $request->name,
            'position' => $request->position,
            'team' => $request->team,
            'age' => $request->age,
            'jersey_number' => $request->jersey_number,
            'image' => $imageName,
        ]);
    
        // Redirect ke halaman pemain dengan pesan sukses
        return redirect(Auth::user()->role . '/player')->with('success', 'Player updated successfully.');
    }

    // Menghapus pemain
    public function DeletePlayer($player_id)
    {
        $player = Player::find($player_id);
        if (!$player) {
            return redirect()->back()->withErrors(['Player not found.']);
        }

        if ($player->image && Storage::exists('public/images/' . $player->image)) {
            Storage::delete('public/images/' . $player->image);
        }

        $player->delete();

        return redirect(Auth::user()->role . '/player')->with('success', 'Player deleted successfully.');
    }
}
