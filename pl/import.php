#!/usr/bin/php
<?php
function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

$data="";
$link=0;

function make_chan($t, $u) {
global $data,$link;
$data->playlist->pl[0]->media->id=trim($u);
$data->playlist->pl[0]->media->title=$t;
$data->opts->pagetitle=$t;
$tr = translit($t);
$json = json_encode($data);
$time=time();
echo "$t=>$u";
file_put_contents("../chandump/$tr", $json);
$query = "INSERT INTO `channels` (`id`, `name`, `owner`,`time`) VALUES (NULL, '$tr', 'farlake',$time)";
//echo $query;
mysqli_query($link,$query);
$res=file_get_contents("http://tube.lazyhome.ru/r/$tr");
echo $res;
}

// Загружаем данные из файла в строку
$string = file_get_contents("template.json");
// Превращаем строку в объект
$data = json_decode($string);
// Отлавливаем ошибки возникшие при превращении
switch (json_last_error()) {
  case JSON_ERROR_NONE:
    $data_error = '';
    break;
  case JSON_ERROR_DEPTH:
    $data_error = 'Достигнута максимальная глубина стека';
    break;
  case JSON_ERROR_STATE_MISMATCH:
    $data_error = 'Неверный или не корректный JSON';
    break;
  case JSON_ERROR_CTRL_CHAR:
    $data_error = 'Ошибка управляющего символа, возможно верная кодировка';
    break;
  case JSON_ERROR_SYNTAX:
    $data_error = 'Синтаксическая ошибка';
    break;
  case JSON_ERROR_UTF8:
    $data_error = 'Некорректные символы UTF-8, возможно неверная кодировка';
    break;  
  default:
    $data_error = 'Неизвестная ошибка';
    break;
}
// Если ошибки есть, то выводим их
if($data_error !='') 
		die ("$data_error");

$link = mysqli_connect('localhost', "cytube3", 'TubeGuru1973', 'cytube3');
if ( !$link ) die("DB Error");

$topic = '';
$url = '';

$fp=fopen('list.m3u','r');
if ($fp) 
{
while (!feof($fp))
{
$text = fgets($fp, 999);

if (preg_match_all("/#EXTINF:(-1|\d*),(.*)/i", $text,$out))
	{
	$topic=$out[2][0];
	}

if (preg_match("/^http/i", "$text") && $topic !="")
        {
        $url=$text;
	make_chan($topic,$url);
	$topic='';
        }
}
}
else echo "Ошибка при открытии файла";
fclose($fp);
mysqli_close($link);
?>
