<?php namespace MiniUrl;


Class Url{

    public $url_e;

    public $url;


    //метод получает переданныю строку от пользоватля и возвращает уже проверенную строку
    public function url_get_and_valid($url_u)
    {
        $this->url=trim(strip_tags(stripcslashes($url_u)));
        $this->url_e=parse_url($this->url);// $url_e присваиваем распарсенную сылку
        if(!empty($this->url_e['host']))
        {
            if (!strstr($this->url, "http://")) {
                echo 'нет http:// -- ' . $this->url;
                if (!strstr($this->url, "https://")) {
                    echo 'нет https:// -- ' . $this->url;
                    $this->url = "http://" . $this->url;
                }
            }
        } else
        {
            $this->url='';
        }
        return $this->url;
    }

    public function Show()
    {
        echo 'сылка из класса '.$this->url;
    }
    //Метод принемает строку от пользователя и выдает ответ существует ли она или нет
    /*  public function UrlExist($url_p) //передаем строку от пользователя
      {
          $this->url=$this->url_get_and_valid($url_p); // вызываем методо для проверки на коректность строки
          $this->url_e=parse_url($this->url);// $url_e присваиваем распарсенную сылку



          if (!empty($this->url_e['host']) and checkdnsrr($this->url_e['host'],"ANY"))
          {
            //  echo ' домен'.$this->url_e['host'].' существует ';
              // Ответ сервера
              $this->status_error[0]=1;
              $this->status_error[1]=' домен'.$this->url_e['host'].' существует ';

              $otvet=@get_headers($url_p);
              $ot=explode(' ', $otvet[0], 3);
              echo 'ответ сылки'.$ot[1];
              if ($ot[1]==200)
              {
                // echo $this->url;
                  $this->status_error[0]=1;
                  $this->status_error[1]=$this->status_error[1]." +сылка".$url_p." существует";

                 // $otve2t=@get_headers($url_p)
                 // echo $ot[1];
                  return array( $this->status_error,$this->url);

              }else
              {
                 // echo "а сылка".$url_p."не отвечает";
                  $this->status_error[0]=0;
                  $this->status_error[1]=$this->status_error[1]." +сылка".$url_p." не существует";
              }

          }else
          {
              $this->status_error[0]=0;
              $this->status_error[1] = ' домен' . $this->url_e['host'] . ' Не существует ';
              return array( $this->status_error,$this->url);
          }
              //echo ' домен'.$this->url_e['host'].' Не существует ';
          return array( $this->status_error,$this->url);
      }*/
}