<?php

use App\Traits\ExecuteSqlFile;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    use ExecuteSqlFile;

    public function up(): void
    {

        $this->executeSqlFile('2025_01_01_init.sql');
    }
};
