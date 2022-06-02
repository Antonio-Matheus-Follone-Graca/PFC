<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
            <div class="mt-1 container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
                    <a class="navbar-brand" href="#">To-Do</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                        <a class="nav-link active" href="http://localhost/PFC_PHP/?usuario&metodo=index">Login</span></a>
                        <a class="nav-link" href="http://localhost/PFC_PHP/?usuario&metodo=formCadastrar">Cadastrar</a>
                    
                        </div>
                    </div>
                </nav>
           

                <div id="conteudo_dinamico">
                    {{area_dinamica2}}
                </div>
        
                
        <!--<div class="container">
            <h1 class="mb-5"> Cadastrar anotação </h1>
            <form action="#" method="get">
                <div class="form-group">
                    <input type="email" class="form-control mb-5" id="exampleFormControlInput1" placeholder="Titulo da anotação">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"> Corpo da mensagem</textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Criar anotação</button>
            </form>
        </div>
        
        -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>