---------------------- Sinkronisasi data Mahasiswa Dimulai ----------------------
batch_id: 123456
error : false,
code : 200,
message : Data mahasiswa berhasil diambil.,
paginate : {
    current_page : 1,
    last_page : 443,
    per_page : 10,
    total : 4428
}
//berhasil
Mengambil data [nama sinkronisasi] pada page 2
error : false,
code : 200
message : Data mahasiswa berhasil diambil.,
total data page 2 : 10

//gagal
Pengulangan pengambilan data [nama sinkronisasi] ke 2 pada page 3
error: true
code: 500
message: Timeout error


Exception lain terjadi pada page 5
error: Unexpected token

status: GAGAL
detail error page:
[
    1: [
        page: 3,
        id_job: 123456,
        error: "Timeout error"
    ]
]
total data: 4428
total data berhasil: 4410
total data gagal: 18
---------------------- End Of Sinkronisasi data Mahasiswa ----------------------
