<?php 
    // é o intermediario entre a model Anotacoes e as views envolvendo anotacoes
    class UsuarioController
    {
        // essa função chama o formulario login
        public function index()
        {
           
           try{
         
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);
            
            $parametros=array();
           
            // renderizando minha view com parametros(graças ao twig)
            $template = $twig->load('login.html'); // página de criar anotação
            $conteudo= $template->render($parametros);
            echo($conteudo);
           }
           catch(Exception $e){
                echo '<script>alert("'.$e->getMessage().'");</script>';
           }
        }

        // função que chama o método logar da model
        public function logar()
        {
            $email_login=$_POST['emailUsuarioLogin'];
            $senha=$_POST['senhaUsuarioLogin'];
            try{
                // instanciando classe Anotacoes
                $objeto_usuario=new Usuario();
                // atribuindo valores aos sets 
                $objeto_usuario->setEmail($email_login);
                $objeto_usuario->setSenha($senha);
                // chamando método de login 
                $objeto_usuario->logar($objeto_usuario->getEmail(),$objeto_usuario->getSenha());
                // se deu tudo certo redireciona para a home
                header('location:http://localhost/PFC_PHP/?pagina=Anotacoes');

            }
            catch(Exception $e){
                echo '<script>alert("Senha ou email invalidos");</script>';
                echo '<script>location.href="http://localhost/PFC_PHP/?usuario&metodo=index"</script>';
            }
        }

        // função que chama a view cadastrar usuario
        public function formCadastrar()
        {
            try{
         
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                
                $parametros=array();
               
                // renderizando minha view com parametros(graças ao twig)
                $template = $twig->load('formCadastrar.html'); // página de criar anotação
                $conteudo= $template->render($parametros);
                echo($conteudo);
               }
               catch(Exception $e){
                    echo '<script>alert("'.$e->getMessage().'");</script>';
               }
        }

         // função que realiza o cadastro do usuario
         public function cadastrarUsuario()
         {
            $nome=$_POST['nomeUsuario'];
            $email=$_POST['emailUsuario'];
            $senha=$_POST['senhaUsuario'];
            try
            {
                 // instanciando classe Anotacoes
                $objeto_usuario=new Usuario();
                // preenchendo atributos do objeto com o método set com os valores recebidos do formulário
                $objeto_usuario->setNome($nome);
                $objeto_usuario->setEmail($email);
                $objeto_usuario->setSenha($senha);
                // usando métodos get para colocar como parametros no método criar anotação
              
                $objeto_usuario=$objeto_usuario->cadastrarUsuario($objeto_usuario->getNome(),$objeto_usuario->getEmail(),$objeto_usuario->getSenha());
               
                echo '<script>alert("conta criada com sucesso");</script>';
                echo '<script>location.href="http://localhost/PFC_PHP/?usuario&metodo=index"</script>';

            }
            catch(Exception $e)
            {
                echo '<script>alert("'.$e->getMessage().'");</script>';
                echo '<script>location.href="http://localhost/PFC_PHP/?usuario&metodo=formCadastrar"</script>';
            }
         }


    }
?>