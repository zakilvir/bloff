<?php

if ($_SESSION['status'] != 'login') {MessageSend(1,"Вы не можете просматривать эту страницу","/");} else {
if ($_SESSION['acc_verification'] != 1) {MessageSend(1,"Для того чтобы добавлять статьи вы должны активировать свой профиль по почте ".$_SESSION['email'],"/".$_SESSION['id']);}

 $title="Add article"; include 'blocks/header.php';
?>
<div class="description">
<p>После сохранения запись будет отправлена на проверку.Пожалуйста не нарушайте правила.</p>
</div>
<br>
<form class="" action="/users/article/query/add" method="post">
  <label >Name : </label><input type="text" name="name" placeholder="Name" required><hr>
  <label >Category : </label><select class="" name="category">
    <option value="CSS">CSS</option>
    <option value="HTML">HTML</option>
    <option value="PHP">PHP</option>
    <option value="JavaScript">JavaScript</option>
    <option value="Business">Business</option>
  </select>
  <hr>
  <div style="display:inline-block;width:90.1%;">
    <textarea type="text" id="textarea" name="text" placeholder="Text" cols="90" rows="5" style="height:330px;min-height:160px; max-width: 97%; min-width: 97%;padding:10px;" required></textarea>
  </div>
  <div style="display:inline-block;width:9%;position:relative;bottom:13px;">
    <div class="addButton" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" title="Вставить видео" id="addvideo">В</div>
  </div>


  <input type="submit" name="add" value="add">
</form>

<?php include 'blocks/content.php'; }; ?>
