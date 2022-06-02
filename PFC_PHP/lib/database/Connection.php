<?php 
    // essa classe é uma classe que faz conexao com o banco de dados,  por isso não está na models

    abstract class Connection{ // classe do tipo abstrata(não pode ser instanciada)
        // atributo
        private static $conn;

        
         // metodos devem ser estaticos para poderem ser chamados sem instaciar a classe

        public static function getConn(){
           if(self::$conn==null){
                self::$conn=new PDO('mysql:host=localhost;dbname=pfc', 'root','');
           }  
           return self::$conn;
        }
    }
?>