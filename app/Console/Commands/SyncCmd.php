<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessSyncJob;
use App\Models\ProgramStudi;
use Exception;

class SyncCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync {--class= : Class name for sync} {--force : Force sync without lock}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run data synchronization job.';

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help = <<<HELP
Run data synchronization jobs. By default, the command will sync all classes unless a specific class is specified with the --class option.

Options:
  --class[=CLASS]        Specify the sync class to run (default: "All").
                         Valid options include: "ProdiSync", "DosenSync", "MhsSync", "MkSync", and "NilaiAkhirMhsSync".
                         If "All" is selected, all sync classes will be processed.

  --force                Force sync without checking for an existing lock.
                         Use this option to run the sync immediately, even if another sync is already in progress.

Examples:
  php artisan sync                   Runs synchronization for all classes, with a default lock to prevent overlapping.
  php artisan sync --class=MhsSync    Runs synchronization only for the MhsSync class, with the default lock behavior.
  php artisan sync --force            Runs synchronization for all classes, overriding the lock to allow immediate processing.
  php artisan sync --class=MkSync --force
                                      Runs synchronization for the MkSync class immediately, bypassing any existing lock.

Details:
  This command dispatches a job for each synchronization class. If the "All" option is chosen, the command iterates through all
  specified classes and executes each sync job, partitioned by program of study (Prodi) when applicable.
  
  A cache-based lock is used to prevent overlapping jobs. The lock lasts 5 minutes by default. The --force option can override this lock.
HELP;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $syncClass = $this->option('class') ?? 'All';
            $force = $this->option('force');
            $lockKey = $syncClass === 'All' ? 'sync-lock' : "sync-lock-{$syncClass}";
            $lock = Cache::lock($lockKey, 300); // 5-minute lock duration

            // Global lock check when "All" is selected
            if (($syncClass === 'All' && !$force && Cache::has('sync-lock')) ||
                (!$force && !$lock->get())
            ) {
                $this->warn("Another sync process is already running. Try again later.");
                return;
            }

            // Sync specific class or all classes    
                
            $syncAll = ["ProdiSync", "DosenSync"];
            $syncByProdi = ["MhsSync", "MkSync", "NilaiAkhirMhsSync"];
            if ($syncClass === 'All') {
                $syncClasses = array_merge($syncAll, $syncByProdi);
                foreach ($syncClasses as $class) {                    
                    if (in_array($class, $syncByProdi)) {
                        $dataProdi = ProgramStudi::all()->pluck('id_prodi');                        
                        foreach ($dataProdi as $prodi) {
                            $this->dispatchSyncJob($class, ["limit" => 500, "id_prodi" => $prodi]);
                        }      
                        $this->info("ProcessSyncJob dispatched for {$class}.");                  
                    } else {                                               
                        $this->dispatchSyncJob($class, $queryParams = ["limit" => 500], false);                        
                    }
                }
            } else {
                if (in_array($syncClass, [$syncByProdi])) {
                    $dataProdi = ProgramStudi::all()->pluck('id_prodi');

                    foreach ($dataProdi as $prodi) {
                        $this->dispatchSyncJob($syncClass, ["limit" => 500, "id_prodi" => $prodi]);
                    }
                } else {
                    $this->dispatchSyncJob($syncClass, $queryParams = ["limit" => 500], false);
                }
            }

            $this->info("Synchronization started for {$syncClass}.");
            Log::info("Synchronization started for {$syncClass}.");
        } catch (Exception $e) {
            Log::error("SyncCmd Error: " . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Dispatch sync job.
     *
     * @param string $class
     */
    protected function dispatchSyncJob(string $class, $queryParams = ["limit" => 500], $job = true)
    {
        $syncClass = "App\\Sync\\{$class}";

        if (!$class) {
            Cache::lock("sync-lock-{$class}")->release();
            throw new Exception("Class must be filled");
        }

        if (!class_exists($syncClass)) {
            Cache::lock("sync-lock-{$class}")->release();
            throw new Exception("Class {$syncClass} not found.");
        }

        if($job) {
            ProcessSyncJob::dispatch(new $syncClass($queryParams));            
            return;
        }

        $this->info("ProcessSyncJob start for {$class}.");
        $syncInstance = new $syncClass($queryParams);             
        $syncInstance->synchronize();
        $this->info("ProcessSyncJob succesfully for {$class}.");
    }
}
