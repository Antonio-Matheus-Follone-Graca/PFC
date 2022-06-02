<?php 
     class Usuario
     {
         // adicionar mais atributos depois(os da documentação), porém so usar o email e senha como testes
         //atributos
        private  $nome; 
        private  $email;
        private  $senha; 
     

        // gets dos atributos 

        public function getNome() 
        {
            return $this->nome;
        }

        public function getEmail() 
        {
             return $this->email;
        }

        public function getSenha() 
        {
            return $this->senha;
        }

     

        // sets dos atributos
          
        public  function setNome($nome) 
        {
            // convertendo a primeira letra em Maiusculo, REGRA DE NEGÓCIO  
            $nome=ucfirst($nome); 
            $this->nome= $nome;
        }

        public  function setEmail($email) 
        {
            // transformando email em letras minusculas, REGRA DE NEGÓCIO 
            // o trim apaga os espacos do inicio do campo e do fim dele 
            $email=trim(strtolower($email));
            $this->email= $email;
        }

        public  function setSenha($senha) 
        {
           // apenas criptografa a senha se ela não estiver vazia
           $senha;
           if(empty($senha))
           {
            $senha=$senha;
           }
           else{
              $senha=sha1($senha);
           }
           $this->senha=$senha;
           
        }

        public  function cadastrarUsuario($nome,$email,$senha) 
        {
         
           // validações
           if (empty($nome) ) // se o campo titulo estiver vazio
           { 
               throw new Exception("Preencha o campo nome kkkkkkk");

               // retorna falso ,não executa o cadastro
               return false;
           }
           else if(empty($email)){
               throw new Exception("Preencha o campo email");

               // retorna falso ,não executa o cadastro
               return false;
           }
          
           else if(empty($senha)){
               throw new Exception("Preencha o campo senha");
               return false;
           }

           else if(strlen($senha)<=5){ // regra de negócio 
            throw new Exception("Preencha o campo senha com no mínimo 6 caracteres");
            return false;
            }

            else // realiza o cadastro 
            {
               
              
                // conexao com  o banco de dados 
                $con = Connection::getConn();

                // verificando se email já está em uso 
                $sql_email="SELECT * FROM usuario where email=:em";
                $sql_email=$con->prepare($sql_email);
                $sql_email->bindValue(':em',$email);
                $resultado_cadastro=$sql_email->execute();
                $linha = $sql_email->fetchObject('Usuario');
                
                if($linha) // se retornar true é pq tem um registro e portando o email já está em uso 
                {
                    throw new Exception("Este email já está em uso, use outro por favor");
                    return false;
                }
                else{
                   
                    $sql_cadastroUsuario='INSERT INTO usuario (nome,email,senha) values(:nome,:email,:senha);';
                    $sql_cadastroUsuario=$con->prepare($sql_cadastroUsuario);
                    $sql_cadastroUsuario->bindValue(':nome',$nome);
                    $sql_cadastroUsuario->bindValue(':email',$email);
                    $sql_cadastroUsuario->bindValue(':senha',$senha);
                    $resultado_cadastro=$sql_cadastroUsuario->execute();
    
                    if($resultado_cadastro) // cadastro realizado com sucesso
                    {
                        return true;
                    }
                    else{
                        throw new Exception("Falha ao inserir dados");
                        return false;
                    }
                }
            }
        }

        public  function logar($email,$senha)
        {
           
              // conexao com  o banco de dados 
              $con = Connection::getConn();
              // select de email e senha
              $sql_login="SELECT * FROM usuario where email=:em and senha=:senha";
              $sql_login=$con->prepare($sql_login);
              $sql_login->bindValue(':em',$email);
              $sql_login->bindValue(':senha',$senha);
              $resultado_cadastro=$sql_login->execute();
              $linha = $sql_login->fetchObject('Usuario');
              
              if($linha) // se retornar true é pq tem um registro, logo o usuario acertou sua senha e email
              {
                
               // iniciando sessão 
               session_start();
               // variavel de sessão 
               $_SESSION['idLogado']=$linha->idUsuario; // variaveis do tipo sessão são do tipo global, podem ser usadas em qualquer arquivo desde de que existam
               $_SESSION['nome_usuario']=$linha->nome;
              
                return true;
              }
              else{
                throw new Exception("email ou senha invalidos");
                return false;
              }
        } 

        public function verificarLogin()
        {
            session_start();
            
            if(isset($_SESSION['idLogado'])){
               return true;
            }
            else{
                return false;
            }
        }

        public function deslogar()
        {
            session_start();

            if(session_destroy()) // se a sessão for destruido retorna true
            {
                return true;
            }
        }
        

     }

?>