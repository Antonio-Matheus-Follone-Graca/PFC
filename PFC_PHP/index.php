
<?php
    // import do core 
    require_once('app\Core\Core.php');
    // import do vendor
    require_once('vendor\autoload.php');

    // import da classe que faz conexão com o banco de dados
    require_once('lib\Database\Connection.php');

    // import das models 
        require_once('app\models\Anotacoes.php');
        require_once('app\models\Usuario.php');
    // fim import das models 

    // import dos controllers 
        require_once('app\controller\AnotacoesController.php');
        require_once('app\controller\ErroController.php');
        require_once('app\controller\UsuarioController.php');

    // fim import dos controllers 

    // carregando menu que será usado em outras paginas que tenham esse menu em comum 
    
    $template=null;
    $area_dinamica=null;



    ob_start();
        $core=new Core();
        $core->start($_GET);
        $saida=ob_get_contents();
    ob_end_clean();

    // se a url tem o parametro get mostra o menu 1, o menu 1 é de logado
    if(isset($_GET['pagina'])){
        $template=file_get_contents('app\template\menu.php');
        $area_dinamica='{{area_dinamica}}';

    }
    else // se não possui o parametro pagina, mostra o menu 2 
    { 
        $template=file_get_contents('app\template\menu2.php');
        $area_dinamica='{{area_dinamica2}}';
    }
    $area_dinamica=$area_dinamica;
 

    $template_pronto= str_replace($area_dinamica,$saida,$template);
    echo($template_pronto);
   
?>