<?php

  require 'libs/rb-mysql.php';

  R::setup('mysql:host=localhost;dbname=magnit_db', 'root', '');
  if (!R::testConnection()) exit ('Нет соединения с базой данных');
?>
