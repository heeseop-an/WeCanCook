<style>
.card {
    max-width: 100%;
}
.card-text {
  overflow-wrap: anywhere;
  word-wrap: break-word;
  word-break: normal;
  hyphens: auto;

}

</style>
<?php
    function getCardView($sql, $model) {
        require('control/mydb.php');
        $result = executePlainSQL($sql);
        ?>
        <div class="row">
        <?php
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        ?>
            <div class="col-lg-4 d-flex align-items-stretch p-3">
            <div class="container">
                <div class="card-deck">
                <div class="card overflow-hidden" style="height: 27rem;" *ngFor="let item of cards">
                    <div class="embed-responsive embed-responsive-4by3"> 
                    <?php
                        $name = $row[0];
                        $name = preg_replace("! !", "_",  rtrim($name));

                        echo "<a href=\"{$model}_detail.php?id={$row[0]}\">".
                        "<img src=images\\$name.jpg style=\"height: 15rem; object-fit: cover;\" 
                            class=\"card-img-top embed-responsive-item\" alt=\"tree\">"."</a>";
                    ?>
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="card-title"><?= $row[0] ?></h5>
                    <span class="card-text mt-3" style="height: 7rem;"><?= $row[2] ?></p>
                    </div>
                </div>
                </div>
            </div>            
            </div>
    <?php } 
    ?>
    </div>
    <?php
    }
?>
