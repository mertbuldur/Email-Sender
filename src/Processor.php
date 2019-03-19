<?php
namespace EmailTask;
interface  ProcessInterface
{
    public function __construct($host,$dbname,$uname,$upass);
    public function add($email,$subject,$text,$sendDateTime); // task ' e eklenecek verileri gösteren method
    public function start(); // task i çalıştıracak method
}
use \PDO;

class Processor  implements ProcessInterface
{
   public $db;
    public function __construct($host,$dbname,$uname,$upass)
    {
        try {
            $this->db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8", $uname, $upass);
            $sql = "CREATE TABLE email (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                        email VARCHAR(255) NOT NULL,
                        text TEXT NOT NULL,
                        subject VARCHAR(255),
                        sendDateTime DATETIME
                  )";

            if($this->db->query("show tables like email")->rowcount() ==0) {
                $this->db->query($sql);
            }

        }
        catch (\PDOException $e)
        {
            echo $e->getMessage();
        }


    }

    public function add($email, $subject, $text, $sendDateTime = null)
    {

        $sendDateTime = ($sendDateTime!="") ? $sendDateTime : date("Y-m-d H:i:s");
        $insert = $this->db->prepare("insert into email(email,subject,text,sendDateTime) values (?,?,?,?)");
        $create = $insert->execute(array($email,$subject,$text,$sendDateTime));
        if($create)
        {
            echo "Task eklendi";
        }
        else
        {
            echo "Task Eklenemedi";
        }
    }

    public function start()
    {
        $nowDateTime = date("Y-m-d H:i:s");
        $count = $this->db->query("select * from email where sendDateTime <= '".$nowDateTime."' ")->rowcount();
        if($count !=0)
        {
            $data = $this->db->query("select * from email where sendDateTime <= '".$nowDateTime."' order by sendDateTime asc limit 1")->fetch(PDO::FETCH_ASSOC);

            // 1. Mail Gönderme işlemleri


            // 2. Ekrana mesaj ver
            echo $data['id']." id li task gönderildi";
            // 3. Task Silinmesi
            $query = $this->db->prepare("delete from email where id = ?");
            $query->execute(array($data['id']));
        }
        else
        {
            echo "Task Yok";
        }
    }

}