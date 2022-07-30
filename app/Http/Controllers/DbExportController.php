<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;

class DbExportController extends Controller
{
    public function export() {
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile('dump.sql');

        return  Storage::download('dump.sql');
    }
}
