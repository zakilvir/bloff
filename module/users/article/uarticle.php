<?php


$post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$page."'"));
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$post['author']."'"));


$comments = mysqli_fetch_array(mysqli_query($COMMENTBD, "SELECT * FROM `uarticles".$page."`"));
if (!$comments) {
  $sql = "CREATE TABLE `uarticles".$page."` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
  mysqli_query($COMMENTBD, $sql);
};



if ($post['status'] == "inspection") {//UCLASS("admin");
  if ($_SESSION['position'] != 'admin' and $post['author'] != $_SESSION['id']) {MessageSend(1,"Вы не можете просматривать эту страницу","/");};
};
 $title=$post['name']; include 'blocks/header.php';

echo '<a href="javascript:history.back();" style="display:inline-block;" >Назад</a>';
echo "<span style=\"float:right;display:inline-block;\">"./*$author['name']." ".$author['lastname']."  ".*/$post['date']."</span>";
echo "<hr><span style=\"font-size:27px;font-weight: 600;display:inline-block;\" >".$post['name']."</span>";
if ($_SESSION['id'] == $post['author'] or $_SESSION['position'] == 'admin') {
echo '<br><a href="'.$page.'/edit" class="smalla" >Edit</a> ';
echo '<a href="'.$page.'/delete" class="smalla" >Delete</a> ';};
if ($_SESSION['position'] == 'admin' and $post['status'] == 'inspection' ) {
echo '<a href="'.$page.'/verify" class="smalla" >Verify</a> ';
};
echo "<br>".$post['text'];
echo "<br><br><span style=\"float:right;\">Author - <a href=\"/".$post['author']."\" class=\"postname\" >".$author['name']." ".$author['lastname']."</a></span><br>";

$commentsNumber = mysqli_fetch_array(mysqli_query($COMMENTBD , "SELECT COUNT(*) FROM `uarticles".$page."`"));
$i = $commentsNumber[0];
$MainCommentsNumber = mysqli_fetch_array(mysqli_query($COMMENTBD , "SELECT COUNT(*) FROM `uarticles".$page."` WHERE `mainid`=0 "));

echo '<center>Комментарии('.$MainCommentsNumber[0].')</center>';
echo '<div style="display:inline-block;width:100%;">';
while ($i >= 1) {
$comment = mysqli_fetch_array(mysqli_query($COMMENTBD, "SELECT * FROM `uarticles".$page."` WHERE `id` = '".$i."'"));
if ($comment['mainid']=="0") {
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$comment['user']."'"));

echo '
<div class="comments" ><a href="/'.$comment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;">  '.$comment['date'].' '.$comment['time'].'</span><br>'.$comment['text'];
if ($_SESSION['status']=='login' and $comment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$comment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';
}
$daughterCommentsCount = mysqli_fetch_array(mysqli_query($COMMENTBD, "SELECT COUNT(*) FROM `uarticles".$page."` WHERE (`mainid` = '".$comment['id']."')"));
if ($daughterCommentsCount[0]) {
$daughterCommentResult = mysqli_query($COMMENTBD, "SELECT * FROM `uarticles".$page."` WHERE (`mainid` = '".$comment['id']."') ORDER BY id ASC, date DESC LIMIT $daughterCommentsCount[0]");
while($daughterComment = mysqli_fetch_array($daughterCommentResult)) {
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$daughterComment['user']."'"));

echo '
<div class="comments2" ><a href="/'.$daughterComment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;"> '.$daughterComment['date']." ".$daughterComment['time']."</span><br>".$daughterComment['text'];
if ($_SESSION['status']=='login' and $daughterComment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$daughterComment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';
;};};
$i--;
};
echo '</div>';
if ($_SESSION['status']=='login') {
 ?>



<br><br>
<form class="" action="/users/article/query/commentadd" method="post">
  <input type="hidden" name="id" value="<?php echo '/'.$module.'/'.$page; ?>" >
    <input type="hidden" id="mainid" name="mainid" value="0" >
  <input type="hidden" name="tablename" value="<?php echo "uarticles".$page; ?>" >
  <div style="display:inline-block;width:90.1%;">
    <textarea type="text" id="textarea" name="text" placeholder="Text" required></textarea>
  </div><br>
    <div class="addButton" style="display:inline-block;width:30px;" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить видео" id="addvideo">В</div>


  <input style="float:right;position:relative;top:15px;" type="submit" name="add" value="Отправить">
</form>
<? }; include 'blocks/content.php'; ?>
