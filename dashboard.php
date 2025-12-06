<?php
session_start();
if (!isset($_SESSION['hr_logged_in']) || $_SESSION['hr_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$dataFile = "data.json";
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Penerima Data</title>
  <style>
    :root {
      --dark-primary: #2c3e50;
      --light-bg: #f4f6f9;
      --success: #27ae60;
      --danger: #c0392b;
      --warning: #e67e22;
      --info: #3498db;
      --muted: #bdc3c7;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      background-color: var(--light-bg);
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background-color: var(--dark-primary);
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 12px;
      margin-bottom: 10px;
      border-radius: 6px;
      transition: background 0.3s;
      cursor: pointer;
    }
    .sidebar a:hover { background-color: #34495e; }

    /* Main */
    .main {
      margin-left: 260px;
      padding: 30px;
      flex: 1;
    }
    .dashboard-header {
      background: linear-gradient(135deg, #2c3e50, #34495e);
      color: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .dashboard-header h1 {
      margin: 0;
      font-size: 24px;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 14px;
      border-bottom: 1px solid #eee;
      text-align: left;
      vertical-align: top;
    }
    th {
      background-color: var(--dark-primary);
      color: white;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.5px;
    }
    tr:hover { background-color: #fafafa; }

    /* Status badge */
    .status {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }
    .status-menunggu { background: var(--muted); color: #2c3e50; }
    .status-diterima { background: var(--success); color: white; }
    .status-ditolak { background: var(--danger); color: white; }

    /* Document chip */
    .doc-link {
      display: inline-block;
      margin: 2px 4px 2px 0;
      padding: 5px 10px;
      background: #ecf0f1;
      border-radius: 16px;
      text-decoration: none;
      color: #2c3e50;
      font-size: 13px;
      transition: all 0.3s ease;
    }
    .doc-link:hover {
      background: var(--info);
      color: white;
    }

    /* Buttons */
    .btn-accept, .btn-reject, .btn-delete {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      color: white;
      margin-right: 5px;
    }
    .btn-accept { background-color: var(--success); }
    .btn-accept:hover { background-color: #2ecc71; }
    .btn-reject { background-color: var(--danger); }
    .btn-reject:hover { background-color: #e74c3c; }
    .btn-delete { background-color: var(--warning); }
    .btn-delete:hover { background-color: #d35400; }

    .section { display: none; }
    .section.active { display: block; }
  </style>
</head>
<body>

<div class="sidebar">
  <h2>Dashboard</h2>
  <a onclick="showSection('masuk')">Data Masuk</a>
  <a onclick="showSection('diterima')">Data Diterima</a>
  <a onclick="showSection('ditolak')">Data Ditolak</a>
  <a href="logout.php">Logout</a>
</div>

<div class="main">
  <!-- Data Masuk -->
  <div id="masuk" class="section active">
    <div class="dashboard-header">
      <h1>📋 Data Pelamar Masuk</h1>
    </div>

    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Dokumen</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        function renderFiles($files, $label) {
          if (is_array($files)) {
            foreach ($files as $i => $file) {
              echo "<a href='$file' target='_blank' class='doc-link'>$label ".($i+1)."</a><br>";
            }
          } elseif (!empty($files)) {
            echo "<a href='$files' target='_blank' class='doc-link'>$label</a>";
          } else {
            echo "-";
          }
        }

        $dataFile = "data.json";
        $data = [];
        if (file_exists($dataFile)) {
          $data = json_decode(file_get_contents($dataFile), true);
          foreach ($data as $index => $row) {
            $statusClass = strtolower($row['status']);
            echo "<tr>
              <td>{$row['fullname']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone']}</td>
              <td>";
                renderFiles($row['cv'], 'CV');
                renderFiles($row['application_letter'], 'Application Letter');
                renderFiles($row['resume'], 'Resume');
                renderFiles($row['degree'], 'Degree');
                renderFiles($row['certificates'], 'Certificate');
            echo "</td>
              <td><span class='status status-{$statusClass}'>{$row['status']}</span></td>
              <td>
                <button class='btn-accept' data-index='{$index}'>Terima</button>
                <button class='btn-reject' data-index='{$index}'>Tolak</button>
                <button class='btn-delete' data-index='{$index}'>Hapus</button>
              </td>
            </tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Data Diterima -->
  <div id="diterima" class="section">
    <h1>Data Diterima</h1>
    <table>
      <thead>
        <tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Dokumen</th></tr>
      </thead>
      <tbody>
        <?php
        if (!empty($data)) {
          foreach ($data as $row) {
            if ($row['status'] === 'Diterima') {
              echo "<tr>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>";
                  renderFiles($row['cv'], 'CV');
                  renderFiles($row['application_letter'], 'Application Letter');
                  renderFiles($row['resume'], 'Resume');
                  renderFiles($row['degree'], 'Degree');
                  renderFiles($row['certificates'], 'Certificate');
              echo "</td>
              </tr>";
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Data Ditolak -->
  <div id="ditolak" class="section">
    <h1>Data Ditolak</h1>
    <table>
      <thead>
        <tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Dokumen</th></tr>
      </thead>
      <tbody>
        <?php
        if (!empty($data)) {
          foreach ($data as $row) {
            if ($row['status'] === 'Ditolak') {
              echo "<tr>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>";
                renderFiles($row['cv'], 'CV');
                renderFiles($row['application_letter'], 'Application Letter');
                renderFiles($row['resume'], 'Resume');
                renderFiles($row['degree'], 'Degree');
                renderFiles($row['certificates'], 'Certificate');
            echo "</td>
            </tr>";
          } // tutup if
        } // tutup foreach
      } // tutup if !empty
      ?>
    </tbody>
  </table>
</div>

<script>
window.onload = function() {
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', () => deleteData(btn.dataset.index));
  });
  document.querySelectorAll('.btn-accept').forEach(btn => {
    btn.addEventListener('click', () => updateStatus(btn.dataset.index, 'Diterima'));
  });
  document.querySelectorAll('.btn-reject').forEach(btn => {
    btn.addEventListener('click', () => updateStatus(btn.dataset.index, 'Ditolak'));
  });
};

function updateStatus(index, status) {
  fetch('update_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'index=' + index + '&status=' + status
  })
  .then(res => res.text())
  .then(res => {
    if (res === 'OK') location.reload();
    else alert('Gagal update status');
  });
}

function deleteData(index) {
  if (confirm("Yakin mau hapus data ini?")) {
    fetch('delete_data.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'index=' + index
    })
    .then(res => res.text())
    .then(res => {
      if (res === 'OK') location.reload();
      else alert('Gagal hapus data');
    });
  }
}

function showSection(id) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
}

</script>
</body>
</html>