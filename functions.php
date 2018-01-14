<?php
/* Child theme kode */
function mit_child_theme() { //Mit child theme funktion

    $parent_style = 'realsoccer-style'; // This is 'realsoccer-style' for the real soccer theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); //henter stylesheet fra parant theme
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    ); // henter stylesheet til child theme
}
add_action( 'wp_enqueue_scripts', 'mit_child_theme' ); // det er en wordpress funktion, sender de nødvendige data om child theme til wordpress.


/* Tilmeld dig funktion */
//Tilføj nyhedsbrev funktionen
function tilfoejNyhedsbrev($emailadresse){
    global $wpdb; //Henter DB forbindelsen fra wordpress
    
    $tabel_navn = $wpdb->prefix . 'nyhedsbrev'; //Definerer tabellens navn udfra prefix wp_
    
    $wpdb->insert($tabel_navn, array(
        'email' => $emailadresse
    ) ); //wordpress egen funktion til at indsætte data i tabellen. Wordpress måde at lave INSERT INTO.
    
    echo '<script>alert("Din e-mail er nu tilføjet!");</script>'; //Javascript pop-up med succes besked
}

if(isset($_POST["tilmelddig"])){ /* hvis tilmelddig har en værdi (er blevet trykket på)*/
    $emailadresse = filter_input(INPUT_POST, 'emailadresse', FILTER_SANITIZE_EMAIL) or die("Ugyldig e-mail adresse"); //henter værdien fra input email feltet og tjekker om det er en gyldig mail vha FILTER_SANITIZE_EMAIL. Hvis det ikke er en gyldig email skriver der fejlbesked ugyldig email. Sikrer også mod SQL injection. 
    
    tilfoejNyhedsbrev($emailadresse); //Den sender data til funktion jeg har oprettet tidligere (emailadresse)
}


/* Nyhedsbrev admin menu */
add_action('admin_menu', 'nyhedsbrev_menu'); //Laver et menupunkt på admin panelet

function nyhedsbrev_menu() {
    add_menu_page('Tilmeldinger', 'Nyhedsbrev', 'manage_options', 'nyhedsbrev', 'nyhedsbrev_tilmeldinger', '../wp-content/plugins/newsletter/images/menu-icon.png', 2);
    // Den synlige del af menuen, wordpress egen funktion.
    // Side title, menu title, bruger rettighed det kræver at se (kun administrator kan det), menu id, function navn, ikon url, menu position
}

function nyhedsbrev_tilmeldinger(){ //meuens indhold
    if(!current_user_can('manage_options')){
        wp_die(__('Du har ikke adgang til denne side')); //Tjekker om bruger har rettigheder til at komme ind på denne side.
    }
    ?>
<div class="wrap"> <!--wordpress egen class-->
        <h1 class="wp-heading-inline">Nyhedsbrev tilmeldinger</h1>
        <?php
    $err_level = error_reporting(0);
    $forbindelse = mysqli_connect("localhost","root","root","wp");
    error_reporting($err_level); //Opretter ny forbindelse til database fordi wordpress egen funktion er kompliceret. Skjuler warning besked (headers mismatch mysql version)

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error(); //Hvis der er forbindelsesfejl skal den displaye en custom besked (failed to connect to MySql), det vises kun når man er logget ind som administrator
    }
    $sql = mysqli_query($forbindelse, "SELECT email, date FROM wp_nyhedsbrev ORDER BY id DESC");
    ?>
    <table width="100%" cellpadding="5" cellspacing="5" border="1">
        <tr>
            <td>E-mail Adresse</td>
            <td>Dato</td>
        </tr>
        <?php
    while($tilmeldinger = mysqli_fetch_array($sql)){ //Henter data fra $sql og sætter ind i array til $tilmeldinger.
        ?>
        <tr>
            <td><?=$tilmeldinger["email"]?></td>
            <td><?=$tilmeldinger["date"]?></td>
        </tr>
        <?php
    }
        ?>
    </table>
</div>
<?php
}