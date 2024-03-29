<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="styles.css" rel="stylesheet">
</head>
<body>

<header class="header bg-primary text-light">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <a href="index.php" class="logo"><img src="images/logo.png" alt="logo"></a>

      <?php
      try {
        include 'dbconnection.php';
        $select_rows = $pdo->query("SELECT SUM(quantity) FROM `cart`");
        $total_quantity = $select_rows->fetchColumn();
        ?>
        <a href="cart.php" class="cart text-light text-decoration-none"><i class="fa-solid fa-cart-shopping"></i> <sup><?= $total_quantity ?></sup></a>
        <?php
      } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
      }
      ?>
    </div>
  </div>
</header>

</body>
</html>
