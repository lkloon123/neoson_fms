<?php

use App\Models\Software;
use Illuminate\Database\Seeder;

class SoftwaresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Software::create([
            'name' => 'ccminer_tpruvot_cuda75',
            'exe_name' => 'ccminer.exe',
            'version' => '2.2.2',
            'github_link' => 'https://github.com/tpruvot/ccminer',
            'path' => 'software/ccminer_tpruvot_cuda75.zip',
            'sha256_checksum' => 'd72a1eaf950ea2696a40aa1aa30255265cacb9c07a98baf598d444ae73b1c23a'
        ]);

        Software::create([
            'name' => 'ccminer_tpruvot_cuda9',
            'exe_name' => 'ccminer.exe',
            'version' => '2.2.4',
            'github_link' => 'https://github.com/tpruvot/ccminer',
            'path' => 'software/ccminer_tpruvot_cuda9.zip',
            'sha256_checksum' => 'e640f2f189b32901613f0ffa6a96a1cb5bc6a07a2e049e8adb61561d0a21d82f'
        ]);

        Software::create([
            'name' => 'ccminer_KlausT_cuda91',
            'exe_name' => 'ccminer.exe',
            'version' => '8.20',
            'github_link' => 'https://github.com/KlausT/ccminer',
            'path' => 'software/ccminer_KlausT_cuda91.zip',
            'sha256_checksum' => '0442237a125e332ba7894c58b6e6d67e8ea39ef7c3d8b2324213bae15e20c511'
        ]);

        Software::create([
            'name' => 'ccminer_KlausT_cuda8',
            'exe_name' => 'ccminer.exe',
            'version' => '8.20',
            'github_link' => 'https://github.com/KlausT/ccminer',
            'path' => 'software/ccminer_KlausT_cuda8.zip',
            'sha256_checksum' => 'd341618438b9cedcea0388e0f68a1186f3ac5affd0f0901b5a425f73e70034da'
        ]);

        Software::create([
            'name' => 'ccminer_phi_anxmod',
            'exe_name' => 'ccminer.exe',
            'version' => '1.0',
            'github_link' => 'https://github.com/216k155/ccminer-phi-anxmod',
            'path' => 'software/ccminer_phi_anxmod.zip',
            'sha256_checksum' => 'c35e5a81b4d77e0142b5ab374a86720c285d56f7d57128a5a0df3f46d65d9481'
        ]);

        Software::create([
            'name' => 'ccminer_phi_spmod',
            'exe_name' => 'ccminer.exe',
            'version' => '1.0',
            'path' => 'software/ccminer_phi_spmod.zip',
            'sha256_checksum' => '4715f5726f650a8c50e83f73e43c35e5fd4af3f0a7eeac2d9b785c00347f9fef'
        ]);

        Software::create([
            'name' => 'ccminer_skunk_spmod8',
            'exe_name' => 'ccminer.exe',
            'version' => '1.0',
            'path' => 'software/ccminer_skunk_spmod8.zip',
            'sha256_checksum' => '9028e0177e717733a9000954e5b7ec804dc693069883b4d4cd96e9e99b63100b'
        ]);

        Software::create([
            'name' => 'ccminer_krnlx',
            'exe_name' => 'ccminer.exe',
            'version' => '1.0',
            'github_link' => 'https://github.com/krnlx/ccminer-xevan',
            'path' => 'software/ccminer_krnlx.zip',
            'sha256_checksum' => '679faf74be4fad73bb9a588f608e7fd82eb8739b30bfde25b059d2206b52e3ae'
        ]);

        $this->command->info('Total Record -> '. Software::all()->count());
    }
}
