
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
			
