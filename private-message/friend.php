<?php
require_once 'init.php';
$friends = getFriends($currentUser['id']);
// var_dump($friends);
?>
<?php include 'header.php' ?>
<h1>Danh sách bạn bè</h1>
<ul>
  <?php foreach ($friends as $friend) : ?>
  <li>
    <a href="wall.php?id=<?php echo $friend['id']; ?>"><?php echo $friend['fullname'] ?></a>
  </li>
  <?php endforeach; ?>
</ul>
<?php include 'footer.php' ?>