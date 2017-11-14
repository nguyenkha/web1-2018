<?php 
function findUserByEmail($email) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute(array(strtolower($email)));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  return $user;
}

function findUserById($id) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute(array($id));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  return $user;
}

function createUser($fullname, $email, $password) {
  global $db;
  $stmt = $db->prepare("INSERT INTO users (email, password, fullname) VALUE (?, ?, ?)");
  $stmt->execute(array($email, $password, $fullname));
  return $db->lastInsertId();
}

function updateUser($user) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ?, hasAvatar = ? WHERE id = ?");
  $stmt->execute(array($user['fullname'], $user['phone'], $user['hasAvatar'], $user['id']));
  return $user;
}

function updateUserPassword($userId, $hashPassword) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
  $stmt->execute(array($hashPassword, $userId));
}

function createPost($userId, $content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO posts (userId, content, createdAt) VALUE (?, ?, CURRENT_TIMESTAMP())");
  $stmt->execute(array($userId, $content));
  return $db->lastInsertId();
}

function getNewFeeds() {
  global $db;
  $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId ORDER BY createdAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function getNewFeedsForUserId($userId) {
  global $db;
  $friends = getFriends($userId);
  $friendIds = array();
  foreach ($friends as $friend) {
    $friendIds[] = $friend['id'];
  }
  $friendIds[] = $userId;
  $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId WHERE p.userId IN (" . implode(',', $friendIds) .  ") ORDER BY createdAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
    $width = ($max_height / $height) * $width;
    $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
    $height = ($max_width / $width) * $height;
    $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}

function getFriends($userId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? OR userId2 = ?");
  $stmt->execute(array($userId, $userId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++) {
    $row1 = $followings[$i];
    if ($userId == $row1['userId1']) {
      $userId2 = $row1['userId2'];
      for ($j = 0; $j < count($followings); $j++) {
        $row2 = $followings[$j];
        if ($userId == $row2['userId2'] && $userId2 == $row2['userId1']) {
          $friends[] = findUserById($userId2);
        }
      }
    }
  }
  return $friends;
}

function isFollow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    return false;
  }
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
  $user2ToUser1 = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user2ToUser1) {
    return false;
  }
  return true;
} 

function unfriend($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
}

function sendFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("INSERT INTO friends(userId1, userId2) VALUES(?, ?)");
  $stmt->execute(array($userId1, $userId2));
}

function acceptFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("INSERT INTO friends(userId1, userId2) VALUES(?, ?)");
  $stmt->execute(array($userId1, $userId2));
}

function rejectFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
}

function cancelFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
}

function getLatestConversations($userId) {
  global $db;
  $stmt = $db->prepare("SELECT userId2 AS id, u.fullname, u.hasAvatar FROM messages AS m LEFT JOIN users AS u ON u.id = m.userId2 WHERE userId1 = ? GROUP BY userId2 ORDER BY createdAt DESC");
  $stmt->execute(array($userId));
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  for ($i = 0; $i < count($result); $i++) {
    $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt DESC LIMIT 1");
    $stmt->execute(array($userId, $result[$i]['id']));
    $lastMessage = $stmt->fetch(PDO::FETCH_ASSOC);
    $result[$i]['lastMessage'] = $lastMessage;
  }
  return $result;
}

function getMessagesWithUserId($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt");
  $stmt->execute(array($userId1, $userId2));
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sendMessage($userId1, $userId2, $content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO messages (userId1, userId2, content, type, createdAt) VALUE (?, ?, ?, ?, CURRENT_TIMESTAMP())");
  $stmt->execute(array($userId1, $userId2, $content, 0));
  $id = $db->lastInsertId();
  $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
  $stmt->execute(array($id));
  $newMessage = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = $db->prepare("INSERT INTO messages (userId2, userId1, content, type, createdAt) VALUE (?, ?, ?, ?, ?)");
  $stmt->execute(array($userId1, $userId2, $content, 1, $newMessage['createdAt']));
}