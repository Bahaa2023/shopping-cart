<?php
include 'dbconnection.php';

// Function to get total quantity of items in the cart
function getTotalQuantity() {
    global $pdo;
    try {
        $total_quantity = 0;
        $select_cart = $pdo->query("SELECT SUM(quantity) as total FROM `cart`");
        $row = $select_cart->fetch(PDO::FETCH_ASSOC);
        $total_quantity = $row['total'];
        return $total_quantity;
    } catch (PDOException $e) {
        // Handle error
        return 0;
    }
}

// Initialize message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   try {
      // Check if the product is already in the cart
      $select_cart = $pdo->prepare("SELECT * FROM `cart` WHERE name = :product_name");
      $select_cart->bindParam(':product_name', $product_name);
      $select_cart->execute();

      if($select_cart->rowCount() > 0){
         // If product already exists in cart, update the quantity
         $row = $select_cart->fetch(PDO::FETCH_ASSOC);
         $updated_quantity = $row['quantity'] + 1;

         $update_quantity = $pdo->prepare("UPDATE `cart` SET quantity = :updated_quantity WHERE name = :product_name");
         $update_quantity->bindParam(':updated_quantity', $updated_quantity);
         $update_quantity->bindParam(':product_name', $product_name);
         $update_quantity->execute();

         // Set success message
         $message = '<div class="message alert alert-success alert-dismissible fade show text-center fw-bold fs-5" role="alert" style="margin-bottom: 0;">
            <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> Your item has been added to the cart
            </div>';

      } else {
         // If product is not in cart, insert it with quantity 1
         $product_quantity = 1;
         $insert_product = $pdo->prepare("INSERT INTO `cart` (name, price, image, quantity) VALUES (:product_name, :product_price, :product_image, :product_quantity)");
         $insert_product->bindParam(':product_name', $product_name);
         $insert_product->bindParam(':product_price', $product_price);
         $insert_product->bindParam(':product_image', $product_image);
         $insert_product->bindParam(':product_quantity', $product_quantity);
         $insert_product->execute();

         // Set success message
         $message = '<div class="message alert alert-success alert-dismissible fade show text-center fw-bold fs-5" role="alert" style="margin-bottom: 0;">
            <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> Your item has been added to the cart
            </div>';
      }
   } catch (PDOException $e) {
      // Set error message if insertion fails
      $message = 'Error: ' . $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Fast Food Restaurant</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include 'header.php';
?>

<div class="message-container">
   <!-- Display message -->
   <?php echo $message; ?>
</div>

<div class="container">
   <section class="products">
      <h1 class="heading text-center mt-5 mb-3">Our Menu</h1>
      <div class="row">
         <?php
         try {
            $select_products = $pdo->query("SELECT * FROM `products`");
            if($select_products->rowCount() > 0){
               while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
         ?>
         <form action="index.php" method="post" class="col-lg-4 col-md-6 mb-4">
            <div class="card d-flex flex-column justify-content-center">
               <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" class="card-img-top" alt="">
               <div class="card-body text-center">
                  <h3 class="card-title"><?php echo $fetch_product['name']; ?></h3>
                  <div class="price">$<?php echo $fetch_product['price']; ?></div>
                  <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                  <input type="submit" class="btn btn-primary mx-auto mt-3" value="Add to Cart">
               </div>
            </div>
         </form>
         <?php
               }
            }
         } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
         }
         ?>
      </div>
   </section>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

