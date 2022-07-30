<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;

class DbExportController extends Controller
{
    public function export() {
        $pathToFile = 'dump.sql';
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile($pathToFile);

        return  response()->download($pathToFile);
    }
}
