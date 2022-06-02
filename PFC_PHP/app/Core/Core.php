<?php
    class Core
    {
        //urlGet pega a url 
        public function start($urlGet){
            // se no parametro  da url existir o parametro pagina
            if(isset($urlGet['pagina']))
            { 
                // verifica o controller e deixa a primeira letra em maiuscula
                $controller=ucfirst($urlGet['pagina'].'Controller'); // pagina da url ex home + Controller=HomeController

            }
            else{ // senão o parametro pagina não  existir define a home como primeira pagina
                $controller='UsuarioController';
            }
             
            // verifica se existe um parametro metodo
            if(isset($urlGet['metodo'])){
                $acao=$urlGet['metodo'];
            }
            else{
                $acao='index';
            }
             

             // verificando se a pagina existe
             if(!class_exists($controller)){
                //  manda para o controller ErroController
                 $controller='ErroController';
             }
            

             // chamando os metodos do controller 
             // onde os parametros são controller, metodo e acao recebe o nome do metodo que quero chamar 

             if(isset($urlGet['id']) && $urlGet['id'] !=null ){
                $id=$urlGet['id'];
             }
             else{
                 $id=null;
             }
             call_user_func_array(array(new $controller,$acao),array('id'=>$id));
             
        }
    }
?>