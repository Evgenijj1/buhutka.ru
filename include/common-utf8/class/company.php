<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/config.php');

$GLOBALS['from']="noreply@".Get::SERVER_NAME();

class Company implements ArrayAccess{
	const db_prefix=db_prefix;
    const limit_request=50; // кол-во бесплатных запросов
    const min_cost=1; // минимальная стоимость запроса, коп
    static public $_adm=[0=>'Клиент',1=>'Почта подтверждена',2=>'Оптовый-клиент',3=>'VIP-Клиент',4=>'Бывший сотрудник',5=>'Сотрудник',9=>'Забанен',uADM_HELPER=>'Помощник Админа', uADM_ADMIN=>'Админ'];

    static public $__adm=[0=>'Клиент',1=>'Почта подтверждена',2=>'Оптовый-клиент',4=>'VIP-Клиент',8=>'Бывший сотрудник',16=>'Тренер',32=>'Сотрудник',34=>'Забанен',128=>'Помошник админа',256=>'Админ'];


    public static $ar_fields=['INN','KPP','OKPO','accountant','chief','phone']; // список полей, изменяемых пользователем
    public static $ar_fields_nochange=['id','name','address','checking_account']; // то что менять автоматически нельзя


    private $user=[];

    /** вызывается при обращении к неопределенному свойству
* @param $property
* @return bool|int|null|string
*/
    function __get($property){
        if(is_null($this->user))return null;
        elseif(isset($this->user[$property]))return $this->user[$property];
            else return '';
    }

    /** вызывается, когда неопределенному свойству присваивается значение
     * @param $property
     * @param $value
     */
    function __set($property, $value){
        if(in_array($property,['tel','api_key','rss'])){
            DB::sql('UPDATE '.self::db_prefix.'user SET '.$property.'="'.$value.'" WHERE id='.$this->id); // сбрасываю хеш
            $this->user[$property]=$value;
            if($this->id==User::id()&&isset($_SESSION['user']['id'])){
                $_SESSION['user'][$property]=$value;
            }
            if( isset($_SESSION['LastUser']['id']) && $_SESSION['LastUser']['id']==$this->id){
                $_SESSION['LastUser'][$property]=$value;
            }
        }else die("Нет обработки сохранения user::".$property);
        DB::CacheClear('user',$this->id);  // сбрасываю хеш
    }


    function __call($name,$arr){// - вызывается при обращении к неопределенному методу
        if($name=='ed'){
            if( $this->ed=='минут' )
                return num2word($arr[0], ["минута", "минуты", "минут"]);
            else
                return $this->ed;
        }elseif(isset($this->user[$name])){
            return $this->user[$name];
        }else die("Нет метода user::".$name);

    }

    /**
     * @param       $name
     * @param array $params
     * @return mixed
     */
    public static function __callStatic($name,array $params)
    {
        if(isset($_SESSION['user'][$name])){
            return $_SESSION['user'][$name];
        }elseif(in_array($name,['id','adm'])){
            return 0;
        }elseif(in_array($name,['api_key'])){
            return 'НЕДОСТУПНО_БЕЗ_РЕГИСТРАЦИИ';
        }else die('Вы хотели вызвать '.__CLASS__.'::'.$name.', но его не существует, и сейчас выполняется '.__METHOD__.'()');
    }

    public static function id(){ // внутри класса вызывает __call
        return (isset($_SESSION['user']['id'])?$_SESSION['user']['id']:0);
    }

    /**
     * @param integer $user
     */
    public function __construct($user = null){
        if(is_object($user)){
            return $user;
        }elseif(is_array($user) && (!empty($user['id']) || !empty($user['mail'])) ){
            $this->user=$this->GetUser($user);
        }elseif($user>0){
            if( !empty($_SESSION['user']['id']) && $_SESSION['user']['id']==$user){
                $this->user=$_SESSION['user'];
            }elseif( isset($_SESSION['LastUser']['id']) && $_SESSION['LastUser']['id']==$user){
                $this->user=$_SESSION['LastUser'];
            }else
                $this->user=$this->GetUser($user);
        }else
            $this->user=null;

        //echo "<br><br>";var_dump($this->user);
        if($user==0){}
        elseif($this->user==null && isset($user['ban'])){}
        elseif($this->user==null && isset($_SESSION['user'])){
            AddToLog("Ошибка в коде пользователя: ".var_export($user,!0).dump("POST",$_POST).dump("GET",$_GET).dump("SESSION",$_SESSION).dump("COOKIE",$_COOKIE));
        }elseif(!isset($_SESSION['user']['id']) || $this->id!=$_SESSION['user']['id'] ) $_SESSION['LastUser']=$this->user;// кеширую последнего пользователя
        return $this;
    }

    static function _GetVar($user,$var){
        $t=new User($user);
        //echo "<br><br>".var_dump($t);
        return $t->$var;
    }

    static function _SetVar($user,$key,$value){
        $user=self::GetUser($user);
        if(!$user){
            AddToLog('User не определен',false,true);
            return false;
        }elseif(in_array($key,['id','time','info','adm','mail','name','pass'])){ // то что менять автоматически нельзя
            return false;
        }else{
            $user[$key]=$value;
            DB::sql('UPDATE `'.self::db_prefix.'user` SET '.$key.'="'.addslashes($value).'" WHERE id="'.intval($user['id']).'"');
        }
        if( !empty($_SESSION['user']['id']) && $_SESSION['user']['id']==$user['id']){
            $_SESSION['user']=$user;
        }elseif( isset($_SESSION['LastUser']['id']) && $_SESSION['LastUser']['id']==$user['id']){
            $_SESSION['LastUser']=$user;
        }
        global $_user;
        if($_user->id==$user['id']) $_user->$key=$value;
        return true;
    }

    /**
     * @param int|array $user
     * @return array|null
     */
    static function GetUser($user=null){
        if(!$user){
            return null;
        }elseif(!is_array($user)){// если передается только id из кеша не брать!
            if($user>0){
                DB::CacheClear("user", intval($user));
                $user=DB::Select("user", intval($user) );
            }
            if(!$user)return null;
        }
        if(empty($user['id'])){
            if(!empty($user['mail'])){
                $user=DB::Select("user", "mail='".addslashes($user['mail'])."'"); if(!$user)return null;
            }else return null;
        }
        //$user['adm']=($user['id']<2? 99 : intval($user['adm']) );// первый всегда админ
        $user['adm']=intval($user['adm']); if($user['id']==1)$user['adm']=uADM_ADMIN;
        $user['name']=str_replace("'","`",$user['name']);
        $user['user_name']=($user['fullname']?$user['fullname']:($user['name']?$user['name']:$user['mail']));
        if(isset($user['info'])&&$user['info']&&!is_array($user['info'])){
            $user['info']=json_decode($user['info'],!0);
        }
        foreach($user as $key => $value)$user[$key]=str_replace('"',"'",$value);
        return $user;
    }

    /** сохранение изменений анкеты, если я admin, то я могу сохранять других пользователей
     * @param array $user
     */
    static function Save($company){

    }

    static function setLastModified($time=0){
        $_SESSION['Last-Modified']=(empty($time)?time():$time);
        if(empty($_SESSION['message'])&&empty($_SESSION['error'])){
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $_SESSION['Last-Modified']).' GMT');
        }
    }


}

