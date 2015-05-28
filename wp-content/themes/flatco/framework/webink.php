<?php
global $tw_googlefonts;
$twWebinkFonts=array();
if(function_exists('getProject')&&  function_exists('getProjectFonts')){
    $tw_webink_projects = getProject('','');
    foreach ($tw_webink_projects as $tw_webink_project){
        $tw_webink_projectfonts = getProjectFonts('',$tw_webink_project->GUID);
        if($tw_webink_projectfonts){
            foreach($tw_webink_projectfonts as $tw_webink_font){
                 $twWebinkFonts[$tw_webink_font->PSName]=$tw_webink_font->Name;
            }
        }
    }
}
$tw_googlefonts=array_merge($twWebinkFonts, $tw_googlefonts);