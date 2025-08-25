<?php
include_once('topo.php');
?>
<div class="slim-navbar sticky-top" style="background-color:<?php print $dadosempresa->cormenu; ?>">
	<div class="container">
		<ul class="nav">
          
		  <li class="nav-item">
            <a class="nav-link" href="./">
              <i class="fa fa-home tx-20"></i>
              <span class="mg-l-10">INICIAL</span>
            </a>
          </li>
		  
		</ul>
	</div> 
</div>
<br>
    <div class="signin-wrapper" style="margin-top:-150px;">

      <div class="signin-box" align="center">
        <br>
        <br>
        <center><img src="off.png" width="100" class="img-fluid" alt="Fim"></center>
        <br>
        <br>
		<hr />
		<form action="" method="post">
		<input type="hidden" name="mesainicial" value="ok">
		
		
		<div class="row mg-t-10">
	   
			<div class="col-12"> AGRADECEMOS SUA PREFERÊNCIA<br>SEU PEDIDO FOI FINALIZADO
			 
			</div>

		 </div>
      </div>
    </div>





</div> 
</div>
<a href="#top" style="color:#999999"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
<?php require '../include/fundo.php'; ?> 
    
	<script src="../lib/jquery/js/jquery.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
<script language="JavaScript">
	window.onload = function() {
		document.addEventListener("contextmenu", function(e){
			e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
              	disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
              	disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
              	disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
              	disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
              	disabledEvent(e);
              }
          }, false);
		function disabledEvent(e){
			if (e.stopPropagation){
				e.stopPropagation();
			} else if (window.event){
				window.event.cancelBubble = true;
			}
			e.preventDefault();
			return false;
		}
	};
</script>
</body>
</html>
<?php
ob_end_flush();
?>