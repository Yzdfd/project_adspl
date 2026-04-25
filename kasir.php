<?php
include 'config.php';

// Proses pakai barang (pengurangan stock)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'pakai') {
        $id = intval($_POST['id']);
        $jumlah = intval($_POST['jumlah']);
        
        // Cek stock terlebih dahulu
        $check = $conn->query("SELECT stock FROM products WHERE id = $id");
        $row = $check->fetch_assoc();
        
        if ($row['stock'] >= $jumlah && $jumlah > 0) {
            $stock_baru = $row['stock'] - $jumlah;
            $sql = "UPDATE products SET stock = $stock_baru WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $pesan_sukses = "✓ Barang berhasil dipakai! Stock berkurang $jumlah unit";
            } else {
                $pesan_error = "✗ Error: " . $conn->error;
            }
        } else {
            $pesan_error = "✗ Stock tidak cukup! Stock tersedia hanya " . $row['stock'] . " unit";
        }
    }
}

// Ambil semua barang
$result = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Penggunaan Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        
        .section-title {
            color: #333;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 600;
        }
        
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.2);
            border-color: #f5576c;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            flex: 1;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-safe {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .stock-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #f5576c;
        }
        
        .stock-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        
        .stock-number {
            font-size: 24px;
            font-weight: 700;
            color: #f5576c;
        }
        
        .form-group {
            margin-bottom: 12px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
            font-size: 13px;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #f5576c;
            box-shadow: 0 0 5px rgba(245, 87, 108, 0.2);
        }
        
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);
        }
        
        .btn-primary:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .empty-message {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-message p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .table-section {
            margin-top: 30px;
            border-top: 2px solid #f0f0f0;
            padding-top: 30px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f5f5f5;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #555;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .table-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .table-form input {
            width: 80px;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }
        
        .table-form button {
            padding: 6px 12px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .table-form button:hover {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
            
            .table-form {
                flex-direction: column;
            }
            
            .table-form input,
            .table-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💳 KASIR</h1>
            <p>Sistem Penggunaan & Pengurangan Stok Barang</p>
        </div>
        
        <div class="content">
            <?php if (isset($pesan_sukses)): ?>
                <div class="alert alert-success"><?php echo $pesan_sukses; ?></div>
            <?php endif; ?>
            
            <?php if (isset($pesan_error)): ?>
                <div class="alert alert-error"><?php echo $pesan_error; ?></div>
            <?php endif; ?>
            
            <!-- View Barang dalam Card -->
            <h2 class="section-title">📦 Barang Tersedia</h2>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="grid-container">
                    <?php 
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()): 
                        $status = $row['stock'] > 10 ? 'Aman' : ($row['stock'] > 0 ? 'Menipis' : 'Habis');
                        $badge_class = $row['stock'] > 10 ? 'badge-safe' : ($row['stock'] > 0 ? 'badge-warning' : 'badge-danger');
                    ?>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><?php echo $row['name']; ?></div>
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            </div>
                            
                            <div class="stock-info">
                                <p>Stock Tersedia:</p>
                                <p class="stock-number"><?php echo $row['stock']; ?></p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="action" value="pakai">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                
                                <div class="form-group">
                                    <label>Jumlah Pakai:</label>
                                    <input type="number" name="jumlah" placeholder="Masukkan jumlah" value="1" min="1" max="<?php echo $row['stock']; ?>" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary" <?php echo $row['stock'] == 0 ? 'disabled' : ''; ?>>
                                    🛒 Pakai Barang
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-message">
                    <p>📭 Belum ada barang di gudang</p>
                    <p style="font-size: 14px; color: #bbb;">Silakan tambahkan barang melalui halaman gudang terlebih dahulu</p>
                </div>
            <?php endif; ?>
            
            <!-- Tabel View Alternatif -->
            <?php if ($result->num_rows > 0): ?>
                <div class="table-section">
                    <h2 class="section-title">📋 Daftar Barang (Tampilan Tabel)</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Pakai Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $result->data_seek(0);
                                $no = 1;
                                while ($row = $result->fetch_assoc()): 
                                    $status = $row['stock'] > 10 ? 'Aman' : ($row['stock'] > 0 ? 'Menipis' : 'Habis');
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><strong><?php echo $row['stock']; ?></strong></td>
                                        <td><?php echo $status; ?></td>
                                        <td>
                                            <form method="POST" class="table-form">
                                                <input type="hidden" name="action" value="pakai">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="number" name="jumlah" value="1" min="1" max="<?php echo $row['stock']; ?>" required>
                                                <button type="submit" <?php echo $row['stock'] == 0 ? 'disabled' : ''; ?>>Pakai</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
