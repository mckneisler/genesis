<?php
$i = 1;
$language['menu'][$i]['id'] = 'music';
$language['menu'][$i]['text'] = 'Muzica';
$language['menu'][$i]['title'] = 'Afişare informaţii muzică';
$language['menu'][$i]['url'] = 'artists.php';

	$j = 1;
	$language['menu'][$i]['submenu'][$j]['id'] = 'artists';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Artisti';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Afişa o listă de artişti';
	$language['menu'][$i]['submenu'][$j]['url'] = 'artists.php';

	$j++;
	$language['menu'][$i]['submenu'][$j]['id'] = 'albums';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Albume';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Afişa o listă de albume';
	$language['menu'][$i]['submenu'][$j]['url'] = 'albums.php';

	$j++;
	$language['menu'][$i]['submenu'][$j]['id'] = 'songs';
	$language['menu'][$i]['submenu'][$j]['text'] = 'Melodii';
	$language['menu'][$i]['submenu'][$j]['title'] = 'Afişa o listă de melodii';
	$language['menu'][$i]['submenu'][$j]['url'] = 'songs.php';

if ($_SESSION['isLoggedIn']) {
	$i++;
	$language['menu'][$i]['id'] = 'logout';
	$language['menu'][$i]['text'] = 'Deconectare';
	$language['menu'][$i]['title'] = 'Radierea Recordly cerere';
	$language['menu'][$i]['url'] = 'index.php?logout=true';
} else {
	if ($menuSelected == "register") {
		$i++;
		$language['menu'][$i]['id'] = 'register';
		$language['menu'][$i]['text'] = 'Înregistrează-te';
		$language['menu'][$i]['title'] = 'Creaţi un nou profil de utilizator';
		$language['menu'][$i]['url'] = 'register.php';
	} else {
		$i++;
		$language['menu'][$i]['id'] = 'login';
		$language['menu'][$i]['text'] = 'Login';
		$language['menu'][$i]['title'] = 'Login la Recordly cerere';
		$language['menu'][$i]['url'] = 'login.php';
	}
}

$language['heading']['fatalError'] = 'Eroare Fatală';
$language['heading']['login'] = 'Login';
$language['heading']['page'] = 'Sistemul de Management Muzical';
$language['heading']['newUser'] = 'Înregistrare Utilizator Nou';
$language['heading']['title'] = $appName . ' Sistemul de Management Muzical';

$language['label']['action'] = 'Acţiune';
$language['label']['album'] = 'Album';
$language['label']['albums'] = 'Albume';
$language['label']['artist'] = 'Artistul';
$language['label']['email'] = 'Email';
$language['label']['favorite'] = 'Favorit';
$language['label']['password'] = 'Parola';
$language['label']['reenterPassword'] = 'Re-introduceţi Parola';
$language['label']['song'] = 'Cântec';
$language['label']['songs'] = 'Melodii';

$language['button']['login'] = 'Login';
$language['button']['register'] = 'Înregistrează-te';

$language['message']['emailAE'] = 'Email adresa există deja';
$language['message']['emailNotReg'] = 'Adresa de email nu a fost înregistrat';
$language['message']['errorsFound'] = 'Erori au fost găsite pe această pagină în domeniile identificate mai jos:';
$language['message']['doesNotMatch'] = 'Nu se potriveşte cu parola de mai sus';
$language['message']['incorrectPassword'] = 'Parola nu este corectă pentru acest email';
$language['message']['invalidPassword'] = 'Parolă invalidă format, acesta trebuie să';
$language['message']['noRecords'] = 'S-au găsit nici o înregistrare';
$language['message']['requiredField'] = 'Acesta este un câmp obligatoriu';

$language['phrase']['added'] = 'Adăugat';
$language['phrase']['atLeast1Lower'] = ' conţin cel puţin 1 minuscule';
$language['phrase']['atLeast1Num'] = ' să conțină cel puțin 1 număr';
$language['phrase']['atLeast1Spec'] = ' conţin cel puţin 1 speciale (!@#$%^&*-_)';
$language['phrase']['atLeast1Upper'] = ' conţin cel puţin 1 majuscule';
$language['phrase']['deleted'] = 'Elimină';
$language['phrase']['emailSubject'] = 'Întrebări de la Site-ul';
$language['phrase']['existingUser'] = 'Utilizator existent?';
$language['phrase']['greaterThan8Char'] = ' fie mai mare decât 8 caractere';
$language['phrase']['lessThan20Char'] = ' fi mai mică de 20 de caractere';
$language['phrase']['login'] = 'Login la contul dvs';
$language['phrase']['newUser'] = 'Utilizator nou?';
$language['phrase']['passwordRules'] = '(8-20 caractere, 1 număr, 1 majuscule, 1 minuscule and 1 speciale)';
$language['phrase']['pleaseLogin'] = 'Vă rugăm să login sau Inregistreaza-te folosind opţiunile de mai sus.';
$language['phrase']['questions'] = 'Aveţi întrebări? Email';
$language['phrase']['removed'] = 'Eliminat';
$language['phrase']['returnToHome'] = 'Întoarcere la pagina de pornire.';
$language['phrase']['siteDesc'] = 'Cu ' . $appName . ' puteţi căuta artişti muzicale şi albume şi melodii lor. Puteţi de asemenea să identifice favorite din fiecare.';
$language['phrase']['signUp'] = 'Înscrieţi-vă pentru un cont nou';
$language['phrase']['swipe'] = 'DEPLASAȚI DEGETUL';
$language['phrase']['webmaster'] = $appName . ' Webmaster';
?>
