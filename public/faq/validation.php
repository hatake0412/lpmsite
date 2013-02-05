<?php
  //宣言
  $sample = new CHK_SAMPLE();
  //メソッド実行
  $error = $sample->CHK_NULL($_POST['name'],$_POST['mail']);
?>
<html>
<head><title>サンプル</title></head>
<body>
 <form action="sample.php" method="POST">
  <font color="red">
 <?php
  if($error!="OK"){
   print $error;
  }
 ?>
  </font><br>
  <input type="text" name="name">
  <input type="text" name="mail">
 <?php
  if($error!="OK"){//エラーがあるとき
   print "<input type=\"submit\" name=\"送信\">";
   print "<input type=\"reset\" name=\"リセット\">";
  }else{
   print "<input type=\"submit\" name=\"送信\">";
  }
 ?>
 </form>
</body>
</html>
<?php
class CHK_SAMPLE{
  private $ERROR_MSG1 = "名前とメールアドレスが未入力です。";
  private $ERROR_MSG2 = "名前が未入力です。";
  private $ERROR_MSG3 = "メールアドレスが未入力です。";
  private $ERROR_MSG4 = "メールアドレスが間違っています。";
  private $KEKKA = "OK";//TRUEの場合の戻り値
  
  //NULL・空白チェック・メアドチェック
  /*----------------------------------------
    引数1：名前
    引数2：メールアドレス

    戻り値:「OK」メッセージ or エラーメッセージ
  ----------------------------------------*/
  public function CHK_NULL($CNAME,$CMAIL){
    if($CNAME!=NULL){
      if($CMAIL!=NULL){
        //名前・メールアドレスがNULLでない
        if($CNAME!=""){
          if($CMAIL!=""){
            //名前・メールアドレスが空白でない
            //メアドチェックも行う
            if($this->CHK_MAIL($CMAIL)=="OK"){
              return $this->KEKKA;
            }else{
              return $this->CHK_MAIL($CMAIL);
            }
          }else{
            return $this->ERROR_MSG3;
          }
        }else{
          //メールアドレスも空白
          if($CMAIL!=""){
            return $this->ERROR_MSG2;
          }else{
            return $this->ERROR_MSG1;
          }
        }
      }else{
        return $this->ERROR_MSG3;
      }
    }else{
      //メールアドレスもNULL
      if($CMAIL!=NULL){
        return $this->ERROR_MSG2;
      }else{
        return $this->ERROR_MSG1;
      }
    }
  }
  //メアドチェック(簡易)
  /*----------------------------------------
    引数1：メールアドレス

    戻り値:「OK」メッセージ or エラーメッセージ

    文字列「*****@******」に一致するか
    ※「*」は任意の文字列
  ----------------------------------------*/
  public function CHK_MAIL($CMAIL){
    if(preg_match("/^[^.]+\@[^.]+$/i", $CMAIL)){
      return $this->KEKKA;
    }else{
      return $this->ERROR_MSG4;
    }
  }
}
?>
