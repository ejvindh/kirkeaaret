<?php
    $investigatedDay = time();
    //$investigatedDay = mktime(1, 0, 0, [month], [dayOfMonth], [year]);
    $litNames = getNamesOfLit();
    $litArray = array();
    $thisyear = date("Y", $investigatedDay);
    
    $easter = unixtojd(easter_date($thisyear));
    $christmas = gregoriantojd (12, 25, $thisyear);
    $christmasdayweek = date("N", jdtounix ($christmas));
    $adventFirst = $christmas - $christmasdayweek - 21;
    $lastSunday = $christmas - $christmasdayweek - 28;
    $newYear = gregoriantojd (1, 1, $thisyear);
    $epiphany = $newYear + 7 - date("N", jdtounix ($newYear));
    $epiphany_last = $easter - 70;
    $allSaints = gregoriantojd (11, 1, $thisyear);

    $litArray[] = array('name'=>$litNames[10], 'jd_day'=>$newYear); //Nytårsdag
    $epiphanyTmp = $epiphany;
    if (date("N", jdtounix ($newYear)) != 1) {
      $litArray[] = array('name'=>$litNames[11], 'jd_day'=>$epiphany); //h3k s
    } else {
      $epiphanyTmp = $epiphany -7;
    }
    $i = 1;
    while($epiphanyTmp + ($i*7) < $epiphany_last) {
      $litArray[] = array('name'=>$litNames[11+$i], 'jd_day'=>$epiphanyTmp + ($i*7)); // x. s.e.h3k
      $i++;
    }
    $litArray[] = array('name'=>$litNames[17], 'jd_day'=>$epiphany_last); //sidste s.e.H3K
    $litArray[] = array('name'=>$litNames[18], 'jd_day'=>$easter - 63); //septuagesima
    $litArray[] = array('name'=>$litNames[19], 'jd_day'=>$easter - 56); //seksagesima
    $litArray[] = array('name'=>$litNames[20], 'jd_day'=>$easter - 49); //Fastelavnssønd
    $litArray[] = array('name'=>$litNames[21], 'jd_day'=>$easter - 42); //1.s.i.fasten
    $litArray[] = array('name'=>$litNames[22], 'jd_day'=>$easter - 35); //2.
    $litArray[] = array('name'=>$litNames[23], 'jd_day'=>$easter - 28); //3.
    $litArray[] = array('name'=>$litNames[24], 'jd_day'=>$easter - 21); //Midfaste
    $litArray[] = array('name'=>$litNames[25], 'jd_day'=>$easter - 14); //Mariæ bebudelse
    $litArray[] = array('name'=>$litNames[26], 'jd_day'=>$easter - 7); //Palme
    $litArray[] = array('name'=>$litNames[27], 'jd_day'=>$easter - 3); //Skærtorsdag
    $litArray[] = array('name'=>$litNames[28], 'jd_day'=>$easter - 2); //Langfredag
    $litArray[] = array('name'=>$litNames[29], 'jd_day'=>$easter); //Påskedag
    $litArray[] = array('name'=>$litNames[30], 'jd_day'=>$easter + 1); //2. påskedag
    $litArray[] = array('name'=>$litNames[31], 'jd_day'=>$easter +7); //1.s.e.påske
    $litArray[] = array('name'=>$litNames[32], 'jd_day'=>$easter +14); //2.s.e.påske
    $litArray[] = array('name'=>$litNames[33], 'jd_day'=>$easter +21); //3.s.e.påske
    $litArray[] = array('name'=>$litNames[34], 'jd_day'=>$easter +26); //Bededag
    $litArray[] = array('name'=>$litNames[35], 'jd_day'=>$easter +28); //4.s.e.påske
    $litArray[] = array('name'=>$litNames[36], 'jd_day'=>$easter +35); //5.s.e.påske
    $litArray[] = array('name'=>$litNames[37], 'jd_day'=>$easter +39); //Kr.Himmelfart
    $litArray[] = array('name'=>$litNames[38], 'jd_day'=>$easter +42); //6.s.e.påske
    $litArray[] = array('name'=>$litNames[39], 'jd_day'=>$easter +49); //Pinsedag
    $litArray[] = array('name'=>$litNames[40], 'jd_day'=>$easter +50); //2. Pinsedag

    //Trinitatis + allehelgen:
    $i = 1;
    $skipAllSaintsSunday = 0;
    $allSaintsNotFoundFlag = true;
    while($easter + 49 + ($i*7) < $lastSunday) {
      if (40+$i == 64) {$skipAllSaintsSunday = 1;}
      $nameTxt = $litNames[40+$i+$skipAllSaintsSunday];
      $dayNumber = $easter + 49 + ($i*7);
      if ($dayNumber > $allSaints && $allSaintsNotFoundFlag) {
        $allSaintsNotFoundFlag = false;
        $nameTxt = $litNames[64]; // AlleHelgen
      }
      $litArray[] = array('name'=>$nameTxt, 'jd_day'=>$dayNumber); //Trinitatis, alleHelgen
      $i++;
    }

    $litArray[] = array('name'=>$litNames[69], 'jd_day'=>$lastSunday); //Sidste søndag i kirkeåret
    $litArray[] = array('name'=>$litNames[0], 'jd_day'=>$adventFirst); //1.s.i.advent
    $litArray[] = array('name'=>$litNames[1], 'jd_day'=>$adventFirst+7); //2.s.i.advent
    $litArray[] = array('name'=>$litNames[2], 'jd_day'=>$adventFirst+14); //3.s.i.advent
    if (($adventFirst+21) < ($christmas-1)) {
      $litArray[] = array('name'=>$litNames[3], 'jd_day'=>$adventFirst+21); //4.s.i.advent
    }
    $litArray[] = array('name'=>$litNames[4], 'jd_day'=>$christmas-1); //Juleaften
    $litArray[] = array('name'=>$litNames[5], 'jd_day'=>$christmas); //Juledag
    $litArray[] = array('name'=>$litNames[7], 'jd_day'=>$christmas+1); //2.juledag
    if ($christmasdayweek < 6) {
      $litArray[] = array('name'=>$litNames[8], 'jd_day'=>($christmas + 7 - $christmasdayweek)); //Julesøndag
    }
    $litArray[] = array('name'=>$litNames[9], 'jd_day'=>$christmas+6); //Nytårsaften

