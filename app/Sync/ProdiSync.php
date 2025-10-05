<?php

namespace App\Sync;

use App\Models\ProgramStudi;
use App\Sync\BaseSynchronize;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\File;

class ProdiSync extends BaseSynchronize
{
    public function __construct(array $queryParams = [])
    {
        parent::__construct(env("PATHNAME_PRODI_IGRACIAS"), $queryParams);
    }

    public function processData($dataProdi)
    {
        $configKey = 'igracias.prodi';
        $prodiMapping = config($configKey, []);
        $processedCount = 0;
        $failedCount = 0;

        try {
            DB::beginTransaction();

            foreach ($dataProdi as $prodi) {
                try {
                    $namaProdi = $prodi['namaprodi'];
                    $pos = strpos($namaProdi, ' ');
                    $prodi['namaprodi'] = substr($namaProdi, $pos + 1);
                    $prodi['updated_at'] = Carbon::parse($prodi['updated_at'])->format('Y-m-d H:i:s');

                    $existingProdi = DB::table('program_studi')
                        ->whereRaw("LOWER(namaprodi) = LOWER(?)", [$prodi['namaprodi']])
                        ->whereRaw("LOWER(jenjang) = LOWER(?)", [$prodi['jenjang']])
                        ->first()->id_prodi ?? $prodi['id_prodi'];

                    $prodiIdIgracias = $prodi["id_prodi"];
                    if($existingProdi) {
                        $prodi["id_prodi"] = $existingProdi;
                    }

                    ProgramStudi::updateOrCreate(
                        ['id_prodi' => $prodi["id_prodi"]],
                        [
                            ...$prodi,
                            ...$this->getAdditionalData()
                        ]
                    );

                    $prodi["id_prodi"] = $prodiIdIgracias;
                    $prodiMapping[$prodi['id_prodi']] = $existingProdi;
                    $processedCount++;
                } catch (Exception $e) {
                    // Log individual failures but continue processing
                    logIgracias('error', "Gagal memproses program studi: {$prodi['namaprodi']} - {$e->getMessage()}");
                    $failedCount++;
                }
            }

            // Track success and failure using the logger's state-based methods
            $logger = $this->getLogger();
            $logger->incrementSuccessCount($processedCount);
            if ($failedCount > 0) {
                $logger->incrementErrorCount($failedCount);
            }

            $this->updateProdiMapping($prodiMapping);
            DB::commit();

            logIgracias('info', "Sinkronisasi program studi berhasil: {$processedCount} data berhasil, {$failedCount} data gagal");
            return $processedCount;
        } catch (Exception $e) {
            DB::rollBack();
            $this->getLogger()->logException($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    protected function afterSync()
    {
        logIgracias('info', 'Sinkronisasi program studi telah selesai.');
    }

    /**
     * Update mapping configuration file
     */
    private function updateProdiMapping(array $mapping): void
    {
        $configPath = config_path('igracias.php');

        // Baca seluruh konfigurasi yang ada
        $currentConfig = require $configPath;

        // Update hanya bagian prodi
        $currentConfig['prodi'] = $mapping;

        // Format array menjadi string konfigurasi PHP
        $configContent = "<?php\n\nreturn " .
            var_export($currentConfig, true) .
            ";\n";

        // Perbaiki formatting (optional, untuk readability)
        $configContent = str_replace(
            ['array (', ')', "=> \n    array"],
            ['[', ']', "=> ["],
            $configContent
        );

        File::put($configPath, $configContent);
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }
}
