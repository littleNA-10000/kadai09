<?php
//セッションスタート
session_start();

require "funcs.php";

//ログインチェック処理
loginCheckManager();

//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table ORDER BY id ASC");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        $view .= '<tr><td>'.$result['id'].'</td><td>'.$result['lid'].'</td><td>'.$result['lpw'].'</td><td>'.$result['kanri_flg'].'</td><td>'.$result['life_flg'].'</td><td>';
        $view .= '<a href="delete_member.php?id='.$result['id'].'">';
        $view .= "[ 削除 ]";
        $view .= "</a></td></tr>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>会員一覧</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- <link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet"> -->
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<nav>
    <a href="main.php">トップに戻る</a> | <a href="logout.php">ログアウトする</a>
</nav>
<h1>
    会員一覧
</h1>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
        <table>
            <tr>
                <th>
                    管理ID
                </th>
                <th>
                    ログインID
                </th>
                <th>
                    パスワード（ハッシュ化）
                </th>
                <th>
                    kanri_flg
                </th>
                <th>
                    life_flg
                </th>
                                <th>
                    削除ボタン
                </th>
            </tr>
            <?=$view?>
        </table>
    </div>
</div>
<!-- Main[End] -->

</body>
</html>