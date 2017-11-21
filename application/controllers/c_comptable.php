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
				// on mémorise le mois de la fiche en cours de modification
				$this->session->set_userdata('mois', $mois);
				// obtention de l'id visiteur courant
				$idVisiteur = $this->session->userdata('idUser');

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
			elseif ($action == 'ValiderFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
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
				
				$this->a_comptable->ValiderFiche($idComptable, $mois);
			}
			elseif ($action == 'RefuserFiche')		// modFiche demandé : on active la fonction modFiche du modèle authentif
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
				
				$this->a_comptable->RefuserFiche($idComptable, $mois);
			}
			else								// dans tous les autres cas, on envoie la vue par défaut pour l'erreur 404
			{
				show_404();
			}
		}
	}
}
