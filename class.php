<?php
class Personnage
{
  private $_degats,
          $_id,
          $_nom;
  
  const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
  const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
  const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
  
  
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }
  

  public function frapper(Personnage $perso) // Frappe un perso
  {
    if ($perso->id() == $this->_id)
    {
      return self::CEST_MOI;
    }
    
    // On dit que le perso se prend des dmg.
    // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
    return $perso->recevoirDegats();
  }
  

  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }
  

  public function recevoirDegats() //Reçoit des dégats 
  {
    $this->_degats += 5;
    
    // = ou + de 100 dmg -> personnage mort.
    if ($this->_degats >= 100)
    {
      return self::PERSONNAGE_TUE;
    }
    
    // Sinon, on alerte que le perso a était frappé.
    return self::PERSONNAGE_FRAPPE;
  }
  

  public function nomValide() //Verifie si le nom est valide 
  {
    return !empty($this->_nom);
  }
  

  // GETTERS //
  // Permet d'afficher les infos //


  public function degats() //Récupére dégat
  {
    return $this->_degats;
  }
  

  public function id() //Récupére ID
  {
    return $this->_id;
  }
  

  public function nom() //Récupére le Nom
  {
    return $this->_nom;
  }
  

  public function setDegats($degats) //Ajoute les dégats si frappé par un perso
  {
    $degats = (int) $degats;
    
    if ($degats >= 0 && $degats <= 100)
    {
      $this->_degats = $degats;
    }
  }

  
  public function setId($id) // Ajoute l'ID du perso
  {
    $id = (int) $id;
    
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  

  public function setNom($nom) // Ajoute le nom du Perso
  {
    if (is_string($nom))
    {
      $this->_nom = $nom;
    }
  }
}