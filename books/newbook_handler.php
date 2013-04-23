<?php
require_once 'dbmanager.php';
$manager=DBManager::getInstance();
$con=$manager->getConnection();
mysql_select_db("books",$con);
$aid = $_POST['aid'];
$bid = $_POST['bid'];
$name = $_POST['name'];
$title = $_POST['title'];
$subjects = explode (",", $_POST['subjects']);
$description = $_POST['description'];
mysql_query("insert into Books (book_id, title, description) values ('$bid', '$title', '$description');");
mysql_query("insert into Authors (author_id, name) values ('$aid', '$name');");
mysql_query("insert into Link_BookAuthors (book_id, author_id) values ('$bid', '$aid');");
$sz = count($subjects);
for ($i=0; $i<$sz; $i++) {
	mysql_query("insert into Subjects (book_id, subject) values ('$bid', '$subjects[$i]');");
}
 echo $_SESSION['login_name'];
?>