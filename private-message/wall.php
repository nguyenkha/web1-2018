<?php
require_once 'init.php';
$profile = findUserById($_GET['id']);
$friends = getFriends($currentUser['id']);
$isFriend = false;
foreach ($friends AS $friend) {
  if ($friend['id'] == $profile['id']) {
    $isFriend = true;
  }
}
$isFollow = isFollow($currentUser['id'], $profile['id']);
$isRequest = isFollow($profile['id'], $currentUser['id']);
?>
<?php include 'header.php' ?>
<h1>Tường nhà <?php echo $profile['fullname'] ?></h1>
<img src="uploads/avatars/<?php echo $profile['id'] ?>.jpg">
<?php if ($isFriend) : ?>
<form action="friend-request.php" method="POST">
  <input type="hidden" name="action" value="unfriend">
  <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
  <button type="submit" class="btn btn-danger">Hủy kết bạn</button>
</form>
<?php else : ?>
  <?php if ($isFollow) : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="cancel-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Hủy yêu cầu kết bạn</button>
    </form>
  <?php elseif ($isRequest) : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="accept-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Chấp nhận yêu cầu kết bạn</button>
    </form>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="reject-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-warning">Từ chối yêu cầu kết bạn</button>
    </form>
  <?php else : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="send-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Gửi yêu cầu kết bạn</button>
    </form>
  <?php endif; ?>
<?php endif; ?>
<?php include 'footer.php' ?>