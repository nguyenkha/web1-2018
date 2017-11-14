<?php
require_once 'init.php';
$conversations = getLatestConversations($currentUser['id']);

?>
<?php include 'header.php' ?>
<h1>Danh sách tin nhắn</h1>
<a href="new-message.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Thêm cuộc trò chuyện</a>
<?php foreach ($conversations as $conversation) : ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($conversation['hasAvatar']) : ?>
          <img class="avatar" src="uploads/avatars/<?php echo $conversation['id'] ?>.jpg">
          <?php else : ?>
          <img class="avatar" src="no-avatar.jpg">
          <?php endif; ?>
        </div>
        <div class="col-11">
          <a href="conversation.php?id=<?php echo $conversation['id'] ?>"><?php echo $conversation['fullname'] ?></a>
        </div>
      </div>
    </h4>
    <p class="card-text">
    <small>Tin nhắn cuối: <?php echo $conversation['lastMessage']['createdAt'] ?></small>
    <p><?php echo $conversation['lastMessage']['content'] ?></p>
    </p>
  </div>
</div>
<?php endforeach; ?>
<?php include 'footer.php' ?>