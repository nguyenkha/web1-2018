<?php 
require_once 'init.php';
$action = $_POST['action'];
$profileId = $_POST['profileId'];

if ($action == 'unfriend') {
  unfriend($currentUser['id'], $profileId);
}
if ($action == 'send-friend-request') {
  sendFriendRequest($currentUser['id'], $profileId);
}
if ($action == 'accept-friend-request') {
  acceptFriendRequest($currentUser['id'], $profileId);
}
if ($action == 'reject-friend-request') {
  rejectFriendRequest($currentUser['id'], $profileId);
}
if ($action == 'cancel-friend-request') {
  cancelFriendRequest($currentUser['id'], $profileId);
}
header('Location: wall.php?id=' . $profileId);
?>