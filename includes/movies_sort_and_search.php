<div class="container">
    <div class="mg_30_top">
        <div class="row">
            <!-- SORT SELECT LIST -->
            <div class="col-3 text-left">
                <form method="get">
                    <select name="sort">
                        <?php 
                            if(isset($_GET['sort'])) {$sort = $_GET['sort'];} else {$sort = 'Alphabetical';}
                        
                        echo '<option selected disabled>'.$sort.'</option>';
                        ?>
                        <option value="Alphabetical">Alphabetical</option>
                        <option value="By release year">By release year</option>
                        <option value="By rating">By rating</option>
                        <option value="By popularity">By popularity</option>
                        <option value="By duration">By duration</option>
                    </select>
                    <?php
                        if(isset($_GET['filter'])) {
                            $filter = $_GET['filter'];
                            echo '<input type="hidden" value="'.$filter.'" name="filter">';
                        }
                    ?>
                    <input type="submit" value="Sort"/>
                </form>
            </div>
            <!-- FILTER SELECT LIST -->
            <div class="col-3">
                <form method="get">
                    <select name="filter">
                        <?php 
                            if(isset($_GET['filter'])) {$filter = $_GET['filter'];} else {$filter = 'None';}
                        echo '<option selected disabled>'.$filter.'</option>';
                        ?>
                        <option value="Action">Action</option>
                        <option value="Drama">Drama</option>
                        <option value="Romance">Romance</option>
                        <option value="War">War</option>
                        <option value="Biography">Biography</option>
                        <option value="Thriller">Thriller</option>
                        <option value="History">History</option>
                    </select>
                    <?php
                        if(isset($_GET['sort'])) {
                            $search = $_GET['sort'];
                            echo '<input type="hidden" value="'.$sort.'" name="sort">';
                        }
                    ?>
                    <input type="submit" value="Filter"/>
                </form>
            </div>
            <!-- SEARCH BOX -->
            <div class="col-6 text-right">
                <form method="get">
                    <input name="search" type="text" placeholder="Search...">
                    <input type="submit" value="Search"/>
                </form>
            </div>
        </div>
    </div>
</div>