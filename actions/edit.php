<?php
include "../con/connection.php";

function editDestination($conn)
{
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name_destination = $_POST['name_destination'];
    $description_destination = $_POST['description_destination'];
    $old_image_url = "";

    $query = "SELECT image_url FROM destination WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($old_image_url);
    $stmt->fetch();
    $stmt->close();

    $filename = $_FILES['image_destination']['name'];
    if ($filename) {
      $rand = rand();
      $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
      $ukuran = $_FILES['image_destination']['size'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);

      if (!in_array($ext, $ekstensi)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed.'); window.location.href='../screen/destination.php';</script>";
        return;
      } elseif ($ukuran >= 1044070) {
        echo "<script>alert('File size is too large. Maximum allowed size is 1MB.'); window.location.href='../screen/destination.php';</script>";
        return;
      }

      $xx = $rand . '_' . $filename;
      $target_directory = '../images/';
      if (!is_dir($target_directory)) {
        mkdir($target_directory, 0755, true);
      }

      $tmp_name = $_FILES['image_destination']['tmp_name'];
      $destination_path = $target_directory . $xx;
      if (!move_uploaded_file($tmp_name, $destination_path)) {
        echo "<script>alert('Failed to upload image. Please try again.'); window.location.href='../screen/destination.php';</script>";
        error_log("Failed to move uploaded file. Temporary path: $tmp_name, Destination path: $destination_path");
        return;
      }

      if ($old_image_url && file_exists($target_directory . $old_image_url)) {
        unlink($target_directory . $old_image_url);
      }

      $query = "UPDATE destination SET name = ?, description = ?, image_url = ? WHERE id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('sssi', $name_destination, $description_destination, $xx, $id);
    } else {
      $query = "UPDATE destination SET name = ?, description = ? WHERE id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('ssi', $name_destination, $description_destination, $id);
    }

    if ($stmt->execute()) {
      echo "<script>alert('Data successfully updated'); window.location.href='../screen/destination.php';</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../screen/destination.php';</script>";
    }

    $stmt->close();
  }
}

function updateCategory($conn)
{
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name_category'];

    $query = "UPDATE category SET `name`='$name' WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo "<script>alert('Data successfully updated'); window.location.href='../screen/category.php';</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../screen/category.php';</script>";
    }
  }
}

function updateTravel($conn)
{
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $destination_id = $_POST['destination_id'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];

    $filename = $_FILES['image_url']['name'];
    $uploadOk = 1;
    $xx = '';

    if ($filename != '') {
      $rand = rand();
      $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
      $ukuran = $_FILES['image_url']['size'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);

      if (!in_array($ext, $ekstensi)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed.'); window.location.href='../screen/travels.php?id=$id';</script>";
        $uploadOk = 0;
      } else {
        if ($ukuran < 1044070) {
          $xx = $rand . '_' . $filename;
          $target_directory = '../images/';
          if (!is_dir($target_directory)) {
            mkdir($target_directory, 0755, true);
          }

          $tmp_name = $_FILES['image_url']['tmp_name'];
          $destination_path = $target_directory . $xx;
          if (!move_uploaded_file($tmp_name, $destination_path)) {
            echo "<script>alert('Failed to upload image. Please try again.'); window.location.href='../screen/travels.php?id=$id';</script>";
            $uploadOk = 0;
          }
        } else {
          echo "<script>alert('File size is too large. Maximum allowed size is 1MB.'); window.location.href='../screen/travels.php?id=$id';</script>";
          $uploadOk = 0;
        }
      }
    }

    if ($uploadOk == 1) {
      if ($filename != '') {
        $query = mysqli_query($conn, "SELECT image_url FROM travel WHERE id = $id");
        $data = mysqli_fetch_assoc($query);
        $old_image_url = $data['image_url'];
        if (file_exists("../images/" . $old_image_url)) {
          unlink("../images/" . $old_image_url);
        }

        $stmt = $conn->prepare("UPDATE travel SET name = ?, description = ?, destination_id = ?, category_id = ?, price = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param('ssiiisi', $name, $description, $destination_id, $category_id, $price, $xx, $id);
      } else {
        $stmt = $conn->prepare("UPDATE travel SET name = ?, description = ?, destination_id = ?, category_id = ?, price = ? WHERE id = ?");
        $stmt->bind_param('ssiiis', $name, $description, $destination_id, $category_id, $price, $id);
      }

      if ($stmt->execute()) {
        echo "<script>alert('Data successfully updated'); window.location.href='../screen/travels.php';</script>";
      } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../screen/travels.php?id=$id';</script>";
      }
      $stmt->close();
    }
  }
}



if ($_POST['action'] == 'editDestination') {
  editDestination($conn);
} elseif ($_POST['action'] == 'updateCategory') {
  updateCategory($conn);
} elseif ($_POST['action'] == 'updateTravel') {
  updateTravel($conn);
}
