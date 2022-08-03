<?php

require_once '../dbconnect.php';

class UserLogic
{
    /**
     * ユーザー登録
     * @param array $userDate
     * @return bool $result
     */
    public static function createUser($userDate)
    {
        $result = false;
        $sql = 'INSERT INTO users (name,mail,password) VALUES(?,?,?)';

        //ユーザーデータを配列に入れる
        $arr = [];
        $arr[] = $userDate['username'];
        $arr[] = $userDate['mail'];
        $arr[] = password_hash($userDate['password'], PASSWORD_DEFAULT);

        try {
            $stmt = connect()->prepare($sql);
            $result = $stmt->execute($arr);
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }

    /**
     * ログイン処理
     * @param string $mail
     * @param string $password
     * @return bool $result
     */
    public static function login($mail, $password)
    {
        //結果
        $result = false;
        //ユーザをmailから検索して取得
        $user = self::getUserByMail($mail);

        if (!$user) {
            $_SESSION['msg'] = "<span style='color:red;'>メールアドレスが一致しません。</span>";
            return $result;
        }

        //パスワード照会
        if (password_verify($password, $user['password'])) {
            //ログイン成功
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['msg'] = "<span style='color:red;'>パスワードが一致しません。</span>";
        return $result;
    }

    /**
     * mailからユーザを取得
     * @param string $mail
     * @return array |bool  $user|false
     */
    public static function getUserByMail($mail)
    {
        //SQLの準備
        //SQLの実行
        //結果を返す
        $result = false;
        $sql = 'SELECT * FROM users WHERE mail = ?';

        //mailデータを配列に入れる
        $arr = [];
        $arr[] = $mail;

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            //SQLの結果
            $user = $stmt->fetch();
            return $user;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * ログインチェック
     * @param string void
     * @return  bool $result
     */
    public static function checkLogin()
    {
        $result = false;

        //セッションにログインユーザは入っていない場合false
        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {

            return $result = true;
        }
    }

    /**
     * ログアウト処理
     * 
     */
    public static function logout()
    {
        $_SESSION = array();
        session_destroy();
    }




    /**
     * エスケープ処理
     * @param 　$formData
     * @return 　$clean
     */
    public static function cleanData($formData)
    {
        foreach ($formData as $key => $value) {
            $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        return $clean;
    }


    /**
     * エスケープ処理（データ）
     * @param 　$allData
     * @return 　$clean
     */
    public static function html($allData)
    {
        for ($i = 0; $i < count($allData); $i++) {
            foreach ($allData[$i] as $key => $value) {
                $clean[$i][$key] = htmlspecialchars($value, ENT_QUOTES);
            }
        }
        return $clean;
    }


    /**
     * バリデーション処理（データ）
     * @param 　$coffee($_POSTで受け取ったデータ)
     * @return 　$error
     */
    public static function dataValidate($coffee)
    {
        //エラー用配列の準備
        $error = array();

        try {
            //画像処理
            //エラーメッセージがじゃない場合（ファイルがある場合）
            if (!$_FILES['error'] = 4) {
                //$_FILESに値がある場合:処理を実行
                if (!empty($_FILES)) {
                    //ファイルの値を変数に格納
                    $file = $_FILES['img'];
                    $filename = basename($file['name']);
                    $tmp_path = $file['tmp_name'];
                    $file_err = $file['error'];
                    $filesize = $file['size'];
                    //$upload_dir = "C:/xampp/htdocs/PHP自作/images/";
                    //$save_filename = date('ymdHis').$filename;

                    //ファイルサイズチェック
                    if ($filesize > 1048576 || $file_err == 2) {
                        $error['filesize'] = 'ファイルサイズは1MB未満にしてください。';
                    }
                    //拡張子が画像形式かチェック
                    $allow_ext = array('jpg', 'jpeg', 'png');
                    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (!in_array(strtolower($file_ext), $allow_ext)) {
                        $error['ext'] = "jpg、jpeg、png形式の画像ファイルを添付してください。";
                    }
                }
            }

            //総合評価
            if (empty($coffee['rating'])) {
                $error['rating'] = "<span style='color: red';>総合評価は必須入力です。</span>";
            } elseif (!preg_match('/^[1 2 3 4 5]+$/', $coffee['rating'])) {
                $error['rating'] = "不正な値です。";
            }
            //名称
            if (empty($coffee['c_name'])) {
                $error['c_name'] = "<span style='color: red';>名称は必須入力です。</span>";
            } elseif (mb_strlen($coffee['c_name']) > 50) {
                $error['c_name'] = "<span style='color: red';>名称は50文字以内で入力してください。</span>";
            }
            //購入店
            if (empty($coffee['place'])) {
                $error['place'] = "<span style='color: red';>購入店は必須入力です。</span>";
            } elseif (mb_strlen($coffee['place']) > 50) {
                $error['place'] = "<span style='color: red';>購入店は50文字以内で入力してください。</span>";
            }
            //価格
            if (!empty($coffee['price'])) {
                if (!preg_match('/^[0-9]+$/', $coffee['price'])) {
                    $error['price'] = "<span style='color: red';>半角数字で入力してください。</span>";
                } elseif ($coffee['price'] > 100000) {
                    $error['price'] = "<span style='color: red';>価格は10万以下で入力してください。</span>";
                }
            }
            //生産地
            if (mb_strlen($coffee['origin']) > 50) {
                $error['origin'] = "<span style='color: red';>生産地は50文字以内で入力してください。</span>";
            }
            //品種
            if (mb_strlen($coffee['variety']) > 50) {
                $error['variety'] = "<span style='color: red';>品種は50文字以内で入力してください。</span>";
            }
            //抽出方法

            //焙煎

            //公開設定
            if (empty($coffee['publish_status'])) {
                $error['publish_status'] = "<span style='color: red';>公開設定は必須入力です。</span>";
            } elseif (!preg_match('/^[1 2]+$/', $coffee['publish_status'])) {
                $error['publish_status'] = "<span style='color: red';>不正な値です。</span>";
            }
            //コメント
            if (mb_strlen($coffee['comment']) > 150) {
                $error['comment'] = "<span style='color: red';>コメントは150文字以内で入力してください。</span>";
            }

            return $error;
        } catch (\Exception $e) {
            $e->getMessage();
            exit();
        }
    }


    /**
     * 新規投稿
     * @param 　$clean($_POSTで受け取ったデータ)
     * @return 　
     */
    public static function dateCreate($clean)
    {

        $evaluation = $clean["rating"];
        $image = $clean["image"];
        $c_name = $clean["c_name"];
        $place = $clean["place"];
        $price = $clean["price"];
        $origin = $clean["origin"];
        $variety = $clean["variety"];
        $brew = $clean["brew"];
        $roast = $clean["roast"];
        $publish_status = $clean["publish_status"];
        $comment = $clean["comment"];
        $user_id = $clean["user_id"];

        $sql = 'INSERT INTO
                    coffees(name,evaluation,place,price,origin,variety,brew,roast,image,comment,publish_status,user_id)
                 VALUE
                    (:name, :evaluation, :place, :price, :origin, :variety, :brew, :roast, :image, :comment, :publish_status, :user_id)';

        //DB接続
        $dbh = connect();
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $c_name, PDO::PARAM_STR);
            $stmt->bindValue(':evaluation', (string)$evaluation, PDO::PARAM_STR);
            $stmt->bindValue(':place', $place, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->bindValue(':origin', $origin, PDO::PARAM_STR);
            $stmt->bindValue(':variety', $variety, PDO::PARAM_STR);
            $stmt->bindValue(':brew', $brew, PDO::PARAM_STR);
            $stmt->bindValue(':roast', $roast, PDO::PARAM_STR);
            $stmt->bindValue(':image', $image, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':publish_status', $publish_status, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * テーブルから全データ取得
     * @param 
     * @return　 $result
     */
    public static function getAll()
    {
        //DB接続
        $dbh = connect();
        try {
            //SQL準備
            $sql = "SELECT * FROM coffees";
            $stmt = $dbh->query($sql);
            $result = $stmt->fetchall(PDO::FETCH_ASSOC);
            return $result;

            $dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }


    /**
     * idのレコード数を取得
     * @param 
     * @return　 $result
     */
    public static function countId()
    {
        //DB接続
        $dbh = connect();
        try {
            //SQL準備
            $sql = "SELECT count(id) FROM coffees";
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

            $dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }

    /**
     *すべてデータを取得 (3件ごと)
     *
     *@param integer $page ページ番号
     *@return Array $result 珈琲メモデータ (3件ごと)
     */
    public static function findAll($page = 0): array
    {
        $dbh = connect();
        $sql = 'SELECT * FROM coffees';
        $sql .= ' ORDER BY id DESC';
        $sql .= ' LIMIT 3 OFFSET ' . (3 * $page);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     *すべてデータを取得 (3件ごと)
     *
     *@param integer $page ページ番号
     *@return Array $result 珈琲メモデータ (3件ごと)
     */
    public static function userFindAll($page = 0, $user_id): array
    {
        $dbh = connect();
        $sql = "SELECT * FROM coffees";
        $sql .= " WHERE user_id = {$user_id}";
        $sql .= " ORDER BY id DESC";
        $sql .= " LIMIT 3 OFFSET " . (3 * $page);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     *すべてデータを取得 (5件ごと)
     *
     *@param integer $page ページ番号
     *@return Array $result 珈琲メモデータ (5件ごと)
     */
    public static function allPostfindAll($page = 0): array
    {
        $dbh = connect();
        $sql = 'SELECT c.id,c.user_id,c.name,c.evaluation,c.place,c.price,c.origin,c.variety,c.brew,c.roast,c.image,c.comment,c.publish_status,c.created_at,u.name as user_name
                FROM coffees as c 
                INNER JOIN users as u 
                ON c.user_id = u.id
                WHERE c.publish_status = 1';
        $sql .= ' ORDER BY c.id DESC';
        $sql .= ' LIMIT 5 OFFSET ' . (5 * $page);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     *すべてデータを取得 (3件ごと)
     *
     *@param integer $page ページ番号
     *@return Array $result 珈琲メモデータ (3件ごと)
     */
    public static function othersUserFindAll($page = 0, $user_id): array
    {
        $dbh = connect();
        $sql = "SELECT * FROM coffees";
        $sql .= " WHERE user_id = {$user_id}";
        $sql .= " AND coffees.publish_status = 1";
        $sql .= " ORDER BY id DESC";
        $sql .= " LIMIT 3 OFFSET " . (3 * $page);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }






    /**
     * 全データ数を取得
     *
     * @return Int $count 全選手の件数
     */
    public static function countAll(): Int
    {
        $dbh = connect();
        $sql = 'SELECT count(*) as count FROM coffees';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }


    /**
     * USER_IDからすべての珈琲メモの投稿数数を取得
     *
     * @return Int $count coffeeの件数User
     */
    public static function countUserAll($user_id): Int
    {
        $dbh = connect();
        $sql = "SELECT count(*) as count 
                FROM coffees
                WHERE user_id = {$user_id}";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }


    /**
     * USER_IDから公開設定の珈琲メモの投稿数数を取得
     *
     * @return Int $count coffeeの件数
     */
    public static function countOthersAll($user_id): Int
    {
        $dbh = connect();
        $sql = "SELECT count(*) as count 
                FROM coffees
                WHERE user_id = {$user_id}
                AND coffees.publish_status = 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }


    /**
     * バリデーション処理（更新）
     * @param 　$coffee($_POSTで受け取ったデータ)
     * @return 　$error
     */
    public static function dataValidate2($coffee)
    {
        //エラー用配列の準備
        $error = array();

        try {
            //画像処理
            //エラーメッセージが4じゃない場合（ファイルがある場合）
            if (!$_FILES['error'] = 4) {
                //$_FILESに値がある場合:処理を実行
                if (!empty($_FILES)) {
                    //ファイルの値を変数に格納
                    $file = $_FILES['img'];
                    $filename = basename($file['name']);
                    $tmp_path = $file['tmp_name'];
                    $file_err = $file['error'];
                    $filesize = $file['size'];
                    //$upload_dir = "C:/xampp/htdocs/PHP自作/images/";
                    //$save_filename = date('ymdHis').$filename;

                    //ファイルサイズチェック
                    if ($filesize > 1048576 || $file_err == 2) {
                        $error['filesize'] = 'ファイルサイズは1MB未満にしてください。';
                    }
                    //拡張子が画像形式かチェック
                    $allow_ext = array('jpg', 'jpeg', 'png');
                    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (!in_array(strtolower($file_ext), $allow_ext)) {
                        $error['ext'] = "jpg、jpeg、png形式の画像ファイルを添付してください。";
                    }
                }
            }

            //総合評価
            if (empty($coffee['rating'])) {
                $error['evaluation'] = "<span style='color: red';>総合評価は必須入力です。</span>";
            } elseif (!preg_match('/^[1 2 3 4 5]+$/', $coffee['rating'])) {
                $error['evaluation'] = "不正な値です。";
            }
            //名称
            if (empty($coffee['name'])) {
                $error['name'] = "<span style='color: red';>名称は必須入力です。</span>";
            } elseif (mb_strlen($coffee['name']) > 50) {
                $error['name'] = "<span style='color: red';>名称は50文字以内で入力してください。</span>";
            }
            //購入店
            if (empty($coffee['place'])) {
                $error['place'] = "<span style='color: red';>購入店は必須入力です。</span>";
            } elseif (mb_strlen($coffee['place']) > 50) {
                $error['place'] = "<span style='color: red';>購入店は50文字以内で入力してください。</span>";
            }
            //価格
            if (!empty($coffee['price'])) {
                if (!preg_match('/^[0-9]+$/', $coffee['price'])) {
                    $error['price'] = "<span style='color: red';>半角数字で入力してください。</span>";
                } elseif ($coffee['price'] > 100000) {
                    $error['price'] = "<span style='color: red';>価格は10万以下で入力してください。</span>";
                }
            }
            //生産地
            if (mb_strlen($coffee['origin']) > 50) {
                $error['origin'] = "<span style='color: red';>生産地は50文字以内で入力してください。</span>";
            }
            //品種
            if (mb_strlen($coffee['variety']) > 50) {
                $error['variety'] = "<span style='color: red';>品種は50文字以内で入力してください。</span>";
            }
            //抽出方法

            //焙煎

            //公開設定
            if (empty($coffee['publish_status'])) {
                $error['publish_status'] = "<span style='color: red';>公開設定は必須入力です。</span>";
            } elseif (!preg_match('/^[1 2]+$/', $coffee['publish_status'])) {
                $error['publish_status'] = "<span style='color: red';>不正な値です。</span>";
            }
            //コメント
            if (mb_strlen($coffee['comment']) > 150) {
                $error['comment'] = "<span style='color: red';>コメントは150文字以内で入力してください。</span>";
            }

            return $error;
        } catch (\Exception $e) {
            $e->getMessage();
            exit();
        }
    }

    /**
     * idから指定データを取得
     * @param int $id
     * @return 　$result
     */
    public static function getId($id)
    {
        //データベース接続
        $dbh = connect();

        //SQL記述
        $sql = 'SELECT * FROM coffees WHERE id = :id';

        //SQL準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        //結果取得
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * user_idから指定データを取得
     * @param int $user_id
     * @return 　$result
     */
    public static function getUserId($user_id)
    {
        //データベース接続
        $dbh = connect();

        //SQL記述
        $sql = 'SELECT u.name,u.comment FROM users as u WHERE id = :id';

        //SQL準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', (int)$user_id, PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        //結果取得
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * 珈琲メモ更新
     * @param int $coffee
     * @return 　$result
     */

    public static function coffeeUpdate($coffee)
    {

        $evaluation = $coffee["rating"];
        $image = $coffee["image"];
        $name = $coffee["name"];
        $place = $coffee["place"];
        $price = $coffee["price"];
        $origin = $coffee["origin"];
        $variety = $coffee["variety"];
        $brew = $coffee["brew"];
        $roast = $coffee["roast"];
        $publish_status = $coffee["publish_status"];
        $comment = $coffee["comment"];
        $id = $coffee['id'];

        $sql = "UPDATE coffees SET 
                    name = :name, evaluation = :rating, place = :place, price = :price, origin = :origin, variety = :variety, brew = :brew, roast = :roast, image = :image, comment = :comment, publish_status = :publish_status
                 WHERE
                    id = :id";

        //DB接続
        $dbh = connect();
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':rating', (string)$evaluation, PDO::PARAM_STR);
            $stmt->bindValue(':place', $place, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->bindValue(':origin', $origin, PDO::PARAM_STR);
            $stmt->bindValue(':variety', $variety, PDO::PARAM_STR);
            $stmt->bindValue(':brew', $brew, PDO::PARAM_STR);
            $stmt->bindValue(':roast', $roast, PDO::PARAM_STR);
            $stmt->bindValue(':image', $image, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':publish_status', $publish_status, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }


    /**
     * idから指定データを削除
     * @param int $id
     * @return 　$result
     */
    public static function delete($id)
    {

        try {
            if (empty($id)) {
                exit("不正なIDです。");
            }
            //データベース接続
            $dbh = connect();
            $dbh->beginTransaction();

            //SQL記述
            $sql = 'DELETE FROM coffees WHERE id = :id';
            //SQL準備
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            //SQL実行
            $result = $stmt->execute();
            $dbh->commit();

            return $result;
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
            exit();
        };
    }


    /**
     * idのレコード数を取得
     * @param 
     * @return　 $result
     */
    public static function countUserId($user_id)
    {
        //DB接続
        $dbh = connect();
        try {
            //SQL準備
            $sql = "SELECT count(user_id=$user_id or null) FROM coffees";
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

            $dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }


    /**
     * ユーザー情報更新更新
     * @param int $user
     * @return 　$result
     */

    public static function userUpdate($user)
    {

        $name = $user["name"];
        $mail = $user["mail"];
        $comment = $user["comment"];
        $id = $user["id"];

        $sql = "UPDATE users SET 
                    name = :name, mail = :mail, comment = :comment
                 WHERE
                    id = :id";

        //DB接続
        $dbh = connect();
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }


    /**
     * idからアカウントを削除する
     * @param int $id
     * @return 　$result
     */
    public static function deleteUser($id)
    {

        try {
            if (empty($id)) {
                exit("不正なIDです。");
            }
            //データベース接続
            $dbh = connect();
            $dbh->beginTransaction();

            //SQL記述
            $sql = 'DELETE FROM users WHERE id = :id';
            //SQL準備
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            //SQL実行
            $result = $stmt->execute();
            $dbh->commit();

            return $result;
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
            exit();
        };
    }



    //ユーザーIDと投稿IDを元にいいね値の重複チェックを行っています
    public static function check_favolite_duplicate($user_id, $coffee_id)
    {
        $dbh = connect();
        $sql = "SELECT *
                FROM goods
                WHERE user_id = :user_id 
                AND coffee_id = :coffee_id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':user_id' => $user_id,
            ':coffee_id' => $coffee_id
        ));
        $favorite = $stmt->fetch();
        return $favorite;
    }



    public static function favoriteDone($user_id,$post_id)
  {
    $sql = 'INSERT INTO goods(user_id, coffee_id)
            VALUES (:user_id, :coffee_id)';
    
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':coffee_id', $post_id, PDO::PARAM_INT);
    $favorite = $stmt->execute();
    return $favorite;
  }

  public static function favoriteCancal($user_id,$post_id)
  {
    $sql = "DELETE
    FROM goods
    WHERE user_id = :user_id 
    AND coffee_id = :coffee_id";

    $stmt = connect()->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':coffee_id', $post_id, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
  }

  /**
     * いいね！の件数を取得
     * @param 　$login_user_id  $id
     * @return　 $result
     */
    public static function countGood($login_user_id,$id)
    {
        //DB接続
        $dbh = connect();
        try {
            //SQL準備
            $sql = "SELECT count
                    FROM goods
                    WHERE user_id = :user_id 
                    AND coffee_id = :coffee_id";
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':user_id', $login_user_id, PDO::PARAM_INT);
            $stmt->bindValue(':coffee_id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;

            $dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }

    /**
     * goodsの投稿idに対するレコード数を取得
     * @param 
     * @return　 $result
     */
    public static function countGoodC($id)
    {
        //DB接続
        $dbh = connect();
        try {
            //SQL準備
            $sql = "SELECT count(coffee_id=$id or null) 
                    FROM goods";
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

            $dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }


    /**
     *すべてデータを取得 (5件ごと)
     *
     *@param integer $page ページ番号
     *@return Array $result 珈琲メモデータ (5件ごと)
     */
    public static function getGoodUser($id)
    {
        $dbh = connect();
        $sql = "SELECT g.id,g.user_id,u.name as user_name
                FROM goods as g 
                INNER JOIN users as u 
                ON g.user_id = u.id
                WHERE g.coffee_id = $id";
        $sql .= ' ORDER BY g.id DESC';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

