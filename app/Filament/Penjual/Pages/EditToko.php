<?php

namespace App\Filament\Penjual\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Penjual;
use Filament\Notifications\Notification;

class EditToko extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Edit Toko';
    protected static ?string $navigationGroup = 'Profil';
    protected static string $view = 'filament.penjual.pages.edit-toko';

    public Penjual $penjual;

    public $nama_toko, $alamat_toko, $latitude, $longitude, $no_telepon_toko,
        $deskripsi_toko, $jam_buka, $jam_tutup, $rekening_bank, $nama_pembilik_rekening;

    public function mount(): void
    {
        $this->penjual = auth()->user()->penjual;

        $this->nama_toko = $this->penjual->nama_toko;
        $this->alamat_toko = $this->penjual->alamat_toko;
        $this->latitude = $this->penjual->latitude;
        $this->longitude = $this->penjual->longitude;
        $this->no_telepon_toko = $this->penjual->no_telepon_toko;
        $this->deskripsi_toko = $this->penjual->deskripsi_toko;
        $this->jam_buka = $this->penjual->jam_buka;
        $this->jam_tutup = $this->penjual->jam_tutup;
        $this->rekening_bank = $this->penjual->rekening_bank;
        $this->nama_pembilik_rekening = $this->penjual->nama_pembilik_rekening;
    }

    public function form(Form $form): Form
    {
        return $form->schema($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('nama_toko')->label('Nama Toko')->required()->statePath('nama_toko'),
                Forms\Components\TextInput::make('alamat_toko')->required()->statePath('alamat_toko'),
                Forms\Components\TextInput::make('latitude')->statePath('latitude'),
                Forms\Components\TextInput::make('longitude')->statePath('longitude'),
                Forms\Components\TextInput::make('no_telepon_toko')->statePath('no_telepon_toko'),
                Forms\Components\TextInput::make('deskripsi_toko')->statePath('deskripsi_toko'),
                Forms\Components\TimePicker::make('jam_buka')->statePath('jam_buka'),
                Forms\Components\TimePicker::make('jam_tutup')->statePath('jam_tutup'),
                Forms\Components\TextInput::make('rekening_bank')->statePath('rekening_bank'),
                Forms\Components\TextInput::make('nama_pembilik_rekening')->statePath('nama_pembilik_rekening'),
            ]),
        ];
    }

    public function update()
    {
        $this->penjual->update([
            'nama_toko' => $this->nama_toko,
            'alamat_toko' => $this->alamat_toko,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'no_telepon_toko' => $this->no_telepon_toko,
            'deskripsi_toko' => $this->deskripsi_toko,
            'jam_buka' => $this->jam_buka,
            'jam_tutup' => $this->jam_tutup,
            'rekening_bank' => $this->rekening_bank,
            'nama_pembilik_rekening' => $this->nama_pembilik_rekening,
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('Data toko berhasil diperbarui.')
            ->success()
            ->send();
    }
}
