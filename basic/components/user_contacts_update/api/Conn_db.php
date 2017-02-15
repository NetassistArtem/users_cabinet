<?php





class Conn_db {

    private static $connection;
    private $PDO;
    private function __clone(){}
    private function __wakeup(){}


    private   function __construct($host, $db_name, $user, $pass){
     //   try{
        $dsn = "mysql:host=$host;dbname=$db_name";

        $this->PDO = new PDO($dsn, $user, $pass);
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //  }catch (PDOException $e){
        //     throw new Exception($e->getMessage(),1044);
          //  }


    }

    public static function getConnection($host, $db_name, $user, $pass)
    {


            if(!self::$connection){
                self::$connection = new Conn_db($host, $db_name, $user, $pass);
            }

            return self::$connection;


    }

    /**
     *
     *
     * Используя методы объекта PDO  prepare($sql), execute($placeholders), fetchAll(PDO::FETCH_ASSOC)
     * плучает данные из базы данных на основании sql запроса, использование $placeholders исключает возможность sql инъекций
     */
    public function getDate($sql, array $placeholders=array())
    {
        //$this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sth = $this->PDO->prepare($sql);

        //$sth->bindParam(':from', $from, PDO::PARAM_INT);
       // $sth->bindParam(':count', $count, PDO::PARAM_INT);

        $sth->execute($placeholders);
        $date = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $date;

    }

    /**
     *
     *
     * Возвращает объект подключения PDO. Это дает возможность обращаться к свойствам и методам класса PDO
     */
    public function getPDO()
    {
        return $this->PDO;
    }

    
}