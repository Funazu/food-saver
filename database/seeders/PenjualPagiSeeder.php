<?php

namespace Database\Seeders;

use App\Models\Penjual;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenjualPagiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Bu Tatik',
                'email' => 'tatiknasi@example.com',
                'nama_toko' => 'Nasi Uduk Bu Tatik',
                'alamat_toko' => 'Jl. Sagan No. 20',
                'no_telepon_toko' => '081222334455',
                'jam_buka' => '04:00:00',
                'jam_tutup' => '12:00:00',
                'rekening_bank' => 'BCA 1111222233',
                'nama_pembilik_rekening' => 'Bu Tatik',
                'latitude' => '-7.7811',
                'longitude' => '110.3734',
                'deskripsi_toko' => 'Nasi uduk legendaris dengan lauk komplit dan sambal khas rumahan.',
            ],
            [
                'name' => 'Pak Slamet',
                'email' => 'lontongpagi@example.com',
                'nama_toko' => 'Lontong Sayur Pagi Slamet',
                'alamat_toko' => 'Jl. AM Sangaji No. 88',
                'no_telepon_toko' => '082112233445',
                'jam_buka' => '04:30:00',
                'jam_tutup' => '11:30:00',
                'rekening_bank' => 'Mandiri 2233445566',
                'nama_pembilik_rekening' => 'Slamet Riyadi',
                'latitude' => '-7.7788',
                'longitude' => '110.3699',
                'deskripsi_toko' => 'Lontong sayur dengan kuah gurih dan sambal pedas, cocok untuk sarapan.',
            ],
            [
                'name' => 'Ibu Dewi',
                'email' => 'buburdewi@example.com',
                'nama_toko' => 'Bubur Ayam Ibu Dewi',
                'alamat_toko' => 'Jl. Colombo No. 9',
                'no_telepon_toko' => '083123456789',
                'jam_buka' => '05:00:00',
                'jam_tutup' => '12:00:00',
                'rekening_bank' => 'BNI 3344556677',
                'nama_pembilik_rekening' => 'Dewi Kartika',
                'latitude' => '-7.7722',
                'longitude' => '110.3911',
                'deskripsi_toko' => 'Bubur ayam lembut dengan topping melimpah dan kerupuk renyah.',
            ],
        ];

        foreach ($data as $item) {
            $user = User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make('password'), // default password
            ]);

            $user->assignRole('penjual'); // jika pakai Spatie Permission

            Penjual::create([
                'user_id' => $user->id,
                'nama_toko' => $item['nama_toko'],
                'alamat_toko' => $item['alamat_toko'],
                'no_telepon_toko' => $item['no_telepon_toko'],
                'jam_buka' => $item['jam_buka'],
                'jam_tutup' => $item['jam_tutup'],
                'rekening_bank' => $item['rekening_bank'],
                'nama_pembilik_rekening' => $item['nama_pembilik_rekening'],
                'status_verifikasi' => 'verified',
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
                'deskripsi_toko' => $item['deskripsi_toko'],
            ]);
        }
    }
}
