<?php
    use Illuminate\Support\Facades\Log;

    function uangSakuRupiah($jumlah){
        if($jumlah != null){
            return "Rp. ".number_format($jumlah, 2, ",", ".");
        }else{
            return 'Tidak Diberi Uang Saku';
        }
    }

    function tahunAjaranMaker() {
        $tahun_akademik = App\Models\TahunAkademik::orderBy('tahun', 'desc')->orderByRaw("CASE WHEN semester = 'Ganjil' THEN 2 WHEN semester = 'Genap' THEN 1 ELSE 0 END")->get();


        $option = '';
        foreach ($tahun_akademik as $key => $value) {
            $option .= '<option value="'.$value->id_year_akademik.'" '.($value->status == 1 ? 'selected' : '').'>' .$value->tahun. ' '.$value->semester.'</option>';
        }
        return $option;
    }

    function logIgracias(string $level, string $message, array $context = []): void
    {
        Log::channel('igracias')->$level($message, $context);
    }
?>
