<?php
require_once 'init.php';

if (!$currentUser) {
  header('Location: index.php');
  exit();
}

$fullname = $currentUser['fullname'];
$phone = $currentUser['phone'];
$success = true;

// Kiểm tra người dùng có nhập tên
if (isset($_POST['fullname'])) {
  if (strlen($_POST['fullname']) > 0) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $currentUser['fullname'] = $fullname;
    $currentUser['phone'] = $phone;
    updateUser($currentUser);
  } else {
    $success = false;
  }

  if(isset($_FILES['avatar'])) {
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileTemp = $_FILES['avatar']['tmp_name'];
    $fileSave = 'uploads/avatars/' . $currentUser['id'] . '.jpg';
    // userid.jpg
    $result = move_uploaded_file($fileTemp, $fileSave);
    if (!$result) {
      $success = false;
    } else {
      $newImage = resizeImage($fileSave, 250, 250);
      imagejpeg($newImage, $fileSave);
      $currentUser['hasAvatar'] = 1;
      updateUser($currentUser);
    }
  }
}

?>
<?php include 'header.php' ?>
<h1>Quản lý thông tin cá nhân</h1>
<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
  Vui lòng nhập đầy đủ thông tin!
</div>
<?php endif; ?>
<form method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fullname">Họ và tên</label>
    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Điền họ và tên vào đây" value="<?php echo $fullname ?>">
  </div>
  <div class="form-group">
    <label for="phone">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone" placeholder="Điền số điện thoại vào đây" value="<?php echo $phone ?>">
  </div>
  <div class="form-group">
    <label for="avatar">Hình ảnh đại diện</label>
    <input type="file" class="form-control-file" id="avatar" name="avatar">
  </div>
  <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
<?php include 'footer.php' ?>