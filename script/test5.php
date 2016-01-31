<?php
include "/config.php";

# подготовка массива данных для записи в БД
$data_user = array(
    "userlongurl" => '', //полная ссылка
    "shortlink" => '', //короткое окончание для ссылки сгенерированное или введеное пользователем
    "lifetime" => '',// время жизни ссылки
    "autogenerate_flag" => ''//если флаг =1 то это автогенерация короткой сылки, =0 пользователем
);

$flag=3; //пользователь отметил что хочет ввести свою ссылку но не ввел, поле пустое

$DBH = new PDO("mysql:host=".HOST.";dbname=".NAME, USER, PASS); // подключение к БД
$STH1 = $DBH->prepare("SELECT redirect,time_life FROM link WHERE short = ?");
$STH2 = $DBH->prepare("SELECT short FROM link WHERE short=?");
$STH3 = $DBH->prepare("SELECT short,id FROM link WHERE redirect=? and autogenerate_flag=?");
$STH4 = $DBH->prepare("SELECT id FROM link ORDER BY id DESC LIMIT 1");
$STH5 = $DBH->prepare("INSERT INTO link ( redirect,short,time_life,autogenerate_flag ) values ( ?, ?, ?, ? )");

$urlget= new MiniUrl\Pars(); //объеки класса парсинга ссылки
$shurl= new MiniUrl\ShortURL(); // объект класса генерации короткого окончания ссылки


#проверяем нажал пользователь кнопку Уменьшить
if(!empty($_POST['save']))
{   #Да. Нажал.
    #Проверяем пришла ссылка от пользователя
    if(isset($_POST['longurl']) and $_POST['longurl']<>'')
    {#Да. Пришла.
        //$t=$_POST['longurl'];
        $str = $urlget->url_get_and_valid($_POST['longurl']);
        if (!empty($str))  // проверка ссылки вернула пустой результат, пользователь ввел не ссылку
        {
            $data_user['userlongurl'] = $str;
            #Проверяем пользователь не указывал время жизни
            if (isset($_POST['lifetimeoptions']) AND $_POST['lifetimeoptions'] == 0)
            {#Да. Не указывал
                $data_user['lifetime'] = 0;//бесконечная ссылка
            } else
            {#НЕТ. Указал.
                # Проверка корректности данных формы.
                if (!preg_match('/[0|30|60|120|300]/', $_POST['lifetimeoptions']))
                {
                    exit();
                }

                echo 'это время жизни' . $_POST['lifetimeoptions'];

                #Выборка значения.
                switch ($_POST['lifetimeoptions'])
                {
                    case '0':
                        $data_user['lifetime'] = 0;
                        break;
                    case '30':
                        $data_user['lifetime'] = 30;
                        break;
                    case '60':
                        $data_user['lifetime'] = 60;
                        break;
                    case '120':
                        $data_user['lifetime'] = 120;
                        break;
                    case '300':
                        $data_user['lifetime'] = 300;
                        break;
                    default:
                        $data_user['lifetime'] = 0;
                }
                $data_user['lifetime']=strtotime("now". $data_user['lifetime']." minutes");
            }
            #Пользователь указал что хочет создать свою
            if (isset($_POST['ownlink'])) {#Да
                echo "хочу свою ссылку";
                #Поле не пустое?
                if (!empty($_POST['ownshorturl']) and $_POST['ownshorturl'] <> '')
                {#Да
                    echo "я что то ввел свое";
                    echo 'первый вывод' . $data_user['userlongurl'];
                    $own = '/' . $_POST['ownshorturl'];
                    echo ' $g= ' . $g;

                    //подготовка для проверка есть ли в бд запись введеной пользователем короткой сылки

                    $STH2->bindParam(1, $own);
                    $STH2->execute();

                    $result = $STH2->fetch(PDO::FETCH_ASSOC);
                    $resshort = $result["short"];

                    echo "resshort= " . $resshort;

                    // проверка записи
                    if (!empty($resshort))
                    {
                        $flag = 1; // в БД есть такое окончание
                    } else
                    {
                        $flag = 2;
                        $data_user['autogenerate_flag'] = 0;
                        // такого окончания нету
                    }
                } else
                {#Нет
                    echo "Вы не ввели свою ссылку";
                }
            } else
            {#НЕТ
                $flag = 0; // свою сылку пользователь не хочет создать
                $data_user['autogenerate_flag'] = 1;
            }
            if ($flag == 1)// в БД есть такое окончание
            {
                echo "есть запись введите другую" ;
                echo "введите другое короткое окончание";

            } elseif ($flag == 0)// свою сылку пользователь не хочет создать генерируем ему сами
            {
                echo 'первый вывод' . $data_user['userlongurl'];
                $g = $data_user['userlongurl'];
                echo ' $g= ' . $g;
                //подготовка для проверка есть ли в бд короткая сылка  на введеную длинную  пользователем

                $STH3->bindParam(1, $g);
                $STH3->bindParam(2, $autogenerate_flag);
                $autogenerate_flag = 1;

                $STH3->execute();
                $result = $STH3->fetch(PDO::FETCH_ASSOC);

                $resshort = $result["short"];
                echo "resshort= " . $resshort;
                $resid = $result["id"];
                echo 'ghdhd' . $resid;

                //проверка записи
                if (!empty($resshort) and $data_user['lifetime'] == 0) {#Да есть
                    $t = $_POST['longurl'];
                    $urlget->parse_ulr($t);

                    $shortlink = $urlget->dd . $resshort;//короткая сылка передается в шаблонизатору твиг
                    echo "есть запись" . $shortlink;
                    $flag = 1;//говорит о том что сылка короткая есть
                } else
                {#Нет генерируем сами
                    $t = $_POST['longurl'];
                    $urlget->parse_ulr($t);

                    $STH4->execute();
                    $result = $STH4->fetch(PDO::FETCH_ASSOC);
                    $res = $result["id"] + 1;
                    $resid = $res;

                    echo '<br> максимальный id' . $res . '</br>';

                    $new_hash = '/' . $shurl->encode($res);
                    echo '$new_hash=' . $new_hash;

                    $data_user['shortlink'] = $new_hash;
                    $data_user['autogenerate_flag'] = 1;
                    $shortlink = $g . $new_hash;//короткая сылка передается в шаблонизатору твиг
                }
            } else
            {// в БД нет такого окончания введеного пользователем, подготавливаем даные для сохранения в БД
                $t = $_POST['longurl'];
                $urlget->parse_ulr($t);
                $data_user['shortlink'] = '/' . $_POST['ownshorturl'];
            }
            if ($flag == 1 or $flag == 3)//сылка короткая была найдена по введеной пользователем или пользователь отметил
                // что хочет ввести свою сылку но не ввел, поле пустое
            {
            } else {# во всех остальных случаях сохраняем в БД данные
                echo "создание записи в бд" . '<br>';
                echo $data_user['userlongurl'] . '<br>';
                echo $data_user['shortlink'] . '<br>';
                echo $data_user['lifetime'] . '<br>';
                echo $data_user['autogenerate_flag'] . '<br>';

                $data = array($data_user['userlongurl'], $data_user['shortlink'], $data_user['lifetime'], $data_user['autogenerate_flag']);
                $STH5->execute($data);

                $shortlink = $urlget->dd . $data_user['shortlink'];//короткая сылка передается в шаблонизатору твиг
            }
        } else
        {
            echo 'Вы ввели не сссылку';
        }
    } else
    {
        echo "вы не ввели длинную ссылку";
    }

} else
{#НЕТ. Не нажал.
}

