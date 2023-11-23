<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="src/css/footer.css">
    <style>
        /* Estilos específicos para el formulario */
        #contactForm {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #008080; /* Cambia este color según tus preferencias */
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Estilos para colocar el formulario a la derecha */
        @media (min-width: 768px) {
            .footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            #contactForm {
                margin-left: auto;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="https://www.facebook.com" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.twitter.com" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="mailto:consultas@proyectocolaborativo.cl" target="_blank">
                        <i class="far fa-envelope"></i>
                    </a>
                </div>
                <div class="col-md-6 text-md-end">
                    &copy; 2023 Tu Compañía. Todos los derechos reservados.
                </div>
            </div>

            <!-- Formulario de contacto -->

            <form id="contactForm" action="form-contacto.php" method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="Nombre">
            </div>
            <div class="form-group">
                <input class="form-control" type="tel" name="phone" placeholder="Teléfono">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Correo electrónico">
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="subject" placeholder="Asunto">
            </div>
        </div>
    </div>
    <div class="form-group">
        <textarea class="form-control" name="message" rows="5" placeholder="Mensaje"></textarea>
    </div>
    <div class="text-center"> 
        <button class="btn mx-auto" type="submit">Enviar</button>
    </div>
</form>
        </div>
    </footer>

    <!-- Script para el envío del formulario -->
    <script>
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();
            this.submit();
        });
    </script>
</body>
</html>
