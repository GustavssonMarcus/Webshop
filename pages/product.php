<?php
require_once ("Models/Database.php");

require_once ("Pages/layout/Header.php");
require_once ("Pages/layout/Navbar.php");


$id = $_GET['id'] ?? "";


$dbContext = new DBContext();


$customer = $dbContext->getSelectedProduct($id);


?>
<?php
layout_header("Marcus");
?>
<?php
layout_Navbar($dbContext);
?>

<Main>
    <Section class="main">
        <div class="main-content">
            <h1>Innebandy Produkter</h1>
        </div>
    </Section>
    <section>
        <h2>
            <?php echo $customer->brand; ?>
            <br>
            <?php echo $customer->brandname; ?>
            <br>
            <?php echo $customer->price; ?> kr
        </h2>
    </section>


</Main>