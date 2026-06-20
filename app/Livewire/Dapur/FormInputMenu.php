<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Sekolah;
use Livewire\Component;

class FormInputMenu extends Component
{
    public $nama_menu = '';
    public $kalori = '';
    public $protein = '';
    public $karbohidrat = '';
    public $lemak = '';
    public $porsi_rencana = '';
    public $id_sekolah = '';

    protected function rules()
    {
        return [
            'nama_menu'    => 'required|string|min:10',
            'kalori'       => 'required|integer|min:400|max:1500',
            'protein'      => 'required|integer|min:10|max:100',
            'karbohidrat'  => 'required|integer|min:1|max:500',
            'lemak'        => 'required|integer|min:1|max:200',
            'porsi_rencana'=> 'required|integer|min:1|max:5000',
            'id_sekolah'   => 'required|exists:sekolah,id_sekolah',
        ];
    }

    protected function messages()
    {
        return [
            'nama_menu.min'      => 'Deskripsi menu minimal 10 karakter (contoh: Nasi Putih, Ayam Goreng, Sayur Bayam).',
            'kalori.min'         => 'Estimasi kalori minimum 400 kkal sesuai standar gizi.',
            'protein.min'        => 'Estimasi protein minimum 10 gram sesuai standar gizi.',
            'karbohidrat.min'    => 'Karbohidrat wajib diisi minimal 1 gram.',
            'lemak.min'          => 'Lemak wajib diisi minimal 1 gram.',
            'id_sekolah.exists'  => 'Sekolah tujuan tidak valid.',
        ];
    }

    public function submit()
    {
        $this->validate();

        Menu::create([
            'dapur_id'     => auth()->id(),
            'id_sekolah'   => $this->id_sekolah,
            'nama_menu'    => $this->nama_menu,
            'kalori'       => $this->kalori,
            'protein'      => $this->protein,
            'karbohidrat'  => $this->karbohidrat,
            'lemak'        => $this->lemak,
            'porsi_rencana'=> $this->porsi_rencana,
            'status'       => 'Pending Verification',
            'id_ahli_gizi' => null, // Will be set by Ahli Gizi on approval
        ]);

        $this->reset(['nama_menu', 'kalori', 'protein', 'karbohidrat', 'lemak', 'porsi_rencana', 'id_sekolah']);
        session()->flash('menu-success', 'Menu berhasil diajukan! Menunggu verifikasi ahli gizi.');

        $this->dispatch('menu-created');
    }

    public function render()
    {
        $sekolahList = Sekolah::with('user')->get();

        return view('livewire.dapur.form-input-menu', compact('sekolahList'));
    }
}
