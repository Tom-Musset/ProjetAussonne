<?php
/* echo '<p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
					               <form action=index.php method=GET align=center>';
									$_GET['vue']='Connexion';
									$_GET['action']='initialiserTypeNouvelle';
									$this->affichePage($_GET['action'],$_GET['vue'],$role);
									echo '<br>  <br>
									<input type=hidden name=vue value=Connexion></input>
									<input type=hidden name=action value=typeChoixNouvelle></input>
									<button type="submit" class="btn btn-primary">Valider</button>
							 </form>
					
				</div>
				<div class="col-md-10 col-xs-12 ">';
				*/
				echo '<p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
					               <form  align=center>';
									$_GET['vue']='Connexion';
									$_GET['action']='initialiserTypeNouvelle';
									$this->affichePage($_GET['action'],$_GET['vue'],$role);
									echo '<br>  <br>
									<input type=hidden name=vue value=Connexion></input>
									<input type=hidden name=action value=typeChoixNouvelle></input>
									<button type="button" class="btn btn-primary" onClick="appelAjax();">Valider</button>
							 </form>
					
				</div>
				<div id="contenuajax" class="col-md-10 col-xs-12 "></div>';
				?>	
				<script>
				
				function appelAjax(){
					var $e = document.getElementsByName("typeNouvelle")[0].value;
					$.ajax({
								   type: "POST",
								url: "Outil/retourajax.php",
								dataType: "json",
								encode: true,
								data: "typeNews="+$e, // on envoie via post
								success: function(retour) {
									console.log(retour);
									document.getElementById("contenuajax").innerHTML=retour["retour"];
								
				
								   },
								   error: function(jqXHR, textStatus)
						{
				
							 if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
							else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
							else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
							else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
							else if (textStatus === "timeout"){alert("Time out error.");}
							else if (textStatus === "abort"){alert("Ajax request aborted.");}
							else{alert("Uncaught Error.n" + jqXHR.responseText);}
						}
							   });
				}
			
				</script>