<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_destination'])) {

    $update_id = $_POST['update_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $activities = mysqli_real_escape_string($conn, $_POST['activities']);
    $tips = mysqli_real_escape_string($conn, $_POST['tips']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']); // Tambahan untuk tipe

    // Update data excluding image
    $update_query = "UPDATE `destinations` SET name = '$name', description = '$description', activities = '$activities', tips = '$tips', location = '$location', price = '$price', type = '$type' WHERE id = '$update_id'";
    mysqli_query($conn, $update_query) or die('Query failed: ' . mysqli_error($conn));

    // Handle image update
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $old_image = $_POST['update_image'];

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image file size is too large!';
        } else {
            // Update image if there's a new one
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                mysqli_query($conn, "UPDATE `destinations` SET image = '$image' WHERE id = '$update_id'") or die('Query failed: ' . mysqli_error($conn));
                if (file_exists('uploaded_img/' . $old_image) && $old_image != '') {
                    unlink('uploaded_img/' . $old_image);
                }
                $message[] = 'Image updated successfully!';
            } else {
                $message[] = 'Failed to upload new image.';
            }
        }
    }

    $message[] = 'Destination updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Update Destination</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $select_destinations = mysqli_query($conn, "SELECT * FROM `destinations` WHERE id = '$update_id'") or die('Query failed: ' . mysqli_error($conn));
    if (mysqli_num_rows($select_destinations) > 0) {
        while ($fetch_destinations = mysqli_fetch_assoc($select_destinations)) {
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo htmlspecialchars($fetch_destinations['image']); ?>" class="image" alt="">
   <input type="hidden" value="<?php echo htmlspecialchars($fetch_destinations['id']); ?>" name="update_id">
   <input type="hidden" value="<?php echo htmlspecialchars($fetch_destinations['image']); ?>" name="update_image">
   <input type="text" class="box" value="<?php echo htmlspecialchars($fetch_destinations['name']); ?>" required placeholder="Update destination name" name="name">
   <textarea name="description" class="box" required placeholder="Update destination description" cols="30" rows="10"><?php echo htmlspecialchars($fetch_destinations['description']); ?></textarea>
   <textarea name="activities" class="box" required placeholder="Update tourist activities" cols="30" rows="10"><?php echo htmlspecialchars($fetch_destinations['activities']); ?></textarea>
   <textarea name="tips" class="box" required placeholder="Update tourist tips" cols="30" rows="10"><?php echo htmlspecialchars($fetch_destinations['tips']); ?></textarea>
   <input type="text" class="box" value="<?php echo htmlspecialchars($fetch_destinations['location']); ?>" required placeholder="Update location" name="location">
   <input type="number" class="box" value="<?php echo htmlspecialchars($fetch_destinations['price']); ?>" required placeholder="Update price" name="price">
   <!-- Dropdown untuk type -->
   <select name="type" class="box" required>
      <option value="destination" <?php echo ($fetch_destinations['type'] == 'destination') ? 'selected' : ''; ?>>Destination</option>
      <option value="hotel" <?php echo ($fetch_destinations['type'] == 'hotel') ? 'selected' : ''; ?>>Hotel</option>
      <option value="dining" <?php echo ($fetch_destinations['type'] == 'dining') ? 'selected' : ''; ?>>Dining</option>
   </select>
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <input type="submit" value="Update Destination" name="update_destination" class="btn">
   <a href="admin_destinations.php" class="option-btn">Go back</a>
</form>

<?php
        }
    } else {
        echo '<p class="empty">No destination found with the given ID</p>';
    }
} else {
    echo '<p class="empty">No destination selected for update</p>';
}
?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>
