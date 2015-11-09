<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Validator;
use Input;

class HomeController extends Controller
{
    private $tabImages = array();

    public function __construct(){

        $this->genererDataImages(); // fonction pour générer les différentes données des images si besoin
    }
    /**
     * Affichage de la page d'accueil
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('index')->with('tabImages', $this->tabImages); // on affiche toutes les images sur la page principale
    }

    /**
     * Affichage de la page d'une image
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        if(isset($this->tabImages[$slug])) { // si le slug de l'image figure parmis la liste des images

            $image = $this->tabImages[$slug];
            $data = json_decode(file_get_contents($image['json']), true); // on transforme le json en un tableau
            array_shift($data[0]); //on retire l'element sourcefile
            return view('show')->with(['image'=> $image, 'data' => $data[0]]); // on renvoit le tableau de données

        } else {

            abort(404);
        }

    }

    public function save($slug)
    {
        $datas = Request::all();
        $exec = "";

        if (isset($datas["auteur"])) { //si c'est une nouvelle image qu'on sauvegarde

            $regles = array(

    			'name' => 'required',
                'auteur' => 'required',
                'source' => 'required',
                'ville' => 'required',
                'pays' => 'required',
                'license' => 'required',
                'desc' => 'required'
    		);
            $validation = Validator::make(Request::all(), $regles);
            if($validation->fails()){
				$json = json_decode(file_get_contents($this->tabImages[$slug]['json']), true)[0];
				array_shift($json); //on retire l'element sourcefile
                Session::flash('message', "Vous n'avez pas rempli tous les champs obligatoires !");
                return view('confirmer')->with(['image'=> $this->tabImages[$slug], 'data' => $json]);

            } else {

                $exec .='-Title="'.$datas["name"].'" ';
                $exec .='-Creator="'.$datas["auteur"].'" ';
                $exec .='-Source="'.$datas["source"].'" ';
                $exec .='-City="'.$datas["ville"].'" ';
                $exec .='-Country="'.$datas["pays"].'" ';
                $exec .='-UsageTerms="'.$datas["license"].'" ';
                $exec .='-Description="'.$datas["desc"].'" ';
				$imgSlug = str_slug($datas["name"]);
            }
        }
        $imgPath = $this->tabImages[$slug]['path'];
        $json = json_decode(file_get_contents($this->tabImages[$slug]['json']), true)[0];
        array_shift($datas); //retirer la méthode
        array_shift($datas); //retirer le token
        foreach ($datas as $k => $v) {
            if($v != "") {
                if(explode("_", $k)[0] =="tab"){ // si la données stockée était un tableau


                    $json[explode("_", $k)[1]] = explode(" ", $v); // on recréé le tableau à partir des éléments ajoutés

                } else {

                    //$json[$k] = $v; // sinon on stocke simplement la valeur
                    if(sizeof(explode("_", $k)) >1){
                        $exec .='-'.explode("_", $k)[1].'='.$v.' ';
                    }
                }

            }
        }
        //file_put_contents($this->tabImages[$slug]['json'], "[".json_encode($json)."]");
        exec("exiftool ".$exec.$this->tabImages[$slug]['path']);
        unlink($this->tabImages[$slug]['json']); //on supprime l'ancien fichier json pour forcer à le recréer

        Session::flash('message', "Vos modifications ont bien été enregistrés dans l'image !");
		
		if(isset($imgSlug)) {
			return redirect('image/'.$imgSlug);
		} else {
			return redirect('image/'.$slug);
		}

    }

    /**
     * Ajout d'une nouvelle image
     *
     * @return \Illuminate\Http\Response
     */
    public function upload() {

        return view('upload');

    }


    /**
     * Affichage du formulaire d'ajout d'une nouvelle image
     *
     * @return \Illuminate\Http\Response
     */
    public function add() {

        $regles = array(

			'photo' => 'image|required'
		);
        $validation = Validator::make(Request::all(), $regles);
        if($validation->fails()){
            Session::flash('message', "Une erreur est survenue lors du téléchargement de l'image !");
            return redirect()->back();
        } else {

            $photo = Input::file('photo');

            if ($photo->isValid()) {

                $destinationPath = public_path().'\img'; // upload path
                $extension = $photo->getClientOriginalExtension(); // getting image extension
                $fileName = uniqid('image-').'.'.$extension; // renameing image
                $uploadSuccess = $photo->move($destinationPath, $fileName);
                if($uploadSuccess){
                    $image = $this->addImage($destinationPath."\\".$fileName);
                    $data = json_decode(file_get_contents($image['json']), true);
                    array_shift($data[0]); //on retire l'element sourcefile
                    Session::flash('message', "L'image a bien été enregistrée sur le serveur !");
                    return view('confirmer')->with(['image'=> $image, 'data' => $data[0]]);

                }
            }

        }


    }

    private function genererDataImages() {

        $tabData =  glob(public_path().'\img\*.{jpg,png,gif}', GLOB_BRACE);
        foreach ($tabData as $img) {

            $this->addImage($img);
        }
    }

    private function addImage($absolutePath) {

        $imgPath = $absolutePath; //chemin absolu de l'image
        $tabImgName = explode("\\", $absolutePath);
        $imgName = end($tabImgName); // nom de l'image avec .jpg
        $imgSrc = asset('img/'.$imgName); // chemin relatif de l'image
        array_pop($tabImgName);
        $json = implode("\\", $tabImgName)."\\".explode(".", $imgName)[0].".json"; //fichier json
        $xmp = implode("\\", $tabImgName)."\\".explode(".", $imgName)[0].".xmp"; //fichier json

        if(!file_exists($json)) { // si le fichier json n'existe pas on le créé (au cas ou)

            exec("exiftool -g -json $imgPath > $json");
        }

        if(!file_exists($xmp)) { // si le fichier xmp n'existe pas on le créé (au cas ou)

            exec("exiftool -tagsfromfile $imgPath > $xmp");
        }
        $jsonData = json_decode(file_get_contents($json), true);

        if(isset($jsonData[0]['XMP']['Title'])) {
            $imgName = $jsonData[0]['XMP']['Title'];
        }
        if(isset($jsonData[0]["XMP"]['Creator'])) {
            $auteur = $jsonData[0]["XMP"]['Creator'];
        } else {
			$auteur = "";
		}
        $imgSlug = str_slug($imgName);
        $newImg = array('name' => $imgName, 'auteur'=>$auteur, 'src' => $imgSrc, 'slug' => $imgSlug, 'path' => $imgPath, 'json' => $json); // on créé un tableau avec les données principales des images
        $this->tabImages[$imgSlug] = $newImg;
        return $this->tabImages[$imgSlug];
    }

}
