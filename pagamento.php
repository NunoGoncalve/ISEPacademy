<?php 
session_start(); include 'funcoes.php'; 


if(isset($_GET["CourseID"]) && isset($_SESSION["UserID"])){
    $CourseID=$_GET["CourseID"];
    $Course=getCourseById($CourseID);
    $Query = "Select Favourite, Status from Interaction where CourseID=".$CourseID." AND UserID=".$_SESSION["UserID"];
    $Info = exeDB($Query);
    if(empty($Info)){
        $Flag=1;
    }else{
        $Flag=0;
    }
      
}
else{
    echo '<script type="text/javascript">document.location.href="catalogo.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento do Curso</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function subscribe(){            
            $.post("funcoes.php",{
            Func:"subscribe",
            <?php echo "CourseID:".$CourseID.",
            Flag:".$Flag?>
            },function(data, status){
                if(data=="ok") { 
                    document.location="curso.php?ID=<?php echo $CourseID?>";
                }
                else{}
            },"text");	          
        }
        function Pay(){
            document.getElementById('pay').className="button is-fullwidth payment-button is-loading";
            setTimeout(() => {  subscribe(); }, 2000);
        } 
    </script>
    <style>

        .payment-box {
            background-color: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .payment-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .title {
            font-size: 2.2rem;
            margin-bottom: 2rem;
            padding-bottom: 5px;
            background: linear-gradient(45deg, #363636, #4a4a4a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .tabs.is-toggle li.is-active a {
            background-color: #4a4a4a;
            border-color: #4a4a4a;
        }

        .tabs.is-toggle a:hover {
            background-color: #f5f5f5;
            border-color: #b5b5b5;
        }

        .notification.is-light {
            background: rgba(240, 240, 240, 0.7);
            border: 1px solid rgba(238, 238, 238, 0.5);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .notification.is-light:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: scale(1.01);
        }

        .price {
            font-size: 2rem;
            margin-top: 1.5rem;
            color: #363636;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .input {
            border-radius: 8px;
            border: 2px solid #eeeeee;
            padding: 1.2rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .input:focus {
            border-color: #4a4a4a;
            box-shadow: 0 0 0 2px rgba(74, 74, 74, 0.2);
            transform: translateY(-2px);
        }

        .input::placeholder {
            color: #bbbbbb;
        }

        .payment-button {
            background: linear-gradient(45deg, #4a4a4a, #363636);
            color: white;
            font-weight: bold;
            padding: 1.5rem;
            border-radius: 8px;
            border: none;
            font-size: 1.1rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-top: 1rem;
        }

        .payment-button:hover {
            background: linear-gradient(45deg, #363636, #4a4a4a);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color:rgb(179, 176, 176);
        }

        .payment-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .icon-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-method {
            display: none;
        }

        .payment-method.is-active {
            display: block;
        }

        @media (max-width: 768px) {
            .payment-box {
                padding: 1.5rem;
            }

            .title {
                font-size: 1.8rem;
            }

            .price {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<?php include 'navbar.php';?>
<body>
    
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box payment-box">
                        <h1 class="title has-text-centered">
                            Finalizar Pagamento
                        </h1>
                        
                        <div class="course-info mb-6">
                            <div class="notification is-light">
                                <h2 class="subtitle has-text-grey-dark">Curso Selecionado</h2>
                                <p class="has-text-grey-dark"><?php echo $Course["Name"]?></p>
                                <p class="has-text-grey">Duração: 6 meses</p>
                                <div class="tags mt-2">
                                    <span class="tag is-medium is-dark"><?php echo $Course["Price"]?>€ </span>
                                </div>
                            </div>
                        </div>
                        <div class="tabs is-toggle is-toggle-rounded is-fullwidth mb-5">
                            <ul>
                                <li class="is-active" data-target="cartao">
                                    <a>
                                        <span class="icon-text">
                                            <span class="icon"><i class="fas fa-credit-card"></i></span>
                                            <span>Cartão Multibanco</span>
                                        </span>
                                    </a>
                                </li>
                                <li data-target="mb">
                                    <a>
                                        <span class="icon-text">
                                            <span class="icon"><i class="fas fa-university"></i></span>
                                            <span>Transferência MB WAY</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form action="javascript:Pay()">
                            <div id="cartao" class="payment-method is-active">
                                <div class="field">
                                    <label class="label has-text-grey-dark">Nome no Cartão</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" placeholder="Como aparece no cartão" required>
                                        <span class="icon is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label has-text-grey-dark">Número do Cartão</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" placeholder="0000 0000 0000 0000" required pattern="^(?:\d{4} ?){4}$">
                                        <span class="icon is-left">
                                            <i class="fas fa-credit-card"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label has-text-grey-dark">Validade</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" placeholder="MM/AA" required  pattern="^(0[1-9]|1[0-2])\/\d{2}$">
                                                <span class="icon is-left">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="field">
                                            <label class="label has-text-grey-dark">CVV</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" placeholder="123" required pattern="^\d{3,4}$">
                                                <span class="icon is-left">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <label class="label has-text-grey-dark">NIF</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" placeholder="000000000" required pattern="^\d{9}$"> 
                                        <span class="icon is-left">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                    </div>
                                </div>                                
                            </div>
                            <div id="mb" class="payment-method">
                            <div class="notification is-light">
                                <h3 class="subtitle is-5 mb-4">Dados para Transferência MB WAY</h3>
                                
                                <div class="field">
                                    <label class="label has-text-grey-dark">Telemóvel MB WAY</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="tel" placeholder="9XXXXXXXX" required pattern="^\d{9}$">
                                        <span class="icon is-left">
                                            <i class="fas fa-mobile-alt"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label has-text-grey-dark">NIF</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" placeholder="000000000" required pattern="^\d{9}$">
                                        <span class="icon is-left">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="field mt-6">
                                <div class="control">
                                    <button class="button is-fullwidth payment-button" id="pay" type="submit">
                                        <span class="icon-text">
                                            <span class="icon"><i class="fas fa-lock"></i></span>
                                            <span>Pagar Agora</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                        <p class="has-text-centered has-text-grey mt-4">
                            <span class="icon-text">
                                <span class="icon"><i class="fas fa-shield-alt"></i></span>
                                <span>Pagamento 100% Seguro</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tabs functionality
            const tabs = document.querySelectorAll('.tabs li');
            const paymentMethods = document.querySelectorAll('.payment-method');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('is-active'));
                    // Add active class to clicked tab
                    tab.classList.add('is-active');

                    // Hide all payment methods
                    paymentMethods.forEach(method => {
                        method.classList.remove('is-active');
                    });

                    // Show selected payment method
                    const targetId = tab.dataset.target;
                    document.getElementById(targetId).classList.add('is-active');
                });
            });
        });
    </script>
</body>
</html>