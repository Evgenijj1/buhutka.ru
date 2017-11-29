<?
require_once($_SERVER['DOCUMENT_ROOT'].'/include/config.php');

$GLOBALS['from']="noreply@".Get::SERVER_NAME();

class Company implements ArrayAccess{
	const db_prefix=db_prefix;
    public static $ar_fields=['INN','KPP','OKPO','accountant','chief','phone','name','OGRN','address','rs']; // список полей, изменяемых пользователем
    public static $ar_fields_nochange=['id']; // то что менять автоматически нельзя


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
        DB::CacheClear('user',$this->id);  // сбрасываю хеш
    }


    function __call($name,$arr){// - вызывается при обращении к неопределенному методу

    }

    /**
     * @param       $name
     * @param array $params
     * @return mixed
     */
    public static function __callStatic($name,array $params)
    {
        
    }

    public static function save(){
        
    }
}