<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset = "UTF-8">
    <title>copy.php</title>
</head>

<body>
    <form action = ""method="post">
        <!--投稿フォーム-->
        <input type = "text" name = "name" placeholder = "ここに名前を入力">
        <input type = "text" name = "comment" placeholder = "ここにコメントを入力">
        <input type = "password" name = "post_pass" placeholder = "送信パスワード">
        <input type = "submit" name = "submit" value = "投稿">
        <br>
        <!--削除フォーム-->
        <input type = "number" name = "del_num" placeholder = "削除したい番号">
        <input type = "password" name = "del_pass" placeholder = "送信パスワード">
        <input type = "submit" name = "submit" value = "削除">
        <br>
        <!--編集フォーム-->
        <input type = "number" name = "edi_num" placeholder = "編集したい番号">
        <input type = "text" name = "edi_name" placeholder = "編集したい名前">
        <input type = "text" name = "edi_comment" placeholder = "編集したいコメント">
        <input type = "password" name = "edi_pass" placeholder = "送信パスワード">
        <input type = "submit" name = "submit" value = "編集">
        <br>
    </form>

    <?php
        //以下、TECH-BASEのデータベースへの接続コード
        $dsn = 'mysql:dbname=tb250625db;host=localhost';
        $user = 'tb-250625';
        $password = '4aYhwR7fNH';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //以下、tbtestというファイルがなければ以下の条件のテーブルを作成する
        $sql = "CREATE TABLE IF NOT EXISTS tbtest3"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT,"
        . "date CHAR(32),"
        . "post_pass CHAR(32)"
        .");";
        $stmt = $pdo->query($sql);//query=()の動作を行う       

        //hello world の表示
        echo "Hello World";
        echo '<br>';
        echo "This is the bulletin board.";
        echo '<br>';
        echo "You can post whatever you think or want to say.";
        echo "<hr>";

        //以下、投稿内容の取得および表示パートに移行する

        //現在時刻の関数化
        $date = date("Y/m/d H:i:s");

        //以下、if文開始
        //もし、投稿欄に入力されていたら↓
        if(!empty($_POST["name"]) && !empty($_POST["comment"])  && !empty($_POST["post_pass"])){

            //フォーム内容の関数への変換
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $post_pass = $_POST["post_pass"];

            //以下の入力内容をデータベースに記入する。
            $sql = "INSERT INTO tbtest3 (name, comment, date, post_pass) VALUES (:name, :comment, :date, :post_pass)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);    
            $stmt->bindParam(':post_pass', $post_pass, PDO::PARAM_STR);
            $stmt->execute();

        //もし、削除欄に入力されていたら↓
        }elseif(!empty($_POST["del_num"]) && !empty($_POST["del_pass"])){

            //フォーム内容の関数への変換
            $delete = $_POST["del_num"];
            $del_pass = $_POST["del_pass"];

            //以下、passとの一致を検証するコード
            $id = $delete;
            $sql = 'SELECT * FROM tbtest3';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            //ループさせるコード
            foreach ($results as $row){

                //一致していた場合、削除を実行するというコード
                if($row['post_pass'] == $del_pass){
                    //以下、削除コード
                    $id = $delete;
                    $sql = 'delete from tbtest3 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

        //もし、編集欄に投稿されていたら↓    
        }elseif(!empty($_POST["edi_num"]) && !empty($_POST["edi_pass"])){

            //フォーム内容の関数への変換
            $edit = $_POST["edi_num"];
            $edi_name = $_POST["edi_name"];
            $edi_comment = $_POST["edi_comment"];
            $edi_pass = $_POST["edi_pass"];

            //以下、passとの一致を検証するコード
            $id = $edit;
            $sql = 'SELECT * FROM tbtest3';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            //ループさせるコード
            foreach ($results as $row){

                //一致していた場合、編集を実行するというコード
                if($row['post_pass'] == $edi_pass){
                    //編集コード
                    $id = $edit; //変更する投稿番号
                    $name = $edi_name;
                    $comment = $edi_comment;
                    $sql = 'UPDATE tbtest3 SET name=:name,comment=:comment WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute(); 
                }
            }
        
        }

        //以下、データベース内容の表示パート
        $id = 1 ;
        $sql = 'SELECT * FROM tbtest3';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].', ';
            echo $row['name'].', ';
            echo $row['comment'].', ';
            echo $row['date'].'<br>';
        echo "<hr>";
        }
    ?>
</body>
</html>
