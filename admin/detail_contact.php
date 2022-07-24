<?php
require_once '../inc/init.php';

if (isset($_GET['id_contact'])) { // si 'id_contact' est dans l'URL, c'est qu'on a demandé l'affichage d'un contact
    $resultat = executeRequete("SELECT * FROM contact WHERE id_contact = :id_contact", array(':id_contact' => $_GET['id_contact']));
    $contact = $resultat->fetch(PDO::FETCH_ASSOC); //$contact est un tableau associatif dont on va afficher les valeurs
    // debug($contact);
}

require_once '../inc/header.php';


?>

<h1>Informations du contact</h1>


<ul>
    <li>Nom : <?= $contact['nom']?></li>
    <li>Prenom : <?= $contact['prenom']?></li>
    <li>Téléhone : <?=$contact['telephone']?></li>
    <li>Email : <?= $contact['email']?></li>
    <li>Contexte de connaissance : <?= $contact['type_contact']?></li>
    <li>Photo : <img style="width:80px" src="../<?=$contact['photo']?>"></li>

</ul>

<?php
require_once '../inc/footer.php';
