<?php

require_once ("Models/Database.php");

$dbContext = new DBContext();
function layout_Navbar($dbContext)
{
    ?>
    <header>
        <nav class="navbar">
            <div class="navbar-menu">
                <h3>Innebandyshopen</h3>
                <div>
                    <ul>

                        <?php
                        foreach ($dbContext->getAllCategories() as $category) {
                            echo "<li class='dropdown-list'><a href='/productpage?id=$category->id'>$category->category</a></li> ";
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php
}
?>