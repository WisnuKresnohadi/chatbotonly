@if ($logbook_week->status == App\Enums\LogbookWeeklyStatus::REJECTED && isset($logbook_week->alasan_tolak))
<div class="text-start" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 15px; margin-right: 10px; height: fit-content !important;">
    <h6>Alasan penolakan logbook :</h6>
    <p class="mb-0">{{ $logbook_week->alasan_tolak }}</p>
</div>
@endif