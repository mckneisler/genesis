<?php

use Illuminate\Database\Seeder;

use App\Models\Code;
use App\Models\CodeLocale;

class CodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating codes...');

		/*
		 * CODES
		 */
		$this->command->info('  Creating types...');
		$types = Code::create([
			'parent_code_id' => 1,
			'code' => 'types'
		]);

		/*
		 * LOCALES
		 */
		$this->command->info('  Creating locales...');
		$locales = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'locales'
		]);
		$english = Code::create([
			'parent_code_id' => $locales->id,
			'code' => 'en'
		]);
		$romanian = Code::create([
			'parent_code_id' => $locales->id,
			'code' => 'ro'
		]);
		CodeLocale::create([
			'model_id' => $locales->id,
			'locale_id' => $english->id,
			'name' => 'Locale|Locales',
			'description' => 'Type that defines locales or languages'
		]);
		CodeLocale::create([
			'model_id' => $locales->id,
			'locale_id' => $romanian->id,
			'name' => 'Locale|Locale',
			'description' => 'Tipul care defineşte localizări sau limbi'
		]);
		CodeLocale::create([
			'model_id' => $english->id,
			'locale_id' => $english->id,
			'name' => 'English'
		]);
		CodeLocale::create([
			'model_id' => $english->id,
			'locale_id' => $romanian->id,
			'name' => 'Multe'
		]);
		CodeLocale::create([
			'model_id' => $romanian->id,
			'locale_id' => $english->id,
			'name' => 'Romanian'
		]);
		CodeLocale::create([
			'model_id' => $romanian->id,
			'locale_id' => $romanian->id,
			'name' => 'Română'
		]);
		CodeLocale::create([
			'model_id' => $types->id,
			'locale_id' => $english->id,
			'name' => 'Type|Types',
			'description' => 'Categories of codes'
		]);
		CodeLocale::create([
			'model_id' => $types->id,
			'locale_id' => $romanian->id,
			'name' => 'Tip|Tipuri',
			'description' => 'Categorii de coduri'
		]);

		/*
		 * STATUSES
		 */
		$this->command->info('  Creating statuses...');
		$statuses = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'statuses',
			'en' => [
				'name' => 'Status|Statuses',
				'description' => 'State of a record in the database'
			],
			'ro' => [
				'name' => 'Statutul|Statusuri',
				'description' => 'Stat ale unei înregistrări în baza de date'
			]
		]);
		Code::create([
			'parent_code_id' => $statuses->id,
			'code' => 'active',
			'en' => [
				'name' => 'Active',
				'description' => 'Currently in use'
			],
			'ro' => [
				'name' => 'Activ',
				'description' => 'În prezent în uz'
			]
		]);
		Code::create([
			'parent_code_id' => $statuses->id,
			'code' => 'disabled',
			'en' => [
				'name' => 'Disabled',
				'description' => 'Currently not in use'
			],
			'ro' => [
				'name' => 'Dezactivat',
				'description' => 'În prezent nu este în uz'
			]
		]);

		/*
		 * ROLES
		 */
		$this->command->info('  Creating roles...');
		$roles = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'roles',
			'en' => [
				'name' => 'Role|Roles',
				'description' => 'Type that defines all of the roles for the application'
			],
			'ro' => [
				'name' => 'Rolul|Roluri',
				'description' => 'Tipul care defineşte toate rolurile de aplicare'
			]
		]);
		Code::create([
			'parent_code_id' => $roles->id,
			'code' => 'admin',
			'en' => [
				'name' => 'Administrator',
				'description' => 'A person who manages the application'
			],
			'ro' => [
				'name' => 'Administrator',
				'description' => 'O persoană care gestionează aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $roles->id,
			'code' => 'dev',
			'en' => [
				'name' => 'Developer',
				'description' => 'A person who maintains the code and data for the application'
			],
			'ro' => [
				'name' => 'Dezvoltator',
				'description' => 'O persoană care susţine cod şi datele de aplicare'
			]
		]);
		Code::create([
			'parent_code_id' => $roles->id,
			'code' => 'translator',
			'en' => [
				'name' => 'Translator',
				'description' => 'A person who translates words an phrases into other languages'
			],
			'ro' => [
				'name' => 'Traducător',
				'description' => 'O persoană care se traduce cuvintele unei fraze in alte limbi'
			]
		]);
		Code::create([
			'parent_code_id' => $roles->id,
			'code' => 'maint_tester',
			'en' => [
				'name' => 'Maintenance Tester',
				'description' => 'A person who is able to test the application while it is in maintenance mode'
			],
			'ro' => [
				'name' => 'Test de Întreţinere',
				'description' => 'O persoană care este capabil de a testa aplicaţia în timp ce este în modul mentenanţă'
			]
		]);

		/*
		 * OBJECTS
		 */
		$this->command->info('  Creating objects...');
		$objects = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'objects',
			'en' => [
				'name' => 'Object|Objects',
				'description' => 'Type that defines all of the objects in the application controlled by permissions'
			],
			'ro' => [
				'name' => 'Obiect|Obiecte',
				'description' => 'Tipul care defineşte toate obiectele în aplicarea controlată de permisiuni'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'profiles',
			'en' => [
				'name' => 'Profile|Profiles',
				'description' => 'User defined identifying attributes'
			],
			'ro' => [
				'name' => 'Profilul|Profile',
				'description' => 'Identifică atributele definite de utilizator'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'admin_menu',
			'en' => [
				'name' => 'Admin Menu',
				'description' => 'Admin option from the menu'
			],
			'ro' => [
				'name' => 'Meniul Admin',
				'description' => 'Admin opţiune din meniu'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'security_menu',
			'en' => [
				'name' => 'Security Menu',
				'description' => 'Security option from the menu'
			],
			'ro' => [
				'name' => 'Meniul de Securitate',
				'description' => 'Opţiune de Securitate din meniul'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'codes',
			'en' => [
				'name' => 'Code|Codes',
				'description' => 'Records in the Codes table'
			],
			'ro' => [
				'name' => 'Cod|Coduri',
				'description' => 'Înregistrările din tabelul de Coduri'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'types',
			'en' => [
				'name' => 'Type|Types',
				'description' => 'Categories in the Codes table'
			],
			'ro' => [
				'name' => 'Tip|Tipuri',
				'description' => 'Categorii din tabelul de Coduri'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'permissions',
			'en' => [
				'name' => 'Permission|Permissions',
				'description' => 'An ability to perform a function in the application, defined by an object and an action pairing'
			],
			'ro' => [
				'name' => 'Permisiunea|Permisiuni',
				'description' => 'O capacitatea de a îndeplini o funcţie în cerere, definit de un obiect şi o acţiune de asociere'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'users',
			'en' => [
				'name' => 'User|Users',
				'description' => 'People who interact with the application'
			],
			'ro' => [
				'name' => 'Utilizator|Utilizatorii',
				'description' => 'Oameni care interacţionează cu cererea'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'artists',
			'en' => [
				'name' => 'Artist|Artists',
				'description' => 'A person or group who creates music'
			],
			'ro' => [
				'name' => 'Artist|Artisti',
				'description' => 'O persoană sau grup care creează muzică'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'albums',
			'en' => [
				'name' => 'Album|Albums',
				'description' => 'A collection of recordings issued as a single item on CD, record, or another medium'
			],
			'ro' => [
				'name' => 'Album|Albume',
				'description' => 'O colecţie de înregistrări emise ca un singur element de pe CD, înregistrare, sau un alt suport'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'songs',
			'en' => [
				'name' => 'Song|Songs',
				'description' => 'A short poem or other set of words set to music or meant to be sung'
			],
			'ro' => [
				'name' => 'Cântec|Melodii',
				'description' => 'Un poem scurt sau alte set de cuvinte set pentru muzică sau menirea de a fi cântat'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'favorite',
			'en' => [
				'name' => 'Favorite|Favorites',
				'description' => 'A thing that is particularly well liked by someone'
			],
			'ro' => [
				'name' => 'Favorit|Favorite',
				'description' => 'Un lucru care este deosebit de bine-a plăcut de cineva'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'actions',
			'en' => [
				'name' => 'Action|Actions',
				'description' => 'A process or function performed using a selected item in a list'
			],
			'ro' => [
				'name' => 'Acţiune|Acţiunile',
				'description' => 'Un proces sau funcţie folosind un element selectat într-o listă'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'name',
			'en' => [
				'name' => 'Name|Names',
				'description' => 'A word or set of words by which a person, animal, place, or thing is known, addressed, or referred to'
			],
			'ro' => [
				'name' => 'Nume|Nume',
				'description' => 'Un cuvânt sau un set de cuvinte prin care o persoană, animale, loc sau lucru este cunoscut, a adresat, sau prevăzute la'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'password',
			'en' => [
				'name' => 'Password|Passwords',
				'description' => 'A secret word or phrase that must be used to gain admission'
			],
			'ro' => [
				'name' => 'Parola|Parole',
				'description' => 'Un secret cuvânt sau o frază care să fie utilizate pentru a obţine admiterea'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'email',
			'en' => [
				'name' => 'Email Address|Email Addresses',
				'description' => 'An address to which electronic messages are delivered'
			],
			'ro' => [
				'name' => 'Adresa de Email|Adrese de Email',
				'description' => 'O adresă la care sunt livrate mesaje electronice'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'description',
			'en' => [
				'name' => 'Description|Descriptions',
				'description' => 'A written representation of an object'
			],
			'ro' => [
				'name' => 'Descriere|Descrieri',
				'description' => 'O reprezentare scrisă de un obiect'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'objects',
			'en' => [
				'name' => 'Object|Objects',
				'description' => 'A thing with distinct and independent existence within the application'
			],
			'ro' => [
				'name' => 'Obiect|Obiecte',
				'description' => 'Un lucru cu existenta distincte şi independente în aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'roles',
			'en' => [
				'name' => 'Role|Roles',
				'description' => 'The part played by a person within the application'
			],
			'ro' => [
				'name' => 'Rolul|Roluri',
				'description' => 'Rolul jucat de o persoană în aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'combination',
			'en' => [
				'name' => 'Combination|Combinations',
				'description' => 'A joining or merging of different parts or qualities in which the component elements are individually distinct'
			],
			'ro' => [
				'name' => 'Combinaţie|Combinaţii',
				'description' => 'O unire sau îmbinarea de diferite părţi sau calităţi în care elementele componente sunt individual distincte'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'maint',
			'en' => [
				'name' => 'Maintenance Mode',
				'description' => 'The state of the application'
			],
			'ro' => [
				'name' => 'Modul de Întreţinere',
				'description' => 'Statul a cererii'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'records',
			'en' => [
				'name' => 'Record|Records',
				'description' => 'A specifice instance of some data'
			],
			'ro' => [
				'name' => 'Înregistrare|Înregistrări',
				'description' => 'Un exemplu de specifice unor date'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'values',
			'en' => [
				'name' => 'Value|Values',
				'description' => 'A list of valid values for an option'
			],
			'ro' => [
				'name' => 'Valoarea|Valorile',
				'description' => 'O listă de valori valabile pentru o opţiune'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'options',
			'en' => [
				'name' => 'Option|Options',
				'description' => 'Configurable parameters within the application'
			],
			'ro' => [
				'name' => 'Opţiune|Opţiuni',
				'description' => 'Configurabil parametri in aplicatie'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'translations',
			'en' => [
				'name' => 'Translation|Translations',
				'description' => 'Names, descriptions and phrases in alternate languages'
			],
			'ro' => [
				'name' => 'Traducere|Versuri',
				'description' => 'Nume, descrieri şi fraze în limbi alternative'
			]
		]);
		Code::create([
			'parent_code_id' => $objects->id,
			'code' => 'seconds',
			'en' => [
				'name' => 'Second|Seconds',
				'description' => 'The 60th part of a minute of time'
			],
			'ro' => [
				'name' => 'Secunde|Secunde',
				'description' => 'Partea a 60 de minute de timp'
			]
		]);

		/*
		 * ACTIONS
		 */
		$this->command->info('  Creating actions...');
		$actions = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'actions',
			'en' => [
				'name' => 'Action|Actions',
				'description' => 'Type that defines all of the actions for objects in the application controlled by permissions'
			],
			'ro' => [
				'name' => 'Acţiune|Acţiunile',
				'description' => 'Tipul care defineşte toate acțiunile pentru obiecte în aplicarea controlată de permisiuni'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'display',
			'en' => [
				'name' => 'Display',
				'description' => 'Displaying objects in the application through permissions'
			],
			'ro' => [
				'name' => 'Afişare',
				'description' => 'Afişare obiecte în aplicaţia prin permisiuni'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'list',
			'en' => [
				'name' => 'List',
				'description' => 'List records from a table'
			],
			'ro' => [
				'name' => 'Listă',
				'description' => 'Listă de înregistrări dintr-un tabel'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'add',
			'en' => [
				'name' => 'Add',
				'description' => 'Add records to a table'
			],
			'ro' => [
				'name' => 'Adauga',
				'description' => 'Adăugarea de înregistrări la un tabel'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'add_child',
			'en' => [
				'name' => 'Add Child',
				'description' => 'Add a new child to a particular object, making that object a list'
			],
			'ro' => [
				'name' => 'Adauga Copil',
				'description' => 'Adăugaţi un nou copil la un anumit obiect, ceea ce face ca obiect o listă'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'new',
			'en' => [
				'name' => 'New',
				'description' => 'Create a new instance of a particular object'
			],
			'ro' => [
				'name' => 'Noi',
				'description' => 'Crea un nou exemplu de un anumit obiect'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'edit',
			'en' => [
				'name' => 'Edit',
				'description' => 'Edit records in a table'
			],
			'ro' => [
				'name' => 'Editare',
				'description' => 'Editaţi înregistrări într-un tabel'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'edit_roles',
			'en' => [
				'name' => 'Edit Roles',
				'description' => 'Modify roles for a permission or user'
			],
			'ro' => [
				'name' => 'Editare Roluri',
				'description' => 'Modificaţi roluri pentru o permisiune sau utilizator'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'update',
			'en' => [
				'name' => 'Update',
				'description' => 'Update records in a table'
			],
			'ro' => [
				'name' => 'Actualizare',
				'description' => 'Actualiza înregistrări într-un tabel'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'save',
			'en' => [
				'name' => 'Save',
				'description' => 'Save the current record'
			],
			'ro' => [
				'name' => 'Salva',
				'description' => 'Salva înregistrarea curentă'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'search',
			'en' => [
				'name' => 'Search',
				'description' => 'Scan recrods for a value'
			],
			'ro' => [
				'name' => 'Căutare',
				'description' => 'Recrods pentru o valoare a scanda'
			]
		]);
		Code::create([
			'parent_code_id' => $actions->id,
			'code' => 'cancel',
			'en' => [
				'name' => 'Cancel',
				'description' => 'Cancel the action of a form'
			],
			'ro' => [
				'name' => 'Revocare',
				'description' => 'Anula acţiunea de o formă'
			]
		]);

		/*
		 * FONTS
		 */
		$this->command->info('  Creating fonts...');
		$fonts = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'fonts',
			'en' => [
				'name' => 'Font|Fonts',
				'description' => 'Style of letering for text'
			],
			'ro' => [
				'name' => 'Font|Surse',
				'description' => 'Stil de letering pentru text'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'arial',
			'en' => [
				'name' => 'Arial',
				'description' => 'A sans-serif typeface'
			],
			'ro' => [
				'name' => 'Arial',
				'description' => 'Un font sans-serif'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'century-gothic',
			'en' => [
				'name' => 'Century Gothic',
				'description' => 'A sans-serif typeface in the geometric style'
			],
			'ro' => [
				'name' => 'Lea Gotic',
				'description' => 'Un font sans-serif în stil geometric'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'comic-sans',
			'en' => [
				'name' => 'Comic Sans',
				'description' => 'A sans-serif casual script typeface inspired by comic book lettering'
			],
			'ro' => [
				'name' => 'Benzi Desenate Fără',
				'description' => 'Un font de script-ul casual sans-serif inspirat de carte de benzi desenate litere'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'copperplate',
			'en' => [
				'name' => 'Copperplate',
				'description' => 'A glyphic typeface derived from intaglio printing'
			],
			'ro' => [
				'name' => 'Aramă',
				'description' => 'Un tip de caractere glyphic derivate din imprimare intaglio'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'georgia',
			'en' => [
				'name' => 'Georgia',
				'description' => 'A serif font that appears elegant but legible printed small or on low-resolution screens'
			],
			'ro' => [
				'name' => 'Georgia',
				'description' => 'Un font serif care apare elegant dar lizibile imprimate mici sau pe ecrane cu rezoluţie scăzută'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'impact',
			'en' => [
				'name' => 'Impact',
				'description' => 'A realist sans-serif typeface'
			],
			'ro' => [
				'name' => 'Impactul',
				'description' => 'Un font sans-serif realist'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'lucida',
			'en' => [
				'name' => 'Lucida',
				'description' => 'A serif typeface featuring a thickened serif'
			],
			'ro' => [
				'name' => 'Lucida',
				'description' => 'Un font serif featuring un serif ingrosata'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'palantino',
			'en' => [
				'name' => 'Palantino',
				'description' => 'An old-style serif typeface'
			],
			'ro' => [
				'name' => 'Palantino',
				'description' => 'Un font serif stil vechi'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'tahoma',
			'en' => [
				'name' => 'Tahoma',
				'description' => 'A humanist sans-serif typeface'
			],
			'ro' => [
				'name' => 'Tahoma',
				'description' => 'Un umanist sans-serif font'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'times',
			'en' => [
				'name' => 'Times',
				'description' => 'A serif typeface commissioned by the British newspaper The Times'
			],
			'ro' => [
				'name' => 'Times',
				'description' => 'Un font serif comandat de ziarul britanic The Times'
			]
		]);
		Code::create([
			'parent_code_id' => $fonts->id,
			'code' => 'verdana',
			'en' => [
				'name' => 'Verdana',
				'description' => 'A humanist sans-serif typeface'
			],
			'ro' => [
				'name' => 'Verdana',
				'description' => 'Un umanist sans-serif font'
			]
		]);

		/*
		 * LABEL POSTIONS
		 */
		$this->command->info('  Creating label postions...');
		$label_positions = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'label_positions',
			'en' => [
				'name' => 'Label Positions',
				'description' => 'Position of the label in relation to the field'
			],
			'ro' => [
				'name' => 'Eticheta Poziţii',
				'description' => 'Poziţia etichetei în ceea ce priveşte domeniul'
			]
		]);
		Code::create([
			'parent_code_id' => $label_positions->id,
			'code' => 'left',
			'en' => [
				'name' => 'Left',
				'description' => 'Labels are positioned to the left of the field'
			],
			'ro' => [
				'name' => 'Stânga',
				'description' => 'Etichetele sunt poziţionate în stânga a câmpului'
			]
		]);
		Code::create([
			'parent_code_id' => $label_positions->id,
			'code' => 'top',
			'en' => [
				'name' => 'Top',
				'description' => 'Labels are positioned on top of the field'
			],
			'ro' => [
				'name' => 'Top',
				'description' => 'Etichetele sunt poziţionate deasupra câmpul'
			]
		]);
		Code::create([
			'parent_code_id' => $label_positions->id,
			'code' => 'bottom',
			'en' => [
				'name' => 'Bottom',
				'description' => 'Labels are positioned below the field'
			],
			'ro' => [
				'name' => 'Jos',
				'description' => 'Etichetele sunt poziţionate sub câmpul'
			]
		]);

		/*
		 * YES/NO
		 */
		$this->command->info('  Creating yes no choice...');
		$yes_no = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'yes_no',
			'en' => [
				'name' => 'Choose Yes/No',
				'description' => 'Choice of yes or no'
			],
			'ro' => [
				'name' => 'Alegeţi Da/Nu',
				'description' => 'Alegerea de da sau nu'
			]
		]);
		Code::create([
			'parent_code_id' => $yes_no->id,
			'code' => '1',
			'en' => [
				'name' => 'Yes',
				'description' => 'Affirmative choice'
			],
			'ro' => [
				'name' => 'Da',
				'description' => 'Alegerea afirmativ'
			]
		]);
		Code::create([
			'parent_code_id' => $yes_no->id,
			'code' => '0',
			'en' => [
				'name' => 'No',
				'description' => 'Negative choice'
			],
			'ro' => [
				'name' => 'Nu',
				'description' => 'Alegerea negativ'
			]
		]);

		/*
		 * TRUE/FALSE
		 */
		$this->command->info('  Creating true false choice...');
		$true_false = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'true_false',
			'en' => [
				'name' => 'Choose True/False',
				'description' => 'Choice of true or false'
			],
			'ro' => [
				'name' => 'Alege Adevărat/Fals',
				'description' => 'Alegerea de adevărat sau fals'
			]
		]);
		Code::create([
			'parent_code_id' => $true_false->id,
			'code' => '1',
			'en' => [
				'name' => 'True',
				'description' => 'Affirmative choice'
			],
			'ro' => [
				'name' => 'Adevărat',
				'description' => 'Alegerea afirmativ'
			]
		]);
		Code::create([
			'parent_code_id' => $true_false->id,
			'code' => '0',
			'en' => [
				'name' => 'False',
				'description' => 'Negative choice'
			],
			'ro' => [
				'name' => 'Fals',
				'description' => 'Alegerea negativ'
			]
		]);

		/*
		 * ON/OFF
		 */
		$this->command->info('  Creating on off choice...');
		$on_off = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'on_off',
			'en' => [
				'name' => 'Choose On/Off',
				'description' => 'Choice of on or off'
			],
			'ro' => [
				'name' => 'Selectaţi Pornit/Oprit',
				'description' => 'Alegerea de pe sau de pe'
			]
		]);
		Code::create([
			'parent_code_id' => $on_off->id,
			'code' => '1',
			'en' => [
				'name' => 'On',
				'description' => 'Affirmative choice'
			],
			'ro' => [
				'name' => 'Pe',
				'description' => 'Alegerea afirmativ'
			]
		]);
		Code::create([
			'parent_code_id' => $on_off->id,
			'code' => '0',
			'en' => [
				'name' => 'Off',
				'description' => 'Negative choice'
			],
			'ro' => [
				'name' => 'Oprit',
				'description' => 'Alegerea negativ'
			]
		]);

		/*
		 * STYLE SHEETS
		 */
		$this->command->info('  Creating style sheets...');
		$styles = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'styles',
			'en' => [
				'name' => 'Style Sheets',
				'description' => 'A template consisting of font and layout settings'
			],
			'ro' => [
				'name' => 'Foi de Stil',
				'description' => 'Un şablon format din setările de font şi aspect'
			]
		]);
		Code::create([
			'parent_code_id' => $styles->id,
			'code' => 'w3',
			'en' => [
				'name' => 'W3Schools',
				'description' => 'Buttons are right justtified and form headers are smaller'
			],
			'ro' => [
				'name' => 'W3Schools',
				'description' => 'Butoanele sunt chiar justtified şi forma anteturi sunt mai mici'
			]
		]);
		Code::create([
			'parent_code_id' => $styles->id,
			'code' => 'bootstrap',
			'en' => [
				'name' => 'Bootstrap',
				'description' => 'Buttons are left justtified or centered and form headers are larger'
			],
			'ro' => [
				'name' => 'Bootstrap',
				'description' => 'Butoanele sunt lăsate justtified sau centrat şi anteturile de formă sunt mai mari'
			]
		]);

		/*
		 * COLORS
		 */
		$this->command->info('  Creating colors...');
		$colors = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'colors',
			'en' => [
				'name' => 'Colors',
				'description' => 'Shades and hues defined in a theme'
			],
			'ro' => [
				'name' => 'Culori',
				'description' => 'Nuanţe şi nuanţe definite într-o temă'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'red',
			'en' => [
				'name' => 'Red',
				'description' => 'The color of Rudolph\'s nose'
			],
			'ro' => [
				'name' => 'Roşu',
				'description' => 'Culoare Rudolph pe nas'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'turquoise-island',
			'en' => [
				'name' => 'Turquoise Island',
				'description' => 'Conveying an ethereal mood of beauty in serenity, this turquoise island exudes a visual panorama that amazes anyone that lays eyes on it.'
			],
			'ro' => [
				'name' => 'Insula Turcoaz',
				'description' => 'Transmite o stare de spirit eteric de frumuseţe în linişte, această insulă turcoaz emană o panoramă vizuale care uimeste cineva care pune ochii pe ea.'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'pink',
			'en' => [
				'name' => 'Pink',
				'description' => 'A girly shade of red'
			],
			'ro' => [
				'name' => 'Roz',
				'description' => 'O fetişcană nuanta de rosu'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'purple',
			'en' => [
				'name' => 'Purple',
				'description' => 'Go K-State!!'
			],
			'ro' => [
				'name' => 'Purpuriu',
				'description' => 'Du-te K-State!!'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'deep-purple',
			'en' => [
				'name' => 'Deep Purple',
				'description' => 'Pioneers of heavy metal'
			],
			'ro' => [
				'name' => 'Adânc Purpuriu',
				'description' => 'Pionierii de metale grele'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'indigo',
			'en' => [
				'name' => 'Indigo',
				'description' => 'Girls who like girls'
			],
			'ro' => [
				'name' => 'Indigo',
				'description' => 'Fete carora le place fete'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'blue',
			'en' => [
				'name' => 'Blue',
				'description' => 'The little boy needed the money'
			],
			'ro' => [
				'name' => 'Albastru',
				'description' => 'Baietelul este nevoie de bani'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'light-blue',
			'en' => [
				'name' => 'Light Blue',
				'description' => 'Colourful, fresh, floral-fruity scent'
			],
			'ro' => [
				'name' => 'Albastru Deschis',
				'description' => 'Parfum colorate, proaspat, floral-fructat'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'cyan',
			'en' => [
				'name' => 'Cyan',
				'description' => 'Makers of Myst, Riven and more'
			],
			'ro' => [
				'name' => 'Cyan',
				'description' => 'Factorii de decizie de Myst, Riven şi mai mult'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'teal',
			'en' => [
				'name' => 'Teal',
				'description' => 'World\'s fastest production drone'
			],
			'ro' => [
				'name' => 'Teal',
				'description' => 'Lume cel mai rapid de producţie trântor'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'green',
			'en' => [
				'name' => 'Green',
				'description' => 'A finely-cut grassed area at the end of a golf fairway'
			],
			'ro' => [
				'name' => 'Verde',
				'description' => 'Un fin tăiat iarbă zonă la capătul unui golf fairway'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'light-green',
			'en' => [
				'name' => 'Light Green',
				'description' => 'Go!!'
			],
			'ro' => [
				'name' => 'Verde Deschis',
				'description' => 'Du-te!!'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'lime',
			'en' => [
				'name' => 'Lime',
				'description' => 'Wedge for a Bloody'
			],
			'ro' => [
				'name' => 'Var',
				'description' => 'Parcela pentru un Sângeros'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'khaki',
			'en' => [
				'name' => 'Khaki',
				'description' => 'Before BDUs'
			],
			'ro' => [
				'name' => 'Kaki',
				'description' => 'Înainte de BDUs'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'yellow',
			'en' => [
				'name' => 'Yellow',
				'description' => 'Submarines from Liverpool'
			],
			'ro' => [
				'name' => 'Galben',
				'description' => 'Submarine din Liverpool'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'amber',
			'en' => [
				'name' => 'Amber',
				'description' => 'Holds dinosaur DNA'
			],
			'ro' => [
				'name' => 'Amber',
				'description' => 'Deţine ADN de dinozaur'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'orange',
			'en' => [
				'name' => 'Orange',
				'description' => 'The new black'
			],
			'ro' => [
				'name' => 'Portocaliu',
				'description' => 'Noul negru'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'deep-orange',
			'en' => [
				'name' => 'Deep Orange',
				'description' => 'The illuminated manuscripts of the Middle Ages'
			],
			'ro' => [
				'name' => 'Adânc  Portocaliu',
				'description' => 'Manuscrise iluminate din Evul mediu'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'blue-grey',
			'en' => [
				'name' => 'Blue Grey',
				'description' => 'Anastasia Steele'
			],
			'ro' => [
				'name' => 'Albastru Gri',
				'description' => 'Anastasia Steele'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'brown',
			'en' => [
				'name' => 'Brown',
				'description' => 'Note that messes'
			],
			'ro' => [
				'name' => 'Maro',
				'description' => 'Reţineţi că de oaie'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'grey',
			'en' => [
				'name' => 'Grey',
				'description' => 'Grandma\'s bush'
			],
			'ro' => [
				'name' => 'Gri',
				'description' => 'Bunica lui bush'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'dark-grey',
			'en' => [
				'name' => 'Dark Grey',
				'description' => 'No hue is to love you'
			],
			'ro' => [
				'name' => 'Gri Închis',
				'description' => 'Nici o nuanţă de culoare este de a te iubesc'
			]
		]);
		Code::create([
			'parent_code_id' => $colors->id,
			'code' => 'black',
			'en' => [
				'name' => 'Black',
				'description' => 'The old orange'
			],
			'ro' => [
				'name' => 'Negru',
				'description' => 'Vechi portocaliu'
			]
		]);

		/*
		 * SHADOW SIZES
		 */
		$this->command->info('  Creating shadow sizes...');
		$shadow_sizes = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'shadow_sizes',
			'en' => [
				'name' => 'Shadow Sizes',
				'description' => 'Different sizes of shadow'
			],
			'ro' => [
				'name' => 'Umbra Dimensiuni',
				'description' => 'Diferite dimensiuni de umbra'
			]
		]);
		Code::create([
			'parent_code_id' => $shadow_sizes->id,
			'code' => 'none',
			'en' => [
				'name' => 'None',
				'description' => 'No shadow'
			],
			'ro' => [
				'name' => 'Nici unul',
				'description' => 'Nici o umbră'
			]
		]);
		Code::create([
			'parent_code_id' => $shadow_sizes->id,
			'code' => 'small',
			'en' => [
				'name' => 'Small',
				'description' => 'Slight shadow'
			],
			'ro' => [
				'name' => 'Mici',
				'description' => 'Umbră uşoară'
			]
		]);
		Code::create([
			'parent_code_id' => $shadow_sizes->id,
			'code' => 'large',
			'en' => [
				'name' => 'Large',
				'description' => 'Heavy shadow'
			],
			'ro' => [
				'name' => 'Mare',
				'description' => 'Umbra grele'
			]
		]);

		/*
		 * DELIMITERS
		 */
		$this->command->info('  Creating delimiters...');
		$delimiters = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'delimiters',
			'en' => [
				'name' => 'Delimiters',
				'description' => 'Character to be used to separate fields in output file'
			],
			'ro' => [
				'name' => 'Separatori',
				'description' => 'De caractere pentru a fi folosit pentru a separa câmpurile în fişierul de ieşire'
			]
		]);
		Code::create([
			'parent_code_id' => $delimiters->id,
			'code' => ',',
			'en' => [
				'name' => 'Comma',
				'description' => 'Use comma as delimiter'
			],
			'ro' => [
				'name' => 'Virgula',
				'description' => 'Utilizarea virgula ca delimitator'
			]
		]);
		Code::create([
			'parent_code_id' => $delimiters->id,
			'code' => '\t',
			'en' => [
				'name' => 'Tab',
				'description' => 'Use tab as delimiter'
			],
			'ro' => [
				'name' => 'Fila',
				'description' => 'Utilizarea fila ca separator'
			]
		]);
		Code::create([
			'parent_code_id' => $delimiters->id,
			'code' => ';',
			'en' => [
				'name' => 'Semicolon',
				'description' => 'Use semicolon as delimiter'
			],
			'ro' => [
				'name' => 'Punct și virgulă',
				'description' => 'Utilizarea punct și virgulă ca separator'
			]
		]);
		Code::create([
			'parent_code_id' => $delimiters->id,
			'code' => '|',
			'en' => [
				'name' => 'Pipe',
				'description' => 'Use pipe as delimiter'
			],
			'ro' => [
				'name' => 'Ţeavă',
				'description' => 'Utilizarea țeavă și virgulă ca separator'
			]
		]);

		/*
		 * QUALIFIERS
		 */
		$this->command->info('  Creating qualifiers...');
		$qualifiers = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'qualifiers',
			'en' => [
				'name' => 'Qualifiers',
				'description' => 'Character to be used to enclose fields in output file'
			],
			'ro' => [
				'name' => 'Calificări',
				'description' => 'Caractere pentru a fi utilizate pentru a le încadra câmpuri în fişierul de ieşire'
			]
		]);
		Code::create([
			'parent_code_id' => $qualifiers->id,
			'code' => '"',
			'en' => [
				'name' => 'Double Quote',
				'description' => 'Use double quote as qualifier'
			],
			'ro' => [
				'name' => 'Citat Dublu',
				'description' => 'Utilizarea dublă citat ca calificare'
			]
		]);
		Code::create([
			'parent_code_id' => $qualifiers->id,
			'code' => '\'',
			'en' => [
				'name' => 'Single Quote',
				'description' => 'Use single double quote as qualifier'
			],
			'ro' => [
				'name' => 'Citat Unică',
				'description' => 'Utilizarea citat unică ca calificare'
			]
		]);

		/*
		 * DATE FORMATS
		 */
		$this->command->info('  Creating date formats...');
		$date_formats = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'date_formats',
			'en' => [
				'name' => 'Date Formats',
				'description' => 'Format of the date display'
			],
			'ro' => [
				'name' => 'Formatele de Dată',
				'description' => 'Formatul de afişare dată'
			]
		]);
		Code::create([
			'parent_code_id' => $date_formats->id,
			'code' => 'M j, Y',
			'en' => [
				'name' => 'Jul 6, 1957',
				'description' => 'A short textual representation of a month (three letters), day of the month without leading zeros and a full numeric representation of a year (4 digits)'
			],
			'ro' => [
				'name' => 'Jul 6, 1957',
				'description' => 'O reprezentarea textuală scurt de o lună (trei litere), ziua lunii fără zerouri şi o reprezentare numerică complet de un an (4 cifre)'
			]
		]);
		Code::create([
			'parent_code_id' => $date_formats->id,
			'code' => 'j M Y',
			'en' => [
				'name' => '6 Jul 1957',
				'description' => 'Day of the month without leading zeros, a short textual representation of a month (three letters) and a full numeric representation of a year (4 digits)'
			],
			'ro' => [
				'name' => '6 Jul 1957',
				'description' => 'Ziua lunii fără zerouri, o reprezentare textuale scurt de o lună (trei litere) şi o reprezentare numerică complet de un an (4 cifre)'
			]
		]);
		Code::create([
			'parent_code_id' => $date_formats->id,
			'code' => 'm/d/Y',
			'en' => [
				'name' => '07/06/1957',
				'description' => 'Day of the month, 2 digits with leading zeros, numeric representation of a month, with leading zeros and a full numeric representation of a year, 4 digits, separated by forward slashes'
			],
			'ro' => [
				'name' => '07/06/1957',
				'description' => 'Zi a lunii, 2 cifre cu zerouri, reprezentarea numerică de o lună, cu zerouri şi o reprezentare numerică complet de un an, 4 cifre, separate prin slash-uri înainte'
			]
		]);
		Code::create([
			'parent_code_id' => $date_formats->id,
			'code' => 'd.m.Y',
			'en' => [
				'name' => '06.07.1957',
				'description' => 'Numeric representation of a month, with leading zeros, day of the month, 2 digits with leading zeros and a full numeric representation of a year, 4 digits, separated by periods'
			],
			'ro' => [
				'name' => '06.07.1957',
				'description' => 'Reprezentarea numerică a lunii, cu zerouri, ziua de luna, de 2 cifre cu zerouri şi o reprezentare numerică complet de un an, de 4 cifre, separate prin perioade'
			]
		]);

		/*
		 * TIME FORMATS
		 */
		$this->command->info('  Creating time formats...');
		$time_formats = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'time_formats',
			'en' => [
				'name' => 'Time Formats',
				'description' => 'Format of the time display'
			],
			'ro' => [
				'name' => 'Formate de Timp',
				'description' => 'Formatul de afişare timp'
			]
		]);
		Code::create([
			'parent_code_id' => $time_formats->id,
			'code' => 'g:i a',
			'en' => [
				'name' => 'x:3:00 pm',
				'description' => '12-hour format of an hour without leading zeros, minutes with leading zeros and lowercase ante meridiem and post meridiem'
			],
			'ro' => [
				'name' => 'x:3:00 pm',
				'description' => '12 ore format de oră, fără zerouri, minute cu zerouri şi minuscule ante meridiem şi post meridiem'
			]
		]);
		Code::create([
			'parent_code_id' => $time_formats->id,
			'code' => 'G:i',
			'en' => [
				'name' => 'x:15:00',
				'description' => '24-hour format of an hour without leading zeros and minutes with leading zeros'
			],
			'ro' => [
				'name' => 'x:15:00',
				'description' => '24 ore format de oră, fără zerouri, minute cu zerouri şi minuscule ante meridiem şi post meridiem'
			]
		]);

		/*
		 * TIME ZONES
		 */
		$this->command->info('  Creating time zones...');
		$timezones = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'timezones',
			'en' => [
				'name' => 'Time Zones',
				'description' => 'A divisions of the earth\'s surface in which a standard time is kept'
			],
			'ro' => [
				'name' => 'Fusuri Orare',
				'description' => 'Unei diviziuni de pe suprafaţa Pământului în care se păstrează un timp standard'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'America/Chicago',
			'en' => [
				'name' => 'America/Chicago'
			],
			'ro' => [
				'name' => 'Americii/Chicago'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'America/Denver',
			'en' => [
				'name' => 'America/Denver'
			],
			'ro' => [
				'name' => 'Americii/Denver'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'America/Los_Angeles',
			'en' => [
				'name' => 'America/Los_Angeles'
			],
			'ro' => [
				'name' => 'Americii/Los_Angeles'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'America/New_York',
			'en' => [
				'name' => 'America/New_York'
			],
			'ro' => [
				'name' => 'Americii/New_York'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'America/Halifax',
			'en' => [
				'name' => 'America/Halifax'
			],
			'ro' => [
				'name' => 'Americii/Halifax'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'Europe/Bucharest',
			'en' => [
				'name' => 'Europe/Bucharest'
			],
			'ro' => [
				'name' => 'Europa/Bucuresti'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'Europe/Berlin',
			'en' => [
				'name' => 'Europe/Berlin'
			],
			'ro' => [
				'name' => 'Europa/Berlin'
			]
		]);
		Code::create([
			'parent_code_id' => $timezones->id,
			'code' => 'Europe/London',
			'en' => [
				'name' => 'Europe/London'
			],
			'ro' => [
				'name' => 'Europa/Londra'
			]
		]);

		/*
		 * TIME DURATIONS
		 */
		$this->command->info('  Creating durations...');
		$durations = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'durations',
			'en' => [
				'name' => 'Durations',
				'description' => 'Amount of time a message is displayed'
			],
			'ro' => [
				'name' => 'Duratele',
				'description' => 'Cantitatea de timp este afişat un mesaj'
			]
		]);
		Code::create([
			'parent_code_id' => $durations->id,
			'code' => '2000',
			'en' => [
				'name' => 'Short',
				'description' => '2 second pause before message disappears'
			],
			'ro' => [
				'name' => 'Scurt',
				'description' => '2 a doua pauză înainte de a dispare mesajul'
			]
		]);
		Code::create([
			'parent_code_id' => $durations->id,
			'code' => '4000',
			'en' => [
				'name' => 'Medium',
				'description' => '4 second pause before message disappears'
			],
			'ro' => [
				'name' => 'Mediu',
				'description' => '4 a doua pauză înainte de a dispare mesajul'
			]
		]);
		Code::create([
			'parent_code_id' => $durations->id,
			'code' => '6000',
			'en' => [
				'name' => 'Long',
				'description' => '6 second pause before message disappears'
			],
			'ro' => [
				'name' => 'Lung',
				'description' => '6 a doua pauză înainte de a dispare mesajul'
			]
		]);

		/*
		 * OPTIONS
		 */
		$this->command->info('  Creating options...');
		$options = Code::create([
			'parent_code_id' => $types->id,
			'code' => 'options',
			'en' => [
				'name' => 'Option|Options',
				'description' => 'Configurable parameters within the application'
			],
			'ro' => [
				'name' => 'Opţiune|Opţiuni',
				'description' => 'Configurabil parametri in aplicatie'
			]
		]);
		$localization = Code::create([
			'parent_code_id' => $options->id,
			'code' => 'localization',
			'en' => [
				'name' => 'Localization',
				'description' => 'Settings for geographic locations and cultural preferences'
			],
			'ro' => [
				'name' => 'Localizare',
				'description' => 'Setări pentru locaţii geografice şi culturale preferinţele'
			]
		]);
		Code::create([
			'parent_code_id' => $localization->id,
			'code' => 'locale',
			'values_code_id' => $locales->id,
			'en' => [
				'name' => 'Language',
				'description' => 'Setting for locale or language used in the applicaton display'
			],
			'ro' => [
				'name' => 'Limba',
				'description' => 'Setare limbă utilizată în afişajul necesar sau localizare'
			]
		]);
		$date_time = Code::create([
			'parent_code_id' => $localization->id,
			'code' => 'date_time',
			'en' => [
				'name' => 'Date/Time',
				'description' => 'Date and time settings'
			],
			'ro' => [
				'name' => 'Data/Ora',
				'description' => 'Setãrile pentru datã ºi timp'
			]
		]);
		Code::create([
			'parent_code_id' => $date_time->id,
			'code' => 'date_format',
			'values_code_id' => $date_formats->id,
			'en' => [
				'name' => 'Date Format',
				'description' => 'Format for dates in the application'
			],
			'ro' => [
				'name' => 'Format Dată',
				'description' => 'Formatul pentru datele în aplicaţia'
			]
		]);
		Code::create([
			'parent_code_id' => $date_time->id,
			'code' => 'time_format',
			'values_code_id' => $time_formats->id,
			'en' => [
				'name' => 'Time Format',
				'description' => 'Format for times in the application'
			],
			'ro' => [
				'name' => 'Formatul Orei',
				'description' => 'Format pentru ori în aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $date_time->id,
			'code' => 'timezone',
			'values_code_id' => $timezones->id,
			'en' => [
				'name' => 'Time Zone',
				'description' => 'A divisions of the earth\'s surface in which a standard time is kept'
			],
			'ro' => [
				'name' => 'Fusul Orar',
				'description' => 'Unei diviziuni de pe suprafaţa Pământului în care se păstrează un timp standard'
			]
		]);
		$display = Code::create([
			'parent_code_id' => $options->id,
			'code' => 'display',
			'en' => [
				'name' => 'Display',
				'description' => 'Settings for look and feel of the application'
			],
			'ro' => [
				'name' => 'Visualizzazione',
				'description' => 'Setările pentru aspectul de aplicare'
			]
		]);
		$messages = Code::create([
			'parent_code_id' => $display->id,
			'code' => 'messages',
			'en' => [
				'name' => 'Messages',
				'description' => 'Configure how messages appear in the application'
			],
			'ro' => [
				'name' => 'Mesaje',
				'description' => 'Configuraţi modul în care mesajele apar în cererea de'
			]
		]);
		Code::create([
			'parent_code_id' => $messages->id,
			'code' => 'message_timer',
			'values_code_id' => $durations->id,
			'en' => [
				'name' => 'Duration',
				'description' => 'The amount of time a message is displayed'
			],
			'ro' => [
				'name' => 'Durata',
				'description' => 'Cantitatea de timp este afişat un mesaj'
			]
		]);
		Code::create([
			'parent_code_id' => $messages->id,
			'code' => 'show_popup_messages',
			'values_code_id' => $yes_no->id,
			'en' => [
				'name' => 'Show Popup Messages',
				'description' => 'Allow messages to be displayed as a popup'
			],
			'ro' => [
				'name' => 'Arată Mesajele Pop-up',
				'description' => 'Permite mesaje să fie afişate ca un pop-up'
			]
		]);
		Code::create([
			'parent_code_id' => $messages->id,
			'code' => 'show_popup_errors',
			'values_code_id' => $yes_no->id,
			'en' => [
				'name' => 'Show Popup Errors',
				'description' => 'Allow errors to be displayed as a popup'
			],
			'ro' => [
				'name' => 'Arată Pop-up Erori',
				'description' => 'Permite erori pentru a fi afişate ca un pop-up'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'style',
			'values_code_id' => $styles->id,
			'en' => [
				'name' => 'Style',
				'description' => 'Size, format and position of forms, tables and buttons'
			],
			'ro' => [
				'name' => 'Stil',
				'description' => 'Dimensiunea, formatul şi poziţia de formulare, tabele şi butoane'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'label_position',
			'values_code_id' => $label_positions->id,
			'en' => [
				'name' => 'Label Position',
				'description' => 'Location for the label in relation to the field on forms'
			],
			'ro' => [
				'name' => 'Poziţie Etichetă',
				'description' => 'Locaţie pentru eticheta în ceea ce priveşte câmpul forme'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'round',
			'values_code_id' => $yes_no->id,
			'en' => [
				'name' => 'Rounding',
				'description' => 'Whether or not forms, tables and buttons are rounded'
			],
			'ro' => [
				'name' => 'Rotunjire',
				'description' => 'Dacă sunt sau nu sunt rotunjite formulare, tabele şi butoane'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'show_submenus',
			'values_code_id' => $yes_no->id,
			'en' => [
				'name' => 'Show Submenus',
				'description' => 'Display submenus beneath the main menu'
			],
			'ro' => [
				'name' => 'Arată Submeniuri',
				'description' => 'Afişare submeniuri sub meniul principal'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'font',
			'values_code_id' => $fonts->id,
			'en' => [
				'name' => 'Font',
				'description' => 'Style of characters in the application'
			],
			'ro' => [
				'name' => 'Font',
				'description' => 'Stil de caractere în aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'theme',
			'values_code_id' => $colors->id,
			'en' => [
				'name' => 'Color Theme',
				'description' => 'Variations on a color schema used throughout the application'
			],
			'ro' => [
				'name' => 'Tema de Culoare',
				'description' => 'Variaţiuni pe o schemă de culori folosite în aplicarea'
			]
		]);
		Code::create([
			'parent_code_id' => $display->id,
			'code' => 'shadow',
			'values_code_id' => $shadow_sizes->id,
			'en' => [
				'name' => 'Shadows',
				'description' => 'Simulated shade behind and under forms and tables'
			],
			'ro' => [
				'name' => 'Umbre',
				'description' => 'Umbra simulate în spatele şi sub forme şi tabele'
			]
		]);
		$downloads = Code::create([
			'parent_code_id' => $options->id,
			'code' => 'downloads',
			'en' => [
				'name' => 'Downloads',
				'description' => 'Settings for downloading table data'
			],
			'ro' => [
				'name' => 'Descărcări',
				'description' => 'Setări pentru descărcarea de date de masă'
			]
		]);
		Code::create([
			'parent_code_id' => $downloads->id,
			'code' => 'delimiter',
			'values_code_id' => $delimiters->id,
			'en' => [
				'name' => 'Delimiter',
				'description' => 'Character to be used to separate fields in output file'
			],
			'ro' => [
				'name' => 'Delimitator',
				'description' => 'De caractere pentru a fi folosit pentru a separa câmpurile în fişierul de ieşire'
			]
		]);
		Code::create([
			'parent_code_id' => $downloads->id,
			'code' => 'qualifier',
			'values_code_id' => $qualifiers->id,
			'en' => [
				'name' => 'Qualifier',
				'description' => 'Character to be used to enclose fields in output file'
			],
			'ro' => [
				'name' => 'Calificativ',
				'description' => 'Caractere pentru a fi utilizate pentru a le încadra câmpuri în fişierul de ieşire'
			]
		]);
    }
}
