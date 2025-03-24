<!DOCTYPE html>
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <?php
        include 'navbar.php';
    ?>

    
    <section class="section is-fullheight is-flex is-justify-content-center is-align-items-center">

        <form class="box custom-card-width" action="">
            
            <div class="field">
                <label class="label" for="">Email</label>    

                <div class="control has-icons-left">


                    <input required class="input" type="email" placeholder="example@example.com">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                
                </div>
                
            </div>

            <div class="field">
                <label class="label" for="">Password</label>

                <div class="control has-icons-left has-icons-right">
                    <input id="password" required class="input" type="password" >
                    <span class="icon is-small is-right is-clickable" onclick="togglePassword('password', 'toggleIcon')">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

            </div>
            


            <button class="button is-success is-fullwidth">Login</button>

            <p>Não tens conta? <a href="register.php">Criar conta!</a> </p>

        </form>
    </section>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
    
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }


            function validatePassword() {~
                document.getElementbyId
            }
        }
    </script>


</body>
</html>