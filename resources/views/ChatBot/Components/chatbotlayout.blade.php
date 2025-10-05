@section('page_style')
<style>
    .nav-container {
        width: 100%;
        height: 64px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: black;
        padding: 0 16px;
    }
    .button-kembali {
        width: 126px;
        height: 38px;
        border-radius: 6px;
        border-width: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4EA971;
        gap: 8px;
        background-color: white;
        border-color: #4EA971;
        cursor: pointer;
    }
</style>
@endsection

<div class="nav-container"
        style="width: 100%;
        height: 64px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 16px;

        ">

    <button
    class="button-kembali"
    onclick="history.back()"
    style="width: 126px;
        height: 38px;
        border-radius: 6px;
        border-width: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4EA971;
        gap: 8px;
        background-color: white;
        border-color: #4EA971;
        cursor: pointer;

        "
    >
    <i class="fas fa-arrow-left"></i>
        Kembali
    </button>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <div class="flex-row justify-content-center align-self-center gap-2" style="width: 105px; height: 64px;  ">

            <div class="" style="font-size:13px; text-align:center; width:100% ">Waktu Tersisa</div>

            <div class="" style="font-weight:500; font-size:18 px; display:flex; align-items: center; justify-content: center; gap:12px ; border-radius: 8px; padding:8px; background-color:#d4f4e2; color:#4EA971">
                <i class="fa-regular fa-clock"></i>
                <span>60.00</span>
            </div>


    </div>


</div>
