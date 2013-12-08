<?php

/**
 * This file is part of the MediaWiki extension Persona.
 * Copyright (C) 2012 Tyler Romeo <tylerromeo@gmail.com>
 *
 * Extension:Persona is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Extension:Persona is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Extension:Persona.  If not, see <http://www.gnu.org/licenses/>.
 */

$messages = array();

$messages['en'] = array(
	'persona-login' => 'Login with Persona',
	'persona-desc' => 'Allows users to log in with their Mozilla Persona account.',
	'persona-error-insecure' => 'Logging in over an insecure connection is not allowed.',
	'persona-error-failure' => 'Persona failed to verify your identity.',
	'persona-error-dberror' => 'An internal database error occurred.',
	'persona-error-invaliduser' => 'There is no user on {{SITENAME}} matching your Persona account.',
	'persona-error-multipleusers' => 'There are multiple users with the same email address as your Persona account. Your account must have a unique email address to log in with Persona.',
);

/** Message documentation (Message documentation)
 * @author Beta16
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'persona-login' => 'Label for the Persona login link and button',
	'persona-desc' => '{{desc|name=Persona|url=http://www.mediawiki.org/wiki/Extension:Persona}}',
	'persona-error-insecure' => 'Error message displayed using mw.notify when attempting insecure login with $wgSecureLogin enabled',
	'persona-error-failure' => 'Error message displayed using mw.notify when the Persona API fails to verify',
	'persona-error-dberror' => 'Error message displayed using mw.notify when an internal error occurs',
	'persona-error-invaliduser' => 'Error message displayed using mw.notify for invalid logins',
	'persona-error-multipleusers' => 'Error message displayed using mw.notify when a Persona account matches multiple MediaWiki accounts',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'persona-login' => 'Aniciar sesión con Persona',
	'persona-desc' => 'Permite que los usuarios anicien sesión cola so cuenta de Mozilla Persona',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'persona-login' => 'Увайсьці праз Persona',
	'persona-desc' => 'Дазваляе ўваходзіць праз рахунак у Mozilla Persona.',
);

/** Czech (čeština)
 * @author Mormegil
 */
$messages['cs'] = array(
	'persona-login' => 'Přihlásit pomocí Persona',
	'persona-desc' => 'Umožňuje uživatelům přihlásit se pomocí účtu Mozilla Persona.',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'persona-login' => 'Mit Persona anmelden',
	'persona-desc' => 'Ermöglicht es Benutzern, sich mit ihrem Mozilla-Persona-Konto anzumelden',
	'persona-error-insecure' => 'Das Anmelden über eine unsichere Verbindung ist nicht erlaubt.',
	'persona-error-failure' => 'Persona konnte deine Identität nicht verifizieren.',
	'persona-error-dberror' => 'Es ist ein interner Datenbankfehler aufgetreten.',
	'persona-error-invaliduser' => 'Es gibt auf {{SITENAME}} keinen Benutzer, der deinem Persona-Benutzerkonto entspricht.',
	'persona-error-multipleusers' => 'Es gibt mehrere Benutzer mit der gleichen E-Mail-Adresse deines Persona-Benutzerkontos. Dein Benutzerkonto muss eine eindeutige E-Mail-Adresse haben, damit du dich mit Persona anmelden kannst.',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'persona-login' => 'Pśizjawjenje z Persona',
	'persona-desc' => 'Zmóžnja wužywarjam se z jich kontom Mozilla Persona pśizjawiś.',
);

/** Spanish (español)
 * @author Armando-Martin
 */
$messages['es'] = array(
	'persona-login' => 'Iniciar sesión con Persona',
	'persona-desc' => 'Permite a los usuarios iniciar sesión con su cuenta de Mozilla Persona',
);

/** Finnish (suomi)
 * @author Silvonen
 */
$messages['fi'] = array(
	'persona-login' => 'Kirjaudu Persona-tunnuksella',
);

