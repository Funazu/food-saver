<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Penjual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenjualSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Sri Mulyani',
                'email' => 'mbokyem@example.com',
                'nama_toko' => 'Warung Nasi Mbok Yem',
                'alamat_toko' => 'Jl. Malioboro No.12',
                'no_telepon_toko' => '081234567890',
                'jam_buka' => '07:00:00',
                'jam_tutup' => '15:00:00',
                'rekening_bank' => 'BCA 1234567890',
                'nama_pembilik_rekening' => 'Sri Mulyani',
                'latitude' => '-7.7925',
                'longitude' => '110.3661',
                'deskripsi_toko' => 'Warung legendaris yang menyajikan nasi tradisional dengan cita rasa rumahan.',
            ],
            [
                'name' => 'Andi Firmansyah',
                'email' => 'geprek@example.com',
                'nama_toko' => 'Ayam Geprek Mantap',
                'alamat_toko' => 'Jl. Kaliurang KM 5',
                'no_telepon_toko' => '082345678901',
                'jam_buka' => '10:00:00',
                'jam_tutup' => '21:00:00',
                'rekening_bank' => 'Mandiri 9876543210',
                'nama_pembilik_rekening' => 'Andi Firmansyah',
                'latitude' => '-7.7648',
                'longitude' => '110.3796',
                'deskripsi_toko' => 'Ayam geprek super pedas dengan berbagai pilihan level sambal.',
            ],
            [
                'name' => 'Budi Hartono',
                'email' => 'kopibudi@example.com',
                'nama_toko' => 'Kopi Budi Corner',
                'alamat_toko' => 'Jl. Monjali No. 45',
                'no_telepon_toko' => '083145678901',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '22:00:00',
                'rekening_bank' => 'BRI 1122334455',
                'nama_pembilik_rekening' => 'Budi Hartono',
                'latitude' => '-7.7552',
                'longitude' => '110.3632',
                'deskripsi_toko' => 'Tempat nongkrong santai dengan kopi lokal terbaik dan suasana cozy.',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'baksoaminah@example.com',
                'nama_toko' => 'Bakso Aminah Super Pedas',
                'alamat_toko' => 'Jl. Gejayan No. 88',
                'no_telepon_toko' => '081234567891',
                'jam_buka' => '11:00:00',
                'jam_tutup' => '20:00:00',
                'rekening_bank' => 'BNI 5566778899',
                'nama_pembilik_rekening' => 'Siti Aminah',
                'latitude' => '-7.7751',
                'longitude' => '110.3883',
                'deskripsi_toko' => 'Bakso khas dengan kuah pedas yang menggoda dan topping melimpah.',
            ],
            [
                'name' => 'Doni Setiawan',
                'email' => 'satepadang@example.com',
                'nama_toko' => 'Sate Padang Doni',
                'alamat_toko' => 'Jl. Godean KM 6',
                'no_telepon_toko' => '082134567890',
                'jam_buka' => '16:00:00',
                'jam_tutup' => '23:00:00',
                'rekening_bank' => 'CIMB 9988776655',
                'nama_pembilik_rekening' => 'Doni Setiawan',
                'latitude' => '-7.8014',
                'longitude' => '110.3176',
                'deskripsi_toko' => 'Sate padang otentik dengan kuah kental khas Minang, nikmat dan pedas.',
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