/*
Reglerne:
-- Nytårsdag er 1. januar
-- Helligtrekonger er 6. januar. H3K-søndag ligger på søndagen mellem 2-6 januar. Hvis ingen søndag ligger der, springes den over. Herefter følger "x./sidste søndag efter H3K" frem til søndagen før septuagesima

-- Påskedag kan kun falde i perioden fra 22. marts til 25. april.
    -- Påskedag er første søndag efter første fuldmåne efter forårsjævndøgn. Forårsjævndøgn er altid d. 21. marts.
    -- Tidligste påske jeg har kunnet finde er 2008: 23.marts
    -- Seneste påske jeg har kunnet finde er 2011: 24. april

    -- Følgende ligger fast rundt omkring påsken
    -- Septuagesima og seksagesima ligger 63, 56 dage før påske
    -- Fastelavnssøndag falder syv uger før påske. Herefter "1-3.s i fasten", Midfaste, Mariæ, Palme
    -- Skærtorsdag, langfredag, 2. påskedag, 1-6.s e. påske, bededag, kr himmel, pinse, trinitatissøndag.
-- 1.-26. s.e. Trinitatis fylder så op frem til sidste søndag i kirkeåret. Den første søndag i november afholdes Alle Helgensdag i stedet, og man springer så her den "x. søndag e. trin" over, som skulle have været der.
    -- AlleHelgen kan tidligst ligge på 20.s.e.T; og senest på 24.s.e.T
-- Sidste søndag i kirkegåret er ugen før 1. advent.
-- Advent er de 4 søndage før juledag. 4. søndag i advent kan (i seneste tilfælde) falde samen med juleaftensdag.
-- Juledagene er 24-26. december.
-- Ligger der en søndag efter juledagene og før nytårsaften, bliver den til Julesøndag. Ellers bortfalder den.
-- Nytårsaften er 31. december

*/
    $prevName = "Something's wrong here";
    $foundName = "[Not Found]";
    $todayFlagNotFound = true;
    foreach((array)$litArray as $litDay) {
      echo "<br>".$litDay["name"]." - ".date('Y-m-d', jdtounix ($litDay["jd_day"]));
      if ($litDay["jd_day"] > unixtojd($investigatedDay) && $todayFlagNotFound) {
        $foundName = $prevName;
        $todayFlagNotFound = false;
      }
      $prevName = $litDay["name"];
    }
    echo "<br><br>Seneste gudstjeneste, eller tjenesten i dag: ".$foundName;

