<?php
require_once('dbc.php');

Class Blog extends Dbc
{

    protected $table_name = 'blog';
   //3.カテゴリ名を表示
    //引数：数字
    //返り値：カテゴリーの文字列

    public function setCategoryName($category)
    {
        if ($category == "1") {
            return '日常';
        } elseif ($category == "2") {
            return "プログラミング";
        } else {
            return "その他";
        }
    }

    public function blogCreate($blogs){
        $sql = "INSERT INTO
            $this->table_name(title,content,category,publich_status)
        VALUES
            (:title,:content,:category,:publich_status)";

        $dbh = $this -> dbConnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title',$blogs['title'],PDO::PARAM_STR);
            $stmt->bindValue(':content',$blogs['content'],PDO::PARAM_STR);
            $stmt->bindValue(':category',$blogs['category'],PDO::PARAM_INT);
            $stmt->bindValue(':publich_status',$blogs['publich_status'],PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            echo 'ブログを投稿しました！';
        }catch(PDOException $e){
            $dbh->rollBack();
            exit($e);
        }
    }

    public function blogUpdate($blogs){
            $sql = "UPDATE $this->table_name SET
              title = :title,content = :content,category = :category,publich_status = :publich_status
            WHERE
                id = :id";

        $dbh = $this -> dbConnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title',$blogs['title'],PDO::PARAM_STR);
            $stmt->bindValue(':content',$blogs['content'],PDO::PARAM_STR);
            $stmt->bindValue(':category',$blogs['category'],PDO::PARAM_INT);
            $stmt->bindValue(':publich_status',$blogs['publich_status'],PDO::PARAM_INT);
            $stmt->bindValue(':id',$blogs['id'],PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo 'ブログを更新しました！';
        }catch(PDOException $e){
            $dbh->rollBack();
            exit($e);
        }
    }

    //ブログのバリデーション
    public function blogValidate($blogs){
        if (empty($blogs['title'])) {
            exit('タイトルを入力してください');
        }
    
        if (mb_strlen('title') > 191) {
            exit('タイトルは191文字以下にしてください');
        }
    
        if (empty($blogs['content'])) {
            exit('本文をを入力してください');
        }
    
        if (empty($blogs['category'])) {
            exit('カテゴリーは必須です');
        }
    
        if (empty($blogs['publich_status'])) {
            exit('公開ステータスは必須です');
        }
    }
    
}

?>