<?php
session_start();
// Basic database connection setup
$conn = new mysqli("localhost", "root", "", "sweet_crumbs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect to login if user is not logged in (assuming 'user_id' session exists)
if (!isset($_SESSION['user_id'])) {
    // Demo fallback: using sample user_id 1 for testing if no session exists
    $user_id = 1; 
} else {
    $user_id = $_SESSION['user_id'];
}

// Fetch user profile data
$user_query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $user_query->fetch_assoc();

// Fetch user orders
$orders_query = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Panel | Sweet Crumbs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<!-- Customer Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">🍰 Sweet Crumbs</a>
    <div class="d-flex align-items-center gap-3">
      <span class="text-light">Welcome, <strong><?php echo htmlspecialchars($user['name'] ?? 'Customer'); ?></strong></span>
      <a href="index.php" class="btn btn-outline-light btn-sm">Shop Cakes</a>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="row g-4">
    <!-- User Profile Card -->
    <div class="col-md-4">
      <div class="card p-4 shadow-sm border-0 rounded-3">
        <h4 class="mb-3">👤 My Profile</h4>
        <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></p>
        <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></p>
        <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Active Customer</span></p>
      </div>
    </div>

    <!-- Orders Table -->
    <div class="col-md-8">
      <div class="card p-4 shadow-sm border-0 rounded-3">
        <h4 class="mb-3">📦 My Order History</h4>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Order #</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($orders_query && $orders_query->num_rows > 0): ?>
                <?php while($order = $orders_query->fetch_assoc()): ?>
                  <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td>₱<?php echo number_format($order['total_price'] ?? 0, 2); ?></td>
                    <td><?php echo $order['created_at'] ?? date('Y-m-d'); ?></td>
                    <td>
                      <span class="badge bg-primary"><?php echo ucfirst($order['status'] ?? 'Pending'); ?></span>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted py-3">No orders found yet. Start shopping!</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