function getNamesOfLit() {
  $litArray = array(
                      "1. søndag i advent", //0
                      "2. søndag i advent",
                      "3. søndag i advent",
                      "4. søndag i advent",
                      "Juleaften",
                      "Juledag",
                      "Juledag - aften",
                      "Anden juledag",
                      "Julesøndag",
                      "Nytårsaften",
                      "Nytårsdag", //10
                      "Helligtrekongers søndag",
                      "1. søndag efter helligtrekonger",
                      "2. søndag efter helligtrekonger",
                      "3. søndag efter helligtrekonger",
                      "4. søndag efter helligtrekonger",
                      "5. søndag efter helligtrekonger",
                      "Sidste søndag efter helligtrekonger",
                      "Søndag septuagesima",
                      "Søndag seksagesima",
                      "Fastelavns søndag", //20
                      "1. søndag i fasten",
                      "2. søndag i fasten",
                      "3. søndag i fasten",
                      "Midfaste søndag",
                      "Mariæ bebudelses dag",
                      "Palmesøndag",
                      "Skærtorsdag",
                      "Langfredag",
                      "Påskedag",
                      "Anden påskedag", //30
                      "1. søndag efter påske",
                      "2. søndag efter påske",
                      "3. søndag efter påske",
                      "Bededag 4. fredag efter påske",
                      "4. søndag efter påske",
                      "5. søndag efter påske",
                      "Kristi himmelfarts dag",
                      "6. søndag efter påske",
                      "Pinsedag",
                      "2. pinsedag", //40
                      "Trinitatis søndag",
                      "1. søndag efter trinitatis",
                      "2. søndag efter trinitatis",
                      "3. søndag efter trinitatis",
                      "4. søndag efter trinitatis",
                      "5. søndag efter trinitatis",
                      "6. søndag efter trinitatis",
                      "7. søndag efter trinitatis",
                      "8. søndag efter trinitatis",
                      "9. søndag efter trinitatis", //50
                      "10. søndag efter trinitatis",
                      "11. søndag efter trinitatis",
                      "12. søndag efter trinitatis",
                      "13. søndag efter trinitatis",
                      "14. søndag efter trinitatis",
                      "15. søndag efter trinitatis",
                      "16. søndag efter trinitatis",
                      "17. søndag efter trinitatis",
                      "18. søndag efter trinitatis",
                      "19. søndag efter trinitatis", //60
                      "20. søndag efter trinitatis",
                      "21. søndag efter trinitatis",
                      "22. søndag efter trinitatis",
                      "Alle helgens dag",
                      "23. søndag efter trinitatis",
                      "24. søndag efter trinitatis",
                      "25. søndag efter trinitatis",
                      "26. søndag efter trinitatis",
                      "Sidste søndag i kirkeåret",
                      "Høstgudstjeneste",
                      "Konfirmation", //70
                      "Bryllup/vielse",
                      "Begravelse/bisættelse",
                      "Ved graven"
                  );
  return $litArray;
}

?>