#Проверяем, пользователь нажал кнопку Перейти.
if(!empty($_POST['enter']))
{#Да. Нажал.
    if (!empty($_POST['shortlink']) and $_POST['shortlink']<>'')
    {
        $str = $urlget->url_get_and_valid($_POST['shortlink']);

        if (!empty($str)) // проверка пользователь ввел сылку?
        {
            //ДА введена короткая сылка
            echo 'вот что пришло ' . $str;
            $urlget->parse_ulr($str);
            echo '<br> вот что распарсили' . $urlget->tt;

            $STH1->bindParam(1, $urlget->tt);
            $STH1->execute();

            $result = $STH1->fetch(PDO::FETCH_ASSOC);
            $reslong = $result["redirect"];
            $restime = $result["time_life"];
            echo "timebase=".$restime.'<br>';
            if($restime == '0')
            {
                echo 'жизнь этой ссылки бесконечна ' . $reslong.'<br>';
                echo 'вот длинная ссылка найденая по короткой ' . $reslong;
                header('Refresh:5; URL='.$reslong);
            }else
            {
                $time=strtotime("now");
                if(($time-$restime)<0)
                {
                    echo "timenow=".date('H:i d.m.Y',$time).'<br>';
                    echo "timebase=".date('H:i d.m.Y',$restime);
                    header('Refresh:5; URL='.$reslong);
                    exit;
                }
                header('Refresh:5; URL=http://localhost/miniurl2/');
            }
        } else
        {
            echo "Вы  ввели не ссылку";
        }
    }else
    {
        echo "Вы не ввели короткую ссылку";
        header('Refresh:5; URL=http://localhost/miniurl2/');
    }

} #НЕТ. Не нажал.


