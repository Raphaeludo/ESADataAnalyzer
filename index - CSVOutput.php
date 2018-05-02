<?php


header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=ESA-Electronic_Stratagem_Analyzer.csv');

$fp = fopen("php://output", "w");


//include_once('AGI_EDCAA_LIBRARY/simplehtmldom_1_5/simple_html_dom.php');

//C:\xampp\htdocs\Electronic_Stratagem_Analyzer[ESA]\Project_Resources\simplehtmldom_1_5\simple_html_dom.php
//C:\xampp\htdocs\Electronic_Stratagem_Analyzer[ESA]\ESA_Includes\simple_html_dom.php
//include_once('Electronic_Stratagem_Analyzer[ESA]/ESA_Includes/simple_html_dom.php');

      //include_once('Electronic_Stratagem_Analyzer[ESA]/Project_Resources/simplehtmldom_1_5/simple_html_dom.php');

      include_once('ESA_Includes/simple_html_dom.php');

      $extractionSource_PrimaryDomain = 'http://www.soccerstats.com';

$DOM_Object;

$DOM_fetcher;

$findElements;

$findElements_Stats;

$stats_halfURL;// = '';

$stats_fullURL;

$fE_H2HVar;

$fE_H2HVar_halfURL;

$fE_H2HVar_fullURL;

$fH2HD;

$DOM_Object_MatchData;

$DOM_Object_StatsCriteria02Confirmation;

$DOM_Object_NationalLeague;
				
$DOM_Object_NationalLeague_Fetcher;
				
$findDOM_Obj_NationalLeague;

$DOM_Object_H2HData;
					
$DOM_Object_H2HData_Fetcher;
				
$find_H2HData;

$capononVar;

$find_H2HData_HOLDERScore;


//VITAL ARRAY VARIABLES NEEDED ON THE EXCEL WORKSHEET...
$matchEvent_ArrayVAR = array();
$NationalLeague_Name_ArrayVAR = array();

$TRUE_Qualified_MatchEvent_ArrayVAR = array();
$TRUE_Qualified_NationalLeague_Name_ArrayVAR = array();


$initial_extractionSource = 'http://www.soccerstats.com/matches.asp?matchday=3';

$DOM_Object = new simple_html_dom();

$DOM_fetcher = $DOM_Object->load_file($initial_extractionSource);

$findElements = $DOM_Object->find('tr.trow8');

$findElements_Stats = $DOM_Object->find('tr.trow8 td[align=center] a[1] font[color=blue] u');