/** French (français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'persona-login' => 'Connexion avec Persona',
	'persona-desc' => 'Permet aux utilisateurs de se connecter avec leur compte Persona de Mozilla.',
	'persona-error-insecure' => 'Se connecter via une connexion non sécurisée n’est pas autorisé.',
	'persona-error-failure' => 'Persona n’a pas réussi à vérifier votre identité.',
	'persona-error-dberror' => 'Une erreur de base de données interne s’est produite.',
	'persona-error-invaliduser' => 'Il n’y a pas d’utilisateur dans {{SITENAME}} qui corresponde à votre compte Persona.',
	'persona-error-multipleusers' => 'Il y a plusieurs utilisateurs avec la même adresse de courriel que votre compte Persona. Votre compte doit avoir une adresse de courriel unique pour que vous puissiez vous connecter avec Persona.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'persona-login' => 'Rexistro con Persona',
	'persona-desc' => 'Permite aos usuarios rexistrarse coa súa conta de Mozilla Persona',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'persona-login' => 'כניסה באמצעות פרסונה',
	'persona-desc' => 'הוספת אפשרות להיכנס באמצעות חשבון מוזילה פרסונה.',
	'persona-error-insecure' => 'הכניסה דרך חיבור בלתי־מאובטח אסורה.',
	'persona-error-failure' => 'פרסונה לא הצליחה לאמת את הזהות שלך.',
	'persona-error-dberror' => 'אירעה שגאית מסד נתונים פנימית.',
	'persona-error-invaliduser' => 'אין משתמש באתר {{SITENAME}} שמתאים לחשבון הפרסונה שלך.',
	'persona-error-multipleusers' => 'יש משתמשים מרובים עם אותה כתובת דואר אלקטרוני כמו בחשבון הפרסונה שלך. לחשבון שלך צריכה להיות כתובת ייחודית כדי להיכנס באמצעות פרסונה.',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'persona-login' => 'Přizjewjenje z Persona',
	'persona-desc' => 'Zmóžnja wužiwarjam so z jich kontom Mozilla Persona přizjewić.',
);

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'persona-login' => 'Accedi con Persona',
	'persona-desc' => "Permette agli utenti di effettuare l'accesso tramite la loro l'utenza Mozilla Persona.",
	'persona-error-insecure' => "Non è consentito l'accesso tramite una connessione non sicura.",
	'persona-error-failure' => 'Persona non è riuscito a verificare la tua identità.',
	'persona-error-dberror' => 'Si è verificato un errore interno nel database.',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'persona-login' => 'Persona でログイン',
	'persona-desc' => '利用者が自分の Mozilla Persona アカウントでログインできるようにする。',
	'persona-error-insecure' => '安全ではない接続でのログインは許可されていません。',
	'persona-error-dberror' => 'データベース内部エラーが発生しました。',
	'persona-error-invaliduser' => 'あなたのペルソナ アカウントに該当する利用者は{{SITENAME}}にはいません。',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'persona-login' => 'Persona로 로그인',
	'persona-desc' => '사용자가 자신의 Mozilla Persona 계정으로 로그인할 수 있습니다',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'persona-login' => 'Met <i lang="en>Persona</i> enlogge',
	'persona-desc' => 'Löht Metmaacher övver iehre Zohjang zom <i lang="en">Persona</i> vun Mozilla enlogge.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'persona-login' => 'Mat Persona aloggen',
	'persona-desc' => 'Erlaabt et Benotzer mat hirem Mozilla-Persona Benotzerkont anzeloggen',
	'persona-error-insecure' => 'Aloggen iwwer eng net sécher Verbindung ass net erlaabt.',
	'persona-error-failure' => 'Persona konnt Är Identitéit net verifizéieren.',
	'persona-error-dberror' => 'An der Datebank ass een interne Feeler geschitt.',
	'persona-error-invaliduser' => 'Et gëtt kee Benotzer op {{SITENAME}} op deen Äre Persona-Benotzerkont passt.',
);

/** Minangkabau (Baso Minangkabau)
 * @author Iwan Novirion
 */
