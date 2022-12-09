<html>
    <head>
        <title>App Mail Send</title>
        <meta charset="utf-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    
    <body>
        <div class="container">
            <div class="text-center py-3">
                <img src="./images/logo.png" width="72" height="72" class="d-block mx-auto mb-2">
                <h2>Send Mail</h1>
                <p class="lead">Seu app de envio de e-mails particular!</p>

                <?php if(isset($_GET['error']) && $_GET['error'] == 'fields') { ?>
                    
                    <div class="text-center text-danger">
                        <h3>Preencha todos os campos corretamente.</h3>
                    </div>

                <?php } ?>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card-body font-weight-bold">
                        <form method="post" action="backend/process_email.php">
                            <div class="form-group">
                                <label for="email">Para</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="joao@teste.com" required>
                            </div>

                            <div class="form-group">
                                <label for="assunto">Para</label>
                                <input type="text" id="assunto" name="assunto" class="form-control" placeholder="Assunto do email" required>
                            </div>

                            <div class="form-group">
                                <label for="mensagem">Para</label>
                                <textarea id="mensagem" name="mensagem" class="form-control" placeholder="Conteúdo da mensagem" required></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Enviar Mensagem</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>