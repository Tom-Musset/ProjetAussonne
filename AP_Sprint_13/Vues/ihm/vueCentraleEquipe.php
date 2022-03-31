<?php
	
	class vueCentraleEquipe
	{
		public function __construct()
		{
			
		}

		public function ajouterEquipe($message, $specialite)
		{
			echo '<form action=index.php?vue=Equipe&action=enregistrer method=POST>
					<legend>Information de l Equipe</legend>
							
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Nom</th>
									  <th scope="col">Nombre de place Equipe</th>
									  <th scope="col">Age Min</th>
									  <th scope="col">Age Max</th>
									  <th scope="col">Sexe Equipe</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="NomEquipe" id="NomEquipe" required="true">
										</td>
										<td>
											<input type=text name="nbrPlaceEquipe" id="nbrPlaceEquipe" required=true>
										</td>
										<td>
											<input type=text name="ageMinEquipe" id="ageMinEquipe" required=true>
										</td>
										<td>
											<input type=text name="ageMaxEquipe" id="ageMaxEquipe" required=true>
										</td>
										<td>
											<input type=text name="sexeEquipe" id="sexeEquipe" required=true>
										</td>
									</tr>
								</tbody>
								<thead>
									<tr>
									  <th scope="col">Entraineur</th>
									  <th scope="col">Specialite</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
										<select name="entraineurEquipe" id="entraineurEquipe" required=true>';
										
										$a=1;
										while ($a<=count($message)){
											echo "<option value='$a'>$message[$a]</option>";
											$a+=1;
										}
											
										echo'</select>
										</td>
										<td>
										<select name="specialiteEquipe" id="specialiteEquipe" required=true>';
										
										$a=1;
										while ($a<=count($specialite)){
											echo "<option value='$a'>$specialite[$a]</option>";
											$a+=1;
										}
											
										echo'</select>
										</td>
									</tr>
								</tbody>
							</table>
							<button type="submit" class="btn btn-primary">Valider</button>
					</form>';
					
		}
		
		public function modifierEquipe($message)
		{
			echo '<form action=index.php?vue=Equipe&action=choixFaitPourModif method = GET>';
			echo $message; 
			echo ' <input type=hidden name=vue value=Equipe></input>
				   <input type=hidden name=action value=choixFaitPourModif></input>
				   <button type="submit" class="btn btn-primary">Valider</button>
				  </form>
			';
		}
		public function visualiserEquipe($message)
		{
						
			$listeEquipe=explode("|",$message);
			echo '<div style="height:80%; overflow:auto;margin-top:1px;">
				  <table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Age Max</th>
							<th scope="col">Age Min</th>
							<th scope="col">Sexe</th>
							<th scope="col">Nbr de pers Max</th>
							<th scope="col">Entraineur</th>
							<th scope="col">Specialité</th>
						</tr>
					</thead>
					</div>
					<tbody>';
			$nbE=0;
			while ($nbE<sizeof($listeEquipe))
			{	
				$i=0;
				while (($i<7) && ($nbE<sizeof($listeEquipe)))
				{
					echo '<td scope>';
					echo trim($listeEquipe[$nbE]);
					$i++;
					$nbE++;
					echo '</td>';
				}
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table> </div>';
			
		}

		public function visualiserEquipeParSpecialite($listeDesObjetsEquipes, $listeDesObjetsSpecialites)
		{	
			echo'<div style="height:70%; overflow:auto;margin-top:1px;">';
			foreach($listeDesObjetsSpecialites as $laSpe){
				$titre = $laSpe->getLibSpecialite();
				echo "<h2> $titre</h2>";
				$liste = ' ';
				echo '<table class="table table-striped table-bordered table-sm ">
						<thead>
							<tr>
								<th scope="col">Nom</th>
								<th scope="col">Age Max</th>
								<th scope="col">Age Min</th>
								<th scope="col">Sexe</th>
								<th scope="col">Nbr de pers Max</th>
								<th scope="col">Entraineur</th>
							</tr>
						</thead>
						</div>
						<tbody>';
								foreach($listeDesObjetsEquipes as $lequipe)
									{
										if($laSpe == $lequipe->getSpecialite() )
										$liste = $liste.$lequipe->afficheEquipe();
									}
									$listeEquipe=explode("|",$liste);
									$nbE=0;
									while ($nbE<sizeof($listeEquipe))
									{	
										$i=0;
										while (($i<7) && ($nbE<sizeof($listeEquipe)))
										{
											echo '<td scope>';
											echo trim($listeEquipe[$nbE]);
											$i++;
											$nbE++;
											echo '</td>';
										}
										echo '</tr>';
									}
						echo '</tbody>';
						echo '</table>';
			}
			echo'</div>';
		}
		
		
	public function choixFaitPourModifEquipe($nom, $nbrPlace, $ageMin, $ageMax, $sexe, $choix,$liste, $liste2)
	{
		echo "<form action=index.php?vue=Equipe&action=EnregModif method = GET>
						<input type=text name=nomEquipe value=\"$nom\"></input>
						<input type=number name=nbrPlaceEquipe value=\"$nbrPlace\"></input>
						<input type=number name=ageMinEquipe value=\"$ageMin\"></input>
						<input type=number name=ageMaxEquipe value=\"$ageMax\"></input>
						<input type=text name=sexeEquipe value=\"$sexe\"></input>";
						echo $liste;
						echo $liste2;
						echo "<input type=hidden name=idEquipe value=\"$choix\"></input>	
						<input type=hidden name=vue value=Equipe></input>
						<input type=hidden name=action value=EnregModif></input>
						<button type='submit' class='btn btn-primary'>Valider</button>
			 </form>";
	}

	public function SaisirEquipe()
	{
		echo '<form action=index.php?vue=Entraineur&action=enregistrer method=POST>';
	}

}
?>