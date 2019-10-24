<?php

/**
 * Charge un fichier en fournissant son chemin
 * @param string $filepath Chemin du fichier
 * @return array|null Un tableau si le fichier existe et est valide, null sinon
 */
function loadFromFile(string $filepath): ?array {
    //
    $file = file_get_contents($filepath);
    if (empty($file))
        return (null);
    $tab = json_decode($file);
    // $file = file($filepath);
    // if (empty($file))
    // {
    //     print("fichier vide\n");
    //     return NULL;
    // } 
    // else 
    // {
    //     $tab = [];
    //     foreach ($file as $key => $value)
    //     {
    //         if ($key != 0 && $key != 10)
    //         {
    //             $line = str_replace("[", "", $value);
    //             $line = str_replace("]", "", $line);
    //             $line = str_replace(",", "", $line);
    //             $tab[] = $line;
    //         }
    //     }
         return ($tab);
    //}
}

/**
 * Retourne la valeur d'une cellule
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @return int Valeur
 */
function get(array &$grid, int $rowIndex, int $columnIndex): int {
    
    return $grid[$rowIndex][$columnIndex];
}

/**
 * Affecte une valeur dans une cellule
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @param int $value Valeur
 */
function set(array &$grid, int $rowIndex, int $columnIndex, int $value): void {
    
      $grid[$rowIndex][$columnIndex] = $value;

}

/**
 * Retourne les données d'une ligne à partir de son index
 * @param int $rowIndex Index de ligne (entre 0 et 8)
 * @return array Chiffres de la ligne demandée
 */
function row(array $grid, int $rowIndex, int $columnIndex): array {
    
   for ($i=0; $i <= 8 ; $i++) 
       $ligne[$i]=get($grid,$rowIndex,$columnIndex);
    return $ligne[$i];
   
}

/**
 * Retourne les données d'une colonne à partir de son index
 * @param int $columnIndex Index de colonne (entre 0 et 8)
 * @return array Chiffres de la colonne demandée
 */
function column(array $grid, int $rowIndex, int $columnIndex): array {
    
    for ($j=0; $j <= 8 ; $j++) 
       $ligne[$i]=get($grid,$rowIndex,$columnIndex);
    return $ligne[$j];
}

/**
 * Retourne les données d'un bloc à partir de son index
 * L'indexation des blocs est faite de gauche à droite puis de haut en bas
 * @param int $squareIndex Index de bloc (entre 0 et 8)
 * @return array Chiffres du bloc demandé
 */
function square(array $grid, int $squareIndex): array {

    switch ($squareIndex) {
        case 1 : 
            for ($j=0; $j <  3; $j++) { 
                for ($i=0; $i < 3; $i++) { 
                    $tab[] = $grid[$i][$j];
            }
            $i = 0;   
        }
            break;
            case 2 :
                for ($j=0; $j <  3; $j++) { 
                    for ($i=0; $i < 6 && $i > 3; $i++) { 
                        $tab[] = $grid[$i][$j];
            }
            $i = 0;
        }
            case 3 :
                for ($j=0; $j < 3 ; $j++) { 
                    for ($i=0; $i <  9  && $i > 6; $i++) { 
                        $tab[] = $grid[$i][$j];       
            }
            $i = 0;
        }
            case 4 :
                for ($j=0; $j < 6 && $j > 3 ; $j++) { 
                    for ($i=0; $i < 3 ; $i++) { 
                        $tab[] = $grid[$i][$j];
            }
            $i = 0;
        }
                        break;
            case 5 :
                for ($j=0; $j < 6 && $j > 3; $j++) { 
                    for ($i=0; $i < 3 && $i > 6 ; $i++) { 
                        $tab[] = $grid[$i][$j];       
            }
            $i = 0;
        }
            break;
            case 6 :
                for ($j=0; $j < 6 &&  $j >3 ; $j++) { 
                    for ($i=0; $i < 9 && $i > 6; $i++) { 
                        $tab[] = $grid[$i][$j];   
            }
            $i = 0;
        }
            break;
            case 7 :
                for ($j=0; $j < 9 && $j > 6 ; $j++) { 
                    for ($i=0; $i < 3; $i++) { 
                        $tab[] = $grid[$i][$j];       
            }
            $i = 0;
        }
            break;
            case 8 :
                for ($j=0; $j < 9 && $j > 6 ; $j++) { 
                    for ($i=0; $i < 6 &&  $i > 3 ; $i++) { 
                        $tab[] = $grid[$i][$j];       
            }
            $i = 0;
        }
            break;
            case 9 :
                for ($j=0; $j < 9 && $j > 6 ; $j++) { 
                    for ($i=0; $i < 9 &&  $i > 6  ; $i++) { 
                        $tab[] = $grid[$i][$j];       
            }
            $i = 0;
        }
    }
        // default:
    return $grid;
}


