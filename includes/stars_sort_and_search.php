<div class="container">
    <div class="mg_30_top">
        <div class="row">
            <!-- SORT SELECT LIST -->
            <div class="col-6 text-left">
                <form method="get">
                    <select name="sort">
                        <?php 
                            if(isset($_GET['sort'])) {$sort = $_GET['sort'];} else {$sort = 'Alphabetical';}
                        
                        echo '<option selected disabled>'.$sort.'</option>';
                        ?>
                        <option value="By last name">By last name</option>
                        <option value="By first name">By first name</option>
                        <option value="By birth">By birth</option>
                        <option value="By death">By death</option>
                        <option value="By popularity">By popularity</option>
                        <option value="By rating">By rating</option>
                    </select>
                    <?php
                        $a = $_GET['a'];
                        echo '<input type="hidden" value="'.$a.'" name="a">';
                    ?>
                    <input type="submit" value="Sort"/>
                </form>
            </div>
            <!-- SEARCH BOX -->
            <div class="col-6 text-right">
                <form method="get">
                    <input name="search" type="text" placeholder="Search...">
                    <?php
                        $a = $_GET['a'];
                        echo '<input type="hidden" value="'.$a.'" name="a">';
                    ?>
                    <input type="submit" value="Search"/>
                </form>
            </div>
        </div>
    </div>
</div>