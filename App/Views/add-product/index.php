
<?php 
    $warnings = $this->params['warnings'] ?? [];
?>
    <nav>
    <ul class="navbar">
        <li class="logo">Add product</li>
        <li class="link"><a href="/">Cancel</a></li>
        <li class="link"><a href="#" onClick="document.querySelector('#submit_button').click()">Save</a></li>
    </ul>
    </nav>
    <main>
        <div style="height:50px;width:100%;"></div>
        <form id="product_form" class="product_wrapper" action="/add-product" method="POST">

            <div class="form_line">
                <label for="sku">SKU</label>
                <input name="sku" id="sku" type="text" value="<?=$this->params['sku']??'';?>"  />
                <div id="sku_wmsg" class="warning_msg">
                    <?=$warnings['sku']??'';?>            
                </div>
            </div>

            <div class="form_line">
                <label for="name" >Name</label>
                <input name="name" id="name" type="text" value="<?=$this->params['name']??'';?>"  />
                <div id="name_wmsg" class="warning_msg ">
                    <?=$warnings['name']??'';?>            
                </div>
            </div>

            <div class="form_line">
                <label for="price" >Price ($)</label>
                <input name="price" id="price" type="number" min="0" step="0.01" value="<?=$this->params['price']??'';?>" />
                <div id="price_wmsg" class="warning_msg ">
                    <?=$warnings['price']??'';?>            
                </div>
            </div>

            <div class="form_line">
                <label for="productType">Type Switcher</label>
                <select name="productType" id="productType" v-model="productType" @change="onTypeChange()" data-selected="<?=$this->params['productType']??'DVD';?>">
                    <?php foreach($this->params['categories'] as $categorie){ ?>
                    <option id="category_<?=$categorie['name']?>" value="<?=$categorie['name']?>"><?=$categorie['name']?></option>
                    <?php } ?>
                </select>
                <div id="productType_wmsg" class="warning_msg ">
                    <?=$warnings['productType']??'';?>            
                </div>
            </div>

            <div id="type_fields">
                <div class="form_lines">
                    <div class="form_line" v-for="(param , index) in selected">
                        <label for="'parameters[' + index + ']'" >{{ param }}</label>
                        <input :name="'parameters[' + index + ']'" :id="index" type="number" value="" required />
                        <div id="data_size_wmsg" class="warning_msg hidden">Please check if {{param}} is corrent.</div>
                    </div>
                </div>
                <div id="param_descr">{{ description[productType] }}</div>
            </div>
            <input id="submit_button" type="submit" value="Submit" class="hidden"/>

        </form>
    </main>
