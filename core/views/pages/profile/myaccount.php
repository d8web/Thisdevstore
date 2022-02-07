<div class="container">
    <div class="row my-5">
        <div class="col">

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?=$_SESSION['success']?>
                </div>
                <?php unset($_SESSION['success'])?>
            <?php endif ?>

            <table class="table table-borderless">

                <?php foreach($user as $key => $value): ?>
                    <tr class="align-middle">
                        <td width="10%" class="fw-bold"><?= ucfirst($key) ?> : </td>
                        <td width="90%" class="fw-normal">
                            <?= ucfirst($value) ?>
                        </td>
                    </tr>
                <?php endforeach ?>

            </table>

        </div>
    </div>
</div>