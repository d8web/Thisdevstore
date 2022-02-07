<?php
    use core\classes\Store;
    $total = null;

    if(isset($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $quantity) {
            $total += $quantity;
        }
    }
?>

<header class="bg-primary p-4">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3 class="m-0">
                    <a class="text-light text-decoration-none m-0" href="?a=home">
                        <?= APP_NAME ?>
                    </a>
                </h3>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">

                <a class="text-light text-decoration-none me-4" href="?a=home">Home</a>
                <a class="text-light text-decoration-none me-4" href="?a=loja">Loja</a>

                <?php if(Store::LoggedUser()): ?>
                    <a class="text-light text-decoration-none me-4" href="?a=myaccount">
                        <?=$_SESSION["name"]?>
                    </a>
                    <a class="text-light text-decoration-none me-4" href="?a=logout">Sair</a>
                <?php else: ?>
                    <a class="text-light text-decoration-none me-4" href="?a=signin">Login</a>
                    <a class="text-light text-decoration-none me-4" href="?a=signup">Cadastro</a>
                <?php endif ?>

                <a class="text-light text-decoration-none color-light" href="?a=cart">
                    <button type="button" class="border-0 bg-transparent position-relative">
                        <i class="fas fa-shopping-cart text-white"></i>
                        
                        <span class="position-absolute top-0 start-100 translate-middle <?php echo $total !== null ? "badge" : "" ?> rounded-pill bg-danger">
                            <span class="m-0" id="total">
                                <?=$total?>
                            </span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                        
                    </button>
                </a>
                
            </div>
        </div>
    </div>
</header>