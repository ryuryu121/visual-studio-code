<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>m3-03.php</title>
    </head>
    
    <body>
        ***掲示板***
        <form action = ""method= "post">
            <input type = "text" name = "name" placeholder = "あなたの名前">
            <input type = "text" name = "input" placeholder = "ここにコメントを入力">
            <input type = "submit" name = "submit" value = "送信">
            <br>
            <input type = "number" name "number" placeholder = "削除する投稿番号">
            <input type = "submit" name = "submit2" value = "削除">

        </form>
        ***ログ内容***
        <br>
        <?php
            $fname = "m3-03.txt";//使用ファイル定義
            if(file_exists($fname)){//もし↑ファイルがあるなら
                if(!empty($_POST["name"])){
                $count = count(file( $fname )) + 1;
                $date = date("Y/m/d H:i:s");
                $senten = $count."<>".$_POST["name"]."<>".$_POST["input"]."<>".$date;
        
                $fp = fopen($fname,"a");
                    fwrite($fp, $senten.PHP_EOL);
                    fclose($fp);
                }
                //↓これより下はテキストファイルの内容の表示パート
                $item = file($fname,FILE_IGNORE_NEW_LINES);
                foreach($item as $items){
                $trans = explode("<>",$items);//＜＞をぶっ壊してそのまま表示してる？？？
                    echo $trans[0];
                    echo " ";
                    echo $trans[1];
                    echo " ";
                    echo $trans[2];
                    echo " ";
                    echo $trans[3]."<br>";
                }
            }else{
                fopen($fname,"a");//↑ファイルがなかったら新たに作成
                }
        ?>
    </body>
</html>