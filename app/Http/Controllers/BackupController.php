<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('backup.index', [
            'title' => 'Backup',
            'breadcrumb' => 'Backup',
            'name_user' => $user->name,
        ]);
    }

    public function download()
    {
        $fileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

        // Konfigurasi database
        $dbHost = config('database.connections.mysql.host');
        $dbUsername = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');
        $dbName = config('database.connections.mysql.database');

        // Buat header untuk response
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        // Fungsi untuk menghasilkan isi file dump SQL
        $callback = function () use ($dbHost, $dbUsername, $dbPassword, $dbName) {
            $command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName}";

            // Jalankan perintah mysqldump dan kirim output ke response
            $process = proc_open($command, [1 => ['pipe', 'w']], $pipes);

            if (is_resource($process)) {
                while (!feof($pipes[1])) {
                    echo fread($pipes[1], 4096);
                }

                fclose($pipes[1]);
                proc_close($process);
            }
        };

        // Mengembalikan response dengan menggunakan StreamedResponse
        return new StreamedResponse($callback, 200, $headers);
    }
}
