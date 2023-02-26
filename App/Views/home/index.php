
<?php 
            // var_dump('<pre>');
            // var_dump($product);
            // var_dump('</pre>');
    //$product defined in home controller 
?>
    <nav>
    <ul class="navbar">
        <li class="logo">Product list</li>
        <li class="link"><a href="#" id="mass_delete_btn">MASS DELETE</a></li>
        <li class="link"><a href="/add-product">ADD</a></li>
    </ul>
    </nav>
    <main>
        <form id="product_list" class="product_wrapper">
    <?php
        foreach($this->params['products'] as $product){
        ?>
        <div class="product_box">
            <input type="checkbox" class="delete-checkbox" value="<?=htmlspecialchars($product->getId());?>"/>
            <div class="sku product_line"><?=htmlspecialchars($product->getSku());?></div>
            <div class="name product_line"><?=htmlspecialchars($product->getName());?></div>
            <div class="price product_line"><?=htmlspecialchars($product->getPrice());?></div>
            <div class="parameters product_line"><?=htmlspecialchars($product->getParameters_value());?></div>
        </div>
        <?php 
        }
    ?>
    </form>
    <div id="mypar"></div>
    </main>
