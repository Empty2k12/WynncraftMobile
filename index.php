<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wynncraft Mobile Item Database</title>
        <link rel="stylesheet" href="additions/main.css" type="text/css"/>
        <link rel="stylesheet" href="additions/jquery.qtip.min.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="additions/jquery.qtip.min.js"></script>
        <script src="additions/main.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    </head>
    <body>
        <div class="searchwrapper">
            <h3>Wynncraft Item Database<sup>Made by Empty2k12 for the Wynncraft Content Contest</sup></h3> 
            <p class="search_desc">You  may search either by name, minimum level or type:</p> 
            <form  method="post" action="index.php" class="searchform"> 
                <input  type="text" name="query"> 
                <input  type="submit" name="submit" value="Search"> 
            </form> 
        </div>

        <div class="datawrapper">
            <?php
            error_reporting(0);

            if (isset($_GET['query'])) {
                $returnedJson = file_get_contents('http://api.wynncraft.com/public_api.php?action=items&command=' . $_GET['query'] . '');
            } else if (isset($_POST['query'])) {
                $returnedJson = file_get_contents('http://api.wynncraft.com/public_api.php?action=items&command=' . $_POST['query'] . '');
            } else {
                $returnedJson = file_get_contents('http://api.wynncraft.com/public_api.php?action=items&command=');
            }
            $decoded = json_decode($returnedJson, true);

            if (array_key_exists('0', $decoded)) {
                $numBox = 0;
                foreach ($decoded as $encoded) {
                    $type = $encoded['item_mineraft'];

                    if (isset($type)) {
                        echo '<div class="item_box" id="box' . $numBox . '">';

                        echo '<h1 title="' . $encoded['item_type'] . ' Item" class="header_' . strtolower($encoded['item_type']) . '">' . $encoded['item_name'] . "</h1>";
                        echo $encoded['item_mineraft'] . "<br>";
                        if (isset($encoded['item_min_lvl'])) {
                            echo "Min Level: " . $encoded['item_min_lvl'] . "<br>";
                        }

                        if ($type === "Shovel" || $type === "Bow" || $type === "Shears" || $type === "Stick") {
                            echo $encoded['max_dam'] . "-" . $encoded['min_dam'];
                        } else {
                            if (isset($encoded['def'])) {
                                echo "Defense: " . $encoded['def'];
                            }
                        }
                        
                        echo '</div>'; 
                        
                        echo '<div class="id_box box' . $numBox . 'id">';
                        echo "Health Regen: " . $encoded['identification']['health_regen'] . "<br>";
                        echo "Mana Regen: " . $encoded['identification']['mana_regen'] . "<br>";
                        echo "Spell Damage: " . $encoded['identification']['spell_dam'] . "<br>";
                        echo "Life Steal: " . $encoded['identification']['life_steal'] . "<br>";
                        echo "Mana Steal: " . $encoded['identification']['mana_steal'] . "<br>";
                        echo "XP Bonus: " . $encoded['identification']['ex_bonus'] . "<br>";
                        echo "Loot Bonus: " . $encoded['identification']['loot_bonus'] . "<br>";
                        echo '</div>';

                        $numBox++;
                    }
                }
            } else {
                echo "<p class='error'>Your Query didn't return any items :( Try another search!</p>";
            }
            ?>
        </div>
    </body>
</html>
