<?php
include "../con/connection.php";

function deleteDestination($conn) {
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM destination WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo "<script>alert('Data succesfully Delete'); window.location.href='../screen/destination.php';</script>";

    } else {
      echo "<script>alert('Failed to delete data. Please try again.'); window.location.href='../screen/destination.php';</script>";
    }
  }
}

function deleteCategory($conn) {
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM category WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo "<script>alert('Data succesfully Delete'); window.location.href='../screen/category.php';</script>";

    } else {
      echo "<script>alert('Failed to delete data. Please try again.'); window.location.href='../screen/category.php';</script>";
    }
  }
}

function deleteTravel($conn) {
  if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM travel WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo "<script>alert('Data succesfully Delete'); window.location.href='../screen/travels.php';</script>";

    } else {
      echo "<script>alert('Failed to delete data. Please try again.'); window.location.href='../screen/travels.php';</script>";
    }
  }
}

if ($_POST['action'] == 'deleteDestination') {
  deleteDestination($conn);
} elseif ($_POST['action'] == 'deleteCategory') {
  deleteCategory($conn);
} elseif ($_POST['action'] == 'deleteTravel') {
  deleteTravel($conn);
}
?>