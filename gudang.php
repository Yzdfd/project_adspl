<?php
include 'config.php';

// Proses tambah barang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'tambah') {
        $name = htmlspecialchars($_POST['name']);
        $stock = intval($_POST['stock']);
        
        if (!empty($name) && $stock >= 0) {
            $sql = "INSERT INTO products (name, stock) VALUES ('$name', $stock)";
            if ($conn->query($sql) === TRUE) {
                $pesan_sukses = "✓ Barang '$name' berhasil ditambahkan dengan stock $stock";
            } else {
                $pesan_error = "✗ Error: " . $conn->error;
            }
        } else {
            $pesan_error = "✗ Nama barang dan stock tidak boleh kosong!";
        }
    }
    
    if ($action == 'update') {
        $id = intval($_POST['id']);
        $stock = intval($_POST['stock']);
        
        $sql = "UPDATE products SET stock = $stock WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $pesan_sukses = "✓ Stock barang berhasil diperbarui";
        } else {
            $pesan_error = "✗ Error: " . $conn->error;
        }
    }
    
    if ($action == 'hapus') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM products WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $pesan_sukses = "✓ Barang berhasil dihapus";
        } else {
            $pesan_error = "✗ Error: " . $conn->error;
        }
    }
}

// Ambil semua barang
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gudang - Manajemen Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 32px;
            margin-bottom: 5px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .content {
            padding: 30px;
        }
        
        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }
        
        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 15px;
            align-items: center;
        }
        
        .form-group label {
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-danger {
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            font-size: 12px;
        }
        
        .btn-danger:hover {
            background: #ee5a52;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .table-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #667eea;
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .stock-low {
            color: #ff6b6b;
            font-weight: 600;
        }
        
        .stock-ok {
            color: #51cf66;
            font-weight: 600;
        }
        
        .action-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .action-form input {
            width: 70px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }
        
        .action-form button {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        @media (max-width: 768px) {
            .form-group {
                grid-template-columns: 1fr;
            }
            
            .action-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 GUDANG</h1>
            <p>Sistem Manajemen Stok Barang</p>
        </div>
        
        <div class="content">
            <?php if (isset($pesan_sukses)): ?>
                <div class="alert alert-success"><?php echo $pesan_sukses; ?></div>
            <?php endif; ?>
            
            <?php if (isset($pesan_error)): ?>
                <div class="alert alert-error"><?php echo $pesan_error; ?></div>
            <?php endif; ?>
            
            <!-- Form Input Barang -->
            <div class="form-section">
                <h2>➕ Tambah Barang Baru</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="tambah">
                    <div class="form-group">
                        <label>Nama Barang:</label>
                        <input type="text" name="name" placeholder="Contoh: Laptop, Mouse, Keyboard" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Stock:</label>
                        <input type="number" name="stock" placeholder="0" value="0" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Barang</button>
                </form>
            </div>
            
            <!-- Tabel Daftar Barang -->
            <div class="table-section">
                <h2>📋 Daftar Barang</h2>
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Stock Saat Ini</th>
                                    <th>Status</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($row = $result->fetch_assoc()): 
                                    $status = $row['stock'] > 10 ? 'Aman' : ($row['stock'] > 0 ? 'Menipis' : 'Habis');
                                    $status_class = $row['stock'] > 10 ? 'stock-ok' : 'stock-low';
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['stock']; ?></td>
                                        <td class="<?php echo $status_class; ?>"><?php echo $status; ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($row['updated_at'])); ?></td>
                                        <td>
                                            <form method="POST" class="action-form" style="display: flex; gap: 5px;">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="number" name="stock" value="<?php echo $row['stock']; ?>" min="0">
                                                <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Update</button>
                                                <button type="submit" formaction="javascript:void(0);" class="btn btn-danger" onclick="return confirm('Yakin hapus barang ini?') && fetch('', {method: 'POST', body: new FormData(Object.assign(new FormData(this.closest('form')), {entries: [...Object.entries({'action': 'hapus'})]})}); return false;">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-message">
                        <p>📭 Belum ada barang. Silakan tambahkan barang baru!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Konfirmasi sebelum hapus
        document.querySelectorAll('.btn-danger').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Yakin ingin menghapus barang ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
