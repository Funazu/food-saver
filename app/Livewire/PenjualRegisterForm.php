<?php

namespace App\Livewire;

use App\Models\Penjual;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenjualRegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public $name, $email, $password, $password_confirmation;
    public $nama_toko, $alamat_toko, $latitude, $longitude, $no_telepon_toko,
        $deskripsi_toko, $jam_buka, $jam_tutup,
        $rekening_bank, $nama_pembilik_rekening;

    protected function getFormSchema(): array
    {
        return [
            Section::make('Akun')
                ->schema([
                    TextInput::make('name')->label('Nama')->required(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('password')->password()->required()->confirmed(),
                    TextInput::make('password_confirmation')->password()->label('Konfirmasi Password')->required(),
                ]),

            Section::make('Informasi Toko')
                ->schema([
                    TextInput::make('nama_toko')->required(),
                    TextInput::make('alamat_toko'),
                    TextInput::make('latitude'),
                    TextInput::make('longitude'),
                    TextInput::make('no_telepon_toko'),
                    Textarea::make('deskripsi_toko'),
                    TimePicker::make('jam_buka'),
                    TimePicker::make('jam_tutup'),
                    TextInput::make('rekening_bank'),
                    TextInput::make('nama_pembilik_rekening'),
                ])
        ];
    }

    public function submit()
    {
        // Cek email sudah ada?
        if (User::where('email', $this->email)->exists()) {
            $this->addError('email', 'Email sudah terdaftar.');
            return;
        }

        // Buat akun user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Buat data penjual
        Penjual::create([
            'user_id' => $user->id,
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

        // Assign role penjual
        $user->assignRole('penjual');

        // Login langsung
        Auth::login($user);

        // Redirect ke dashboard penjual
        return redirect()->route('filament.penjual.pages.dashboard');
    }

    public function render()
    {
        return view('livewire.penjual-register-form');
    }
}
