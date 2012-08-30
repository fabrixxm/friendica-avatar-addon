<?php
/* Name: Avatar Server
 * Description: libravatar server. Returns profile picture on md5 of users acct
 * Author: Fabio Comuni <acct:fabrixxm@kirgroup.com>
 * Version: 1.0
*/

function avatar_install(){
    logger("Avatar Server plugin enabled");
}
function avatar_uninstall(){
    logger("Avatar Server plugin disabled");
}


function avatar_module(){}

function avatar_init(&$a){

    if ($a->argc == 2) {
        $domain = $a->get_hostname();
        $mduser = $a->argv[1];
        $size = ( isset($_GET['s'])?$_GET['s']:80 );
        $default = ( isset($_GET['d'])?$_GET['d']:$a->get_baseurl().'/images/person-175.jpg' );
      
        // search a photo near $size for user corresponding to hash
        $r = q("SELECT photo.type, photo.data, ABS(photo.width - %s) as size
                    FROM user, photo
                    WHERE 
                            photo.uid = user.uid
                        AND  photo.profile = 1
                        AND  user.verified = 1
                        AND  user.blocked = 0
                        AND  account_removed = 0
                        AND  account_expired = 0
                        AND MD5( CONCAT( nickname, '@%s' ) ) = '%s'
                    ORDER BY size
                    LIMIT 1
                    ",
                intval($size),
                dbesc($domain),
                dbesc($mduser)
            );
        if (count($r)>0){
            header("Content-type: ". $r[0]['type']);
            header("Expires: " . gmdate("D, d M Y H:i:s", time() + (3600*24)) . " GMT");
            header("Cache-Control: max-age=" . (3600*24));
            
            echo $r[0]['data'];
            killme();
        } 
        
        if (in_array($default , array('mm','identicon','monsterid','wavatar','retro'))) $default = $a->get_baseurl().'/images/person-175.jpg';
        goaway($default);
        killme();
    }

}
