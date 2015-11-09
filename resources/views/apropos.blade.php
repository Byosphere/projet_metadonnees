@extends('master')

@section('content')
<div class="container">
    <h2>Détail du fonctionnement du site</h2>
    <hr>
    <h3>Les différentes fonctions du controller principal</h3>
    <h4>genererDataImages()</h4>
    <p>Cette fonction se trouve dans le constructeur du controller principal, elle s'execute donc à chaque chargement de page. C'est un coût en ressources nécessaire afin d'une part vérifier
    l'intégrité des différents fichiers nécessaires au fonctionnement du site (jpg, json, xmp) mais aussi de palier à l'absence de base de données.</p>
    <p>Son fonctionnement est simple, cela génère un tableau qui contient l'ensemble des informations des images et vérifie si les fichiers json et xmp associés existent.
        Ce tableau est utlisé pour afficher les photos sur la page d'accueil, mais aussi les pages de détail.
    </p>
    <img src="{{asset('img/apropos/gdi.jpg')}}" alt="" />
    <p>
        On fait appel à la fonction addImage() qui s'occupe de remplir le tableau des informations pour chaque image.
    </p>
    <img src="{{asset('img/apropos/add.jpg')}}" alt="" />
    <h4>index() et show($slug)</h4>
    <p>
        Cela permet ensuite de passer en paramètre pour la vue les différentes informations de cette façon :
    </p>
    <img src="{{asset('img/apropos/index.jpg')}}" alt="" />
    <h4>save($slug)</h4>
    <p>
        Cette fonction permet de mettre à jour les informations d'une image, elle fonctionne aussi bien pour la modification des images existantes que pour la validation des nouvelles images.
        Dans le premier cas, elle stocke avec Exiftool les données envoyées sur l'image. Dans le second cas, elle vérifie en plus que toutes les données indispensables (titre de l'image, etc.) sont
        ajoutées correctement. Voici une partie de l'algorithme pour créer la commande exiftool.
    </p>
    <img src="{{asset('img/apropos/save.jpg')}}" alt="" />
    <h4>add()</h4>
    <img src="" alt="" />
    <p>
        Projet réalisé par Yohann Caillon dans le cadre du cours de Jean-marc Lecarpentier
    </p>
</div>
@endsection
