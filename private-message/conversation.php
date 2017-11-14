<?php
require_once 'init.php';

if (isset($_POST['content'])) {
  sendMessage($currentUser['id'], $_GET['id'], $_POST['content']); 
}

$messages = getMessagesWithUserId($currentUser['id'], $_GET['id']);
$user = findUserById($_GET['id']);

?>
<?php include 'header.php' ?>
<h1>Cuộc trò chuyện với: <?php echo $user['fullname'] ?></h1>
<?php foreach ($messages as $message) : ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <?php if ($message['type'] == 1) : ?>
    <p class="card-text">
      <strong><?php echo $user['fullname'] ?></strong>:
      <?php echo $message['content'] ?>
    </p>
    <?php else: ?>
    <p class="card-text text-right">
      <?php echo $message['content'] ?>
    </p>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
<form method="POST">
  <div class="form-group">
    <label for="content">Tin nhắn:</label>
    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
</form>
<?php include 'footer.php' ?>