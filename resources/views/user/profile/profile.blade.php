<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - PharmaPlus</title>
</head>
<body>
    <h1>My Profile</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    {{-- kamu bisa tambahkan phone, role, dll kalau tabel users punya --}}
</body>
</html>
