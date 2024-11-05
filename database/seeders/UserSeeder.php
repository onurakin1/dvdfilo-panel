<?php

namespace Database\Seeders;

use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->repository->truncate();
        Schema::enableForeignKeyConstraints();

        $users = [
            [
                'first_name' => 'sysadmin',
                'email' => 'sys@limonistmeta.com',
                'email_verified_at' => now(),
                'level' => 1,
                'password' => bcrypt('metaLimonist24')
            ],
            [
                'first_name' => 'admin',
                'email' => 'admin@limonistmeta.com',
                'email_verified_at' => now(),
                'level' => 2,
                'password' => bcrypt('metaLimonist24')
            ]
        ];

        $this->repository->saveMany($users);
    }
}
