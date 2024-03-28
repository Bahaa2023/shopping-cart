<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z5vE73LF+7kEjPhA6Ad/Bm4flX+eLkyJ8g5fww" crossorigin="anonymous">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container">

        <section class="shopping-cart">

            <h1 class="heading mt-5 mb-5 text-center">Shopping Cart</h1>

            <div class="table-responsive bg-light">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include 'cart_actions.php';

                        $grand_total = 0;
                        try {
                            $select_cart = $pdo->query("SELECT * FROM `cart`");
                            if ($select_cart->rowCount() > 0) {
                                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                                    $grand_total += $sub_total;
                        ?>

                                    <tr>
                                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                                        <td><?php echo $fetch_cart['name']; ?></td>
                                        <td>$<?php echo number_format($fetch_cart['price']); ?></td>
                                        <td>
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                                <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </td>
                                        <td>$<?php echo number_format($sub_total); ?></td>
                                        <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="btn btn-danger"> <i class="fas fa-trash"></i> Remove</a></td>
                                    </tr>
                        <?php
                                }
                            }
                        } catch (PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                        ?>

                        <tr class="table-bottom">
                            <td colspan="3"></td>
                            <td class="fw-bold fs-5">Grand Total</td>
                            <td>$<?php echo number_format($grand_total); ?></td>
                            <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="btn btn-danger"> <i class="fas fa-trash"></i> Delete All </a></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="checkout-btn text-center mb-2">
              <a href="index.php" class="btn btn-warning">Continue Shopping</a>
              <a href="#" class="btn <?= ($grand_total > 1) ? 'btn-primary' : 'btn-secondary disabled'; ?>">Proceed to Checkout</a>    
            </div>

        </section>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-Nu4PPeYBbh7qgko0rVD1zDq4JC0NRpbrxFbzQQv9v9Bh7pyq2U5PrUq8NY3Fhj3H" crossorigin="anonymous"></script>
    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