$messages['min'] = array(
	'persona-login' => 'Login jo Persona',
	'persona-desc' => 'Izinkan pangguno untuak login jo akun Mozilla Persona.',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'persona-login' => 'Најава со Persona',
	'persona-desc' => 'Овозможува корисниците да се најавуваат со нивната сметка на Mozilla Persona.',
	'persona-error-insecure' => 'Не се допушта најава со небезбедна сметка.',
	'persona-error-failure' => 'Персона не успеа да потврди кои сте.',
	'persona-error-dberror' => 'Се појави внатрешна грешка во базата.',
	'persona-error-invaliduser' => 'На {{SITENAME}} нема корисник што одговара на вашата сметка на Персона.',
	'persona-error-multipleusers' => 'Персона има повеќе од еден корисник со е-поштата што ја внесовте. Сметката мора да има единствена и неповторлива адреса за да може да работи.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Wiki13
 */
$messages['nl'] = array(
	'persona-login' => 'Aanmelden met Persona',
	'persona-desc' => 'Maakt het mogelijk om gebruikers aan te laten melden met hun Mozilla Personagebruiker.',
	'persona-error-insecure' => 'Aanmelden via een niet-beveiligde verbinding is niet toegestaan.',
	'persona-error-failure' => 'Persona kon uw identiteit niet verifiëren.',
	'persona-error-dberror' => 'Er is een interne databasefout opgetreden.',
	'persona-error-invaliduser' => 'Er is geen gebruiker op {{SITENAME}} die overeenkomt met uw Personagebruiker.',
	'persona-error-multipleusers' => 'Er zijn meerdere gebruikers met hetzelfde e-mailadres als uw Personagebruiker. Uw gebruiker moet een uniek e-mailadres hebben om aan het kunnen melden met Persona.',
);

/** Polish (polski)
 * @author Chrumps
 */
$messages['pl'] = array(
	'persona-error-insecure' => 'Logowanie przez niezabezpieczone połączenie nie jest dozwolone.',
	'persona-error-dberror' => 'Wystąpił błąd wewnętrzny bazy danych.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'persona-login' => 'Intré ant ël sistema con Persona',
	'persona-desc' => "A përmëtt a j'utent d'intré ant ël sistema con sò cont Mozilla Persona.",
);

/** Portuguese (português)
 * @author Fúlvio
 */
$messages['pt'] = array(
	'persona-login' => 'Entrar com Persona',
	'persona-desc' => 'Permite que os utilizadores iniciem sessão com sua conta do Mozilla Persona.',
);

/** Romansh (rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'persona-login' => "S'annunziar cun Persona",
	'persona-desc' => "Lubescha ad utilisaders da s'annunziar cun lur contos da Mozilla Persona.",
);

/** Romanian (română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'persona-login' => 'Autentificare cu Persona',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'persona-login' => 'Tràse cu Persona',
	'persona-desc' => "Permette a l'utinde de trasè cu 'u cunde lore de Mozilla Persona.",
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'persona-login' => 'Войти, используя Persona',
	'persona-desc' => 'Позволяет пользователям входить с помощью их учётной записи в Mozilla Persona.',
	'persona-error-insecure' => 'Вход через незащищённое соединение не разрешён.',
	'persona-error-failure' => 'Persona не смогла проверить вашу личность.',
	'persona-error-dberror' => 'Произошла внутренняя ошибка базы данных.',
	'persona-error-invaliduser' => 'На {{SITENAME}} нет пользователя с указанной вами учётной записью Persona.',
	'persona-error-multipleusers' => 'Существует несколько пользователей с тем же адресом электронной почты, что и у вашей учётной записи Persona. Ваша учётная запись должна иметь уникальный адрес электронной почты для того, чтоб можно было входить с помощью Persona.',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'persona-login' => 'පුද්ගලතාව සමඟ ප්‍රවිෂ්ට වන්න',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'persona-login' => 'Logga in med Persona',
	'persona-desc' => 'Låter användare att logga in med sitt Mozilla Persona-konto.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Ата
 */
$messages['uk'] = array(
	'persona-login' => 'Увійти, використовуючи Persona',
	'persona-desc' => 'Дозволяє користувачам входити з допомогою облікового запису Mozilla Persona.',
	'persona-error-insecure' => "Вхід через незахищене з'єднання не допускається.",
	'persona-error-failure' => 'Не вдалося перевірити вашу особистість.',
	'persona-error-dberror' => 'Сталася помилка внутрішньої бази даних.',
	'persona-error-invaliduser' => 'Немає користувача на {{SITENAME}} відповідного вашому  обліковому запису Persona.',
	'persona-error-multipleusers' => 'Існує декілька користувачів з однаковою електронною поштою, як у вашому обліковому записі Persona. Ваш обліковий запис повинен мати унікальну адресу електронної пошти для входу через Persona.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'persona-login' => '用 Persona 登录',
	'persona-desc' => '允许用户使用他们的 Mozilla Persona 帐户登录。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Justincheng12345
 */
$messages['zh-hant'] = array(
	'persona-login' => '以Persona登入',
	'persona-desc' => '容許用戶使用Mozilla Persona帳戶登入。',
);