/**
 * Génère l'affichage de la grille
 * @return string
 */
function display(array $grid): string {
    //
    $line = NULL;
    foreach ($grid as $value) 
    {
        foreach ($value as $valeur) {
            $line .= $valeur;
            $line .= ' ';
        }
        $line .= "\n";
        
    }
    return ($line);
}

/**
 * Teste si la valeur peut être ajoutée aux coordonnées demandées
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @param int $value Valeur
 * @return bool Résultat du test
 */
function isValueValidForPosition(array $grid, int $rowIndex, int $columnIndex, int $value): bool {
    $bool=false;
    $colonne=column($grid,$columnIndex);
    $ligne=row($grid,$rowIndex);

    $squareIndex=0;
    if (floor($rowIndex)==1) {
        $squareIndex=$squareIndex+3 + floor($columnIndex/3);
    }
    if (floor($rowIndex)==2) {
        $squareIndex=$squareIndex+6 + floor($columnIndex/3);
    }
    $cube=square($grid,$squareIndex);

    if ($grid[$rowIndex][$columnIndex]==0) {
        if (!in_array($value, $colonne)&& !in_array($value, $ligne)&& !in_array($value, $cube)) {
            $bool=true;
        }
    }
    return $bool;
}

/**
 * Retourne les coordonnées de la prochaine cellule à partir des coordonnées actuelles
 * (Le parcours est fait de gauche à droite puis de haut en bas)
 * @param int $rowIndex Index de ligne
 * @param int $columnIndex Index de colonne
 * @return array Coordonnées suivantes au format [indexLigne, indexColonne]
 */
function getNextRowColumn(array $grid, int $rowIndex, int $columnIndex): array {
    
    if ($columnIndex == 8) {
        $columnIndex = 0;
        $rowIndex +=1;
    }
    else{
        $rowIndex += 1;
    }
    return $nextPosition=[$rowIndex,$columnIndex];
}

/**
 * Teste si la grille est valide
 * @return bool
 */
function isValid(array $grid): bool {
    //
}

function solve(array $grid, int $rowIndex, int $columnIndex): ?array {
    //
   
        // while( $rowIndex < 9 )
        // {
            //  $line[] = $grid[$rowIndex];
            // if ($columnIndex < count($line))
            // {
            //   //  print($grid[$columnIndex]);
            //     // if ($line[$rowIndex][$columnIndex] != ' ')
            //     // {
                    if(get($grid, $rowIndex, $columnIndex) == 0)
                    {
                        print_r(get($grid,1,1));
                        set($grid,1, 1, 4);
                        print_r(get($grid,1,1));
                    }
            //         solve($grid, $rowIndex, ++$columnIndex);
            //     // }
            // }
            //print_r($tab);  
        //     $rowIndex++;
        //     $columnIndex = 0;
        //     solve($grid, $rowIndex, $columnIndex);    
        // }
        return $grid;
}

$dir = __DIR__ . '/grids';
$files = array_values(array_filter(scandir($dir), function($f){ return $f != '.' && $f != '..'; }));
    
foreach($files as $file){
    $filepath = realpath($dir . '/' . $file);
    echo("Chargement du fichier $file" . PHP_EOL);
    $grid = loadFromFile($filepath);
    if ($grid != NULL)
        echo(display($grid) . PHP_EOL);
    $startTime = microtime(true);
    echo("Début de la recherche de solution" . PHP_EOL);
    if ($grid != NULL)
        $solvedGrid = solve($grid , 0, 0);
echo display($solvedGrid);
    // if($solvedGrid === null){
    //     echo("Echec, grille insolvable" . PHP_EOL);
    // } else {
    //     echo("Reussite :" . PHP_EOL);
    //     echo(display($solvedGrid) . PHP_EOL);
    // }

    // $duration = round((microtime(true) - $startTime) * 1000);
    // echo("Durée totale : $duration ms" . PHP_EOL);
    echo("--------------------------------------------------" . PHP_EOL);
}