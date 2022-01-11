<?php
  
  $file = 'comment.txt';

  date_default_timezone_set('Japan');

  $name = '';
  $text = '';
  $book = [];
  $errors = '';

  if($_SERVER["REQUEST_METHOD"] === "POST") {
      $name = filter_input(INPUT_POST,'booktitle');
      $text = filter_input(INPUT_POST,'text');
      $book = $name."<br>".$text.",".date('Y年m月d日H時i分')."\n";

      if (mb_strlen($name) > 10 || mb_strlen($text) > 100) {
        $errors = '本のタイトルを10文字以内、<br>感想文を100文字以内でお願い致します。';
  
      } else {
        file_put_contents($file, $book, FILE_APPEND);
      } 
  }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>読書感想文</title>
</head>
<body>
  <header class="header">
    <h1>
      読書感想文
    </h1>
  </header>

<div class="form">
  <form action="index.php" method="post">
    <p><?php echo $errors; ?></p>
    <h1><label>BOOK TITLE</label></h1>
    <input type="text" name="booktitle" style="width: 230px; height: 30px;margin-top: 5px;" placeholder="タイトルを書いてね"><br>
    <h1><label>BOOK COMMENT</label></h1>
    <textarea name="text" id="" cols="45" rows="6" style="margin-top: 5px; margin-bottom: 5px;" placeholder="感想を自由に書いてね"></textarea><br>
    <button type="submit" id="btn">投稿</button>
  </form>
</div>



<div class="wrap">
  <h2>読書感想一覧</h2>
    <ul></ul>
</div>

  <footer>
    <h2>Book@読書感想文(仮)</h2>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
    $(function() {
      $.ajax({
        url: 'comment.txt',
      }).done(function (data) {
        data.split('\n').forEach(function (comment) {
          const post_text = comment.split(',')[0];
          const post_time = comment.split(',')[1];
          if (post_text) {
          const li = `<li>${post_text}<span>${post_time}</span></li>`;
          $('ul').append(li);
          }
        })
      });
    });

    $('#btn').click(function () {
    if (confirm("投稿しますか?")) {
      return ture;
    } else {
      return false;
    }
  });


  </script>

</body>
</html>