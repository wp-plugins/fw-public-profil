<?php
/*
Plugin Name: Public Profil
Plugin URI: http://www.wieser.at/wordpress/plugins/
Description: Profil Daten auf Seiten, Beiträge einfach per Shortcode gestalten und publizieren
Version: 0.1
Author: Franz Wieser
Author URI: http://www.wieser.at/
Update Server: http://www.wieser.at/
Min WP Version: 3.3
Max WP Version: 3.5.1
*/


function fw_user_block($atts, $content = null ) {
extract( shortcode_atts( array(
      'user' => '',
      ), $atts ) );

global $fwuser;
$fwuser=$user;

   return '<span class="caption">'. do_shortcode($content) . '</span>';

}

function fw_user($atts, $content = null )
{
extract( shortcode_atts( array(
      'feld' => '',
      ), $atts ) );

global $fwuser;

$user = get_user_by('login', $fwuser);

$userfeld =$user->$feld;


return $userfeld;

}

function public_profil_dashboard()
{
global $current_user;
   echo '<div class="wrap">';
   echo '<H3>Public Profil</H3>';
echo 'Publizieren von Benutzerdaten auf Seiten und Beiträge<br/>';   

echo '<b>Liste der Benutzer: </b>("user" wird für Parameter "Feld" im Shortcode "fwuserblock" verwendet)';
$users = get_users();
echo '<table border="1">';
echo '<tr><th>Name</th><th>user</th></tr>';
foreach ($users as $user)
	{
echo '<tr><td>'.$user->display_name.' </td><td>'.$user->user_login.'</td>';
}
echo '</table>';

echo '<b>Benutzer Profil Felder:</b> (für Parameter "feld" im Shortcode "fwuser")<br/>';
 $all_meta_for_user = get_user_meta( 1 );
  while(list ( $key, $val ) = each ( $all_meta_for_user ))
   {
	 echo $key.'<br/>';
   }



echo '<p/><b>Muster Shortcode zum Einbau in Seiten, Beiträge usw</b><br/>
<pre>[fwuserblock user="kasperl"]

Name: [fwuser feld="last_name"]
Vorname: [fwuser feld="first_name"]
Email [fwuser feld="user_email"]
Homepage: [fwuser feld="user_url"]
[/fwuserblock]
</pre><p/>';


   


}

function public_profil_plugin_menu()
{
add_menu_page('Public Profil', 'Public Profil', 'read', 'publicprofil', 'public_profil_dashboard');
}

add_action('admin_menu', 'public_profil_plugin_menu');


add_shortcode('fwuserblock','fw_user_block');

add_shortcode('fwuser','fw_user');

?>
