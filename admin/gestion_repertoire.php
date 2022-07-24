<?php
require_once '../inc/init.php';

'<h1>Gestion du répertoire</h1>';

// formule pour supprimer un contact
if(isset($_GET['id_contact'])){// l'info de id_contact est récupérée suite au clic sur le bouton "supprimer" qui est positionné sur cette même page
    $resultat = executeRequete("DELETE FROM contact WHERE id_contact = :id_contact", array(':id_contact'=> $_GET['id_contact']));

    if($resultat->rowCount() == 1){// on entre dans cette condition si la requête s'est bien passée ==> il y a bien 1 donnée stockée dans la variable $resultat.  
        $contenu .= '<div class="alert alert-success">Le contact a bien été supprimé</div>';
    }else{// on entre dans cette condition si la requête ne s'est PAS bien passée ==> il y a eu un soucis, il faut réviser le code et corriger le pb
        $contenu .= '<div class="alert alert-danger">Le contact n\'a pas été supprimé</div>';
    }
}


$resultat = executeRequete("SELECT * FROM contact"); //on sélectionne tous les contacts

$contenu .= '<h2>Affichage du répertoire</h2>';

$contenu .= 'Nombre de contact(s) dans le répertoire : ' . $resultat->rowCount().' ';
$contenu .= '<a class="btn btn-outline-primary mt-2 mb-2" href="formulaire_contact.php">Ajouter un contact <i class="bi bi-check2-square"></i></a>';


$contenu .= '<table class="table">';
$contenu .= '<tr>';
$contenu .= '<th>ID</th>';
$contenu .= '<th>Nom</th>';
$contenu .= '<th>Prenom</th>';
$contenu .= '<th>Téléphone</th>';
$contenu .= '<th>Email</th>';
$contenu .= '<th>Contexte de connaissance</th>';
$contenu .= '<th>Photo</th>';
$contenu .= '<th>Action(s)</th>'; // colonne pour les liens "modifier et supprimer"
$contenu .= '</tr>';

// debug($resultat);

while ($contact = $resultat->fetch(PDO::FETCH_ASSOC)) { // puisque $contact est un tableau, on le parcours avec une foreach
    $contenu .= '<tr>'; //on crée 1 ligne de table par contact
    foreach ($contact as $indice => $information) { //$information parcours les valeurs de $contact
        if ($indice == 'photo') { // si l'indice se trouve sur le champs "photo", on affiche une balise img dans lequel on pourra mettre le chemin stocke en bdd
            $contenu .= '<td><img style="width:80px" src="../' . $information . '"</td>'; // $information contient le chemin relatif de la photo vers le dossier "photo/" qui se trouve dans le dossier parent. on concatène donc "../".
        } else { // sinon on affiche les autrs valeurs dans une <td> seul
            $contenu .= '<td>' . $information . '</td>';
        }
    }

        $contenu .= '<td>   
                <a href="detail_contact.php?id_contact='.$contact['id_contact'].'" class="btn btn-outline-secondary">Voir le détail <i class="bi bi-eye"></i></a>
                <a href="formulaire_contact.php?id_contact='.$contact['id_contact'].'" class="btn btn-outline-primary">Modifier <i class="bi bi-pencil"></i></a>
                <a href="?id_contact='.$contact['id_contact'].'" class="btn btn-outline-danger">Supprimer <i class="bi bi-eraser-fill"></i></a>
                </td>';


    $contenu .= '</tr>';
}

$contenu .= '</table>';

require_once '../inc/header.php';


echo $contenu;

require_once '../inc/footer.php';
