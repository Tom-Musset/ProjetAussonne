<?php
	
	class vueCentraleEntraineur
	{
		public function __construct()
		{
			
		}
		
		public function ajouterEntraineur()
		{
			echo '<form action=index.php?vue=Entraineur&action=SaisirEntraineur method=POST align=center>
							<fieldset>
							<legend>L entraineur est un : </legend>
							<input type="radio" name="typeEntraineur" value="Vacataire" id="vacataire">
							<label for="vacataire">Vacataire</label> <br/>

							<input type="radio" name="typeEntraineur" value="Titulaire" id="titulaire">
							<label for="titulaire">Titulaire</label> <br/>

							
							
							<button type="submit" class="btn btn-primary">Valider</button>
							</fieldset>	
						  </form>';
					
		}

		public function modifierEntraineur($message)
		{
			echo '<form action=index.php?vue=Entraineur&action=choixFaitPourModif method = GET>';
			echo '<select name="idEntraineur" id="idEntraineur" required=true>';
										
			$a=1;
			while ($a<=count($message)){
				echo "<option value='$a'>$message[$a]</option>";
				$a+=1;
			}
				
			echo'</select>';
			echo ' <input type=hidden name=vue value=Entraineur></input>
				   <input type=hidden name=action value=choixFaitPourModif></input>
				   <button type="submit" class="btn btn-primary">Valider</button>
				  </form>
			';
		}
		
		public function ajouterSpecialiteEntraineur($message,$message2)
		{
			echo '<form action=index.php?vue=Entraineur&action=enregistrerSpecialite method=POST>';
			echo 'Choisissez une specialité à ajouter à cet Entraineur : ';
			echo '<select name="idEntraineur" id="idEntraineur" required=true>';
										
			$a=1;
			while ($a<=count($message2)){
				echo "<option value='$a'>$message2[$a]</option>";
				$a+=1;
			}
				
			echo'</select>';
			echo $message; 
			echo '  <button type="submit" class="btn btn-primary">Valider</button>
			</form>';
		}

		public function visualiserAdherentDeLentraineur($lesAdherents,$idAdherents)
		{		
			
			echo '<div style="height:80%; overflow:auto;margin-top:20px;">
				<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
							<th scope="col">Age</th>
							<th scope="col">Sexe</th>

							
						</tr>
					</thead>
					</div>
					<tbody>';

					foreach($idAdherents as $lId){
                        foreach($lesAdherents as $lAdherent){
                            if($lAdherent->getIdAdherent()==$lId){
                                echo '<tr>';
                                echo '<td scope>';
                                echo trim($lAdherent->getNomAdherent());
                                echo '</td>';
                                echo '<td scope>';
                                echo trim($lAdherent->getPrenomAdherent());
                                echo '</td>';
                                echo '<td scope>';
                                echo trim($lAdherent->getAgeAdherent());
                                echo '</td>';
                                echo '<td scope>';
                                echo trim($lAdherent->getSexeAdherent());
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                    }
					echo'</tbody></table></div>';
		}

		public function choixFaitPourModifEntraineur($nom, $login, $pwd, $choix, $typeEntraineur,$info)
	{
		echo '<form action=index.php?vue=Entraineur&action=EnregModif method = GET>
						<input type=text name=nomEntraineur value='.$nom.'></input>
						<input type=integer name=loginEntraineur value='.$login.'></input>
						<input type=integer name=pwdEntraineur value='.$pwd.'></input>';
						
						if($typeEntraineur=="Vacataire"){
							echo '<input type=text name=infoEntraineur value='.$info.'></input>';
						}
						else{
							echo '<input type=date name=infoEntraineur value='.$info.'></input>';
						}

						echo '<input type=hidden name=idEntraineur value='.$choix.'></input>
						<input type=hidden name=typeEntraineur value='.$typeEntraineur.'></input>
						<input type=hidden name=vue value=Entraineur></input>
						<input type=hidden name=action value=EnregModif></input>
						<button type="submit" class="btn btn-primary">Valider</button>
			 </form>';
	}

	public function modifierSonProfil($id){
		echo '<div style="height:50%; width:50%;" margin:auto;>
		<form action=index.php?vue=Entraineur&action=modifierPwd method = POST>
				<input type=password name=pwdEntraineur></input>
				<input type=hidden name=idEntraineur value='.$id.'></input>	
				<input type="submit">
		</form></div>';
	}

		public function visualiserEntraineur($lesTitulaires,$lesVacataires,$EntraineurSpecialite,$listeSpecialite,$lesEquipes)
		{
				echo '<div class="ascenseur">
					<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Nom</th>
							<th scope="col">Login</th>
							<th scope="col">Date ou Téléphone</th>
							<th scope="col">Spécialité(s)</th>
							<th scope="col">Equipe(s)</th>
						</tr>
					</thead>
					<tbody>';
					$nbE=0;
					
					foreach($lesTitulaires as $leTitulaire){
						$liste="";
						echo '<tr>';
						echo '<td scope>';
						echo trim($leTitulaire->getIdTitulaire());
						echo '</td>';

						echo '<td scope>';
						echo trim($leTitulaire->getNomTitulaire());
						echo '</td>';
						
						echo '<td scope>';
						echo trim($leTitulaire->getLogin());
						echo '</td>';

						echo '<td scope>';
						echo trim($leTitulaire->getDateEmbauche());
						echo '</td>';

						foreach($EntraineurSpecialite as $lEntraineurSpecialite){
							if($lEntraineurSpecialite->getIdEntraineur()==$leTitulaire->getIdTitulaire()){
								foreach($listeSpecialite as $laSpecialite){
									if($lEntraineurSpecialite->getIdSpecialite()==$laSpecialite->getIdSpecialite()){
										$liste.=$laSpecialite->getLibSpecialite().'<br>';
									}
								}
							}
						}
						echo '<td scope>';
						echo trim($liste);
						echo '</td>';

						$listeEquipe='';
						foreach($lesEquipes as $lEquipe){
							if($lEquipe->getIdEquipe()==$leTitulaire->getIdTitulaire()){
								$listeEquipe.=$lEquipe->getNomEquipe().'<br>';
							}
						}
						echo '<td scope>';
						echo trim($listeEquipe);
						echo '</td>';
					}

						$liste="";

					foreach($lesVacataires as $leVacataire){
						echo '<tr>';
						echo '<td scope>';
						echo trim($leVacataire->getIdVacataire());
						echo '</td>';

						echo '<td scope>';
						echo trim($leVacataire->getNomVacataire());
						echo '</td>';
						
						echo '<td scope>';
						echo trim($leVacataire->getLogin());
						echo '</td>';

						echo '<td scope>';
						echo trim($leVacataire->getTelephone());
						echo '</td>';

						foreach($EntraineurSpecialite as $lEntraineurSpecialite){
							if($lEntraineurSpecialite->getIdEntraineur()==$leVacataire->getIdVacataire()){
								foreach($listeSpecialite as $laSpecialite){
									if($lEntraineurSpecialite->getIdSpecialite()==$laSpecialite->getIdSpecialite()){
										$liste.=$laSpecialite->getLibSpecialite().'<br>';
									}
								}
							}
						}
						echo '<td scope>';
						echo trim($liste);
						echo '</td>';

						$listeEquipe='';
						foreach($lesEquipes as $lEquipe){
							if($lEquipe->getIdEquipe()==$leVacataire->getIdVacataire()){
								$listeEquipe.=$lEquipe->getNomEquipe();
							}
						}
						echo '<td scope>';
						echo trim($listeEquipe);
						echo '</td>';

					}

					echo '</tr>';
					echo '</tbody>';
					echo '</table>';
					echo '</div>';
					
		}
		public function saisirEntraineur()
		{
			$typeEntraineur = htmlspecialchars($_POST['typeEntraineur']);
						
				echo '<form action=index.php?vue=Entraineur&action=enregistrer method=POST>';
					
					switch ($typeEntraineur) 
					{
					case 'Vacataire':
						echo '<legend>Information du Vacataire</legend>
							
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Téléphone</th>
									  <th scope="col">Nom</th>
									  <th scope="col">Login</th>
									  <th scope="col">Password</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									  <td scope>
										<input type="text" name="numTelVacataire" id="NumTel" required="true">
									  </td>
									  <td>
										<input type=text name=nomEntraineur id=nomEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=loginEntraineur id=loginEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=pwdEntraineur id=pwdEntraineur required=true>
									  </td>
									</tr>
									<tr colspan=5>
									  <input type=hidden name=typeEntraineur value='.$typeEntraineur.'>
									  <button type="submit" class="btn btn-primary">Valider</button>
									</tr>
								</tbody>
							</table>
							
					</form>';
					break;
			
					case 'Titulaire':
						echo '<legend>Information du Titulaire</legend>
												
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Date Entrée</th>
									  <th scope="col">Nom</th>
									  <th scope="col">Login</th>
									  <th scope="col">Password</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									  <td scope>
										<input type="date" name="dateEmbaucheTitulaire" id="dateEmbaucheTitulaire" required="true"  required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
									  </td>
									  <td>
										<input type=text name=nomEntraineur id=nomEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=loginEntraineur id=loginEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=pwdEntraineur id=pwdEntraineur required=true>
									  </td>
									</tr>
									<tr colspan=5>
									  <input type=hidden name=typeEntraineur value='.$typeEntraineur.'>
									  <button type="submit" class="btn btn-primary">Valider</button>
									</tr>
								</tbody>
							</table>
							
					</form>';
						break;
					}
		}		
	}