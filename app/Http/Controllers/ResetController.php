<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResetController extends Controller
{
    public function index()
    {
        $excludedTables = [
            'failed_jobs',
            'model_has_permissions',
            'model_has_roles',
            'password_reset_tokens',
            'personal_access_tokens',
            'permissions',
            'role_has_permissions',
            'roles',
            'users',
        ];

        $tables = $this->getTables($excludedTables);

        $tablesWithCount = collect($tables)->map(function ($table) {
            return [
                'name' => $table,
                'count' => $this->getTableRowCount($table),
            ];
        });

        return view('backup.reset', [
            'title' => 'Reset Database',
            'tablesWithCount' => $tablesWithCount,
            'breadcrumb' => 'Reset Database',
            'name_user' => Auth::user()->name,
        ]);
    }

    public function resetTable($table)
    {
        DB::table($table)->truncate();

        return redirect()->back()->with('success', 'Tabel ' . $table . ' berhasil direset!');
    }

    private function getTables($excludedTables = [])
    {
        $tables = [];

        $tablesRaw = DB::select('SHOW TABLES');

        foreach ($tablesRaw as $table) {
            $values = array_values((array)$table);
            $tableName = $values[0];

            if (!in_array($tableName, $excludedTables)) {
                $tables[] = $tableName;
            }
        }

        return $tables;
    }

    private function getTableRowCount($table)
    {
        $count = DB::table($table)->count();

        return $count;
    }
}
