<?php 

if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$notesOnPage = 7;
$fromPage = ($page - 1) * $notesOnPage;

$queryShowComment = "SELECT * FROM comment ORDER BY id DESC LIMIT $fromPage,$notesOnPage";
$comments = mysqli_query($link, $queryShowComment) or die(mysqli_error($link));

for ($data = []; $row = mysqli_fetch_assoc($comments); $data[] = $row);

$queryCountComments = "SELECT COUNT(*) as count FROM comment";
$resultCount = mysqli_query($link, $queryCountComments) or die(mysqli_error($link));
$count = mysqli_fetch_assoc($resultCount)['count'];
$pagesCount = ceil($count / $notesOnPage);



