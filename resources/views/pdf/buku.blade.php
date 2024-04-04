<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #dddddd;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 200px; /* Sesuaikan lebar gambar */
            height: auto;
        }

        /* Style untuk footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px; /* Sesuaikan ukuran font */
            color: #666; /* Sesuaikan warna font */
            padding: 10px 0; /* Sesuaikan padding */
        }
    </style>
</head>
<body>
    
    <h1>Laporan Buku</h1>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->penulis }}</td>
                    <td>{{ $book->tahun_terbit }}</td>
                    <td>{{ $book->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer dengan tanggal proses -->
    <div class="footer">
        Laporan Buku dicetak pada: {{ now()->format('d F Y H:i:s') }} <!-- Tambahkan informasi tanggal proses -->
    </div>

</body>
</html>
