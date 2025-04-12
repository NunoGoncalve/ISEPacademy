<?php  
	$course = $_GET["Course"];
	$user = $_GET["User"];
	$category = $_GET["Cat"];
?>
<!DOCTYPE html>
<html>
    <head>
    
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
		<script>
		window.jsPDF = window.jspdf.jsPDF;
		var docPDF = new jsPDF('p', 'mm', [300, 200]);
		function print(){
			var elementHTML = document.querySelector("#printTable");
			
			docPDF.html(elementHTML, {
				callback: function(docPDF) {
			  		docPDF.save('Certificado.pdf');
					//var pageCount = doc.internal.getNumberOfPages();
					//doc.deletePage(pageCount);
				},
			 	x: -13,
			 	y: -1,
			 	width: 234,
			 	windowWidth: 1870
			});
		}
	</script>
		<style>
	.container {
	position: relative;
	text-align: center;
	color: black;
	font-family: 'Georgia', serif;
}

/* Nome do aluno */
.centered {
	position: absolute;
	top: 67.5%;
	left: 50%;
	transform: translate(-50%, -50%);
	font-size: 36px;
	font-weight: bold;
}

/* Nome do curso */
.course {
	position: absolute;
	top: 55%;
	left: 55%;
	transform: translate(-50%, -50%);
	font-size: 30px;
	font-weight: bold;
	width: 35%;
	text-align: start;
}

/* Texto do certificado */
.text {
	position: absolute;
	top: 80%;
	left: 50%;
	transform: translate(-50%, -50%);
	font-size: 32px;
	line-height: 1.8;
	width: 75%;
	text-align: justify;
	background-color: rgba(255, 255, 255, 0.6); /* Fundo leve para aumentar contraste */
	padding: 5px;
	border-radius: 10px;
	font-family: 'Arial', sans-serif;
}

.date{
	font-family: 'Arial', sans-serif;
	text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.15);
	font-size: 25px;
	width: 30%;
}

.text, .centered, .course {
	text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.15);
}
.footer {
    position: absolute;
    bottom: 7px; /* Distância do rodapé */
    left: 48%;
    transform: translateX(-50%);
    width: 100%;
    text-align: center;
}

.logo-footer {
    width: 50%; /* Ajuste o tamanho do logo conforme necessário */
    max-width: 250px;
    opacity: 0.7; /* Um toque suave de transparência */
}



</style>
	
    </head>
    <body  id="printTable" onload="print()">
		
		<div class="container" >
		  	<img src="img/certificado.png" alt="certificado" style="width:90%;">		 
			<div class="centered"><h1><?php echo $user;?></h1></div>
			<div class="course"><h1><?php echo $course;?></h1></div>
			<div class="text">
				<p>
					Certificamos que <strong><?php echo $user;?></strong> concluiu com êxito o curso <strong><?php echo $course;?></strong>, 
					oferecido por <strong>ISEPAcademy</strong>.<br><br>
					O curso foi realizado de forma 100% digital, com atividades teóricas e práticas que contribuíram significativamente para o desenvolvimento de competências na área de <strong><?php echo $category;?></strong>.
					<br>
				</p>
			</div>

			<br><div class="date"><p >Emitido em <?php echo date("d/m/Y"); ?>.</p></div>
		</div>
		<div class="footer">
			<img src="img/01ISEPacademylogo.png" alt="Logo" class="logo-footer">
		</div>

		<script>
			setTimeout(function() {
				
				window.open('','_parent',''); 
				window.close();

			}, 1000);
		</script>
    </body>
</html>