<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    // Use mysqldump from system path or configured path
    $mysqldumpPath = env('MYSQLDUMP_PATH', 'mysqldump');

    $timestamp = now()->format('Y-m-d__H-i-s');
    $sqlFilename = "backup-{$timestamp}.sql";
    $zipFilename = "backup-{$timestamp}.zip";

    $sqlPath = storage_path("app/backup/{$sqlFilename}");
    $zipPath = storage_path("app/backup/{$zipFilename}");

    // Build mysqldump command
    $commandDump = "\"{$mysqldumpPath}\" --user=" . env('DB_USERNAME') .
        " --password=" . env('DB_PASSWORD') .
        " --host=" . env('DB_HOST') .
        " " . env('DB_DATABASE') .
        " > \"{$sqlPath}\"";

    // Run dump
    exec($commandDump, $outputDump, $returnVarDump);

    if ($returnVarDump !== 0) {
        $this->error("Database dump failed.");
        return;
    }

    // Build zip command
    $commandZip = $isWindows
        ? "powershell Compress-Archive -Path \"{$sqlPath}\" -DestinationPath \"{$zipPath}\""
        : "zip -j \"{$zipPath}\" \"{$sqlPath}\"";

    exec($commandZip, $outputZip, $returnVarZip);

    if ($returnVarZip === 0) {
        unlink($sqlPath); // Clean up uncompressed file
        $this->info("Backup created: {$zipPath}");
    } else {
        $this->error("Compression failed.");
    }
}

}
