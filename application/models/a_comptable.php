<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_comptable extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		// chargement du modèle d'accès aux données qui est utile à toutes les méthodes
		$this->load->model('dataAccess');
    }

	/**
	 * Accueil du visiteur
	 * La fonction intègre un mécanisme de contrôle d'existence des 
	 * fiches de frais sur les 6 derniers mois. 
	 * Si l'une d'elle est absente, elle est créée
	*/
	public function accueil()
	{	// TODO : Contrôler que toutes les valeurs de $unMois sont valides (chaine de caractère dans la BdD)
	
		// chargement du modèle contenant les fonctions génériques
		$this->load->model('functionsLib');

		// obtention de la liste des 6 derniers mois (y compris celui ci)
		$lesMois = $this->functionsLib->getSixDerniersMois();
		
		// obtention de l'id de l'visiteur mémorisé en session
		$idComptable = $this->session->userdata('idUser');
		
		// contrôle de l'existence des 6 dernières fiches et création si nécessaire
		foreach ($lesMois as $unMois){
			if(!$this->dataAccess->ExisteFiche($idComptable, $unMois)) $this->dataAccess->creeFiche($idComptable, $unMois);
		}
		// envoie de la vue accueil du visiteur
		$this->templates->load('t_comptable', 'v_visAccueil');
	}
	
	/**
	 * Liste les fiches existantes du visiteur connecté et 
	 * donne accès aux fonctionnalités associées
	 *
	 * @param $idVisiteur : l'id du visiteur 
	 * @param $message : message facultatif destiné à notifier l'visiteur du résultat d'une action précédemment exécutée
	*/
	public function listeFiches ($message=null)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		$data['notify'] = $message;
		$data['listeFiches'] = $this->dataAccess->getFiches();		
		$this->templates->load('t_comptable', 'v_cptMesFiches', $data);	
	}
	

	/**
	 * Suivi des fiches validées afin de pouvoir les mettre en paiement
	 * puis de les remboursées
	 *
	 * @param $idVisiteur : l'id du visiteur
	 * @param $message : message facultatif destiné à notifier l'visiteur du résultat d'une action précédemment exécutée
	 */
	public function suiviFiches ($message=null)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		$data['notify'] = $message;
		$data['suiviFiches'] = $this->dataAccess->getsuiviFiches();
		$this->templates->load('t_comptable', 'v_cptSuiviFiches', $data);
	}
	
	
	/**
	 * Présente le détail de la fiche sélectionnée 
	 * 
	 * @param $idVisiteur : l'id du visiteur 
	 * @param $mois : le mois de la fiche à modifier 
	*/
	
	public function voirFiche($idVisiteur, $mois)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$data['numAnnee'] = substr( $mois,0,4);
		$data['numMois'] = substr( $mois,4,2);
		$data['lesFraisHorsForfait'] = $this->dataAccess->getLesLignesHorsForfait($idVisiteur,$mois);
		$data['lesFraisForfait'] = $this->dataAccess->getLesLignesForfait($idVisiteur,$mois);		

		$this->templates->load('t_comptable', 'v_cptVoirListeFrais', $data);
	}
	

	/**
	 * Présente le détail de la fiche sélectionnée et donne 
	 * accés à la modification du contenu de cette fiche.
	 * 
	 * @param $idComptable : l'id du comptable
	 * @param $mois : le mois de la fiche à modifier 
	 * @param $message : message facultatif destiné à notifier l'visiteur du résultat d'une action précédemment exécutée
	*/
	/*public function ValiderFiche($idComptable, $mois)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$this->dataAccess->ValiderFiche($idComptable, $mois);
	}*/
	 /**
	  * Permet de valider pour le comptable de valider 
	  * une fiche de frais du visiteur
	  * 
	  * @param $idVisiteur
	  * @param $mois
	  * @param $message
	  */
	public function ValiderFiche($idVisiteur, $mois, $message = NULL)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$data['notify']= $message;
		//$data['ValiderFiche'] = $this->dataAccess->getLesInfosFicheFrais($idVisiteur,$mois);
		$this->dataAccess->ValiderFiche($idVisiteur, $mois);
		$data['listeFiches'] = $this->dataAccess->getFiches();
		$this->templates->load('t_comptable', 'v_cptMesFiches', $data);
	}

	public function RefuserFiche($idVisiteur, $mois, $message = NULL)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$data['notify']= $message;
		//$data['RefuserFiche'] = $this->dataAccess->getLesInfosFicheFrais($idVisiteur,$mois);
		$this->dataAccess->RefuserFiche($idVisiteur, $mois);
		$data['listeFiches'] = $this->dataAccess->getFiches();
		$this->templates->load('t_comptable', 'v_cptMesFiches', $data);
	}
	
	
	public function MisePaiementFiche($idVisiteur, $mois, $message = NULL)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$data['notify']= $message;
		//$data['ValiderFiche'] = $this->dataAccess->getLesInfosFicheFrais($idVisiteur,$mois);
		$this->dataAccess->MisePaiementFiche($idVisiteur, $mois);
		$data['suiviFiches'] = $this->dataAccess->getsuiviFiches();
		$this->templates->load('t_comptable', 'v_cptSuiviFiches', $data);
	}
	
	public function RembourserFiche($idVisiteur, $mois, $message = NULL)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		
		$data['notify']= $message;
		//$data['RefuserFiche'] = $this->dataAccess->getLesInfosFicheFrais($idVisiteur,$mois);
		$this->dataAccess->RembourserFiche($idVisiteur, $mois);
		$data['suiviFiches'] = $this->dataAccess->getsuiviFiches();
		$this->templates->load('t_comptable', 'v_cptSuiviFiches', $data);
	}
	

	/**
	 * Modifie les quantités associées aux frais forfaitisés dans une fiche donnée
	 * 
	 * @param $idComptable : l'id du comptable 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function majForfait($idComptable, $mois, $lesFrais)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider les données contenues dans $lesFrais ...
		
		$this->dataAccess->majLignesForfait($idComptable,$mois,$lesFrais);
		$this->dataAccess->recalculeMontantFiche($idComptable,$mois);
	}

	/**
	 * Ajoute une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $idVisiteur : l'id du visiteur 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function ajouteFrais($idComptable, $mois, $uneLigne)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider la donnée contenues dans $uneLigne ...

		$dateFrais = $uneLigne['dateFrais'];
		$libelle = $uneLigne['libelle'];
		$montant = $uneLigne['montant'];

		$this->dataAccess->creeLigneHorsForfait($idComptable,$mois,$libelle,$dateFrais,$montant);
	}

	/**
	 * Supprime une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $idVisiteur : l'id du visiteur 
	 * @param $mois : le mois de la fiche concernée
	 * @param $idLigneFrais : l'id de la ligne à supprimer
	*/
	public function supprLigneFrais($idComptable, $mois, $idLigneFrais)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session et cohérents entre eux

	    $this->dataAccess->supprimerLigneHorsForfait($idLigneFrais);
	}
}