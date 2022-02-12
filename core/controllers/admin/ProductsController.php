<?php

namespace core\controllers\admin;

use core\classes\Store;
use core\handlers\AdminProducts;

class ProductsController {

    public function __construct() {
        // Verificar se existe um admin logado
        if(!Store::LoggedAdmin()) {
            Store::Redirect("signInAdmin", true);
            exit;
        }
    }

    public function productsList() {

        $data = [
            "productsList" =>  AdminProducts::getListProducts(),
        ];

        // Aprensentar a página de produtos
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/products",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    // Método para mostrar o formulário para adicionar um novo produto
    public function newProduct() {

        // Aprensentar a página de adicionar um novo produto
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/newProduct",
            "admin/partials/bottom",
            "admin/partials/footer"
        ]);

    }

    // Submissão do formulário para adicionar um novo produto
    public function newProductSubmit() {

        if(
            isset($_POST["name"]) && empty($_POST["name"]) || 
            isset($_POST["category"]) && empty($_POST["category"]) ||
            isset($_POST["price"]) && empty($_POST["price"]) ||
            isset($_POST["description"]) && empty($_POST["description"]) ||
            isset($_POST["stock"]) && empty($_POST["stock"])
        ) {
            $_SESSION["error"] = "Preencha todos os dados corretamente!";
            Store::Redirect("newProduct", true);
            exit;
        }

        $data = [
            "name" => trim($_POST["name"]),
            "category" => trim($_POST["category"]),
            "price" => trim($_POST["price"]),
            "stock" => trim($_POST["stock"]),
            "visible" => trim($_POST["visible"]),
            "bestseller" => trim($_POST["bestseller"]),
            "description" => trim($_POST["description"]),
        ];

        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES['image'];

            if(in_array($image['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                $folder = $_SERVER['DOCUMENT_ROOT']."/store/public/assets/images/products";
                $imageName = $this->cutImage($image, 800, 800, $folder);

                // Inserir o nome da nova imagem no array de upload
                $data['image'] = $imageName;
            }

        } else {
            $_SESSION["error"] = "Imagem inválida ou não existe!";
            Store::Redirect("newProduct", true);
            exit;
        }

        // Adicionando o produto no banco de dados
        AdminProducts::addProduct($data);
        $_SESSION["success"] = "Produto Adicionado com sucesso!";
        Store::Redirect("productsList", true);

    }

    // Mostrar o formulário para editar um produto
    public function editProduct() {

        // Verifica se o id do produto foi passado pela query string
        if(!isset($_GET["product"])) {
            Store::Redirect("home", true);
            exit;
        }

        $productId = Store::aesDescrypt($_GET["product"]);

        // Verificar se o id do produto está vazio, caso esteja redirecionamos para a home
        if(empty($productId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o tipo do parâmetro é diferente de uma string.
        // Caso não seja uma string redirecionamos para home.
        if(gettype($productId) != "string") {
            Store::Redirect("home", true);
            exit;
        }

        // Pegando dados do produto
        $data = [
            "product" => AdminProducts::getProductById($productId)
        ];
        
        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/productEdit",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    // Submissão do formulário para editar um produto
    public function editProductSubmit() {

        if(!isset($_POST["id"])) {
            Store::Redirect("home", true);
            exit;
        }

        $id = Store::aesDescrypt($_POST["id"]);
        if(empty($id)) {
            Store::Redirect("home", true);
            exit;
        }

        if(
            isset($_POST["name"]) && empty($_POST["name"]) || 
            isset($_POST["category"]) && empty($_POST["category"]) ||
            isset($_POST["price"]) && empty($_POST["price"]) ||
            isset($_POST["description"]) && empty($_POST["description"]) ||
            isset($_POST["stock"]) && empty($_POST["stock"])
        ) {
            $_SESSION["error"] = "Preencha todos os dados corretamente!";
            Store::Redirect("editProduct&product=".$_POST["id"], true);
            exit;
        }

        // Array com os dados para update
        $updateData = [
            "id" => $id,
            "name" => trim($_POST["name"]),
            "category" => trim($_POST["category"]),
            "price" => trim($_POST["price"]),
            "stock" => trim($_POST["stock"]),
            "visible" => trim($_POST["visible"]),
            "bestseller" => trim($_POST["bestseller"]),
            "description" => trim($_POST["description"]),
        ];

        if(isset($_FILES["image"]) && !empty($_FILES["image"]['tmp_name'])) {
            $image = $_FILES['image'];

            if(in_array($image['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
                $folder = $_SERVER['DOCUMENT_ROOT']."/store/public/assets/images/products";
                $imageName = $this->cutImage($image, 800, 800, $folder);

                // Inserir o nome da nova imagem no array de upload
                $updateData['image'] = $imageName;

                // Deletando imagem antiga
                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    $imageOldFolder = $folder."/".Store::aesDescrypt($_POST["oldImage"]);
                    unlink($imageOldFolder);
                }
            }
            
        } else {
            $updateData["image"] = Store::aesDescrypt($_POST["oldImage"]);
        }

        // Atualizar o produto no banco de dados
        AdminProducts::updateProduct($updateData);
        $_SESSION["success"] = "Produto editado com sucesso!";
        Store::Redirect("productsList", true);

    }

    // Deletar um produto
    public function deleteProduct() {

        if(!isset($_GET["product"])) {
            Store::Redirect("productsList", true);
            exit;
        }

        $id = Store::aesDescrypt($_GET["product"]);
        if(empty($id)) {
            Store::Redirect("productsList", true);
            exit;
        }

        // Deletar o produto setando o valor deleted_at para null
        AdminProducts::deletedProduct($id);
        $_SESSION["success"] = "Produto deletado com sucesso!";
        Store::Redirect("productsList", true);
        exit;

    }

    private function cutImage($file, $w, $h, $folder) {
        list($widthOrig, $heightOrig) = getimagesize($file['tmp_name']);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $w;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $h) {
            $newHeight = $h;
            $newWidth = $newHeight * $ratio;
        }

        $x = $w - $newWidth;
        $y = $h - $newHeight;
        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($w, $h);
        switch($file['type']) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($file['tmp_name']);
            break;
            case 'image/png':
                $image = imagecreatefrompng($file['tmp_name']);
            break;
        }
   
        imagealphablending( $finalImage, false );
        imagesavealpha( $finalImage, true );

        imagecopyresampled(
            $finalImage, $image,
            $x, $y, 0, 0,
            $newWidth, $newHeight, $widthOrig, $heightOrig
        );

        $fileName = md5(time().rand(0,9999)).'.png';

        imagepng($finalImage, $folder.'/'.$fileName);

        return $fileName;
    }

}