foreach($findElements as $fE)
{?>
	<div class="dataResults_BG">
  <?php
  $fE_Var = $fE->children(19)->children(0);//->href;
	$fE_H2HVar = $fE->children(19)->children(1);
	
	//++--$fE_Var = $fE->find('td[align=center] a[1] font[color=blue] u');
	
	//>>GOOD_CHECK***
	//++***if($fE->children(19)->plaintext == "stats")
	if((strpos($fE->children(19)->plaintext, "stats") !== FALSE))
	{
		
		if((strpos($fE_Var->href, "stats") !== FALSE))// && ($fE_Var !== ""))//if($fE_Var !== "stats")
		{
      echo '<br/>';
      echo "<b>" . "First Criteria Satisfied that this Match is a League Match" . "</b>" . "<br/>";
			$fE_VarStatus = TRUE;
			
			if($fE_VarStatus)
			{
				
				//EXPLANATION:
				/*THIS BLOCK should be used as an outer wrapper for this particular foreach loop block inside which
				iteration for extracting league matches are done. So because this commented block iterates for 
				the National league each league match belongs to, then it should therefore be a wrap around for loop block
				which does the match extraction.*/
				
				$DOM_Object_NationalLeague = new simple_html_dom();
				
				$DOM_Object_NationalLeague_Fetcher = $DOM_Object_NationalLeague->load_file($initial_extractionSource);
				
				$find_NationalLeague = $DOM_Object_NationalLeague->find('div.twelve table[id=btable] tbody tr.trow2 td[height=30]');

        //***IN_USE_in_foreach_loop_block***echo $find_NationalLeague[1]->innertext;
        //TEMPORARILY DISABLED. MUCH BETTER METHOD FOR OBTAINING LEAGUE NAME INFO BELOW.
				/*foreach($find_NationalLeague as $fNL)
				{
					$fNL_Var = $fNL->innertext;
					echo $fNL_Var . '<br/>';
				}*/
				
				$DOM_Object_NationalLeague->clear();
				
				//END OF National League Type Loop Iteration.
        /**/


        //$fE_H2HVar;

					$fE_H2HVar_halfURL = $fE_H2HVar->href;
					
					$fE_H2HVar_fullURL = $extractionSource_PrimaryDomain . '/' . $fE_H2HVar_halfURL;
          
          //Again, No Need to Print MAtch URL at Least for this Version
					//echo $fE_H2HVar_fullURL . '<br/>';
        
					
					$DOM_Object_H2HData = new simple_html_dom();
					
					$DOM_Object_H2HData_Fetcher = $DOM_Object_H2HData->load_file($fE_H2HVar_fullURL);
					
					//--IN_USE--$find_NationalLeague = $DOM_Object->find('div.twelve table[id=btable] tbody tr.trow2 td[height=30]');
					//--IN_USE--echo $find_NationalLeague;
					
					/*
					$fNL_Var = $fNL->innertext;
          echo $fNL_Var . '<br/>';
          */
          

          //MUCH BETTER SOLUTION FOR EXTRACTING NATIONAL LEAGUE NAME
					$NationalLeague_CountryName_FirstSplit = substr($fE_H2HVar_fullURL, 42);						
					$NationalLeague_CountryName_Stringb4Ampersand = strstr($NationalLeague_CountryName_FirstSplit, "&", TRUE);
					
					$find_H2HData_CountryFlag = $DOM_Object_H2HData->find('.row .six table tbody tr td', 1)->innertext;//('.row .six table tbody tr td[height=14, width=25]', 1);
					
					$find_H2HData_LeagueName = $DOM_Object_H2HData->find('form[name=MenuList] select[name=countryLeague] option[value=#]', 0)->plaintext;
					
					$NationalLeague_Name = $find_H2HData_CountryFlag . '&nbsp;&nbsp;' . '<b>' . $NationalLeague_CountryName_Stringb4Ampersand . '</b>' . '&nbsp;&nbsp;' . $find_H2HData_LeagueName;
					
					echo $NationalLeague_Name . '</br>' . '<br/>';
					
					$NationalLeague_Name_ArrayVAR[] = $NationalLeague_Name;

					
					//$stats_halfURL = $DOM_Object->find('div.twelve table[id=btable] tbody tr.trow8 td[align=center] a[1]');
        //No Need To Print the Match URL.
          //echo $fE_H2HVar->href . '<br/>' . '<br/>';
				
				$stats_halfURL = $fE_Var->href; 
				
				//**Previous Half Solution**echo $extractionSource_PrimaryDomain.'/'.$stats_halfURL[0]->href . '<br/>' . '<br/>';
				//echo $fE_Var . '<br/>';<br />
				
				$stats_fullURL = $extractionSource_PrimaryDomain . '/' . $stats_halfURL;
				
				//echo $extractionSource_PrimaryDomain . '/' . $stats_halfURL . '<br/>' . '<br/>';
        //No Need to Print this URL.
        //echo $stats_fullURL . '<br/>' . '<br/>';
					
					$matchEvent = $fE->children(8) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fE->children(9) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fE->children(10) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<br/>';
					
					echo $matchEvent . '</br>';
					
					$matchEvent_ArrayVAR[] = $matchEvent;
					
					echo 'HOME TEAM:' . $homeTeam = $fE->children(8);
					echo '<br/>';
					echo 'AWAY TEAM:' . $awayTeam = $fE->children(10);
					echo  '<br/>';// . '<br/>';
					
					
					
					//1ST POINT OF EXTRACTION FOR HOME TEAM
					$find_H2HData = $DOM_Object_H2HData->find('div[id=h2h-team1] table', 0);
					
					//1ST POINT OF EXTRACTION FOR AWAY TEAM
					$find_H2HData_AWAY = $DOM_Object_H2HData->find('div[id=h2h-team2] table', 0);
					
          
          $find_H2HData_HOLDER01 = $find_H2HData->find('tbody tr[bgcolor]');
						//2ND POINT OF EXTRACTION FOR AWAY TEAM
						//**IN_USE**
						$find_H2HData_HOLDER01_AWAY = $find_H2HData_AWAY->find('tbody tr[bgcolor]');
						
						
						//TEST TO CHECK FOR HOW TO HANDLE ERROR NOTICE: "trying to get property of non-object"
						/*$find_H2HData_HOLDER02 = $find_H2HData->find('tbody tr td a font b', 0);
						if($find_H2HData_HOLDER02)
						{
							//echo $find_H2HData_HOLDER02->plaintext . '<br/>' . '<br/>';//PRINTS: CS
							//echo $find_H2HData_HOLDER02->find('a font b', 0)->plaintext . '<br/>' . '<br/>';
							echo $find_H2HData_HOLDER02->plaintext . '<br/>' . '<br/>';
						}
						else
						{
							echo "I ain't seen nothing in this shit hole homie..." . '<br/>' . '<br/>';
						}*/
							
						
						//++$find_H2HData_HOLDER03 = $find_H2HData_HOLDER02[2]->find('a font b');
						//++echo $find_H2HData_HOLDER03->plaintext . '<br/>' . '<br/>';
						//++echo $find_H2HData_HOLDER02->plaintext . '<br/>' . '<br/>';
						//*+echo $find_H2HData_HOLDER02 . '<br/>' . '<br/>';
						
						
						echo '<br/>';// . '<br/>';
						$HomeTeam_CountofMatchHistory = 0;
						$HomeTeam_CountofMatchHistory = count($find_H2HData_HOLDER01);
						echo "<u>" . $homeTeam . "'s Number of Matches Played so Far:" . "</u>" . '<b>' . $HomeTeam_CountofMatchHistory . '</b>' . '<br/>';
						/*$HomeTeam_ROWList_of_MatchHistory_ArrayVAR = array();
						$HomeTeam_ROWList_of_MatchHistory_LEFTResult_ArrayVAR = array();*/

//EXTRACTION ITERATION FOR HOME TEAM
foreach($find_H2HData_HOLDER01 as $fH2HD_HOLDER01)
{
  //echo $fH2HD_HOLDER01->innertext . '<br/>';
  //++**echo $fH2HD_HOLDER01->children(1) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fH2HD_HOLDER01->children(2)->children(0) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fH2HD_HOLDER01->children(3) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<br/>';
  $find_H2HData_HOLDERScore = $fH2HD_HOLDER01->find('td a font b', 0);
  
  $find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData = $fH2HD_HOLDER01->find('td font b', 0);
  $find_H2HData_HOLDERScore_PostponedMatch_in_TableData = $fH2HD_HOLDER01->find('td', 0);
  
  /*function check_against_property_of_nonObject_notice()
  {
    if($find_H2HData_HOLDERScore)
    {
      $capononVar = $find_H2HData_HOLDERScore->plaintext;
    }
    return $capononVar;
  }*/
  
  //echo $fH2HD_HOLDER01->children(1) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . check_against_property_of_nonObject_notice() . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fH2HD_HOLDER01->children(3) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<br/>';
  
  //STORING THE THREE VARIABLES RESPONSIBLE FOR PRINTING THE ROW LIST OF HOME TEAM'S MATCH HISTORY [$fH2HD_HOLDER01->children(1) AND $find_H2HData_HOLDERScore->plaintext AND $fH2HD_HOLDER01->children(3)] IN A VARIABLE $HomeTeam_ROWList_of_MatchHistory WHICH IS THEN STORED AS AN ARRAY.
  
  $HomeTeam_ROWList_of_MatchHistory_LEFTResult = 
  $fH2HD_HOLDER01->children(1) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  if($find_H2HData_HOLDERScore)
  {
    $HomeTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else if($find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData)
  {
    $HomeTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else if($find_H2HData_HOLDERScore_PostponedMatch_in_TableData)
  {
    $HomeTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore_PostponedMatch_in_TableData->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else
  {
    $HomeTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    "No Available Scoreline" . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  $HomeTeam_ROWList_of_MatchHistory_RIGHTResult = 
  $fH2HD_HOLDER01->children(3) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<br/>';
  
  //CONCATENATING...
  $HomeTeam_ROWList_of_MatchHistory = $HomeTeam_ROWList_of_MatchHistory_LEFTResult . $HomeTeam_ROWList_of_MatchHistory_MIDDLEResult . $HomeTeam_ROWList_of_MatchHistory_RIGHTResult;
  
  echo $HomeTeam_ROWList_of_MatchHistory;
  
  //$HomeTeam_ROWList_of_MatchHistory_ArrayVAR = array();
  $HomeTeam_ROWList_of_MatchHistory_ArrayVAR[] = $HomeTeam_ROWList_of_MatchHistory;
  
  //extract($HomeTeam_ROWList_of_MatchHistory_ArrayVAR);
  
  //For Diagnostics:
  //echo '$HomeTeam_ROWList_of_MatchHistory_LEFTResult' . '&nbsp;&nbsp;&nbsp;' . '=' . '&nbsp;&nbsp;&nbsp;' . $HomeTeam_ROWList_of_MatchHistory_LEFTResult;
  //echo '<br/>';
  //$HT_RL_MH_LR_Stripped = strip_tags($HomeTeam_ROWList_of_MatchHistory_LEFTResult);
  //if($HT_RL_MH_LR_Stripped === strip_tags($homeTeam))
  //echo 'ROW_LIST Printing OF $HomeTeam_ROWList_of_MatchHistory_ArrayVAR' . '&nbsp;&nbsp;&nbsp;' . '=' . '&nbsp;&nbsp;&nbsp;' . $HomeTeam_ROWList_of_MatchHistory_ArrayVAR . '<br/>' . '<br/>';
  
  
    //$HomeTeam_ROWList_of_MatchHistory_LEFTResult_ArrayVAR[] = $HomeTeam_ROWList_of_MatchHistory_LEFTResult;
  
  //For Diagnostics:
  /*echo 'Home Team printed WITHOUT HTML Formatting:&nbsp;&nbsp;&nbsp;' . $homeTeam . '<br/>';
  echo 'Left Team in Row_List printed WITH HTML Formatting:&nbsp;&nbsp;&nbsp;' . $HomeTeam_ROWList_of_MatchHistory_LEFTResult . '<br/>';
  echo 'Left Team in Row_List printed WITHOUT HTML Formatting:&nbsp;&nbsp;&nbsp;' . strip_tags($HomeTeam_ROWList_of_MatchHistory_LEFTResult);
  echo '<br/>' . '<br/>';*/
  //echo '<br/>';
  
  
}//***END OF foreach($find_H2HData_HOLDER01 as $fH2HD_HOLDER01) BLOCK***


//FOR AWAY TEAM MATCH HISTORY
						
echo '<br/>';// . '<br/>';
$AwayTeam_CountofMatchHistory = 0;
$AwayTeam_CountofMatchHistory = count($find_H2HData_HOLDER01_AWAY);
echo "<u>" . $awayTeam . "'s Number of Matches Played so Far:" . "</u>" . '<b>' . $AwayTeam_CountofMatchHistory . '</b>' . '<br/>';// . '<br/>';

//EXTRACTION ITERATION FOR AWAY TEAM
foreach($find_H2HData_HOLDER01_AWAY as $fH2HD_HOLDER01_AWAY)
{
  $find_H2HData_HOLDERScore_AWAY = $fH2HD_HOLDER01_AWAY->find('td a font b', 0);
  
  $find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData_AWAY = $fH2HD_HOLDER01_AWAY->find('td font b', 0);
  $find_H2HData_HOLDERScore_PostponedMatch_in_TableData_AWAY = $fH2HD_HOLDER01_AWAY->find('td', 0);
  
  //STORING THE THREE VARIABLES RESPONSIBLE FOR PRINTING THE ROW LIST OF AWAY TEAM'S MATCH HISTORY [$fH2HD_HOLDER01->children(1) AND $find_H2HData_HOLDERScore->plaintext AND $fH2HD_HOLDER01->children(3)] IN A VARIABLE $AwayTeam_ROWList_of_MatchHistory WHICH IS THEN STORED AS AN ARRAY.
  
  $AwayTeam_ROWList_of_MatchHistory_LEFTResult = 
  $fH2HD_HOLDER01_AWAY->children(1) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  if($find_H2HData_HOLDERScore_AWAY)
  {
    $AwayTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore_AWAY->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else if($find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData_AWAY)
  {
    $AwayTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore_Without_Anchor_Tag_in_TableData_AWAY->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else if($find_H2HData_HOLDERScore_PostponedMatch_in_TableData_AWAY)
  {
    $AwayTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    $find_H2HData_HOLDERScore_PostponedMatch_in_TableData_AWAY->plaintext . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  else
  {
    $AwayTeam_ROWList_of_MatchHistory_MIDDLEResult = 
    "No Available Scoreline" . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  $AwayTeam_ROWList_of_MatchHistory_RIGHTResult = 
  $fH2HD_HOLDER01_AWAY->children(3) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<br/>';
  
  //CONCATENATING...
  $AwayTeam_ROWList_of_MatchHistory = $AwayTeam_ROWList_of_MatchHistory_LEFTResult . $AwayTeam_ROWList_of_MatchHistory_MIDDLEResult . $AwayTeam_ROWList_of_MatchHistory_RIGHTResult;
  
  echo $AwayTeam_ROWList_of_MatchHistory;
  
  $AwayTeam_ROWList_of_MatchHistory_ArrayVAR[] = $AwayTeam_ROWList_of_MatchHistory;
  
  //extract($AwayTeam_ROWList_of_MatchHistory_ArrayVAR);
  
  //For Diagnostics:
  //echo '$AwayTeam_ROWList_of_MatchHistory_RIGHTResult' . '&nbsp;&nbsp;&nbsp;' . '=' . '&nbsp;&nbsp;&nbsp;' . $AwayTeam_ROWList_of_MatchHistory_RIGHTResult;
  //echo '<br/>';

    //$HomeTeam_ROWList_of_MatchHistory_RIGHTResult_ArrayVAR = array();
    //$AwayTeam_ROWList_of_MatchHistory_RIGHTResult_ArrayVAR[] = $AwayTeam_ROWList_of_MatchHistory_RIGHTResult;
    
    
    
  //For Diagnostics:
  /*echo 'Away Team printed WITHOUT HTML Formatting:&nbsp;&nbsp;&nbsp;' . $awayTeam . '<br/>';
  echo 'Right Team in Row_List printed WITH HTML Formatting:&nbsp;&nbsp;&nbsp;' . $AwayTeam_ROWList_of_MatchHistory_RIGHTResult . '<br/>';
  echo 'Right Team in Row_List printed WITHOUT HTML Formatting:&nbsp;&nbsp;&nbsp;' . strip_tags($AwayTeam_ROWList_of_MatchHistory_RIGHTResult);
  echo '<br/>' . '<br/>';*/
  
  
  
}//***END OF foreach($find_H2HData_HOLDER01_AWAY as $fH2HD_HOLDER01_AWAY) BLOCK***


$DOM_Object_H2HData->clear();
unset($DOM_Object_H2HData);


//*****************END OF AWAY TEAM MATCH RESULTS ITERATION********************

      }

    }

  }?>

  <!-- end of .dataResults_BG --></div>
  <?php           
}//END OF THE MOTHER FOREACH LOOP foreach($findElements as $fE)


//CSV DATA OUTPUT BEGINS HERE...

$Buffer_TitleHead_String_ArrayVAR = array();

/*$Buffer_ArrayVAR = array();
$Buffer_ArrayVAR[] = "";

$Buffer_TitleHead_String_ArrayVAR = array();
$Match_TitleHead_String_ArrayVAR = array();
$LeagueName_TitleHead_String_ArrayVAR = array();*/

$TitleHead_String_ArrayVAR = array();


$Buffer_TitleHead_String_ArrayVAR[] = '';
/*$MatchEvent_TitleHead_String_ArrayVAR[] = 'MATCH';
$LeagueName_TitleHead_String_ArrayVAR[] = 'LEAGUE';*/

$TitleHead_String_ArrayVAR = array('MATCH', 'LEAGUE');//, 'HTS', 'HTC', 'ATS', 'ATC', 'HS+1', 'HS-1', 'HC+1', 'HC-1', 'AS+1', 'AS-1', 'AC+1', 'AC-1', 'PHW', 'PHX', 'PHL', 'PAW', 'PAX', 'PAL');


$CSV_Output_Holder[] = $Buffer_TitleHead_String_ArrayVAR;

$CSV_Output_Holder[] = $TitleHead_String_ArrayVAR;

//fputcsv($fp, $CSV_Output_Holder);

//$CSV_Output_Holder[] = $Buffer_ArrayVAR;
$CSV_Output_Holder[] = $TRUE_Qualified_MatchEvent_ArrayVAR;//$matchEvent_ArrayVAR;
$CSV_Output_Holder[] = $TRUE_Qualified_NationalLeague_Name_ArrayVAR;//$NationalLeague_Name_ArrayVAR;

/*
//DIAGNOSTIC...
echo '<br/><br/>';
echo 'TRYING TO PRINT MULTIPLE ARRAYS AND STRING VALUES STORED INTO $CSV_Output_Holder';
echo '<br/><br/>';
*/


function StripTrimClean_Callback($array_dataValue)
{
	$StrippedTrimmedCleaned_DV = str_replace("&nbsp;", "", str_replace("\xc2\xa0", "", trim(strip_tags($array_dataValue))));
	return $StrippedTrimmedCleaned_DV;
}

//OVER TO YOU GENTLEMEN...
foreach($CSV_Output_Holder as $CSV_OuH)
{
	//USING array_map() WHICH RETURNS AN ARRAY...
	$Stripped_and_Cleaned_DataValues = array_map("StripTrimClean_Callback", $CSV_OuH);
	
	fputcsv($fp, $Stripped_and_Cleaned_DataValues);
	
}

fclose($fp);
	
	
	/*$DOM_Object_NationalLeague->clear();
	unset($DOM_Object_NationalLeague);*/
	
	$DOM_Object->clear();
	unset($DOM_Object);

?>