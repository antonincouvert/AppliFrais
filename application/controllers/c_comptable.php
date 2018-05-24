<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Contrôleur du module VISITEUR de l'application
*/
class C_comptable extends CI_Controller {

	/**
	 * Aiguillage des demandes faites au contrôleur
	 * La fonction _remap est une fonctionnalité offerte par CI destinée à remplacer 
	 * le comportement habituel de la fonction index. Grâce à _remap, on dispose
	 * d'une fonction unique capable d'accepter un nombre variable de paramètres.
	 *
	 * @param $action : l'action demandée par le comptable
	 * @param $params : les éventuels paramètres transmis pour la réalisation de cette action
	*/
	public function _remap($action, $params = array())
	{
		// chargement du modèle d'authentification
		$this->load->model('authentif');
		
		// contrôle de la bonne authentification de le comptable
		if (!$this->authentif->estConnecte()) 
		{
			// le comptable n'est pas authentifié, on envoie la vue de connexion
			$data = array();
			$this->templates->load('t_connexion', 'v_connexion', $data);
		}
		
		else if ( $this->session->userdata('statut') != 'comptable')
		{
			$this->load->helper('url');
			redirect('/c_default/');
		}
		
		else
		{
			// Aiguillage selon l'action demandée 
			// CI a traité l'URL au préalable de sorte à toujours renvoyer l'action "index"
			// même lorsqu'aucune action n'est exprimée
			if ($action == 'index')				// index demandé : on active la fonction accueil du modèle le comptable
			{
				$this->load->model('a_comptable');

				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');

				$this->a_comptable->accueil();
			}
			elseif ($action == 'listeFiches')		// listesFiches demandé : on active la fonction listesFiches du modèle comptable
			{
				$this->load->model('a_comptable');

				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');

				$this->a_comptable->listeFiches();
			}
			elseif ($action == 'suiviFiches')		// listesFiches demandé : on active la fonction listesFiches du modèle comptable
			{
				$this->load->model('a_comptable');
				
				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');
				
				$this->a_comptable->suiviFiches();
			}
			elseif ($action == 'deconnecter')	// deconnecter demandé : on active la fonction deconnecter du modèle authentif
			{
				$this->load->model('authentif');
				$this->authentif->deconnecter();
			}
			elseif ($action == 'voirFiche')		// voirFiche demandé : on active la fonction voirFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à consulter)
			
				$this->load->model('a_comptable');

				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$mois = $params[0];
				// mémorisation du mode modification en cours 
				$idVisiteur = $params[1];
				// on mémorise le mois de la fiche en cours de modification
				$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				
				$this->a_comptable->voirFiche($idVisiteur, $mois);
				
			}
			elseif ($action == 'modFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
			
				$this->load->model('a_comptable');

				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$mois = $params[0];
				// mémorisation du mode modification en cours 
				// on mémorise le mois de la fiche en cours de modification
				$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');

				$this->a_comptable->modFiche($idComptable, $mois);
			}
			elseif ($action == 'listeFiches')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				//$idVisiteur = $params[0];
				//$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->listeFiches($idVisiteur, $mois);
			}
			elseif ($action == 'ValiderFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$idVisiteur = $params[0];
				$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->ValiderFiche($idVisiteur, $mois);
				
				$this->a_comptable->listeFiches("La fiche $idVisiteur du $mois est validée.");
			}
			elseif ($action == 'RefuserFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$idVisiteur = $params[0];
				$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->RefuserFiche($idVisiteur, $mois);
			}
			elseif ($action == 'RefusFiche') 	// signeFiche demandé : on active la fonction signeFiche du modÃ¨le visiteur ...
			{	// TODO : contrÃ´ler la validité du second paramÃ¨tre (mois de la fiche Ã  modifier)
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche Ã  signer qui doit avoir été transmis
				// en second paramÃ¨tre
				$mois = $params[0];
				// obtention de l'id utilisateur courant et du mois concerné
				$idVisiteur = $params[1];
				$raison = $this->input->post('raison');
				$this->a_comptable->RefusFiche($idVisiteur, $mois, $raison);
				
				// ... et on revient Ã  mesFiches
				$this->a_comptable->listeFiches("La fiche $idVisiteur du $mois est refusée car $raison .");
			}
			else if ($action == 'modifMontantFrais') //action modifMontantFrais demandé : on modifie le montant du frais
			{
				$this->load->model('a_comptable');
				
				$mois = $params[0];
				$idVisiteur = $params[1];
				$idFrais = $params[2];
				
				$nouveauMontantFrais = $_POST[$idFrais];
				$this->a_comptable->modifMontantFrais($mois, $idVisiteur, $nouveauMontantFrais, $idFrais);
				
				$data['notify'] = "Le montant du frais a bien été modifié";
				$data['mois'] = $mois;
				$data['idVisiteur'] = $params[1];
				$data['numAnnee'] = substr( $mois,0,4);
				$data['numMois'] = substr( $mois,4,2);
				$data['lesFraisHorsForfait'] = $this->a_comptable->getLesLignesHorsForfait($idVisiteur,$mois);
				$data['lesFraisForfait'] = $this->a_comptable->getLesLignesForfait($idVisiteur,$mois);
				
				$this->templates->load('t_comptable', 'v_cptModMontant', $data);
				
			}
			else if ($action == 'modMontantFrais') //action modifMontantFrais demandé : on modifie le montant du frais
			{
				$this->load->model('a_comptable');
				
				$mois = $params[0];
				$idVisiteur = $params[1];

				$data['mois'] = $mois;
				$data['idVisiteur'] = $params[1];
				$data['numAnnee'] = substr( $mois,0,4);
				$data['numMois'] = substr( $mois,4,2);
				$data['lesFraisHorsForfait'] = $this->a_comptable->getLesLignesHorsForfait($idVisiteur,$mois);
				$data['lesFraisForfait'] = $this->a_comptable->getLesLignesForfait($idVisiteur,$mois);
				
				$this->templates->load('t_comptable', 'v_cptModMontant', $data);
				
			}
			elseif ($action == 'suiviFiches')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				//$idVisiteur = $params[0];
				//$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->suiviFiches($idVisiteur, $mois);
			}
			elseif ($action == 'MisePaiementFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$idVisiteur = $params[0];
				$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->MisePaiementFiche($idVisiteur, $mois);
			}
			elseif ($action == 'RembourserFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$idVisiteur = $params[0];
				$mois = $params[1];
				// mémorisation du mode modification en cours
				// on mémorise le mois de la fiche en cours de modification
				//$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idComptable = $this->session->userdata('idUser');
				
				$this->a_comptable->RembourserFiche($idVisiteur, $mois);
			}
			else								// dans tous les autres cas, on envoie la vue par défaut pour l'erreur 404
			{
				show_404();
			}
		}
	}
}
