<?php 
require_once 'init.php';

if ($currentUser) {
  // $newFeeds = getNewFeeds();
  $newFeeds = getNewFeedsForUserId($currentUser['id']);
}
?>
<?php include 'header.php' ?>
<h1>Trang chủ</h1>
<?php if ($currentUser) : ?>
<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>
<?php foreach ($newFeeds as $post) : ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['userHasAvatar']) : ?>
          <img class="avatar" src="uploads/avatars/<?php echo $post['userId'] ?>.jpg">
          <?php else : ?>
          <img class="avatar" src="no-avatar.jpg">
          <?php endif; ?>
        </div>
        <div class="col-11">
          <?php echo $post['userFullname'] ?>
        </div>
      </div>
    </h4>
    <p class="card-text">
    <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
    <p><?php echo $post['content'] ?></p>
    </p>
  </div>
</div>
<?php endforeach; ?>
<?php else: ?>
Bạn chưa đăng nhập
<?php endif ?>
<?php include 'footer.php' ?>