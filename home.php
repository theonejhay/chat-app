
<?php
  session_start();

  if (!isset($_SESSION['user']) && !isset($_SESSION['isloggedin'])) {
    header('location: index.php');
    exit();
  }

?>

<!DOCTYPE html>
<head>

  <title>Pusher Test</title>
  <link id="theme-link" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<style>

  .messages {
    height: 400px;
    overflow-y: scroll;
    padding-right: 10px; 
  }

  .message-container {
    display: flex;
    flex-direction: column;
    margin-bottom: 8px;
  }

  .message-container-right {
    align-items: flex-end; 
  }

  .message-container-left {
    align-items: flex-start;
  }

  .username {
    font-weight: bold;
    margin-bottom: 4px;
  }

  .message {
    background-color: #f2f2f2;
    padding: 6px 10px;
    border-radius: 8px;
  }
  body {
    background-color: #ffffff;
    color: #333333;
    font-family: Arial, sans-serif;
    margin-top: 20px;
  }

 .container {
   max-width: 800px;
   margin: 0 auto;
  }

  .chat-box {
   background-color: #ffffff;
   border-radius: 8px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   padding: 20px;
   margin-bottom: 20px;
  }

  .message-container {
   display: flex;
   flex-direction: column;
   margin-bottom: 10px;
  }

  .message-container-right {
   align-items: flex-end;
  }

  .message-container-left {
   align-items: flex-start;
  }

  .username {
   font-weight: bold;
   margin-bottom: 4px;
   color: #333333;
  }

  .message {
    background-color: #e8f0fe;
    padding: 8px 12px;
    border-radius: 12px;
    max-width: 70%;
    word-wrap: break-word;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .message-container-left .message {
    background-color: #f5f5f5;
    color: #333333;
  }

  .input-group {
    margin-bottom: 20px;
  }
  .input-group input[type="text"] {
    border-radius: 6px;
  }
  .input-group button {
     border-radius: 6px;
  }
 body.dark-mode {
    background-color: #333333;
    color: #ffffff;
  }
  body.dark-mode .messages,
  body.dark-mode .message-container-left .message {
    background-color: #222222;
    color: #ffffff;
  }
  body.dark-mode .message-container-right .message {
    background-color: #333333;
    color: #ffffff;
  }
  body.dark-mode .messages.border {
    border-color: #555555;
  }
  body.dark-mode .form {
    background-color: #222222;
  }
  body.dark-mode .username {
    color: #ffffff;
  }
  #toggleDarkMode:hover {
      transform: scale(1.1);

    }
    
  #send:hover {
      transform: scale(1.1);
  
    }

</style>
<body class>
    <?php  $username = $_SESSION['user']; ?>
    <div class="container-fluid mt-4">
    <div class="text-end mb-3">

      <button class="btn btn-outline-secondary" id="toggleDarkMode">Dark Mode</button>
    </div>
        <form class="row">
            <div class="offset-md-2 col-md-8">
                <div class="messages border p-1" style="height: 400px;">

                </div>
                <div class="input-group mt-1 mb-3">
                    <input 
                        type="text" 
                        id="message" 
                        class="form-control"         
                        placeholder="Message" 
                        aria-label="Message" 
                        aria-describedby="send">
                    <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        id="send">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>

  <script src="./jquery-3.6.0.min.js"></script>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
 $('#toggleDarkMode').click(function () {
      $('body').toggleClass('dark-mode');
    });
var pusher = new Pusher('cd76a8880edd61ba35ba', {
    cluster: 'ap1'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {
    const { username, message } = JSON.parse(data.message);
    const currentUser = '<?= $username ?>';

    let chatClass = 'message-container-right'; 
    let alignmentClass = 'align-items-end'; 

    if (username !== currentUser) {
      chatClass = 'message-container-left'; 
      alignmentClass = 'align-items-start'; 
    }

    let chat = `<div class="message-container ${chatClass}">
                  <div class="username">${username}</div>
                  <div class="message">${message}</div>
                </div>`;

    $('.messages').append(chat);
    $('.messages').scrollTop($('.messages')[0].scrollHeight); 
  });

  $('#send').click(function () {
    let username = '<?= $username ?>';
    let message = $('#message').val();

    $.ajax({
      url: 'send.php',
      type: "POST",
      dataType: "JSON",
      data: {
        username,
        message
      },
      success: function(response) {
        $('#message').val(''); 
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
</script>
</script>

</body>