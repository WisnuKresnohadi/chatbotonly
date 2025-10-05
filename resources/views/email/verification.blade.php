<html>
<body>
    <h2>Verifikasi Email</h2>
    <p>Klik tautan di bawah ini untuk memverifikasi alamat email Anda:</p>
    <a href="{{ route('verification.verify', $user) }}">Verifikasi Email</a>
    <p>Jika Anda belum memiliki kata sandi, Anda dapat menetapkannya di <a href="{{ route('password.reset', $user) }}">halaman set ulang kata sandi</a>.</p>
</body>
</html>