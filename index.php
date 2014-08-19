<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wynncraft Mobile Item Database</title>
        <link rel="stylesheet" href="additions/main.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="additions/jquery.qtip.min.js"></script>
        <script src="additions/main.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>
    <body>
        <div class="searchwrapper">
            <h3><a href="index.php">Wynncraft Item Database</a><sup>Made by Empty2k12 for the Wynncraft Content Contest</sup></h3> 
            
            <div class='spoilerwrapper'>
                <input class="spoilertoggle" type='button' value='What to search?'>
                <div class='spoiler' style='display: none; overflow: hidden;'>
                    You may either search by:
                    <ul>
                        <li>Name (e.g. <a href="index.php?query=Adamantite">Admantite</a> or <a href="index.php?query=Ado+Saki">Ado Saki</a>)</li>
                        <li>Minimum Level (e.g. <a href="index.php?query=75">75</a> returns all Bob's Weapons)</li>
                        <li>Type (e.g. <a href="index.php?query=Shovel">Shovel</a> or <a href="index.php?query=Stick">Stick</a>)</li>
                        <li>Class (e.g. <a href="index.php?query=class:DarkWizard">class:DarkWizard</a>)</li>
                    </ul>
                </div>  
            </div>
            
            <form  method="get" action="index.php" class="searchform"> 
                <input type="text" name="query"> 
                <input type="submit" value="Find"> 
            </form> 
        </div>

        <div class="datawrapper">
            <?php
            error_reporting(0);

            if (strcasecmp(get_query(), "class:Assassin") == 0 || strcasecmp(get_query(), "class:Ninja") == 0) {
                $query = "Shears";
            } else if (strcasecmp(get_query(), "class:Archer") == 0 || strcasecmp(get_query(), "class:Hunter") == 0) {
                $query = "Bow";
            } else if (strcasecmp(get_query(), "class:DarkWizard") == 0 || strcasecmp(get_query(), "class:Mage") == 0) {
                $query = "Stick";
            } else if (strcasecmp(get_query(), "class:Warrior") == 0 || strcasecmp(get_query(), "class:Knight") == 0) {
                $query = "Shovel";
            } else {
                $query = urlencode(get_query());
            }

            $returnedJson = get_page_contents('http://api.wynncraft.com/public_api.php?action=items&command=' . $query);

            $decoded = json_decode($returnedJson, true);

            if (array_key_exists('0', $decoded)) {
                $numBox = 0;
                foreach ($decoded as $item) {
                    $type = $item['item_mineraft'];

                    if (isset($type)) {
                        echo '<div class="item_box" id="box' . $numBox . '">';
                        echo '<h1 title="' . $item['item_type'] . ' Item" class="header_' . strtolower($item['item_type']) . '">' . $item['item_name'] . "</h1>";
                        echo $item['item_mineraft'] . "<br>";
                        if (isset($item['item_min_lvl'])) {
                            echo "Min Level: " . $item['item_min_lvl'] . "<br>";
                        }

                        if ($type === "Shovel" || $type === "Bow" || $type === "Shears" || $type === "Stick") {
                            echo $item['max_dam'] . "-" . $item['min_dam'];
                        } else {
                            if (isset($item['def'])) {
                                echo "Defense: " . $item['def'];
                            }
                        }
                        echo '</div>';

                        echo '<div class="id_box box' . $numBox . 'id">';
                        if (isset($item['identification']['health_regen'])) {
                            echo "Health Regen: " . $item['identification']['health_regen'] . "<br>";
                        }
                        if (isset($item['identification']['mana_regen'])) {
                            echo "Mana Regen: " . $item['identification']['mana_regen'] . "<br>";
                        }
                        if (isset($item['identification']['spell_dam'])) {
                            echo "Spell Damage: " . $item['identification']['spell_dam'] . "<br>";
                        }
                        if (isset($item['identification']['life_steal'])) {
                            echo "Life Steal: " . $item['identification']['life_steal'] . "<br>";
                        }
                        if (isset($item['identification']['mana_steal'])) {
                            echo "Mana Steal: " . $item['identification']['mana_steal'] . "<br>";
                        }
                        if (isset($item['identification']['exp_bonus'])) {
                            echo "XP Bonus: " . $item['identification']['exp_bonus'] . "<br>";
                        }
                        if (isset($item['identification']['loot_bonus'])) {
                            echo "Loot Bonus: " . $item['identification']['loot_bonus'] . "<br>";
                        }
                        echo '</div>';

                        $numBox++;
                    }
                }
            } else {
                echo "<p class='error'>Your Query didn't return any items :( Try another search!</p>";
            }

            function get_page_contents($url) {
                if (function_exists('curl_init')) {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                    return curl_exec($ch);
                } else {
                    return file_get_contents($url);
                }
            }

            function get_query() {
                return urldecode($_GET['query']);
            }
            ?>
        </div>

        <div class="footerwrapper">
            <center>&copy; 2014 Empty2k12 &bull; All Rights Reserved &bull; <a href="http://forums.wynncraft.com/threads/1-7-10-wynncraft-gui-mod-update-1-2.42548/">My Wynncraft Mod</a></center>
        </div>
    </body>
</html>

