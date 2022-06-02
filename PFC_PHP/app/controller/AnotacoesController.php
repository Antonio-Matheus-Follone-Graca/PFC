<?php 
   // possui metodos da classe usuario e classe anotacoes 
    class AnotacoesController
    {

      // ao instanciar o controller verifica se o usuario está logado
        public function __construct()
        {
          // instanciando usuario 
          $objeto_usuario=new Usuario();
          // verificar login 
          $logado=$objeto_usuario->verificarLogin();

          if(!$logado) // se retornar false  é pq está não está logado 
          {
            // redireciona para a pagina de login 
           header('location:http://localhost/PFC_PHP/');
          }
        }

        public function deslogar()
        {
           // instanciando usuario 
           $objeto_usuario=new Usuario();
           // verificar login 
           $deslogar=$objeto_usuario->deslogar();
           // se tudo deu certo e retornou true redireciona o usuario para a index do projeto
           if($deslogar)
           {
            header('location:http://localhost/PFC_PHP/');
           }
        }

        // dai pra baixo são os metodos envolvendo a classe da model Anotações e a tabela Anotacoes do banco de dados
        public function index()
        {
          
            try{
                // twig pega a pasta view
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);
                // pagina home.html
                $template = $twig->load('home.php');
    
                // selecionando todas as postagens do metodo seleciona todos da model Postagem

           
                  $objeto_anotacoes=new Anotacoes();
                  // preenchendo o atributo id usuario, para listar apenas as anotacoes do usuario
                  $objeto_anotacoes->setidUsuario($_SESSION['idLogado']);
                  $objeto_anotacoes=$objeto_anotacoes->listar();
                  
                  $parametros['anotacoes']=$objeto_anotacoes;
                  $parametros['nome_usuario']=$_SESSION['nome_usuario'];
                
                
                
                  $conteudo= $template->render($parametros);
                  echo($conteudo);



                /* codigo anterior, sem usar a orientacao a objetos do jeito certo
                  $objAnotacoes=Anotacoes::listar();
                  $parametros['anotacoes']=$objAnotacoes;
                */

                /*  outra forma de passar parametros para a view 
                  $parametros['id'] = $postagem->idAnotacao;
                  $parametros['titulo'] = $postagem->Titulo;
                  $parametros['conteudo'] = $postagem->Mensagem;
                  $parametros['IdUsuario'] = $postagem->IdUsuario;
                */
              }
              catch(Exception $e){
                echo($e->getMessage());
              }
        }

        // funcao que chama a view do cadastrar anotações
        public function formularioCadastrarAnotacao(){
       
              // twig pega a pasta view
          $loader = new \Twig\Loader\FilesystemLoader('app/view');
          $twig = new \Twig\Environment($loader);
          
          $parametros=array();
          // passando o id do usuario logado para colocar no formulario de cadastrar anotação 
          $parametros['fkIdusuario']=$_SESSION['idLogado']; // variaveis do tipo sessão são globais, ou seja podem ser usadas em qualquer arquivo desde de que existam
         
         
          $template = $twig->load('CriarAnotacao.html'); // página de criar anotação
          $conteudo= $template->render($parametros);
          echo($conteudo); 
         
        }

        // funcao que faz o cadastro das anotações, após a execucão da função acima

        public function cadastrar()
        {
          //pegando valores de cada campo do formulario e os atribuindo á variaveis 
          $titulo_anotacao=$_POST['titulo_anotacao'];
          $mensagem=$_POST['mensagem'];
          $idUsuario=$_POST['idUsuario'];
          // ou posso simplesmente passar a variavel $_POST, ai passa tudo de uma vez

          //chamando a model(classe) anotacoes e seu método de cadastrar  
          try
          {
            // instanciando classe Anotacoes
            $objeto_anotacoes=new Anotacoes();
            // preenchendo atributos do objeto com o método set com os valores recebidos do formulário
            $objeto_anotacoes->setTitulo($titulo_anotacao);
            $objeto_anotacoes->setMensagem($mensagem);
            $objeto_anotacoes->setIdUsuario($idUsuario);
            // usando métodos get para colocar como parametros no método criar anotação
           
            $objeto_anotacoes=$objeto_anotacoes->criarAnotacao($objeto_anotacoes->getTitulo(),$objeto_anotacoes->getMensagem(),$objeto_anotacoes->getIdUsuario());

           

            /*  codigo anterior, codigo anterior, sem usar a orientacao a objetos do jeito certo

              Anotacoes::criarAnotacao($titulo_anotacao, $mensagem,$idUsuario);
            */ 

            // redirecionando 
            header('location:http://localhost/PFC_PHP/?pagina=Anotacoes');
            /*echo '<script>alert("Publicação inserida com sucesso!");</script>';
            echo '<script>location.href="http://localhost/PFC_PHP/?pagina=Anotacoes"</script>';*/
           }
          catch(Exception $e){
            // se deu erro caiu no throw new 
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/PFC_PHP/?pagina=anotacoes&metodo=formularioCadastrarAnotacao"</script>';
          }
        }

        // funcao que chama a função de deletar da classe anotação 
        public function delete($paramID)
        {
            try{
              // instanciando classe anotacoes 
              $objeto_anotacoes=new Anotacoes();
              // preenchendo atributos do id anotacao com o metodo set da classe Anotacoes, onde peguei o id da anotação recebido da view 
              $objeto_anotacoes->setidAnotacao($paramID);
              // passando o id do usuario
              $objeto_anotacoes->setIdUsuario($_SESSION['idLogado']);
              // chamando método de deletar anotação da classe , passando como parametro o método  getIdAnotacao da classe
              $objeto_anotacoes->excluirAnotacao($objeto_anotacoes->getIdAnotacao());
                header('location:http://localhost/PFC_PHP/?pagina=Anotacoes');
              }
              catch(Exception $e){
                echo '<script>alert("'.$e->getMessage().'");</script>';
                echo '<script>location.href="http://localhost/PFC_PHP/?pagina=Anotacoes"</script>';
              }
        }

        // funcao que chama a view do atualizar anotacao e faz um select para preparar o campo
        public function formularioUpdateAnotacao($paramID)
        {
         // twig pega a pasta view
          $loader = new \Twig\Loader\FilesystemLoader('app/view');
          $twig = new \Twig\Environment($loader);
          // renderizando minha view com parametros(graças ao twig)
          $template = $twig->load('formularioUpdate.html');

          
          // instanciando classe anotacoes 
          $objeto_anotacoes=new Anotacoes();
        
          // usando o método setIdAnotacao para atribuir valor ao atributo
          $objeto_anotacoes->setidAnotacao($paramID);
         
          // chamando o método seleciona por id da classe

         $objeto_anotacoes=$objeto_anotacoes->selecionaPorId($objeto_anotacoes->getIdAnotacao()); 
        
         // setando os outros atributos da classe Anotacoes atraves dos resultados devolvidos do banco
         $objeto_anotacoes->setTitulo($objeto_anotacoes->getTitulo()); // no banco o campo titulo está como Titulo
         $objeto_anotacoes->setMensagem($objeto_anotacoes->getMensagem()); // no banco o campo titulo está como Mensagem
          // passando as informacoes  para os parametros dos formularios

          $parametros = array();
          $parametros['idAnotacao'] = $objeto_anotacoes->	getIdAnotacao() ;
          $parametros['Titulo'] = $objeto_anotacoes->getTitulo();
          $parametros['Mensagem'] = $objeto_anotacoes->getMensagem();
          $parametros['idUsuario'] = $objeto_anotacoes->getIdUsuario();

          // rendezirando a pagina de formulario com os valores recebidos do metodo selecionaPorId da model Anotacoes
          $conteudo= $template->render($parametros);
       
          echo($conteudo);
          
        }

        // funcao que faz o update em si 
        public function atualizar()
        {
             //chamando método update da MODEL Postagem  
          
           // pegando valores de cada campo do formulario e os atribuindo 
          
          $tituloNovo=$_POST['titulo_anotacaoNovo'];
          $mensagemNova=$_POST['mensagemNova'];
          $idAnotacao=$_POST['idAnotacao'];
          // ou posso simplesmente passar a variavel $_POST, ai passa tudo de uma vez
          
          try{
            $objeto_anotacoes=new Anotacoes();
            // passando os valores recebidos do formulário para a classe Anotacoes
            $objeto_anotacoes->setTitulo($tituloNovo);
            $objeto_anotacoes->setMensagem($mensagemNova);
            $objeto_anotacoes->setidAnotacao($idAnotacao);

            // chamando método da classe Anotacoes que  atualiza anotação

            // titulo, mensagem e id anotacao são os parametros, os passei via get atributo da classe
            $objeto_anotacoes->editarAnotacao($objeto_anotacoes->getTitulo(),$objeto_anotacoes->getMensagem(),$objeto_anotacoes->getIdAnotacao());

            //$update=Anotacoes:: editarAnotacao($tituloNovo,$mensagemNova,$idAnotacao);
           
            
            header('location:http://localhost/PFC_PHP/?pagina=Anotacoes');
          }
          catch(Exception $e){
           echo '<script>alert("'.$e->getMessage().'");</script>';
           // echo '<script>location.href="http://localhost/PFC_PHP/?pagina=Anotacoes"</script> </script>';
          }
         
          
        }
    }
?>