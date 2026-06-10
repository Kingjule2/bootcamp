<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\User;
use Livewire\Component;

class FormInputMenu extends Component
{
    public $nama_menu = '';
    public $kalori = '';
    public $protein = '';
    public $porsi_rencana = '';
    public $target_sekolah_id = '';

    protected function rules()
    {
        return [
            'nama_menu' => 'required|string|min:10',
            'kalori' => 'required|integer|min:400|max:1500',
            'protein' => 'required|integer|min:10|max:100',
            'porsi_rencana' => 'required|integer|min:1|max:5000',
            'target_sekolah_id' => 'required|exists:users,id',
        ];
    }

    protected function messages()
    {
        return [
            'nama_menu.min' => 'Deskripsi menu minimal 10 karakter (contoh: Nasi Putih, Ayam Goreng, Sayur Bayam).',
            'kalori.min' => 'Estimasi kalori minimum 400 kkal sesuai standar gizi.',
            'protein.min' => 'Estimasi protein minimum 10 gram sesuai standar gizi.',
            'target_sekolah_id.exists' => 'Sekolah tujuan tidak valid.',
        ];
    }

    public function submit()
    {
        $this->validate();

        Menu::create([
            'dapur_id' => auth()->id(),
            'target_sekolah_id' => $this->target_sekolah_id,
            'nama_menu' => $this->nama_menu,
            'kalori' => $this->kalori,
            'protein' => $this->protein,
            'porsi_rencana' => $this->porsi_rencana,
            'status' => 'Pending Verification',
        ]);

        $this->reset(['nama_menu', 'kalori', 'protein', 'porsi_rencana', 'target_sekolah_id']);
        session()->flash('menu-success', 'Menu berhasil diajukan! Menunggu verifikasi ahli gizi.');

        $this->dispatch('menu-created');
    }

    public function render()
    {
        $sekolahList = User::where('role', 'sekolah')->orderBy('nama_entitas')->get();

        return view('livewire.dapur.form-input-menu', compact('sekolahList'));
    }
}
