<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';


$query = mysqli_query($koneksi, "SELECT * FROM komentar ORDER BY tanggal DESC");


?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Komentar - Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #4cc9f0;
      --danger: #f72585;
      --warning: #f8961e;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      padding: 20px;
      margin: 0;
    }
    
    .admin-container {
      max-width: 1000px;
      margin: 30px auto;
    }
    
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    
    .admin-title {
      color: var(--dark);
      font-size: 28px;
      font-weight: 700;
      margin: 0;
    }
    
    .comment-count {
      background: var(--primary);
      color: white;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
    }
    
    .admin-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }
    
    .comment-list {
      padding: 0;
      margin: 0;
      list-style: none;
    }
    
    .comment-item {
      padding: 20px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    
    .comment-item:hover {
      background: rgba(67, 97, 238, 0.03);
    }
    
    .comment-item:last-child {
      border-bottom: none;
    }
    
    .comment-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    
    .comment-user {
      display: flex;
      align-items: center;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    .user-info {
      line-height: 1.3;
    }
    
    .comment-name {
      font-weight: 600;
      color: var(--dark);
      font-size: 16px;
    }
    
    .comment-email {
      font-size: 13px;
      color: #6c757d;
    }
    
    .comment-date {
      font-size: 12px;
      color: #adb5bd;
      font-weight: 500;
    }
    
    .comment-message {
      padding: 12px 0 0 52px;
      color: #495057;
      line-height: 1.5;
      white-space: pre-wrap;
    }
    
    .comment-actions {
      display: flex;
      gap: 10px;
      padding-top: 10px;
      padding-left: 52px;
    }
    
    .action-btn {
      border: none;
      background: none;
      cursor: pointer;
      padding: 5px 10px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 500;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .reply-btn {
      color: var(--primary);
      background: rgba(67, 97, 238, 0.1);
    }
    
    .reply-btn:hover {
      background: rgba(67, 97, 238, 0.2);
    }
    
    .delete-btn {
      color: var(--danger);
      background: rgba(247, 37, 133, 0.1);
    }
    
    .delete-btn:hover {
      background: rgba(247, 37, 133, 0.2);
    }
    
    .empty-state {
      text-align: center;
      padding: 50px 20px;
    }
    
    .empty-icon {
      font-size: 60px;
      color: #dee2e6;
      margin-bottom: 20px;
    }
    
    .empty-text {
      color: #6c757d;
      font-size: 16px;
      margin-bottom: 20px;
    }
    
    .search-box {
      margin-bottom: 20px;
      position: relative;
    }
    
    .search-input {
      width: 100%;
      padding: 12px 20px 12px 45px;
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      font-size: 14px;
      transition: all 0.3s;
    }
    
    .search-input:focus {
      outline: none;
      box-shadow: 0 2px 15px rgba(67, 97, 238, 0.2);
    }
    
    .search-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
    }
    
    @media (max-width: 768px) {
      .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      
      .comment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      
      .comment-date {
        margin-left: 52px;
      }
    }
  </style>
</head>
<body>

  <div class="admin-container">
    <div class="admin-header">
      <h1 class="admin-title">Komentar Pelanggan</h1>
      <span class="comment-count">
        <?= mysqli_num_rows($query) ?> Komentar
      </span>
    </div>
  
    <div class="admin-card">
      <?php if (mysqli_num_rows($query) > 0): ?>
        <ul class="comment-list">
          <?php while ($row = mysqli_fetch_assoc($query)): 
            $initial = strtoupper(substr($row['nama'], 0, 1));
          ?>
            <li class="comment-item">
              <div class="comment-header">
                <div class="comment-user">
                  <div class="user-avatar"><?= $initial ?></div>
                  <div class="user-info">
                    <div class="comment-name"><?= htmlspecialchars($row['nama']) ?></div>
                    <div class="comment-email"><?= htmlspecialchars($row['email']) ?></div>
                  </div>
                </div>
                <?php
                if (!empty($row['tanggal']) && $row['tanggal'] != '0000-00-00 00:00:00') {
                echo date('d M Y H:i', strtotime($row['tanggal']));
                } else {
                echo 'Belum ada tanggal';
                }
                  ?>

              </div>
              <div class="comment-message"><?= nl2br(htmlspecialchars($row['pesan'])) ?></div>
              <div class="comment-actions">
               <form method="POST" action="balasan_pesan.php" style="display: inline;">
               <input type="hidden" name="id" value="<?= $row['id'] ?>">
               <button type="submit" class="action-btn reply-btn">
                <i class="fas fa-reply"></i> Balas
               </button>
              </form>

           <form method="POST" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
           <input type="hidden" name="id" value="<?= $row['id'] ?>">
           <button type="submit" class="btn btn-danger">🗑 Hapus</button>
           </form>


              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <div class="empty-state">
          <div class="empty-icon">
            <i class="far fa-comment-dots"></i>
          </div>
          <div class="empty-text">Belum ada komentar dari pelanggan</div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    // Basic search functionality
    document.querySelector('.search-input').addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      const comments = document.querySelectorAll('.comment-item');
      
      comments.forEach(comment => {
        const text = comment.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          comment.style.display = '';
        } else {
          comment.style.display = 'none';
        }
      });
    });
    
    // Add click handlers for buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
          // Here you would typically make an AJAX call to delete the comment
          this.closest('.comment-item').style.opacity = '0.5';
          // In a real implementation, you would remove the element after successful deletion
        }
      });
    });
    
    document.querySelectorAll('.reply-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const email = this.closest('.comment-item').querySelector('.comment-email').textContent;
        prompt(`Balas ke: ${email}`, 'Tulis balasan Anda di sini...');
      });
    });
  </script>

</body>
</html>