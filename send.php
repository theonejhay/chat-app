<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    'cd76a8880edd61ba35ba',
    'b474746122f78bce442e',
    '1728070',
    $options
  );

  $username = $_POST['username'];
  $message = $_POST['message'];

  $data['message'] = json_encode(array(
    'username'=> $username,
    'message' => $message
  ));

  $pusher->trigger('my-channel', 'my-event', $data);
