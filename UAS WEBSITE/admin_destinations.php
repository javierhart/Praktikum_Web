<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['add_destination'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $activities = mysqli_real_escape_string($conn, $_POST['activities']);
    $tips = mysqli_real_escape_string($conn, $_POST['tips']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']); // Added line for type
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_destination_name = mysqli_query($conn, "SELECT name FROM `destinations` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_destination_name) > 0) {
        $message[] = 'Destination name already exists!';
    } else {
        // Updated query to include 'location', 'price', and 'type'
        $insert_destination = mysqli_query($conn, "INSERT INTO `destinations` (name, description, activities, tips, location, price, type, image) VALUES ('$name', '$description', '$activities', '$tips', '$location', '$price', '$type', '$image')") or die('query failed');

        if ($insert_destination) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Destination added successfully!';
            }
        }
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `destinations` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `destinations` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_destinations.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Destination</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Link to your admin CSS file -->
    <link rel="stylesheet" href="admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">

    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add Destination</h3>
        <input type="text" class="box" required placeholder="Add Travel" name="name">
        <textarea name="description" class="box" required placeholder="Enter a tourist destination description" cols="30" rows="5"></textarea>
        <textarea name="activities" class="box" required placeholder="Enter activities for tourists" cols="30" rows="5"></textarea>
        <textarea name="tips" class="box" required placeholder="Enter tips for tourists" cols="30" rows="5"></textarea>
        <!-- Added location input field -->
        <input type="text" class="box" required placeholder="Enter location" name="location">
        <!-- Added price input field -->
        <input type="number" class="box" required placeholder="Enter price" name="price">
        <!-- Added type input field as a select dropdown -->
        <select name="type" class="box" required>
            <option value="" disabled selected>Select Type</option>
            <option value="destination">Destination</option>
            <option value="hotel">Hotel</option>
            <option value="dining">Dining</option>
            <option value="store">store</option>
        </select>
        <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
        <input type="submit" value="Add Destination" name="add_destination" class="btn">
    </form>

</section>

<section class="show-products">

    <div class="box-container">

    <?php
    $select_destinations = mysqli_query($conn, "SELECT * FROM `destinations`") or die('query failed');
    if (mysqli_num_rows($select_destinations) > 0) {
        while ($fetch_destinations = mysqli_fetch_assoc($select_destinations)) {
    ?>
        <div class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch_destinations['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_destinations['name']; ?></div>
            <a href="admin_destinations.php?delete=<?php echo $fetch_destinations['id']; ?>" class="delete-btn" onclick="return confirm('Delete this destination?');">Delete</a>
            <a href="admin_update_product.php?update=<?php echo $fetch_destinations['id']; ?>" class="option-btn">Update</a>
        </div>

    <?php
        }
    } else {
        echo '<p class="empty">No destinations added yet!</p>';
    }
    ?>
    </div>
   
</section>

<script src="js/admin_script.js"></script>

</body>
</html>
