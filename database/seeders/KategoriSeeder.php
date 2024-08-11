<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now(); // Get the current timestamp

        $kategoris = [
            ['kode_kategori' => 'K001', 'nama_kategori' => 'Basic Pneumatic brake system', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K002', 'nama_kategori' => 'Basic Computer', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K003', 'nama_kategori' => 'Basic Differential & Hub Reduction', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K004', 'nama_kategori' => 'Basic Driving Double Trailer', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K005', 'nama_kategori' => 'Basic Driving Single Trailer', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K006', 'nama_kategori' => 'Basic Driving Triple Trailer', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K007', 'nama_kategori' => 'Basic Driving FM 440/480 I Shift', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K008', 'nama_kategori' => 'Basic Driving MB Actors', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K009', 'nama_kategori' => 'Basic Electrical Component & Symbol', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K010', 'nama_kategori' => 'Basic Engine Diesel', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K011', 'nama_kategori' => 'Basic Hydraulic System', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K012', 'nama_kategori' => 'Basic Power Train', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K013', 'nama_kategori' => 'Basic Steering System', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K014', 'nama_kategori' => 'Basic Suspension System', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K015', 'nama_kategori' => 'Behaviour Based Safety', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K016', 'nama_kategori' => 'Behaviour Based Safety For Frontliner', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K017', 'nama_kategori' => 'Basic Charging System', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K018', 'nama_kategori' => 'Radio Communication', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K019', 'nama_kategori' => 'Road Regulation', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K020', 'nama_kategori' => 'Rollover Prevention', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K021', 'nama_kategori' => 'Pratical Simulator Excavator', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K022', 'nama_kategori' => 'Slinging and Rigging', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K023', 'nama_kategori' => 'Starting System Component', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K024', 'nama_kategori' => 'Transmisi Volvo I Shift', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K025', 'nama_kategori' => 'Transmisi Volvo Manual', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K026', 'nama_kategori' => 'Transport Overview', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K027', 'nama_kategori' => 'Truck Mechanical Awareness', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K028', 'nama_kategori' => 'Truck Power Train', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K029', 'nama_kategori' => 'Use Hand Tools and Power Tools', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K030', 'nama_kategori' => 'Working at Height', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K031', 'nama_kategori' => 'Workshop Overview', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K032', 'nama_kategori' => 'Mechanical Awareness HE', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K033', 'nama_kategori' => 'Charging System Component', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K034', 'nama_kategori' => 'Starting and Charging system', 'created_at' => $now, 'updated_at' => $now],
            ['kode_kategori' => 'K035', 'nama_kategori' => 'Adjust Valve Clearance Volvo', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('kategori')->insert($kategoris);
    }
}
