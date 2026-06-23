<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            'rkud.view',
            'rkud.create',
            'rkud.edit',
            'rkud.delete',

            'perangkat-daerah.view',
            'perangkat-daerah.create',
            'perangkat-daerah.edit',
            'perangkat-daerah.delete',

            'kebijakan-spd.view',
            'kebijakan-spd.create',
            'kebijakan-spd.edit',
            'kebijakan-spd.delete',

            'besaran-up.view',
            'besaran-up.create',
            'besaran-up.edit',
            'besaran-up.delete',

            'pegawai.view',
            'pegawai.create',
            'pegawai.edit',
            'pegawai.delete',

            'rekening-penerimaan.view',
            'rekening-penerimaan.edit',

            'rekening-bank-skpd.view',
            'rekening-bank-skpd.edit',

            'blokir-rekening.view',
            'blokir-rekening.edit',

            'dpa-pendapatan.view',
            'dpa-pendapatan.create',
            'dpa-pendapatan.edit',
            'dpa-pendapatan.delete',

            'dpa-pendapatan.detail.view',
            'dpa-pendapatan.detail.edit',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat semua roles
        $roles = [
            ['id' => 1,  'name' => 'superadmin'],
            ['id' => 2,  'name' => 'KUASA PENGGUNA ANGGARAN'],
            ['id' => 3,  'name' => 'PPK SKPD'],
            ['id' => 4,  'name' => 'BENDAHARA PENERIMAAN'],
            ['id' => 5,  'name' => 'BENDAHARA PENGELUARAN'],
            ['id' => 6,  'name' => 'BENDAHARA UOBK'],
            ['id' => 7,  'name' => 'SEKRETARIS DAERAH'],
            ['id' => 8,  'name' => 'BENDAHARA PENGELUARAN PEMBANTU'],
            ['id' => 9,  'name' => 'PPTK'],
            ['id' => 10, 'name' => 'BENDAHARA UMUM DAERAH'],
            ['id' => 11, 'name' => 'PENGGUNA ANGGARAN'],
            ['id' => 12, 'name' => 'KUASA BENDAHARA UMUM DAERAH'],
            ['id' => 13, 'name' => 'PEJABAT PENGELOLA KEUANGAN DAERAH'],
            ['id' => 14, 'name' => 'BENDAHARA PENERIMAAN PEMBANTU'],
            ['id' => 15, 'name' => 'PPK UNIT SKPD'],
            ['id' => 16, 'name' => 'KASUBAG PROGRAM'],
            ['id' => 17, 'name' => 'MITRA BUD'],
            ['id' => 18, 'name' => 'OPERATOR OPD'],
            ['id' => 19, 'name' => 'FUNGSI AKUNTANSI SKPD'],
            ['id' => 20, 'name' => 'FUNGSI AKUNTANSI SKPKD'],
            ['id' => 21, 'name' => 'KEMENTERIAN / LEMBAGA'],
            ['id' => 22, 'name' => 'PEMERINTAH DAERAH'],
            ['id' => 23, 'name' => 'BPK PUSAT'],
            ['id' => 24, 'name' => 'BPK PEMDA'],
            ['id' => 25, 'name' => 'KPK'],
        ];

        DB::table('roles')->upsert(
            array_map(fn ($r) => array_merge($r, [
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]), $roles),
            ['id'],
            ['name', 'guard_name', 'updated_at']
        );

        // Ambil role dari database setelah upsert
        $superadmin = Role::findById(1);
        $operatorOpd = Role::findById(18);

        // SUPER ADMIN dapat semua permission
        $superadmin->syncPermissions(Permission::all());

        // OPERATOR OPD hanya bisa view
        $operatorOpd->syncPermissions([
            'user.view',
        ]);
    }
}
