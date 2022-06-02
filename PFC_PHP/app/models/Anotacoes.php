<?php
// import da classe de conexão
    class Anotacoes
    {
        //atributos
        private  $titulo; 
        private  $mensagem;
        private  $idUsuario; 
        private $idAnotacao;

        // gets dos atributos 

        public function getTitulo() 
        {
            return $this->titulo;
        }

        public function getMensagem() 
        {
             return $this->mensagem;
        }

        public function getIdUsuario() 
        {
            return $this->idUsuario;
        }

        public function getIdAnotacao() 
        {
            return $this->idAnotacao;
        }

        // sets dos atributos
          
        public  function setTitulo($titulo) 
        {
            $this->titulo= $titulo;
        }

       
            
        public function setMensagem($mensagem) 
        {
            $this->mensagem= $mensagem;
        }


        public function setIdUsuario($idUsuario) 
        {
             $this->idUsuario= $idUsuario;
        }

        
        public function setidAnotacao($idAnotacao) 
        {
                 $this->idAnotacao= $idAnotacao;
        }
        

        
       
       
        


          

        // metodos 
        public  function listar() // lista todas as anotacoes 
		{
			$con = Connection::getConn();

			$sql = "SELECT * FROM `anotacoes` WHERE idUsuario=:fkusuario; "; 
          
			$sql = $con->prepare($sql);
            $sql->bindValue(':fkusuario',$this->idUsuario);
			$sql->execute();

			$resultado = array();

			while ($row = $sql->fetchObject('Anotacoes')) {
				$resultado[] = $row;
			}

			
			return $resultado;
		}

		public  function criarAnotacao($titulo_anotacao,$mensagem,$idUsuario) // DEPOIS, o id usuario é ESTATICO, pois não temos o  cadastrar usuario e logar usuario
        {
            // validacao 
            if (empty($titulo_anotacao) ) // se o campo titulo estiver vazio
            { 
                throw new Exception("Preencha o campo titulo");

                // retorna falso ,não executa o cadastro
                return false;
            }
            else if(empty($mensagem)){
                throw new Exception("Preencha o campo conteudo");

                // retorna falso ,não executa o cadastro
                return false;
            }
			// 
			else if(empty($idUsuario)){
				throw new Exception("Preencha o campo id do usuario");
			}
            else{
                $con=Connection::getConn();
                $sql_cadastro='INSERT INTO anotacoes (Titulo,Mensagem,IdUsuario) values(:tit,:mens,:idUsuario);';
                $sql_cadastro=$con->prepare($sql_cadastro);
                $sql_cadastro->bindValue(':tit',$titulo_anotacao);
                $sql_cadastro->bindValue(':mens',$mensagem);
				$sql_cadastro->bindValue(':idUsuario',$idUsuario,PDO::PARAM_INT);
                $resultado_cadastro=$sql_cadastro->execute();

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

        public  function excluirAnotacao($idAnotacao){
            // conexao com banco de dados
            $con=Connection::getConn();
            // como o id da anotação é unico , só o id id da anotação é necessario  não preciso do id do usuario
            $sql_deletar="DELETE FROM anotacoes where idAnotacao =:id";
            $sql_deletar=$con->prepare($sql_deletar);
            $sql_deletar->bindValue(':id',$idAnotacao);
           
            
            $resultado_deletar=$sql_deletar->execute();

            if($resultado_deletar==0){
               throw new Exception("falha ao deletar publicação");
               return false;
            }
            else{
                return true;
            }
        }

        // select por id, para setar os valores do formulario update 
        
        public  static function selecionaPorId($idAnotacao)
        {
			$con = Connection::getConn();

			$sql = "SELECT * FROM anotacoes WHERE idAnotacao = :id";
			$sql = $con->prepare($sql);
			$sql->bindValue(':id', $idAnotacao, PDO::PARAM_INT);
			$sql->execute();

			$resultado = $sql->fetchObject('Anotacoes');
			return $resultado;
		}

        // funcao que faz o update da anotação
        public  function editarAnotacao($tituloNovo,$mensagemNova,$idAnotacao)
        {
            // conexao com banco de dados
            $con=Connection::getConn();
             // como o id da anotação é unico , só o id da anotação é necessario  não preciso do id do usuario
            $sql_atualizar="UPDATE anotacoes set Titulo=:tit,Mensagem=:mens where idAnotacao =:idAnotacao ";
            $sql_atualizar=$con->prepare($sql_atualizar);
            $sql_atualizar->bindValue(':tit',$tituloNovo);
            $sql_atualizar->bindValue(':mens',$mensagemNova);
            $sql_atualizar->bindValue(':idAnotacao',$idAnotacao);
            $resultado_atualizar=$sql_atualizar->execute();

            if(!$resultado_atualizar){ //  se deu errado o update 
                throw new Exception("falha ao alterar publicação");
                return false;
            }
           return true;
        }

        // fazer depois, se der tempo, pois precisa-se de um usuario cadastrado e logado  
        
        /*public static function pesquisarAnotacao($idUsuario, $titulo,$mensagem){

        }*/

        }


    
?>