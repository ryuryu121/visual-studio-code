<?php
    //記入例；以下は php で挟まれるPHP領域に記載すること。
    //4-2以降でも毎回接続は必要。
    //$dsnの式の中にスペースを入れないこと！

    // 【サンプル】
    // ・データベース名：tb219876db
    // ・ユーザー名：tb-219876
    // ・パスワード：ZzYyXxWwVv
    // の学生の場合：
    // m4-1の内容
    // DB接続設定
    $dsn = 'mysql:dbname=tb250625db;host=localhost';
    $user = 'tb-250625';
    $password = '4aYhwR7fNH';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    // m4-2の内容
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"//tbtestというファイルがなければ以下の条件のテーブルを作れ
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name CHAR(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);//query=()の動作を行え！

    // m4-3の内容
    $sql ='SHOW TABLES';
    $result = $pdo -> query($sql); // query は検索願い。たのも～！
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";

    // m4-4の内容
    $sql ='SHOW CREATE TABLE tbtest';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
    }
    echo "<hr>";

    // m4-5の内容
    $name = '（ラグラージ）';
    $comment = '（ハイドロポンプ）'; //好きな名前、好きな言葉は自分で決めること

    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
    //bindParamの引数名（:name など）はテーブルのカラム名に併せるとミスが少なくなります。最適なものを適宜決めよう。
        
     // m4-6の内容
    //$rowの添字（[ ]内）は、4-2で作成したカラムの名称に合わせる必要があります。
    
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";
    }

    // m4-7の内容
    //bindParamの引数（:nameなど）は4-2でどんな名前のカラムを設定したかで変える必要がある。
    $id = 1; //変更する投稿番号
    $name = "（ミューツー）";
    $comment = "（サイコキネシス）"; //変更したい名前、変更したいコメントは自分で決めること
    $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    //続けて、4-6の SELECTで表示させる機能 も記述し、表示もさせる。
    //※ データベース接続は上記で行っている状態なので、その部分は不要

    //↓以下がその表示させるためのコード。これしないと反映されなかった。
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";


    //m4-8の内容
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    $id = 4;
    $sql = 'delete from tbtest where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    //続けて、4-6の SELECTで表示させる機能 も記述し、表示もさせる。
    //※ データベース接続は上記で行っている状態なので、その部分は不要

    //↓以下がその表示させるためのコード。これしないと反映されなかった。
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";

    
    //m4-9の内容
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    // 【！この SQLは tbtest テーブルを削除します！】
        $sql = 'DROP TABLE tbtest';
        $stmt = $pdo->query($sql);
?>