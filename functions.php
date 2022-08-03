<?php 

/**
 * XSS対策：エスケープ処理
 * 
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES,'UTF-8');
}

/**
 * XSS対策：エスケープ処理2
 * 
 * @param string $str $formData[配列]
 * @return string $clean
 */
function html($formData) {
    foreach ($formData as $key => $value) {
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
    return $clean;
}

/**
 * XSS対策：エスケープ処理3
 * 
 * @param string $str $formData[配列]
 * @return string $clean
 */
function html2($allData)
    {
        for ($i = 0; $i < count($allData); $i++) {
            foreach ($allData[$i] as $key => $value) {
                $clean[$i][$key] = htmlspecialchars($value, ENT_QUOTES);
            }
        }
        return $clean;
    }

/**
 * CSRF対策
 * @param void
 * @return string $csrf_token
 */
function setToken() {
    //トークン生成
    //フォームからそのトークンを送信
    //送信後画面でトークン照会
    //処理完了後トークン削除
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}


// ランダムな4桁の数字の生成
function generateCode($length = 4)
{
    $max = pow(10, $length) - 1;                    // コードの最大値算出
    $rand = random_int(0, $max);                    // 乱数生成
    $code = sprintf('%0'. $length. 'd', $rand);     // 乱数の頭0埋め

    return $code;
}

// SQL実行関数
function queryPost($dbh, $sql, $data){
	// クエリ作成
	$stmt = $dbh->prepare($sql);
	// SQL文を実行
	if(!$stmt->execute($data)){
		
		$err_msg['common'] = 'エラー発生';
		return 0;
	}
	return $stmt;
}

function getGood($p_id){
	
	try {
		$dbh = Connect();
		$sql = 'SELECT * FROM goods 
                WHERE post_id = :p_id';
		$data = array(':p_id' => $p_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt){
			return $stmt->fetchAll();
		}else{
			return false;
		}
	} catch (Exception $e) {
		error_log('エラー発生：'.$e->getMessage());
	}
}

function isGood($u_id, $p_id){

	try {
		$dbh = Connect();
		$sql = 'SELECT * FROM goods 
                WHERE post_id = :p_id 
                AND user_id = :u_id';
		$data = array(':u_id' => $u_id, ':p_id' => $p_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);

		if($stmt->rowCount()){
			
			return true;
		}else{
			
			return false;
		}

	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
	}
}

?>