<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/19
 * Time: 22:10
 */
session_start();
$_mysqli = mysqli_connect('localhost', 'root', '123456', 'art_store');
mysqli_select_db($_mysqli, 'art_store');
$index = $_GET["index"];
$_mysqli->query('set names utf8');

$sql = $_SESSION["searchsql"];

$result = mysqli_query($_mysqli, $sql);

if($result)
    $totalCount = $result->num_rows;
$pageSize = 9;
$totalPage = (int)(($totalCount%$pageSize==0)?($totalCount/$pageSize):($totalCount/$pageSize+1));//强制类型转换
if(!isset($_GET['index']))//page的范围需要规定
    $currentPage = 1;
else
    $currentPage = $_GET['index'];

$mark = ($currentPage-1)*$pageSize;
$firstPage = 1;
$lastPage = $totalPage;
$prePage = ($currentPage>1)?$currentPage-1:1;//page的范围需要规定
$nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;//page的范围需要规定
$sql.=" limit $mark, $pageSize";
//$from = ($index - 1)*9;
//$to = $index * 9;
//$sql.=" limit $from, $to";
$result = mysqli_query($_mysqli, $sql);//搜索出来的表

echo "<table>";
for ($i = 0; $i < 3; $i++) {
    echo '<tr>';
    for ($j = 0; $j < 3; $j++) {

        //$row = $result->fetch_assoc();
        if ($row = $result ->fetch_assoc()) {
            $cut = mb_strimwidth($row['description'], 0, 250, '...');
            echo <<<CON
<td>
            <a href="detail.php?artworkID= {$row['artworkID']}">
                <img src="resources/img/{$row['imageFileName']}">
            </a>
            <p>{$row['title']}</p><p> By {$row['artist']}</p>
            <span>{$cut}</span><br>
            <button class="btn1"><a href="detail.php?artworkID={$row['artworkID']}">查看</a></button>
            <button class="btn2"><a>热度 {$row['view']}</a></button>
        </td>

CON;
        }
    }
    echo '</tr>';
}
echo "</table>";
//$sql = $_SESSION[''];




echo "<ul class=\"pagination\">
    <li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage($prePage)\">Previous</a></li>";

for($n = 1; $n <= $totalPage; $n++){
    echo "<li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage(this.innerText)\">".$n."</a></li>";
};

echo "<li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage($nextPage)\">Next</a></li>
</ul>";

echo $currentPage .'/'. $totalPage.'页';
?>
