<?php
/** Adminer - Compact database management
 * @link https://www.adminer.org/
 * @author Jakub Vrana, https://www.vrana.cz/
 * @copyright 2007 Jakub Vrana
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 * @version 4.7.7
 *
 *  Modified by SooR
 *
 */
error_reporting(6135);

// Safety hidden file
function rand_str($length = 32) {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $str = '';
  $alphaLength = strlen($alphabet) - 1;
  for ($i = 0; $i < $length; $i++) {
    $n = rand(0, $alphaLength);

    $str .= $alphabet[$n];
  }
  return $str;
}

if (basename(__FILE__) == 'ocdminer.php') {
  $file = rand_str(40) . '.php';
  $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
  $location = $protocol . $_SERVER['HTTP_HOST'] . str_replace('ocdminer.php', $file, $_SERVER['REQUEST_URI']);

  if (!rename(__FILE__, rtrim(__FILE__, 'ocdminer.php') . $file)) {
    exit('Please, rename this file to <b>' . $file . '</b> and go to ' . $location);
  }

  header('Location: ' . $location, true);

  exit;
}

$expire_timeleft = (time() - filectime(__FILE__));
$lifetime = 60 * 60 * 2;

if ($expire_timeleft > $lifetime) {
  rename(__FILE__, __FILE__ . '.expired');

  exit;
}

$tc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($tc || ini_get("filter.default_flags")) {
  foreach (array(
    '_GET',
    '_POST',
    '_COOKIE',
    '_SERVER'
  ) as $X) {
    $Yg = filter_input_array(constant("INPUT$X") , FILTER_UNSAFE_RAW);
    if ($Yg) $$X = $Yg;
  }
}
if (function_exists("mb_internal_encoding")) mb_internal_encoding("8bit");
function connection() {
  global $e;
  return $e;
}
function adminer() {
  global $b;
  return $b;
}
function version() {
  global $ga;
  return $ga;
}
function idf_unescape($Tc) {
  $qd = substr($Tc, -1);
  return str_replace($qd . $qd, $qd, substr($Tc, 1, -1));
}
function escape_string($X) {
  return substr(q($X) , 1, -1);
}
function number($X) {
  return preg_replace('~[^0-9]+~', '', $X);
}
function number_type() {
  return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}
function remove_slashes($df, $tc = false) {
  if (get_magic_quotes_gpc()) {
    while (list($z, $X) = each($df)) {
      foreach ($X as $jd => $W) {
        unset($df[$z][$jd]);
        if (is_array($W)) {
          $df[$z][stripslashes($jd) ] = $W;
          $df[] = & $df[$z][stripslashes($jd) ];
        }
        else $df[$z][stripslashes($jd) ] = ($tc ? $W : stripslashes($W));
      }
    }
  }
}
function bracket_escape($Tc, $_a = false) {
  static $Lg = array(
    ':' => ':1',
    ']' => ':2',
    '[' => ':3',
    '"' => ':4'
  );
  return strtr($Tc, ($_a ? array_flip($Lg) : $Lg));
}
function min_version($nh, $Cd = "", $f = null) {
  global $e;
  if (!$f) $f = $e;
  $Lf = $f->server_info;
  if ($Cd && preg_match('~([\d.]+)-MariaDB~', $Lf, $C)) {
    $Lf = $C[1];
    $nh = $Cd;
  }
  return (version_compare($Lf, $nh) >= 0);
}
function charset($e) {
  return (min_version("5.5.3", 0, $e) ? "utf8mb4" : "utf8");
}
function script($Uf, $Kg = "\n") {
  return "<script" . nonce() . ">$Uf</script>$Kg";
}
function script_src($dh) {
  return "<script src='" . h($dh) . "'" . nonce() . "></script>\n";
}
function nonce() {
  return ' nonce="' . get_nonce() . '"';
}
function target_blank() {
  return ' target="_blank" rel="noreferrer noopener"';
}
function h($eg) {
  return str_replace("\0", "&#0;", htmlspecialchars($eg, ENT_QUOTES, 'utf-8'));
}
function nl_br($eg) {
  return str_replace("\n", "<br>", $eg);
}
function checkbox($E, $Y, $Na, $nd = "", $ne = "", $Ra = "", $od = "") {
  $K = "<input type='checkbox' name='$E' value='" . h($Y) . "'" . ($Na ? " checked" : "") . ($od ? " aria-labelledby='$od'" : "") . ">" . ($ne ? script("qsl('input').onclick = function () { $ne };", "") : "");
  return ($nd != "" || $Ra ? "<label" . ($Ra ? " class='$Ra'" : "") . ">$K" . h($nd) . "</label>" : $K);
}
function optionlist($re, $Gf = null, $hh = false) {
  $K = "";
  foreach ($re as $jd => $W) {
    $se = array(
      $jd => $W
    );
    if (is_array($W)) {
      $K .= '<optgroup label="' . h($jd) . '">';
      $se = $W;
    }
    foreach ($se as $z => $X) $K .= '<option' . ($hh || is_string($z) ? ' value="' . h($z) . '"' : '') . (($hh || is_string($z) ? (string)$z : $X) === $Gf ? ' selected' : '') . '>' . h($X);
    if (is_array($W)) $K .= '</optgroup>';
  }
  return $K;
}
function html_select($E, $re, $Y = "", $me = true, $od = "") {
  if ($me) return "<select name='" . h($E) . "'" . ($od ? " aria-labelledby='$od'" : "") . ">" . optionlist($re, $Y) . "</select>" . (is_string($me) ? script("qsl('select').onchange = function () { $me };", "") : "");
  $K = "";
  foreach ($re as $z => $X) $K .= "<label><input type='radio' name='" . h($E) . "' value='" . h($z) . "'" . ($z == $Y ? " checked" : "") . ">" . h($X) . "</label>";
  return $K;
}
function select_input($wa, $re, $Y = "", $me = "", $Qe = "") {
  $tg = ($re ? "select" : "input");
  return "<$tg$wa" . ($re ? "><option value=''>$Qe" . optionlist($re, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$Qe'>") . ($me ? script("qsl('$tg').onchange = $me;", "") : "");
}
function confirm($D = "", $Hf = "qsl('input')") {
  return script("$Hf.onclick = function () { return confirm('" . ($D ? js_escape($D) : 'Are you sure?') . "'); };", "");
}
function print_fieldset($u, $vd, $qh = false) {
  echo "<fieldset><legend>", "<a href='#fieldset-$u'>$vd</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", "") , "</legend>", "<div id='fieldset-$u'" . ($qh ? "" : " class='hidden'") . ">\n";
}
function bold($Ga, $Ra = "") {
  return ($Ga ? " class='active $Ra'" : ($Ra ? " class='$Ra'" : ""));
}
function odd($K = ' class="odd"') {
  static $t = 0;
  if (!$K) $t = - 1;
  return ($t++ % 2 ? $K : '');
}
function js_escape($eg) {
  return addcslashes($eg, "\r\n'\\/");
}
function json_row($z, $X = null) {
  static $uc = true;
  if ($uc) echo "{";
  if ($z != "") {
    echo ($uc ? "" : ",") . "\n\t\"" . addcslashes($z, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
    $uc = false;
  }
  else {
    echo "\n}\n";
    $uc = true;
  }
}
function ini_bool($Yc) {
  $X = ini_get($Yc);
  return (preg_match('~^(on|true|yes)$~i', $X) || (int)$X);
}
function sid() {
  static $K;
  if ($K === null) $K = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
  return $K;
}
function set_password($mh, $O, $V, $G) {
  $_SESSION["pwds"][$mh][$O][$V] = ($_COOKIE["adminer_key"] && is_string($G) ? array(
    encrypt_string($G, $_COOKIE["adminer_key"])
  ) : $G);
}
function get_password() {
  $K = get_session("pwds");
  if (is_array($K)) $K = ($_COOKIE["adminer_key"] ? decrypt_string($K[0], $_COOKIE["adminer_key"]) : false);
  return $K;
}
function q($eg) {
  global $e;
  return $e->quote($eg);
}
function get_vals($I, $c = 0) {
  global $e;
  $K = array();
  $J = $e->query($I);
  if (is_object($J)) {
    while ($L = $J->fetch_row()) $K[] = $L[$c];
  }
  return $K;
}
function get_key_vals($I, $f = null, $Of = true) {
  global $e;
  if (!is_object($f)) $f = $e;
  $K = array();
  $J = $f->query($I);
  if (is_object($J)) {
    while ($L = $J->fetch_row()) {
      if ($Of) $K[$L[0]] = $L[1];
      else $K[] = $L[0];
    }
  }
  return $K;
}
function get_rows($I, $f = null, $k = "<p class='error'>") {
  global $e;
  $eb = (is_object($f) ? $f : $e);
  $K = array();
  $J = $eb->query($I);
  if (is_object($J)) {
    while ($L = $J->fetch_assoc()) $K[] = $L;
  }
  elseif (!$J && !is_object($f) && $k && defined("PAGE_HEADER")) echo $k . error() . "\n";
  return $K;
}
function unique_array($L, $w) {
  foreach ($w as $v) {
    if (preg_match("~PRIMARY|UNIQUE~", $v["type"])) {
      $K = array();
      foreach ($v["columns"] as $z) {
        if (!isset($L[$z])) continue 2;
        $K[$z] = $L[$z];
      }
      return $K;
    }
  }
}
function escape_key($z) {
  if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $z, $C)) return $C[1] . idf_escape(idf_unescape($C[2])) . $C[3];
  return idf_escape($z);
}
function where($Z, $m = array()) {
  global $e, $y;
  $K = array();
  foreach ((array)$Z["where"] as $z => $X) {
    $z = bracket_escape($z, 1);
    $c = escape_key($z);
    $K[] = $c . ($y == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($y == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($m[$z], q($X))));
    if ($y == "sql" && preg_match('~char|text~', $m[$z]["type"]) && preg_match("~[^ -@]~", $X)) $K[] = "$c = " . q($X) . " COLLATE " . charset($e) . "_bin";
  }
  foreach ((array)$Z["null"] as $z) $K[] = escape_key($z) . " IS NULL";
  return implode(" AND ", $K);
}
function where_check($X, $m = array()) {
  parse_str($X, $Ma);
  remove_slashes(array(&$Ma
  ));
  return where($Ma, $m);
}
function where_link($t, $c, $Y, $oe = "=") {
  return "&where%5B$t%5D%5Bcol%5D=" . urlencode($c) . "&where%5B$t%5D%5Bop%5D=" . urlencode(($Y !== null ? $oe : "IS NULL")) . "&where%5B$t%5D%5Bval%5D=" . urlencode($Y);
}
function convert_fields($d, $m, $N = array()) {
  $K = "";
  foreach ($d as $z => $X) {
    if ($N && !in_array(idf_escape($z) , $N)) continue;
    $ua = convert_field($m[$z]);
    if ($ua) $K .= ", $ua AS " . idf_escape($z);
  }
  return $K;
}
function cookie($E, $Y, $yd = 2592000) {
  global $ba;
  return header("Set-Cookie: $E=" . urlencode($Y) . ($yd ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $yd) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}
function restart_session() {
  if (!ini_bool("session.use_cookies")) session_start();
}
function stop_session($wc = false) {
  $gh = ini_bool("session.use_cookies");
  if (!$gh || $wc) {
    session_write_close();
    if ($gh && @ini_set("session.use_cookies", false) === false) session_start();
  }
}
function &get_session($z) {
  return $_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}
function set_session($z, $X) {
  $_SESSION[$z][DRIVER][SERVER][$_GET["username"]] = $X;
}
function auth_url($mh, $O, $V, $i = null) {
  global $Ib;
  preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($Ib)) . "|username|" . ($i !== null ? "db|" : "") . session_name()) , $C);
  return "$C[1]?" . (sid() ? SID . "&" : "") . ($mh != "server" || $O != "" ? urlencode($mh) . "=" . urlencode($O) . "&" : "") . "username=" . urlencode($V) . ($i != "" ? "&db=" . urlencode($i) : "") . ($C[2] ? "&$C[2]" : "");
}
function is_ajax() {
  return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}
function redirect($B, $D = null) {
  if ($D !== null) {
    restart_session();
    $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B !== null ? $B : $_SERVER["REQUEST_URI"])) ][] = $D;
  }
  if ($B !== null) {
    if ($B == "") $B = ".";
    header("Location: $B");
    exit;
  }
}
function query_redirect($I, $B, $D, $lf = true, $gc = true, $nc = false, $_g = "") {
  global $e, $k, $b;
  if ($gc) {
    $ag = microtime(true);
    $nc = !$e->query($I);
    $_g = format_time($ag);
  }
  $Wf = "";
  if ($I) $Wf = $b->messageQuery($I, $_g, $nc);
  if ($nc) {
    $k = error() . $Wf . script("messagesPrint();");
    return false;
  }
  if ($lf) redirect($B, $D . $Wf);
  return true;
}
function queries($I) {
  global $e;
  static $gf = array();
  static $ag;
  if (!$ag) $ag = microtime(true);
  if ($I === null) return array(
    implode("\n", $gf) ,
    format_time($ag)
  );
  $gf[] = (preg_match('~;$~', $I) ? "DELIMITER ;;\n$I;\nDELIMITER " : $I) . ";";
  return $e->query($I);
}
function apply_queries($I, $S, $cc = 'table') {
  foreach ($S as $Q) {
    if (!queries("$I " . $cc($Q))) return false;
  }
  return true;
}
function queries_redirect($B, $D, $lf) {
  list($gf, $_g) = queries(null);
  return query_redirect($gf, $B, $D, $lf, false, !$lf, $_g);
}
function format_time($ag) {
  return sprintf('%.3f s', max(0, microtime(true) - $ag));
}
function relative_uri() {
  return preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]);
}
function remove_from_uri($Fe = "") {
  return substr(preg_replace("~(?<=[?&])($Fe" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&") , 0, -1);
}
function pagination($F, $pb) {
  return " " . ($F == $pb ? $F + 1 : '<a href="' . h(remove_from_uri("page") . ($F ? "&page=$F" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($F + 1) . "</a>");
}
function get_file($z, $xb = false) {
  $rc = $_FILES[$z];
  if (!$rc) return null;
  foreach ($rc as $z => $X) $rc[$z] = (array)$X;
  $K = '';
  foreach ($rc["error"] as $z => $k) {
    if ($k) return $k;
    $E = $rc["name"][$z];
    $Hg = $rc["tmp_name"][$z];
    $fb = file_get_contents($xb && preg_match('~\.gz$~', $E) ? "compress.zlib://$Hg" : $Hg);
    if ($xb) {
      $ag = substr($fb, 0, 3);
      if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $ag, $rf)) $fb = iconv("utf-16", "utf-8", $fb);
      elseif ($ag == "\xEF\xBB\xBF") $fb = substr($fb, 3);
      $K .= $fb . "\n\n";
    }
    else $K .= $fb;
  }
  return $K;
}
function upload_error($k) {
  $Id = ($k == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
  return ($k ? 'Unable to upload a file.' . ($Id ? " " . sprintf('Maximum allowed file size is %sB.', $Id) : "") : 'File does not exist.');
}
function repeat_pattern($Oe, $wd) {
  return str_repeat("$Oe{0,65535}", $wd / 65535) . "$Oe{0," . ($wd % 65535) . "}";
}
function is_utf8($X) {
  return (preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}
function shorten_utf8($eg, $wd = 80, $ig = "") {
  if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $wd) . ")($)?)u", $eg, $C)) preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $wd) . ")($)?)", $eg, $C);
  return h($C[1]) . $ig . (isset($C[2]) ? "" : "<i>…</i>");
}
function format_number($X) {
  return strtr(number_format($X, 0, ".", ',') , preg_split('~~u', '0123456789', -1, PREG_SPLIT_NO_EMPTY));
}
function friendly_url($X) {
  return preg_replace('~[^a-z0-9_]~i', '-', $X);
}
function hidden_fields($df, $Uc = array()) {
  $K = false;
  while (list($z, $X) = each($df)) {
    if (!in_array($z, $Uc)) {
      if (is_array($X)) {
        foreach ($X as $jd => $W) $df[$z . "[$jd]"] = $W;
      }
      else {
        $K = true;
        echo '<input type="hidden" name="' . h($z) . '" value="' . h($X) . '">';
      }
    }
  }
  return $K;
}
function hidden_fields_get() {
  echo (sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : '') , (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : "") , '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}
function table_status1($Q, $oc = false) {
  $K = table_status($Q, $oc);
  return ($K ? $K : array(
    "Name" => $Q
  ));
}
function column_foreign_keys($Q) {
  global $b;
  $K = array();
  foreach ($b->foreignKeys($Q) as $n) {
    foreach ($n["source"] as $X) $K[$X][] = $n;
  }
  return $K;
}
function enum_input($U, $wa, $l, $Y, $Wb = null) {
  global $b;
  preg_match_all("~'((?:[^']|'')*)'~", $l["length"], $Dd);
  $K = ($Wb !== null ? "<label><input type='$U'$wa value='$Wb'" . ((is_array($Y) ? in_array($Wb, $Y) : $Y === 0) ? " checked" : "") . "><i>" . 'empty' . "</i></label>" : "");
  foreach ($Dd[1] as $t => $X) {
    $X = stripcslashes(str_replace("''", "'", $X));
    $Na = (is_int($Y) ? $Y == $t + 1 : (is_array($Y) ? in_array($t + 1, $Y) : $Y === $X));
    $K .= " <label><input type='$U'$wa value='" . ($t + 1) . "'" . ($Na ? ' checked' : '') . '>' . h($b->editVal($X, $l)) . '</label>';
  }
  return $K;
}
function input($l, $Y, $q) {
  global $Tg, $b, $y;
  $E = h(bracket_escape($l["field"]));
  echo "<td class='function'>";
  if (is_array($Y) && !$q) {
    $ta = array(
      $Y
    );
    if (version_compare(PHP_VERSION, 5.4) >= 0) $ta[] = JSON_PRETTY_PRINT;
    $Y = call_user_func_array('json_encode', $ta);
    $q = "json";
  }
  $tf = ($y == "mssql" && $l["auto_increment"]);
  if ($tf && !$_POST["save"]) $q = null;
  $Cc = (isset($_GET["select"]) || $tf ? array(
    "orig" => 'original'
  ) : array()) + $b->editFunctions($l);
  $wa = " name='fields[$E]'";
  if ($l["type"] == "enum") echo h($Cc[""]) . "<td>" . $b->editInput($_GET["edit"], $l, $wa, $Y);
  else {
    $Kc = (in_array($q, $Cc) || isset($Cc[$q]));
    echo (count($Cc) > 1 ? "<select name='function[$E]'>" . optionlist($Cc, $q === null || $Kc ? $q : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($Cc))) . '<td>';
    $ad = $b->editInput($_GET["edit"], $l, $wa, $Y);
    if ($ad != "") echo $ad;
    elseif (preg_match('~bool~', $l["type"])) echo "<input type='hidden'$wa value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$wa value='1'>";
    elseif ($l["type"] == "set") {
      preg_match_all("~'((?:[^']|'')*)'~", $l["length"], $Dd);
      foreach ($Dd[1] as $t => $X) {
        $X = stripcslashes(str_replace("''", "'", $X));
        $Na = (is_int($Y) ? ($Y >> $t) & 1 : in_array($X, explode(",", $Y) , true));
        echo " <label><input type='checkbox' name='fields[$E][$t]' value='" . (1 << $t) . "'" . ($Na ? ' checked' : '') . ">" . h($b->editVal($X, $l)) . '</label>';
      }
    }
    elseif (preg_match('~blob|bytea|raw|file~', $l["type"]) && ini_bool("file_uploads")) echo "<input type='file' name='fields-$E'>";
    elseif (($yg = preg_match('~text|lob|memo~i', $l["type"])) || preg_match("~\n~", $Y)) {
      if ($yg && $y != "sqlite") $wa .= " cols='50' rows='12'";
      else {
        $M = min(12, substr_count($Y, "\n") + 1);
        $wa .= " cols='30' rows='$M'" . ($M == 1 ? " style='height: 1.2em;'" : "");
      }
      echo "<textarea$wa>" . h($Y) . '</textarea>';
    }
    elseif ($q == "json" || preg_match('~^jsonb?$~', $l["type"])) echo "<textarea$wa cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
    else {
      $Kd = (!preg_match('~int~', $l["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $l["length"], $C) ? ((preg_match("~binary~", $l["type"]) ? 2 : 1) * $C[1] + ($C[3] ? 1 : 0) + ($C[2] && !$l["unsigned"] ? 1 : 0)) : ($Tg[$l["type"]] ? $Tg[$l["type"]] + ($l["unsigned"] ? 0 : 1) : 0));
      if ($y == 'sql' && min_version(5.6) && preg_match('~time~', $l["type"])) $Kd += 7;
      echo "<input" . ((!$Kc || $q === "") && preg_match('~(?<!o)int(?!er)~', $l["type"]) && !preg_match('~\[\]~', $l["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Kd ? " data-maxlength='$Kd'" : "") . (preg_match('~char|binary~', $l["type"]) && $Kd > 20 ? " size='40'" : "") . "$wa>";
    }
    echo $b->editHint($_GET["edit"], $l, $Y);
    $uc = 0;
    foreach ($Cc as $z => $X) {
      if ($z === "" || !$X) break;
      $uc++;
    }
    if ($uc) echo script("mixin(qsl('td'), {onchange: partial(skipOriginal, $uc), oninput: function () { this.onchange(); }});");
  }
}
function process_input($l) {
  global $b, $j;
  $Tc = bracket_escape($l["field"]);
  $q = $_POST["function"][$Tc];
  $Y = $_POST["fields"][$Tc];
  if ($l["type"] == "enum") {
    if ($Y == - 1) return false;
    if ($Y == "") return "NULL";
    return +$Y;
  }
  if ($l["auto_increment"] && $Y == "") return null;
  if ($q == "orig") return (preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? idf_escape($l["field"]) : false);
  if ($q == "NULL") return "NULL";
  if ($l["type"] == "set") return array_sum((array)$Y);
  if ($q == "json") {
    $q = "";
    $Y = json_decode($Y, true);
    if (!is_array($Y)) return false;
    return $Y;
  }
  if (preg_match('~blob|bytea|raw|file~', $l["type"]) && ini_bool("file_uploads")) {
    $rc = get_file("fields-$Tc");
    if (!is_string($rc)) return false;
    return $j->quoteBinary($rc);
  }
  return $b->processInput($l, $Y, $q);
}
function fields_from_edit() {
  global $j;
  $K = array();
  foreach ((array)$_POST["field_keys"] as $z => $X) {
    if ($X != "") {
      $X = bracket_escape($X);
      $_POST["function"][$X] = $_POST["field_funs"][$z];
      $_POST["fields"][$X] = $_POST["field_vals"][$z];
    }
  }
  foreach ((array)$_POST["fields"] as $z => $X) {
    $E = bracket_escape($z, 1);
    $K[$E] = array(
      "field" => $E,
      "privileges" => array(
        "insert" => 1,
        "update" => 1
      ),
      "null" => 1,
      "auto_increment" => ($z == $j->primary) ,
    );
  }
  return $K;
}
function search_tables() {
  global $b, $e;
  $_GET["where"][0]["val"] = $_POST["query"];
  $Jf = "<ul>\n";
  foreach (table_status('', true) as $Q => $R) {
    $E = $b->tableName($R);
    if (isset($R["Engine"]) && $E != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
      $J = $e->query("SELECT" . limit("1 FROM " . table($Q) , " WHERE " . implode(" AND ", $b->selectSearchProcess(fields($Q) , array())) , 1));
      if (!$J || $J->fetch_row()) {
        $Ze = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$E</a>";
        echo "$Jf<li>" . ($J ? $Ze : "<p class='error'>$Ze: " . error()) . "\n";
        $Jf = "";
      }
    }
  }
  echo ($Jf ? "<p class='message'>" . 'No tables.' : "</ul>") . "\n";
}
function dump_headers($Sc, $Rd = false) {
  global $b;
  $K = $b->dumpHeaders($Sc, $Rd);
  $Ce = $_POST["output"];
  if ($Ce != "text") header("Content-Disposition: attachment; filename=" . $b->dumpFilename($Sc) . ".$K" . ($Ce != "file" && !preg_match('~[^0-9a-z]~', $Ce) ? ".$Ce" : ""));
  session_write_close();
  ob_flush();
  flush();
  return $K;
}
function dump_csv($L) {
  foreach ($L as $z => $X) {
    if (preg_match("~[\"\n,;\t]~", $X) || $X === "") $L[$z] = '"' . str_replace('"', '""', $X) . '"';
  }
  echo implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")) , $L) . "\r\n";
}
function apply_sql_function($q, $c) {
  return ($q ? ($q == "unixepoch" ? "DATETIME($c, '$q')" : ($q == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$q(")) . "$c)") : $c);
}
function get_temp_dir() {
  $K = ini_get("upload_tmp_dir");
  if (!$K) {
    if (function_exists('sys_get_temp_dir')) $K = sys_get_temp_dir();
    else {
      $sc = @tempnam("", "");
      if (!$sc) return false;
      $K = dirname($sc);
      unlink($sc);
    }
  }
  return $K;
}
function file_open_lock($sc) {
  $p = @fopen($sc, "r+");
  if (!$p) {
    $p = @fopen($sc, "w");
    if (!$p) return;
    chmod($sc, 0660);
  }
  flock($p, LOCK_EX);
  return $p;
}
function file_write_unlock($p, $rb) {
  rewind($p);
  fwrite($p, $rb);
  ftruncate($p, strlen($rb));
  flock($p, LOCK_UN);
  fclose($p);
}
function password_file($g) {
  $sc = get_temp_dir() . "/adminer.key";
  $K = @file_get_contents($sc);
  if ($K || !$g) return $K;
  $p = @fopen($sc, "w");
  if ($p) {
    chmod($sc, 0660);
    $K = rand_string();
    fwrite($p, $K);
    fclose($p);
  }
  return $K;
}
function rand_string() {
  return md5(uniqid(mt_rand() , true));
}
function select_value($X, $A, $l, $zg) {
  global $b;
  if (is_array($X)) {
    $K = "";
    foreach ($X as $jd => $W) $K .= "<tr>" . ($X != array_values($X) ? "<th>" . h($jd) : "") . "<td>" . select_value($W, $A, $l, $zg);
    return "<table cellspacing='0'>$K</table>";
  }
  if (!$A) $A = $b->selectLink($X, $l);
  if ($A === null) {
    if (is_mail($X)) $A = "mailto:$X";
    if (is_url($X)) $A = $X;
  }
  $K = $b->editVal($X, $l);
  if ($K !== null) {
    if (!is_utf8($K)) $K = "\0";
    elseif ($zg != "" && is_shortable($l)) $K = shorten_utf8($K, max(0, +$zg));
    else $K = h($K);
  }
  return $b->selectVal($K, $A, $l, $X);
}
function is_mail($Tb) {
  $va = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
  $Hb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
  $Oe = "$va+(\\.$va+)*@($Hb?\\.)+$Hb";
  return is_string($Tb) && preg_match("(^$Oe(,\\s*$Oe)*\$)i", $Tb);
}
function is_url($eg) {
  $Hb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
  return preg_match("~^(https?)://($Hb?\\.)+$Hb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $eg);
}
function is_shortable($l) {
  return preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $l["type"]);
}
function count_rows($Q, $Z, $gd, $s) {
  global $y;
  $I = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
  return ($gd && ($y == "sql" || count($s) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $s) . ")$I" : "SELECT COUNT(*)" . ($gd ? " FROM (SELECT 1$I GROUP BY " . implode(", ", $s) . ") x" : $I));
}
function slow_query($I) {
  global $b, $T, $j;
  $i = $b->database();
  $Ag = $b->queryTimeout();
  $Sf = $j->slowQuery($I, $Ag);
  if (!$Sf && support("kill") && is_object($f = connect()) && ($i == "" || $f->select_db($i))) {
    $ld = $f->result(connection_id());
    echo '<script', nonce() , '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME) , 'script=kill\', function () {
	}, \'kill=', $ld, '&token=', $T, '\');
}, ', 1000 * $Ag, ');
</script>';
  }
  else $f = null;
  ob_flush();
  flush();
  $K = @get_key_vals(($Sf ? $Sf : $I) , $f, false);
  if ($f) {
    echo script("clearTimeout(timeout);");
    ob_flush();
    flush();
  }
  return $K;
}
function get_token() {
  $jf = rand(1, 1e6);
  return ($jf ^ $_SESSION["token"]) . ":$jf";
}
function verify_token() {
  list($T, $jf) = explode(":", $_POST["token"]);
  return ($jf ^ $_SESSION["token"]) == $T;
}
function lzw_decompress($Da) {
  $Eb = 256;
  $Ea = 8;
  $Ta = array();
  $uf = 0;
  $vf = 0;
  for ($t = 0;$t < strlen($Da);$t++) {
    $uf = ($uf << 8) + ord($Da[$t]);
    $vf += 8;
    if ($vf >= $Ea) {
      $vf -= $Ea;
      $Ta[] = $uf >> $vf;
      $uf &= (1 << $vf) - 1;
      $Eb++;
      if ($Eb >> $Ea) $Ea++;
    }
  }
  $Db = range("\0", "\xFF");
  $K = "";
  foreach ($Ta as $t => $Sa) {
    $Sb = $Db[$Sa];
    if (!isset($Sb)) $Sb = $wh . $wh[0];
    $K .= $Sb;
    if ($t) $Db[] = $wh . $Sb[0];
    $wh = $Sb;
  }
  return $K;
}
function on_help($Za, $Qf = 0) {
  return script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Qf) }, onmouseout: helpMouseout});", "");
}
function edit_form($a, $m, $L, $bh) {
  global $b, $y, $T, $k;
  $ng = $b->tableName(table_status1($a, true));
  page_header(($bh ? 'Edit' : 'Insert') , $k, array(
    "select" => array(
      $a,
      $ng
    )
  ) , $ng);
  if ($L === false) echo "<p class='error'>" . 'No rows.' . "\n";
  echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
  if (!$m) echo "<p class='error'>" . 'You have no privileges to update this table.' . "\n";
  else {
    echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
    foreach ($m as $E => $l) {
      echo "<tr><th>" . $b->fieldName($l);
      $yb = $_GET["set"][bracket_escape($E) ];
      if ($yb === null) {
        $yb = $l["default"];
        if ($l["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $yb, $rf)) $yb = $rf[1];
      }
      $Y = ($L !== null ? ($L[$E] != "" && $y == "sql" && preg_match("~enum|set~", $l["type"]) ? (is_array($L[$E]) ? array_sum($L[$E]) : +$L[$E]) : $L[$E]) : (!$bh && $l["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $yb)));
      if (!$_POST["save"] && is_string($Y)) $Y = $b->editVal($Y, $l);
      $q = ($_POST["save"] ? (string)$_POST["function"][$E] : ($bh && preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
      if (preg_match("~time~", $l["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
        $Y = "";
        $q = "now";
      }
      input($l, $Y, $q);
      echo "\n";
    }
    if (!support("table")) echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $b->editFunctions(array(
      "null" => isset($_GET["select"])
    ))) . "<td><input name='field_vals[]'>" . "\n";
    echo "</table>\n";
  }
  echo "<p>\n";
  if ($m) {
    echo "<input type='submit' value='" . 'Save' . "'>\n";
    if (!isset($_GET["select"])) {
      echo "<input type='submit' name='insert' value='" . ($bh ? 'Save and continue edit' : 'Save and insert next') . "' title='Ctrl+Shift+Enter'>\n", ($bh ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . 'Saving' . "…', this); };") : "");
    }
  }
  echo ($bh ? "<input type='submit' name='delete' value='" . 'Delete' . "'>" . confirm() . "\n" : ($_POST || !$m ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
  if (isset($_GET["select"])) hidden_fields(array(
    "check" => (array)$_POST["check"],
    "clone" => $_POST["clone"],
    "all" => $_POST["all"]
  ));
  echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]) , '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $T, '">
</form>';
}
if (isset($_GET["file"])) {
  if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
    header("HTTP/1.1 304 Not Modified");
    exit;
  }
  header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: immutable");
  if ($_GET["file"] == "favicon.ico") {
    header("Content-Type: image/x-icon");
    echo lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
  } elseif ($_GET["file"] == "default.css") {
    header("Content-Type: text/css; charset=utf-8");
    echo "
*,*::before,*::after{box-sizing:border-box;}
html{font-family:sans-serif;  line-height:1.15;  -webkit-text-size-adjust:100%;  -webkit-tap-highlight-color:rgba(0,0,0,0);}
article, aside, figcaption, figure, footer, header, hgroup, main, nav, section{display:block;}
body{margin:0;  font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';  font-size:1rem;  font-weight:400;  line-height:1.5;  color:#212529;  text-align:left;  background-color:#fff;}
[tabindex='-1']:focus:not(:focus-visible){outline:0 !important;}
hr{box-sizing:content-box;  height:0;  overflow:visible;}
h1, h2, h3, h4, h5, h6{margin-top:0;  margin-bottom:0.5rem;}
p{margin-top:0;  margin-bottom:1rem;}
abbr[title],abbr[data-original-title]{text-decoration:underline;  -webkit-text-decoration:underline dotted;  text-decoration:underline dotted;  cursor:help;  border-bottom:0;  -webkit-text-decoration-skip-ink:none;  text-decoration-skip-ink:none;}
ol,ul,dl{margin-top:0;  margin-bottom:1rem;}
ol ol,ul ul,ol ul,ul ol{margin-bottom:0;}
dt{font-weight:700;}
dd{margin-bottom:.5rem;  margin-left:0;}
b,strong{font-weight:bolder;}
small{font-size:80%;}
sub,sup{position:relative;  font-size:75%;  line-height:0;  vertical-align:baseline;}
sub{bottom:-.25em;}
sup{top:-.5em;}
a{color:#007bff;  text-decoration:none;  background-color:transparent;}
a:hover{color:#0056b3;  text-decoration:underline;}
a:not([href]){color:inherit;  text-decoration:none;}
a:not([href]):hover{color:inherit;  text-decoration:none;}
pre,code,kbd,samp, textarea{font-family:SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;  font-size:1em;}
pre{margin-top:0;  margin-bottom:1rem;  overflow:auto;}
img{vertical-align:middle;  border-style:none;}
svg{overflow:hidden;  vertical-align:middle;}
table{border-collapse:collapse;}
caption{padding-top:0.75rem;  padding-bottom:0.75rem;  color:#6c757d;  text-align:left;  caption-side:bottom;}
th{text-align:inherit;}
label{display:inline-block;  margin-bottom:0.5rem;}
button{border-radius:0;}
button:focus{outline:1px dotted;  outline:5px auto -webkit-focus-ring-color;}
input,button,select,optgroup,textarea{margin:0;  font-family:inherit;  font-size:inherit;  line-height:inherit;}
button,input{overflow:visible;}
button,select{text-transform:none;}
select{word-wrap:normal;}
button,[type='button'],[type='reset'],[type='submit']{-webkit-appearance:button;}
button:not(:disabled),[type='button']:not(:disabled),[type='reset']:not(:disabled),[type='submit']:not(:disabled){cursor:pointer;}
button::-moz-focus-inner,[type='button']::-moz-focus-inner,[type='reset']::-moz-focus-inner,[type='submit']::-moz-focus-inner{padding:0;  border-style:none;}
input[type='radio'],input[type='checkbox']{box-sizing:border-box;  padding:0;}
input[type='date'],input[type='time'],input[type='datetime-local'],input[type='month']{-webkit-appearance:listbox;}
textarea{overflow:auto; resize:vertical; width:100%;}
fieldset{min-width:0;  padding:0;  margin:0;  border:0;}
legend{display:block;  width:100%;  max-width:100%;  padding:0;  margin-bottom:.5rem;  font-size:1.5rem;  line-height:inherit;  color:inherit;  white-space:normal;}
progress{vertical-align:baseline;}
[type='number']::-webkit-inner-spin-button,[type='number']::-webkit-outer-spin-button{height:auto;}
[type='search']{outline-offset:-2px;  -webkit-appearance:none;}
[type='search']::-webkit-search-decoration{-webkit-appearance:none;}
::-webkit-file-upload-button{font:inherit;  -webkit-appearance:button;}
[hidden]{display:none !important;}
body{color:#000;background:#fff;margin:0;}
a,a:visited{color:#366fc5;text-decoration:none;}
a:link:hover, a:visited:hover{color:red;text-decoration:underline;}
a.text:hover{text-decoration:none;}
a.jush-help:hover{color:inherit;}
i{font-style:normal;font-family:monospace;}
h1{font-size:150%;  margin:0;  padding:.8em 1em;  border-bottom:1px solid #454f58;  font-weight:normal;  color:#6c7c8a;  background:#2b3238;}
h2{font-size:175%;  margin:0 -20px 20px -20px;  padding:.8em 1em;  color:#000;  font-weight:normal;  background:#e0edf7;}
h3{font-weight:normal;  font-size:1.25rem;  margin:1em 0 0;  background-color:#9eb2c1;  padding:8px 12px;  color:#fff;}
form{margin:0;}
td table{width:100%;margin:0;}
table{margin:1em 20px 0 0;border-collapse:collapse;width:100%;}
td, th{border:1px solid #e0e0e0;padding:.2em .3em;}
th{text-align:left;}
thead td, thead th{background:#ddf;  padding:10px;  border-color:#cacaea;}
fieldset{display:inline;vertical-align:top;padding:.5em .8em;margin:.8em .5em 0 0;border:1px solid #999;}
p{margin:.8em 20px 0 0;}
img{vertical-align:middle;border:0;}
td img{max-width:200px;max-height:200px;}
code{background:#ecf6fe;  padding:5px 10px;  font-size:1.4rem;}
tbody tr:hover td, tbody tr:hover th{background:#eee;}
pre{background-color:#fff;}
input{}
input.default{box-shadow:1px 1px 1px #777;}
input.required{box-shadow:1px 1px 1px red;}
input.maxlength{box-shadow:1px 1px 1px red;}
input.wayoff{left:-1000px;position:absolute;}
select,input:not([type='checkbox']):not([type='radio']){padding:4px;  border-radius:4px;  border:1px solid #bfbfbf;  height:34px;}
textarea{padding:4px;  border-radius:4px;  border:1px solid #bfbfbf;}
label+label{margin-left:15px;}
label input{margin-right:5px;}
table input:not([type='checkbox']),table input:not([type='radio']),table input:not([type='image']),table select{
/*width:calc(100% - 10px);*/
}
.block{display:block;}
.version{color:#6d767d; font-size:60%;}
.js .hidden, .nojs .jsonly{display:none;}
.js .column{position:absolute;background:#ddf;padding:.27em 1ex .3em 0;margin-top:-.27em;}
.nowrap td, .nowrap th, td.nowrap, p.nowrap{white-space:pre;}
.wrap td{white-space:normal;}
.error{color:red;background:#fee;}
.error b{background:#fff;font-weight:normal;}
.message{color:green;background:#efe;}
.message table{color:#000;background:#fff;}
.error, .message{padding:.5em .8em;margin:1em 20px 0 0;}
.char{color:#007F00;}
.date{color:#7F007F;}
.enum{color:#007F7F;}
.binary{color:red;}
.odd td{}
.js .checkable .checked td, .js .checkable .checked th{background:#ddf;}
.time{color:#9c9c9c;}
.function{text-align:right;}
.number{text-align:right;}
.datetime{text-align:right;}
.type{width:15ex;width:auto\9;}
.options select{width:20ex;width:auto\9;}
.view{font-style:italic;}
.active{font-weight:bold;}
.sqlarea{width:98%;}
.icon{width:28px!important;height:28px!important;background-color:#414e75;vertical-align:middle;}
.icon:hover{background-color:#f70000;}
.size{width:10ex;}
.help{cursor:help;}
.footer{position:sticky;bottom:0;margin-right:-20px;border-top:20px solid rgba(255,255,255,.7);border-image:linear-gradient(rgba(255,255,255,.2), #fff) 100% 0;}
.footer > div{background:#fff;padding:0 0 .5em;}
.footer fieldset{margin-top:0;}
.links a{white-space:nowrap;margin-right:20px;}
#menu .links a{color:#b0daff; font-size:25px;}
#menu .links a:hover{text-decoration:none;}
.logout{margin-top:.5em;  position:absolute;  top:-4px;  right:14px;}
.loadmore{margin-left:1ex;}
#menu{background-color:#373f46; position:fixed; padding:0 0 191px 0; top:0; bottom:0;left:0; width:350px;}
#menu p, #logins, #tables{color:white;padding:.8em 1em;margin:0;border-bottom:1px solid #454f58;}
#logins li, #tables li{list-style:none;}
#tables{overflow:auto; height:100%;}
#dbs{overflow:hidden;}
#logins, #tables{white-space:nowrap;overflow:auto;}
#logins a, #tables a, #tables span{color:#c7c7c7;}
#tables a.active{color:white;}
#content{margin:0px 0 0 350px; padding:0px 20px 20px 20px; width:calc(100% - 350px);}
#lang{position:absolute;top:0;left:0;line-height:1.8em;padding:.3em 1em;}
#breadcrumb{white-space:nowrap;  background:#ecf6ff;  margin:0 -20px 0 -20px;}
#breadcrumb a,#breadcrumb span{display:inline-block;  padding:10px;  color:#373f46;  text-decoration:underline;}
#breadcrumb span{text-decoration:none;  color:black;}
#breadcrumb a + a:before,#breadcrumb a + span:before{content:' / ';  text-decoration:none;  display:inline-block;  margin-left:-15px;  margin-right:5px;  color:#a9bbca;}
#h1{color:#6b7279; text-decoration:none;}
#version{font-size:67%;color:red;}
#schema{margin-left:60px;position:relative;-moz-user-select:none;-webkit-user-select:none;}
#schema .table{border:1px solid silver;padding:0 2px;cursor:move;position:absolute;}
#schema .references{position:absolute;}
#help{position:absolute;border:1px solid #999;background:#eee;padding:5px;font-family:monospace;z-index:1;}
#form{margin-bottom:30px;}
#form > p{background:#f1f1f1;  padding:12px 15px;  margin-right:0;}
#form > p > select, #form > p > input{margin-right:12px;}
#form + p{margin-bottom:20px;}
input[type='submit']{background-color:#3877ce;  padding-left:15px!important;  padding-right:15px!important;  color:#fff;  border-color:#2b599a!important;}
.edit-select-sql{font-size:18px;}
.rtl h2{margin:0 -18px 20px 0;}
.rtl p, .rtl table, .rtl .error, .rtl .message{margin:1em 0 0 20px;}
.rtl .logout{left:0;right:auto;}
.rtl #content{margin:2em 21em 0 0;padding:10px 0 20px 20px;}
.rtl #breadcrumb{left:auto;right:21em;margin:0 -18px 0 0;}
.rtl .pages{left:auto;right:21em;}
.rtl input.wayoff{left:auto;right:-1000px;}
.rtl #lang, .rtl #menu{left:auto;right:0;}
@media all and (max-device-width:880px){.pages{left:auto;}
#menu{position:static;width:auto;}
#lang{position:static;border-top:1px solid #999;}
#breadcrumb{left:auto;}
.rtl .pages{right:auto;}
.rtl #content{margin-right:10px;}
.rtl #breadcrumb{right:auto;}
}
.jush{color:black;}
.jush-htm_com, .jush-com, .jush-com_code, .jush-one, .jush-php_doc, .jush-php_com, .jush-php_one, .jush-js_one, .jush-js_doc{color:gray;}
.jush-php, .jush-php_new, .jush-php_fun{color:#000033;background-color:#FFF0F0;}
.jush-php_quo, .jush-quo, .jush-quo_one, .jush-php_eot, .jush-apo, .jush-sql_apo, .jush-sqlite_apo, .jush-sql_quo, .jush-sql_eot{color:green;}
.jush-php_apo{color:#009F00;}
.jush-php_quo_var, .jush-php_var, .jush-sql_var{font-style:italic;}
.jush-php_apo .jush-php_quo_var, .jush-php_apo .jush-php_var{font-style:normal;}
.jush-php_halt2{background-color:white;color:black;}
.jush-tag_css, .jush-att_css .jush-att_quo, .jush-att_css .jush-att_apo, .jush-att_css .jush-att_val{color:black;background-color:#FFFFE0;}
.jush-tag_js, .jush-att_js .jush-att_quo, .jush-att_js .jush-att_apo, .jush-att_js .jush-att_val, .jush-css_js{color:black;background-color:#F0F0FF;}
.jush-tag, .jush-xml_tag{color:navy;}
.jush-att, .jush-xml_att, .jush-att_js, .jush-att_css, .jush-att_http{color:teal;}
.jush-att_quo, .jush-att_apo, .jush-att_val{color:purple;}
.jush-ent{color:purple;}
.jush-js_key, .jush-js_key .jush-quo, .jush-js_key .jush-apo{color:purple;}
.jush-js_reg{color:navy;}
.jush-php_sql .jush-php_quo, .jush-php_sql .jush-php_apo, .jush-php_sqlite .jush-php_quo, .jush-php_sqlite .jush-php_apo, .jush-php_pgsql .jush-php_quo, .jush-php_pgsql .jush-php_apo, .jush-php_mssql .jush-php_quo, .jush-php_mssql .jush-php_apo, .jush-php_oracle .jush-php_quo, .jush-php_oracle .jush-php_apo{background-color:#FFBBB0;}
.jush-bac, .jush-php_bac, .jush-bra, .jush-mssql_bra, .jush-sqlite_quo{color:red;}
.jush-num, .jush-clr{color:#007F7F;}
.jush a{color:navy;}
.jush a.jush-help{cursor:help;}
.jush-sql a, .jush-sql_code a, .jush-sqlite a, .jush-pgsql a, .jush-mssql a, .jush-oracle a, .jush-simpledb a{font-weight:bold;}
.jush-php_sql .jush-php_quo a, .jush-php_sql .jush-php_apo a{font-weight:normal;}
.jush-tag a, .jush-att a, .jush-apo a, .jush-quo a, .jush-php_apo a, .jush-php_quo a, .jush-php_eot2 a{color:inherit;color:expression(parentNode.currentStyle.color);}
a.jush-custom:link, a.jush-custom:visited{font-weight:normal;color:inherit;color:expression(parentNode.currentStyle.color);}
.jush p{margin:0;}
";
  } elseif ($_GET["file"] == "functions.js") {
    header("Content-Type: text/javascript; charset=utf-8");
    echo lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�|\nC(�\"��P���.��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�/��6KU����<2�pOI���`���ⳈdO�H��5�-��4��pX25-Ң�ۈ�z7��\"(�P�\\32:]U����߅!]�<�A�ۤ���iڰ�l\r�\0v��#J8��wm��ɤ�<�ɠ��%m;p#�`X�D���iZ��N0����9��占��`��wJ�D��2�9t��*��y��NiIh\\9����:����xﭵyl*�Ȉ��Y�����8�W��?���ޛ3���!\"6�n[��\r�*\$�Ƨ�nzx�9\r�|*3ףp�ﻶ�:(p\\;��mz���9����8N���j2����\r�H�H&��(�z��7i�k� ����c��e���t���2:SH�Ƞ�/)�x�@��t�ri9����8����yҷ���V�+^Wڦ��kZ�Y�l�ʣ���4��Ƌ������\\E�{�7\0�p���D��i�-T����0l�%=���˃9(�5�\n\n�n,4�\0�a}܃.��Rs\02B\\�b1�S�\0003,�XPHJsp�d�K� CA!�2*W����2\$�+�f^\n�1����zE� Iv�\\�2��.*A���E(d���b��܄��9����Dh�&��?�H�s�Q�2�x~nÁJ�T2�&��eR���G�Q��Tw�ݑ��P���\\�)6�����sh\\3�\0R	�'\r+*;R�H�.�!�[�'~�%t< �p�K#�!�l���Le����,���&�\$	��`��CX��ӆ0֭����:M�h	�ڜG��!&3�D�<!�23��?h�J�e ��h�\r�m���Ni�������N�Hl7��v��WI�.��-�5֧ey�\rEJ\ni*�\$@�RU0,\$U�E����ªu)@(t�SJk�p!�~���d`�>��\n�;#\rp9�jɹ�]&Nc(r���TQU��S��\08n`��y�b���L�O5��,��>���x���f䴒���+��\"�I�{kM�[\r%�[	�e�a�1! ����Ԯ�F@�b)R��72��0�\nW���L�ܜҮtd�+���0wgl�0n@��ɢ�i�M��\nA�M5n�\$E�ױN��l�����%�1 A������k�r�iFB���ol,muNx-�_�֤C( ��f�l\r1p[9x(i�BҖ��zQl��8C�	��XU Tb��I�`�p+V\0��;�Cb��X�+ϒ�s��]H��[�k�x�G*�]�awn�!�6�����mS���I��K�~/�ӥ7��eeN��S�/;d�A�>}l~��� �%^�f�آpڜDE��a��t\nx=�kЎ�*d���T����j2��j��\n��� ,�e=��M84���a�j@�T�s���nf��\n�6�\rd��0���Y�'%ԓ��~	�Ҩ�<���AH�G��8���΃\$z��{���u2*��a��>�(w�K.bP�{��o��´�z�#�2�8=�8>���A,�e���+�C�x�*���-b=m���,�a��lzk���\$W�,�m�Ji�ʧ���+���0�[��.R�sK���X��ZL��2�`�(�C�vZ������\$�׹,�D?H��NxX��)��M��\$�,��*\nѣ\$<q�şh!��S����xsA!�:�K��}�������R��A2k�X�p\n<�����l���3�����VV�}�g&Yݍ!�+�;<�Y��YE3r�َ��C�o5����ճ�kk�����ۣ��t��U���)�[����}��u��l�:D��+Ϗ _o��h140���0��b�K�㬒�����lG��#��������|Ud�IK���7�^��@��O\0H��Hi�6\r����\\cg\0���2�B�*e��\n��	�zr�!�nWz&� {H��'\$X �w@�8�DGr*���H�'p#�Į���\nd���,���,�;g~�\0�#����E��\r�I`��'��%E�.�]`�Л��%&��m��\r��%4S�v�#\n��fH\$%�-�#���qB�����Q-�c2���&���]�� �qh\r�l]�s���h�7�n#����-�jE�Fr�l&d����z�F6����\"���|���s@����z)0rpڏ\0�X\0���|DL<!��o�*�D�{.B<E���0nB(� �|\r\n�^���� h�!���r\$��(^�~����/p�q��B��O����,\\��#RR��%���d�Hj�`����̭ V� bS�d�i�E���oh�r<i/k\$-�\$o��+�ŋ��l��O�&evƒ�i�jMPA'u'���( M(h/+��WD�So�.n�.�n���(�(\"���h�&p��/�/1D̊�j娸E��&⦀�,'l\$/.,�d���W�bbO3�B�sH�:J`!�.���������,F��7(��Կ��1�l�s �Ҏ���Ţq�X\r����~R鰱`�Ҟ�Y*�:R��rJ��%L�+n�\"��\r��͇H!qb�2�Li�%����Wj#9��ObE.I:�6�7\0�6+�%�.����a7E8VS�?(DG�ӳB�%;���/<�����\r ��>�M��@���H�Ds��Z[tH�Enx(���R�x��@��GkjW�>���#T/8�c8�Q0��_�IIGII�!���YEd�E�^�td�th�`DV!C�8��\r���b�3�!3�@�33N}�ZB�3	�3�30��M(�>��}�\\�t�f�f���I\r���337 X�\"td�,\nbtNO`P�;�ܕҭ���\$\n����Zѭ5U5WU�^ho���t�PM/5K4Ej�KQ&53GX�Xx)�<5D��\r�V�\n�r�5b܀\\J\">��1S\r[-��Du�\r���)00�Y��ˢ�k{\n��#��\r�^��|�uܻU�_n�U4�U�~Yt�\rI��@䏳�R �3:�uePMS�0T�wW�X���D��KOU����;U�\n�OY��Y�Q,M[\0�_�D���W��J*�\rg(]�\r\"ZC��6u�+�Y��Y6ô�0�q�(��8}��3AX3T�h9j�j�f�Mt�PJbqMP5>������Y�k%&\\�1d��E4� �Yn���\$<�U]Ӊ1�mbֶ�^�����\"NV��p��p��eM���W�ܢ�\\�)\n �\nf7\n�2��r8��=Ek7tV����7P��L��a6��v@'�6i��j&>��;��`��a	\0pڨ(�J��)�\\��n��Ĭm\0��2��eqJ��P��t��fj��\"[\0����X,<\\������+md��~�����s%o��mn�),ׄ�ԇ�\r4��8\r����mE�H]�����HW�M0D�߀��~�ˁ�K��E}����|f�^���\r>�-z]2s�xD�d[s�t�S��\0Qf-K`���t���wT�9��Z��	�\nB�9 Nb��<�B�I5o�oJ�p��JNd��\r�hލ��2�\"�x�HC�ݍ�:���9Yn16��zr+z���\\�����m ��T ���@Y2lQ<2O+�%��.Ӄh�0A���Z��2R��1��/�hH\r�X��aNB&� �M@�[x��ʮ���8&L�V͜v�*�j�ۚGH��\\ٮ	���&s�\0Q��\\\"�b��	��\rBs��w��	���BN`�7�Co(���\nè���1�9�*E� �S��U�0U� t�'|�m���?h[�\$.#�5	 �	p��yB�@R�]���@|��{���P\0x�/� w�%�EsBd���CU�~O׷�P�@X�]����Z3��1��{�eLY���ڐ�\\�(*R`�	�\n������QCF�*�����霬�p�X|`N���\$�[���@�U������Z�`Zd\"\\\"����)��I�:�t��oD�\0[�����-���g�����*`hu%�,����I�7ī�H�m�6�}��N�ͳ\$�M�UYf&1����e]pz���I��m�G/� �w �!�\\#5�4I�d�E�hq���Ѭk�x|�k�qD�b�z?���>���:��[�L�ƬZ�X��:�������j�w5	�Y��0 ���\$\0C��dSg����{�@�\n`�	���C ���M�����# t}x�N����{�۰)��C��FKZ�j��\0PFY�B�pFk��0<�>�D<JE��g\r�.�2��8�U@*�5fk��JD���4��TDU76�/��@��K+���J�����@�=��WIOD�85M��N�\$R�\0�5�\r��_���E���I�ϳN�l���y\\����qU��Q���\n@���ۺ�p���P۱�7ԽN\r�R{*�qm�\$\0R��ԓ���q�È+U@�B��Of*�Cˬ�MC��`_ ���˵N��T�5٦C׻� ��\\W�e&_X�_؍h���B�3���%�FW���|�Gޛ'�[�ł����V��#^\r��GR����P��Fg�����Yi ���z\n��+�^/�������\\�6��b�dmh��@q���Ah�),J��W��cm�em]�ӏe�kZb0�����Y�]ym��f�e�B;���O��w�apDW�����{�\0��-2/bN�sֽ޾Ra�Ϯh&qt\n\"�i�Rm�hz�e����FS7��PP�䖤��:B����sm��Y d���7}3?*�t����lT�}�~�����=c������	��3�;T�L�5*	�~#�A����s�x-7��f5`�#\"N�b��G����@�e�[�����s����-��M6��qq� h�e5�\0Ң���*�b�IS���Fή9}�p�-��`{��ɖkP�0T<��Z9�0<՚\r��;!��g�\r\nK�\n��\0��*�\nb7(�_�@,�e2\r�]�K�+\0��p C\\Ѣ,0�^�MЧ����@�;X\r��?\$\r�j�+�/��B��P�����J{\"a�6�䉜�|�\n\0��\\5���	156�� .�[�Uد\0d��8Y�:!���=��X.�uC����!S���o�p�B���7��ů�Rh�\\h�E=�y:< :u��2�80�si��TsB�@\$ ��@�u	�Q���.��T0M\\/�d+ƃ\n��=��d���A���)\r@@�h3���8.eZa|.�7�Yk�c���'D#��Y�@X�q�=M��44�B AM��dU\"�Hw4�(>��8���C�?e_`��X:�A9ø���p�G��Gy6��F�Xr��l�1��ػ�B�Å9Rz��hB�{����\0��^��-�0�%D�5F\"\"�����i�`��nAf� \"tDZ\"_�V\$��!/�D�ᚆ������٦�̀F,25�j�T��y\0�N�x\r�Yl��#��Eq\n��B2�\n��6���4���!/�\n��Q��*�;)bR�Z0\0�CDo�˞�48������e�\n�S%\\�PIk��(0��u/��G������\\�}�4Fp��G�_�G?)g�ot��[v��\0��?b�;��`(�ی�NS)\n�x=��+@��7��j�0��,�1Åz����>0��Gc��L�VX�����%����Q+���o�F���ܶ�>Q-�c���l����w��z5G��@(h�c�H��r?��Nb�@�������lx3�U`�rw���U���t�8�=�l#���l�䨉8�E\"����O6\n��1e�`\\hKf�V/зPaYK�O�� ��x�	�Oj���r7�F;��B����̒��>�Ц�V\rĖ�|�'J�z����#�PB��Y5\0NC�^\n~LrR��[̟Rì�g�eZ\0x�^�i<Q�/)�%@ʐ��fB�Hf�{%P�\"\"���@���)���DE(iM2�S�*�y�S�\"���e̒1��ט\n4`ʩ>��Q*��y�n����T�u�����~%�+W��XK���Q�[ʔ��l�PYy#D٬D<�FL���@�6']Ƌ��\rF�`�!�%\n�0�c���˩%c8WrpG�.T�Do�UL2�*�|\$�:�Xt5�XY�I�p#� �^\n��:�#D�@�1\r*�K7�@D\0��C�C�xBh�EnK�,1\"�*y[�#!�י�ٙ���l_�/��x�\0���5�Z��4\0005J�h\"2���%Y���a�a1S�O�4��%ni��P��ߴq�_ʽ6���6��\n@PjU�\0��`r;�H�������:�����4 _w*�@F@%��s[�d�e���bh�\0�ɱP\r�\\i�J�99P9�^s�.��P29�\nNj#,����5���M)��B���\ni%~����:9��X\r�e��8���eӽ+���9���x�*�ـW2�N�ba�S�E��2��\r����p�	��\\(/	Lf����Y��X#8ZJăH��+P�-I1xɈ�36�N�w\r���[x3�>\rTO�b�>s��0���jA�8;�#ј������jPd�qR�J�\"��(x����h�*��	T��aV��Yƌ��\$����7�Z9ĸ�1̚XJ���a�AOk8fD�C�96@���M�(H�����B���?�i�TAPܭ�^0�P��af/�ύ�P0�MH)\"�dU@�r1\\�\r�oH|�����h�8�@�?P��Z,A>®��E(�&��e��͞]�Q\$������ЪZ�}a���̙:P�w:��(�Z���!8������n@9�\$��(K\"����%Ŧ��@2��\$P��<��\0��灦JtUXP\"-A��ɦYk�2����4�C\n�\0���2��~�s_��\0�N5��Ҝ��/�ӀI�;���i���֗efkF<�r�E�,�6%?�I�j;'S)M����4)�N�.�~�����\0J�Ӕ��3��Qzz	�?��m1����q�	cQH�ܯyL\"Oυ0|c\$P�\"����r0eL��m#d�px.uA�^�B�76��qn�׍�B�n��iZvR@�)*�㌁qƒ�)��7^�I��jI�S5�3�������8ں���x�9	�Lq��L�OA�A\0001���%�!1-�W��Ҏ�%#!5+�����!�vue(�Bp�\nK�/������\\�i���\0^�\$�,�|�Z��(R�+k��\n++��V�G�{/�T�<��M�ê��¢���\$�{д�̀y�Vt� +�S�Z���(u� x\"HC�J�? v8�J�P� Q\0�V1��#��'_�\n�4%�ǥ\nza_���PDD{��+\$Sz�օ? l�ʍ��2z��!=�OD���[�b\0�K�Į�tj�+�(�Ҕ5�.��k�Z�F֭=A���Uך��0�C�������~�v.�8�+Rx[�º�زŦ�Au��I8䬎3���� '	�i�f��.J�ʈT���X11����&3��6���	��f@|O`b��g\0�>���x�kkMD�Q�\n����h����a�y\$t��`\"��5����56���| `&���:T�A��\n������pjR���I*��Q�����aN�Z�_Z�q⴩����G9\0�����(İ=J��� dG���9r��,Qp�+kZ�\$��I+����(��5��{2��_m�ˆ8��e���n����\\6Ŋ���\${X��K\$��#k�U��+v�vE�m�n��vO�	!Adt��_/�(6�1ڕ��m[�����\$�Tαh�d��X�����/7ꠡB� �-\$��Ur�>b*)̶Z�Xnb�\n��ESΝpoe����p\\��D� ��E�#�,��T~�.�P��m)a��=óR���E��<��r�6��gHE-t�봺R�v�ZtF+m[���u�:��7w��]��,`��-�w��9���a���o���[DM������oe�rq6�H���Ș!*�teh���^�ʔ��I��M�đ\"DA��\$�\0oH��̜�Ap��E�ZL���}\"��:�|��6�|=n����f�c���v�J]�A5c�H��8��-�����O�VBV�#д��`���\r���-�	�KBd�G�^�+��.��El��\$\$(q�0|9(��h��{\n4a7B�P\0n@-h�oW���� `�+^j��d��9cP�q1��H\"���\\�����!���\".ڤ�����E<�/���z}���(�XD.6?Nxk*,)�l�W�9�	j\\I��(J���@;�1����\n�Ix��ï�h\rI[:��ˈH�5/�vBu�Pfu��6�!4�xl��2�����^ ��g\0�����_q��~4I�O\"�-x�D��b\\\"�-_�rȔ���G\"�b�a{O���R�v�r�qK�\0\$�m�b���NAt@�)U�𣰮��p�j��v��,9�ʄ��*T~�L���dѻ�K�g��P�L����F�2���P*,uW��*Z����UpU�i\0d�]��\rGw\n@`����k�!�q�g��E��HE�@��]y2s��e��%���\"���\\�O�?�z+���4�;uzЁ0d7��F����<d��2�u�9���W\$y9��\0P܀d�,�-���[����h|BQ ��5ҙ���ة�<��r\0�t;2����f�9T��=@�s:��ɘ��L�v���X@WoN �W��\$D�D7��e����:(�v�����/����r\rA�Ơ\n�z3|�٘��z^ev/�y��^5��G��0B�����m�`��vl���n�n�R>\nYTc��b��P\\�rPc�cx7c���D�={*�dr��8��w�΁܆=R6_��Ɯ�Ny��`&��\$�H��G�k�4Y|��/�ٳ�@��Ҥ�sέ������R\"y�[�zGo�%Gg����{�ϟ�.���9r�c�\\U����5��C����\"��)L׌�I���k��\r��i��(�Ϲ-���\\d��&r�|�f����P�eM�I��bc0Ml�C���OZ9�&��z�������HK�X�Ў�%��AauR���w�I=�KY���De��̀\r�ވ1�D�\"OmuL�o�C\\�m!�s�T\0�t���|�uK��)���貅Z2�XoM|C���h/���➁!�FԨ�(���J�\0�H�Sz3��(f�J�4ޣ�8�cb�\$��۩R��`���i�޺�.\0��?�l�[6�D��Hֆ��R[��e<q�����;�������pKtf`/���Ԥz\rݫ-Mi�͢L�J��,��JC��� ��f��ӧ[�����ڲ,-Yڇ]!y nT���Bl�ބ\$zUcu��\$�j>72�,4.���!��Q��D+�F���ן��[\n6�So8�M)�Leٴ��\r,�e=�\r�����-�h��#�M�*=O���\n��#D���Q�+a�O��-Ss1+[@(���3|���r��F�拄=iJ���2&�s�\rO�\$!l��D����Bt��i��Rq;͉@�P���WP>?�=r�ןnCs,���;B�o��M�m�}��y��M�����˹-���>y,g�6�q���\"�q3|d��;��b�F7�	늫@��?��v@	��ERU� �&I\\}-X����gG4�]g6��Ԃ>��\0�:��\"jWP�{�g���O\\3����\n��\r� ��,�Dߢ�9�\0	�O}jCڷ�L��|	H��6�����r�TF������!��S+�r�����c3��B@XdT6&��ǎG�g�n�8�Ƒ�z|)���V��^��	��-\0�8���-�8b�7�-�/�@�֐>V���+u\0B�zl%5׶��OJ���!��ֲ@�x�h�7 �!�1�8�SR�\0Q*o�8�n*�?_���\nx���T�9�������n�4,7o�^�N]�d�q�1#e�(v������,���ms.8�T�WgB>`�L�@���\\�y��n\nNq���1�E=h4<Ӿ\$�sA��u3�B���:�@�u�2�A=��\\B-uM��DnW�d�V��TlrR����Ҟ�Ug�\r��������{F�>A�C��'�	��2�������b�����b���d�Y/�|nr\r��S�Sk*�AO��R)��;�s�Ԕ\$w\$)E��Ai�鰠�Q 1�ݔ���D3%�� ���*2r��PL�s,�;�ug+��t�h�b�L���%��rC�|�Z����N�*��*5;ۡ�U�A�{І��~y�iKX��ڔD��#�2CJY��������>zS�CU��c����ORԾ�0�)�+��:-IN����|�e�G�;�b��\$,p0��_L.��\$ċ�v��SܖF1&U��(	��nxt���d�@0��������/wc��_R�2�f�ѭeĪ�\0=��s��bsCO4�t~�h�(�o}OU����_h���p������x���\$?!�Bw�G�9�G��渦���V?{X�n�S�~��_1��Ţq��U{#x\nN \$�8�E��q�~��7�!��i!�n�qi\r\$��k𨞣��Q��Ld	�S��tpA9��/[�s�\0��6Vv,�������'�`�?C�s�hctH\"�K�}n���'������^�3���_M�%�o���郄�VO��ٿ����E�\n��rpT��L��|`e�Ѻ���A�j�:d|[�ێ⽌���J���4�l N�u4]l�M�H&��\$�\0YR��qzWĘ@������e3�'t|��.���`(�I<��2�_5�)%����G��m\0P\n�m�o@��>���xB\"��Em|��2�\$},3L�YX�go�\$߶ <�����IE\"`���4�g�8^�]\n����:��qV�Tԣ�m�m��7&ғĤ�m��&���Qz�������ű�H����yO�f��\r٣.�����@�JW&�q�5�0	�5��P�G��\n������F�{\0\r�m�@�@ �P� x�4i4�+@\0,͚\\�C1ӎ�\n�L���>n�\0���	 #������#@]/4JR� IR��p�<�ǯ�aj��?)Mv��2X|@v\0a��\"�τ��k���-�yA[|�7\r��\$����ZǭR�t���>����CErL	��r�O�e�R/���J��~�%Xo�4�dU\"�Qr��I�QD������QQM}�Q�{)ة�\",f��_(,�6�Q+c����&�S���~O�p�C���������V�����@1�[�<H/�~�\0^C��T���q_gP��pe��@B�������끠pȿ�)X��\0��ߔ��{�`�\0v������Q����@~�翡����TƁW������������������O�>�8&����CLݑ��(���(���Ǐ2��\r%�;�k抐4��_O;�5��`@<���/�7�_	�6'AY��\"��aS��z�kp�4�+h@Z����8>���oߔL������j�s���\rJ��m��\0L\0c�?���m��N�(����Tp#���|�>����A[?�[�ſ�Hk�����\n�t��p:�G���>��T�{*��-�t����P��X�j�N�4���0\n\$��:H,�H}�A���c�*���n?�돢\n���;�O�\0Z��v�AB���`�o��8_�R--n��T#DIs1��\0V�PM\0V�r���0\$Bi�`�T�d�X|e\08\\�7),_���K�3(.c��\\�d��2���R<�u�\\��	4�N�(|g���|�N&,����y���(���8b�:P���1Y'!��Ą�\0fx���\0��1����H[,�>����&�T�/a\rLC�bE����	7����b��kș�|b��0�T\"���.���ق5s��D�Sg�8�Rh*�4�}�����<-9B\$���d9B\$�i�H�8cj\\`���_�����	�#`��h����HΨp�\$�0�`1W\n��%N�Z\\#�b��P��%m7l\"��d��\"P��!�#/ş��,ͪ��J#0��c�]��-(򐹆6�7l~�\r\0B��0�:CA�\\pϑ�[����(Ќ�JG�0�B\"8�P�B*%�<#�BF72�B������5Bp	t&��6\0b���4<\$퀶�K��V\0G	�mY�");
  } elseif ($_GET["file"] == "jush.js") {
    header("Content-Type: text/javascript; charset=utf-8");
    echo lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O���/�<�x�9�o�����3n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��㢺�>�8�\$�c��1�c���c����{n7����A�N�RLi\r1���!�(�j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mplv�)� ��HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f������\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g��U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��yŊ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL�pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)���\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j����Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9O\$��طzyM�3�\\9���.o�����E(i������7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~����)TZ0E9M�YZtXe!�f�@�{Ȭyl	8�;���R{��8�Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��jG���t�*3%k�YܲT*�|\"C��lhE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+�����̷�^�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�)���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�=MƂ0n�P�/p�ot������.�̽�g\0�)o�\n0���\rF����b�i��o}\n�̯�	NQ�'�x�Fa�J���L������\r��\r����0��'��d	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���n!�Ɏ�z�����\\��\r���`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v���N�͐f��@܆�&�B\$�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} ��lb�&�vj4�LS��ִԶ5&dsF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQMTmGB�tl-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj���\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v�#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA������2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`�}M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU�cD�ѷ���X!��u�&-vP�ر\0'L�X �L����o	��>�Վ�\r@�P�\rxF��E��ȭ�%����=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y�����]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#�������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9����W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-����������J(���@�;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u��6�|�|X����س|O�x!�:���ϗY]�����c���\r�h�9n�������8'������\rS.1��USȸ��X��+��z]ɵ��?����C�\r��\\����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K��f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR&M���?�St�T]ݴG�:I����)��B�� v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ����lJ����y�I�	�:����B�bP���Z��n����U;>_�\n	�����`��uM򌂂�֍m����Lw�B\0\\b8�M��[z��&�1�\0�	�\r�T������+\\�3�Plb4-)%Wd#\n��r��MX\"ϡ�(Ei11(b`@f����S���j�D��bf�}�r����D�R1���b��A��Iy\"�Wv��gC�I�J8z\"P\\i�\\m~ZR��v�1ZB5I��i@x����-�uM\njK�U�h\$o��JϤ!�L\"#p7\0� P�\0�D�\$	�GK4e��\$�\nG�?�3�EAJF4�Ip\0��F�4��<f@� %q�<k�w��	�LOp\0�x��(	�G>�@�����9\0T����GB7�-�����G:<Q��#���Ǵ�1�&tz��0*J=�'�J>���8q��Х���	�O��X�F��Q�,����\"9��p�*�66A'�,y��IF�R��T���\"��H�R�!�j#kyF���e��z�����G\0�p��aJ`C�i�@�T�|\n�Ix�K\"��*��Tk\$c��ƔaAh��!�\"�E\0O�d�Sx�\0T	�\0���!F�\n�U�|�#S&		IvL\"����\$h���EA�N\$�%%�/\nP�1���{��) <���L���-R1��6���<�@O*\0J@q��Ԫ#�@ǵ0\$t�|�]�`��ĊA]���Pᑀ�C�p\\pҤ\0���7���@9�b�m�r�o�C+�]�Jr�f��\r�)d�����^h�I\\�. g��>���8���'�H�f�rJ�[r�o���.�v���#�#yR�+�y��^����F\0᱁�]!ɕ�ޔ++�_�,�\0<@�M-�2W���R,c���e2�*@\0�P ��c�a0�\\P���O���`I_2Qs\$�w��=:�z\0)�`�h�������\nJ@@ʫ�\0�� 6qT��4J%�N-�m����.ɋ%*cn��N�6\"\r͑�����f�A���p�MۀI7\0�M�>lO�4�S	7�c���\"�ߧ\0�6�ps�����y.��	���RK��PAo1F�tI�b*��<���@�7�˂p,�0N��:��N�m�,�xO%�!��v����gz(�M���I��	��~y���h\0U:��OZyA8�<2����us�~l���E�O�0��0]'�>��ɍ�:���;�/��w�����'~3GΖ~ӭ����c.	���vT\0c�t'�;P�\$�\$����-�s��e|�!�@d�Obw��c��'�@`P\"x����0O�5�/|�U{:b�R\"�0�шk���`BD�\nk�P��c��4�^ p6S`��\$�f;�7�?ls��߆gD�'4Xja	A��E%�	86b�:qr\r�]C8�c�F\n'ьf_9�%(��*�~��iS����@(85�T��[��Jڍ4�I�l=��Q�\$d��h�@D	-��!�_]��H�Ɗ�k6:���\\M-����\r�FJ>\n.��q�eG�5QZ����' ɢ���ہ0��zP��#������r���t����ˎ��<Q��T��3�D\\����pOE�%)77�Wt�[��@����\$F)�5qG0�-�W�v�`�*)Rr��=9qE*K\$g	��A!�PjBT:�K���!��H� R0?�6�yA)B@:Q�8B+J�5U]`�Ҭ��:���*%Ip9�̀�`KcQ�Q.B��Ltb��yJ�E�T��7���Am�䢕Ku:��Sji� 5.q%LiF��Tr��i��K�Ҩz�55T%U��U�IՂ���Y\"\nS�m���x��Ch�NZ�UZ���( B��\$Y�V��u@蔻����|	�\$\0�\0�oZw2Ҁx2���k\$�*I6I�n�����I,��QU4�\n��).�Q���aI�]����L�h\"�f���>�:Z�>L�`n�ض��7�VLZu��e��X����B���B�����Z`;���J�]�����S8��f \nڶ�#\$�jM(��ޡ����a�G���+A�!�xL/\0)	C�\n�W@�4�����۩� ��RZ����=���8�`�8~�h��P ��\r�	���D-FyX�+�f�QSj+X�|��9-��s�x�����+�V�cbp쿔o6H�q�����@.��l�8g�YM��WMP��U��YL�3Pa�H2�9��:�a�`��d\0�&�Y��Y0٘��S�-��%;/�T�BS�P�%f������@�F��(�֍*�q +[�Z:�QY\0޴�JUY֓/���pkzȈ�,�𪇃j�ꀥW�״e�J�F��VBI�\r��pF�Nقֶ�*ը�3k�0�D�{����`q��ҲBq�e�D�c���V�E���n����FG�E�>j�����0g�a|�Sh�7u�݄�\$���;a��7&��R[WX���(q�#���P���ז�c8!�H���VX�Ď�j��Z������Q,DUaQ�X0��ը���Gb��l�B�t9-oZ���L���­�pˇ�x6&��My��sҐ����\"�̀�R�IWU`c���}l<|�~�w\"��vI%r+��R�\n\\����][��6�&���ȭ�a�Ӻ��j�(ړ�Tѓ��C'��� '%de,�\n�FC�эe9C�N�Ѝ�-6�Ueȵ��CX��V������+�R+�����3B��ڌJ�虜��T2�]�\0P�a�t29��(i�#�aƮ1\"S�:�����oF)k�f���Ъ\0�ӿ��,��w�J@��V򄎵�q.e}KmZ����XnZ{G-���ZQ���}��׶�6ɸ���_�؁Չ�\n�@7�` �C\0]_ ��ʵ����}�G�WW: fCYk+��b۶���2S,	ڋ�9�\0﯁+�W�Z!�e��2�������k.Oc��(v̮8�DeG`ۇ�L���,�d�\"C���B-�İ(����p���p�=����!�k������}(���B�kr�_R�ܼ0�8a%ۘL	\0���b������@�\"��r,�0T�rV>����Q��\"�r��P�&3b�P��-�x���uW~�\"�*舞�N�h�%7���K�Y��^A����C����p����\0�..`c��+ϊ�GJ���H���E����l@|I#Ac��D��|+<[c2�+*WS<�r��g���}��>i�݀�!`f8�(c����Q�=f�\n�2�c�h4�+q���8\na�R�B�|�R����m��\\q��gX����ώ0�X�`n�F���O p��H�C��jd�f��EuDV��bJɦ��:��\\�!mɱ?,TIa���aT.L�]�,J��?�?��FMct!a٧R�F�G�!�A���rr�-p�X��\r��C^�7���&�R�\0��f�*�A\n�՛H��y�Y=���l�<��A�_��	+��tA�\0B�<Ay�(fy�1�c�O;p���ᦝ`�4СM��*��f�� 5fvy {?���:y��^c��u�'���8\0��ӱ?��g��� 8B��&p9�O\"z���rs�0��B�!u�3�f{�\0�:�\n@\0����p���6�v.;�����b�ƫ:J>˂��-�B�hkR`-����aw�xEj����r�8�\0\\����\\�Uhm� �(m�H3̴��S����q\0��NVh�Hy�	��5�M͎e\\g�\n�IP:Sj�ۡٶ�<���x�&�L��;nfͶc�q��\$f�&l���i�����0%yΞ�t�/��gU̳�d�\0e:��h�Z	�^�@��1��m#�N��w@��O��zG�\$�m6�6}��ҋ�X'�I�i\\Q�Y���4k-.�:yz���H��]��x�G��3��M\0��@z7���6�-DO34�ދ\0Κ��ΰt\"�\"vC\"Jf�Rʞ��ku3�M��~����5V ��j/3���@gG�}D���B�Nq��=]\$�I��Ӟ�3�x=_j�X٨�fk(C]^j�M��F��ա��ϣCz��V��=]&�\r�A<	������6�Ԯ�״�`jk7:g��4ծ��YZq�ftu�|�h�Z��6��i〰0�?��骭{-7_:��ސtѯ�ck�`Y��&���I�lP`:�� j�{h�=�f	��[by��ʀoЋB�RS���B6��^@'�4��1U�Dq}��N�(X�6j}�c�{@8���,�	�PFC���B�\$mv���P�\"��L��CS�]����E���lU��f�wh{o�(��)�\0@*a1G� (��D4-c��P8��N|R���VM���n8G`e}�!}���p�����@_���nCt�9��\0]�u��s���~�r��#Cn�p;�%�>wu���n�w��ݞ�.���[��hT�{��值	�ˁ��J���ƗiJ�6�O�=������E��ٴ��Im���V'��@�&�{��������;�op;^��6Ŷ@2�l���N��M��r�_ܰ�Í�` �( y�6�7�����ǂ��7/�p�e>|��	�=�]�oc����&�xNm���烻��o�G�N	p����x��ý���y\\3����'�I`r�G�]ľ�7�\\7�49�]�^p�{<Z��q4�u�|��Qۙ��p���i\$�@ox�_<���9pBU\"\0005�� i�ׂ��C�p�\n�i@�[��4�jЁ�6b�P�\0�&F2~������U&�}����ɘ	��Da<��zx�k���=���r3��(l_���FeF���4�1�K	\\ӎld�	�1�H\r���p!�%bG�Xf��'\0���	'6��ps_��\$?0\0�~p(�H\n�1�W:9�͢��`��:h�B��g�B�k��p�Ɓ�t��EBI@<�%����` �y�d\\Y@D�P?�|+!��W��.:�Le�v,�>q�A���:���bY�@8�d>r/)�B�4���(���`|�:t�!����?<�@���/��S��P\0��>\\�� |�3�:V�uw���x�(����4��ZjD^���L�'���C[�'�����jº[�E�� u�{KZ[s���6��S1��z%1�c��B4�B\n3M`0�;����3�.�&?��!YA�I,)��l�W['��ITj���>F���S���BбP�ca�ǌu�N����H�	LS��0��Y`���\"il�\r�B���/����%P���N�G��0J�X\n?a�!�3@M�F&ó����,�\"���lb�:KJ\r�`k_�b��A��į��1�I,�����;B,�:���Y%�J���#v��'�{������	wx:\ni����}c��eN���`!w��\0�BRU#�S�!�<`��&v�<�&�qO�+Σ�sfL9�Q�Bʇ����b��_+�*�Su>%0�����8@l�?�L1po.�C&��ɠB��qh�����z\0�`1�_9�\"���!�\$���~~-�.�*3r?�ò�d�s\0����>z\n�\0�0�1�~���J����|Sޜ��k7g�\0��KԠd��a��Pg�%�w�D��zm�����)����j�����`k���Q�^��1���+��>/wb�GwOk���_�'��-CJ��7&����E�\0L\r>�!�q́���7����o��`9O`�����+!}�P~E�N�c��Q�)��#��#�����������J��z_u{��K%�\0=��O�X�߶C�>\n���|w�?�F�����a�ϩU����b	N�Y��h����/��)�G��2���K|�y/�\0��Z�{��P�YG�;�?Z}T!�0��=mN����f�\"%4�a�\"!�ޟ����\0���}��[��ܾ��bU}�ڕm��2�����/t���%#�.�ؖ��se�B�p&}[˟��7�<a�K���8��P\0��g��?��,�\0�߈r,�>���W����/��[�q��k~�CӋ4��G��:��X��G�r\0������L%VFLUc��䑢��H�ybP��'#��	\0п���`9�9�~���_��0q�5K-�E0�b�ϭ�����t`lm����b��Ƙ; ,=��'S�.b��S���Cc����ʍAR,����X�@�'��8Z0�&�Xnc<<ȣ�3\0(�+*�3��@&\r�+�@h, ��\$O���\0Œ��t+>����b��ʰ�\r�><]#�%�;N�s�Ŏ����*��c�0-@��L� >�Y�p#�-�f0��ʱa�,>��`����P�:9��o���ov�R)e\0ڢ\\����\nr{îX����:A*��.�D��7�����#,�N�\r�E���hQK2�ݩ��z�>P@���	T<��=�:���X�GJ<�GAf�&�A^p�`���{��0`�:���);U !�e\0����c�p\r�����:(��@�%2	S�\$Y��3�hC��:O�#��L��/����k,��K�oo7�BD0{���j��j&X2��{�}�R�x��v���أ�9A����0�;0�����-�5��/�<�� �N�8E����	+�Ѕ�Pd��;���*n��&�8/jX�\r��>	PϐW>K��O��V�/��U\n<��\0�\nI�k@��㦃[��Ϧ²�#�?���%���.\0001\0��k�`1T� ����ɐl�������p���������< .�>��5��\0��	O�>k@Bn��<\"i%�>��z��������3�P�!�\r�\"��\r �>�ad���U?�ǔ3P��j3�䰑>;���>�t6�2�[��޾M\r�>��\0��P���B�Oe*R�n���y;� 8\0���o�0���i���3ʀ2@����?x�[����L�a����w\ns����A��x\r[�a�6�clc=�ʼX0�z/>+����W[�o2���)e�2�HQP�DY�zG4#YD����p)	�H�p���&�4*@�/:�	�T�	���aH5���h.�A>��`;.���Y��a	���t/ =3��BnhD?(\n�!�B�s�\0��D�&D�J��)\0�j�Q�y��hDh(�K�/!�>�h,=�����tJ�+�S��,\"M�Ŀ�N�1�[;�Т��+��#<��I�Zğ�P�)��LJ�D��P1\$����Q�>dO��v�#�/mh8881N:��Z0Z���T �B�C�q3%��@�\0��\"�XD	�3\0�!\\�8#�h�v�ib��T�!d�����V\\2��S��Œ\nA+ͽp�x�iD(�(�<*��+��E��T���B�S�CȿT���� e�A�\"�|�u�v8�T\0002�@8D^oo�����|�N������J8[��3����J�z׳WL\0�\0��Ȇ8�:y,�6&@�� �E�ʯݑh;�!f��.B�;:���[Z3������n���ȑ��A���qP4,��Xc8^��`׃��l.����S�hޔ���O+�%P#Ρ\n?��IB��eˑ�O\\]��6�#��۽؁(!c)�N����?E��B##D �Ddo��P�A�\0�:�n�Ɵ�`  ��Q��>!\r6�\0��V%cb�HF�)�m&\0B�2I�5��#]���D>��3<\n:ML��9C���0��\0���(ᏩH\n����M�\"GR\n@���`[���\ni*\0��)������u�)��Hp\0�N�	�\"��N:9q�.\r!���J��{,�'����4�B���lq���Xc��4��N1ɨ5�Wm��3\n��F��`�'��Ҋx��&>z>N�\$4?����(\n쀨>�	�ϵP�!Cq͌��p�qGLqq�G�y�H.�^��\0z�\$�AT9Fs�Ѕ�D{�a��cc_�G�z�)� �}Q��h��HBָ�<�y!L����!\\�����'�H(��-�\"�in]Ğ���\\�!�`M�H,gȎ��*�Kf�*\0�>6���6��2�hJ�7�{nq�8����H�#c�H�#�\r�:��7�8�܀Z��ZrD��߲`rG\0�l\n�I��i\0<����\0Lg�~���E��\$��P�\$�@�PƼT03�HGH�l�Q%*\"N?�%��	��\n�CrW�C\$��p�%�uR`��%��R\$�<�`�Ifx���\$/\$�����\$���O�(���\0��\0�RY�*�/	�\rܜC9��&hh�=I�'\$�RRI�'\\�a=E����u·'̙wI�'T���������K9%�d����!��������j�����&���v̟�\\=<,�E��`�Y��\\����*b0>�r��,d�pd���0DD ̖`�,T �1�% P���/�\r�b�(���J����T0�``ƾ����J�t���ʟ((d�ʪ�h+ <Ɉ+H%i�����#�`� ���'��B>t��J�Z\\�`<J�+hR���8�hR�,J]g�I��0\n%J�*�Y���JwD��&ʖD�������R�K\"�1Q�� ��AJKC,�mV�������-���KI*�r��\0�L�\"�Kb(����J:qKr�d�ʟ-)��ˆ#Ը�޸[�A�@�.[�Ҩʼ�4���.�1�J�.̮�u#J���g\0��򑧣<�&���K�+�	M?�/d��%'/��2Y��>�\$��l�\0��+����}-t��ͅ*�R�\$ߔ��K�.����JH�ʉ�2\r��B���(P���6\"��nf�\0#Ї ��%\$��[�\n�no�LJ�����e'<����1K��y�Y1��s�0�&zLf#�Ƴ/%y-�ˣ3-��K��L�΁��0����[,��̵,������0���(�.D��@��2�L+.|�����2�(�L�*��S:\0�3����G3l��aːl�@L�3z4�ǽ%̒�L�3����!0�33=L�4|ȗ��+\"���4���7�,\$�SPM�\\��?J�Y�̡��+(�a=K��4���C̤<Ё�=\$�,��UJ]5h�W�&t�I%��5�ҳ\\M38g�́5H�N?W1H��^��Ը�Y͗ؠ�͏.�N3M�4Å�`��i/P�7�dM>�d�/�LR���=K�60>�I\0[��\0��\r2���Z@�1��2��7�9�FG+�Ҝ�\r)�hQtL}8\$�BeC#��r*H�۫�-�H�/���6��\$�RC9�ب!���7�k/P�0Xr5��3D���<T�Ԓq�K���n�H�<�F�:1SL�r�%(��u)�Xr�1��nJ�I��S�\$\$�.·9��IΟ�3 �L�l���Ι9��C�N�#ԡ�\$�/��s��9�@6�t���N�9���N�:����7�Ӭ�:D���M)<#���M}+�2�N��O&��JNy*���ٸ[;���O\"m����M�<c�´���8�K�,���N�=07s�JE=T��O<����J�=D��:�C<���ˉ=���K�ʻ̳�L3�����LTЀ3�S,�.���q-��s�7�>�?�7O;ܠ`�OA9���ϻ\$���O�;��`9�n�I�A�xp��E=O�<��5����2�O�?d�����`N�iO�>��3�P	?���O�m��S�M�ˬ��=�(�d�Aȭ9���\0�#��@��9D����&���?����i9�\n�/��A���ȭA��S�Po?kuN5�~4���6���=򖌓*@(�N\0\\۔dG��p#��>�0��\$2�4z )�`�W���+\0��80�菦������z\"T��0�:\0�\ne \$��rM�=�r\n�N�P�Cmt80�� #��J=�&��3\0*��B�6�\"������#��>�	�(Q\n���8�1C\rt2�EC�\n`(�x?j8N�\0��[��QN>���'\0�x	c���\n�3��Ch�`&\0���8�\0�\n���O`/����A`#��Xc���D �tR\n>���d�B�D�L��������Dt4���j�p�GAoQoG8,-s����K#�);�E5�TQ�G�4Ao\0�>�tM�D8yRG@'P�C�	�<P�C�\"�K\0��x��~\0�ei9���v))ѵGb6���H\r48�@�M�:��F�tQ�!H��{R} �URp���O\0�I�t8������[D4F�D�#��+D�'�M����>RgI���Q�J���U�)Em���TZ�E�'��iE����qFzA��>�)T�Q3H�#TL�qIjNT���&C��h�X\nT���K\0000�5���JH�\0�FE@'љFp�hS5F�\"�oѮ�e%aoS E)� ��DU��Q�Fm�ѣM��Ѳe(tn� �U1ܣ~>�\$��ǂ��(h�ǑG�y`�\0��	��G��3�5Sp(��P�G�\$��#��	���N�\n�V\$��]ԜP�=\"RӨ?Lzt��1L\$\0��G~��,�KN�=���GM����NS�)��O]:ԊS}�81�RGe@C�\0�OP�S�N�1��T!P�@��S����S�G`\n�:��P�j�7R� @3��\n� �������DӠ��L�����	��\0�Q5���CP��SMP�v4��?h	h�T�D0��֏��>&�ITx�O�?�@U��R8@%Ԗ��K���N�K��RyE�E#�� @����%L�Q�Q����?N5\0�R\0�ԁT�F�ԔR�S�!oTE�C(�����ĵ\0�?3i�SS@U�QeM��	K�\n4P�CeS��\0�NC�P��O�!�\"RT�����S�N���U5OU>UiI�PU#UnKP��UYT�*�C��U�/\0+���)��:ReA�\$\0���x��WD�3���`����U5�IHUY��:�P	�e\0�MJi�����Q�>�@�T�C{��u��?�^�v\0WR�]U}C��1-5+U�?�\r�W<�?5�JU-SX��L�� \\t�?�sM�b�ՃV܁t�T�>�MU+�	E�c���9Nm\rRǃC�8�S�X�'R��XjCI#G|�!Q�Gh�t�Q��� )<�Y�*��RmX0����M���OQ�Y�h���du���Z(�Ao#�NlyN�V�Z9I���M��V�ZuOՅT�T�EՇַS�e����\n�X��S�QER����[MF�V�O=/����>�gչT�V�oU�T�Z�N�*T\\*����S-p�S��V�q��M(�Q=\\�-UUUV�C���Z�\nu�V\$?M@U�WJ\r\rU��\\�'U�W]�W��W8�N�'#h=oC���F(��:9�Yu����V-U�9�]�C�:U�\\�\n�qW���(TT?5P�\$ R3�⺟C}`>\0�E]�#R��	��#R�)�W���:`#�G�)4�R��;��ViD%8�)Ǔ^�Q��#�h	�HX	��\$N�x��#i x�ԒXR��'�9`m\\���\nE��Q�`�bu@��N�dT�#YY����GV�]j5#?L�xt/#���#酽O�P��Q��6����^� �������M\\R5t�Ӛp�*��X�V\"W�D�	oRALm\rdG�N	����6�p\$�P废E5����Tx\n�+��C[��V�����8U�Du}ػF\$.��Q-;4Ȁ�NX\n�.X�b͐�\0�b�)�#�N�G4K��ZS�^״M�8��d�\"C��>��dHe\n�Y8���.� ���ҏF�D��W1cZ6��Q�KH�@*\0�^���\\Q�F�4U3Y|�=�Ӥ�E��ۤ�?-�47Y�Pm�hYw_\r�VeױM���ُe(0��F�\r�!�PUI�u�7Q�C�ю?0����gu\rqधY-Q�����=g\0�\0M#�U�S5Zt�֟ae^�\$>�ArV�_\r;t���HW�Z�@H��hzD��\0�S2J� HI�O�'ǁe�g�6�[�R�<�?� /��KM����\n>��H�Z!i����TX6���i�C !ӛg�� �G }Q6��4>�w�!ڙC}�VB�>�UQڑj�8c�U�T���'<�>����HC]�V��7jj3v���`0���23����x�@U�k�\n�:Si5��#Y�-w����M?c��MQ�GQ�уb`��\0�@��ҧ\0M��)ZrKX�֟�Wl������l�TM�D\r4�QsS�40�sQ́�mY�h�d��C`{�V�gE�\n��XkՁ�'��,4���^��6�#<4��NXnM):��OM_6d�������[\"KU�n��?l�x\0&\0�R56�T~>��ո?�Jn��� ��Z/i�6���glͦ�U��F}�.����JL�CTbM�4��cL�TjSD�}Jt���Z����:�L���d:�Ez�ʤ�>��V\$2>����[�p�6��R�9u�W.?�1��RHu���R�?58Ԯ��D��u���p�c�Z�?�r׻ Eaf��}5wY���ϒ���W�wT[Sp7'�_aEk�\"[/i��#�\$;m�fأWO����F�\r%\$�ju-t#<�!�\n:�KEA����]�\nU�Q�KE��#��X��5[�>�`/��D��֭VEp�)��I%�q���n�x):��le���[e�\\�eV[j�����7 -+��G�WEwt�WkE�~u�Q/m�#ԐW�`�yu�ǣD�A�'ױ\r��ՙO�D )ZM^��u-|v8]�g��h���L��W\0���6�X��=Y�d�Q�7ϓ��9����r <�֏�D��B`c�9���`�D�=wx�I%�,ᄬ�����j[њ����O��� ``��|�����������.�	AO���	��@�@ 0h2�\\�ЀM{e�9^>���@7\0��˂W���\$,��Ś�@؀����w^fm�,\0�yD,ם^X�.�ֆ�7����2��f;��6�\n����^�zC�קmz��n�^���&LFF�,��[��e��aXy9h�!:z�9c�Q9b� !���Gw_W�g�9���S+t���p�tɃ\nm+����_�	��\\���k5���]�4�_h�9 ��N����]%|��7�֜�];��|���X��9�|����G���[��\0�}U���MC�I:�qO�Vԃa\0\r�R�6π�\0�@H��P+r�S�W���p7�I~�p/��H�^������E�-%��̻�&.��+�Jђ;:���!���N�	�~����/�W��!�B�L+�\$��q�=��+�`/Ƅe�\\���x�pE�lpS�JS�ݢ��6��_�(ů���b\\O��&�\\�59�\0�9n���D�{�\$���K��v2	d]�v�C�����?�tf|W�:���p&��Ln��賞�{;���G�R9��T.y���I8���\rl� �	T��n�3���T.�9��3����Z�s����G����:	0���z��.�]��ģQ�?�gT�%��x�Ռ.����n<�-�8B˳,B��rgQ�����Ɏ`��2�:{�g��s��g�Z��� ׌<��w{���bU9�	`5`4�\0BxMp�8qnah�@ؼ�-�(�>S|0�����3�8h\0���C�zLQ�@�\n?��`A��>2��,���N�&��x�l8sah1�|�B�ɇD�xB�#V��V�׊`W�a'@���	X_?\n�  �_�. �P�r2�bUar�I�~��S���\0ׅ\"�2����>b;�vPh{[�7a`�\0�˲j�o�~���v��|fv�4[�\$��{�P\rv�BKGbp������O�5ݠ2\0j�لL���)�m��V�ejBB.'R{C��V'`؂ ��%�ǀ�\$�O��\0�`����4 �N�>;4���/�π��*��\\5���!��`X*�%��N�3S�AM���Ɣ,�1����\\��caϧ ��@��˃�B/����0`�v2��`hD�JO\$�@p!9�!�\n1�7pB,>8F4��f�π:��7���3��3����T8�=+~�n���\\�e�<br����Fز� ��C�N�:c�:�l�<\r��\\3�>���6�ONn��!;��@�tw�^F�L�;���,^a��\ra\"��ڮ'�:�v�Je4�א;��_d\r4\r�:����S�����2��[c��X�ʦPl�\$�ޣ�i�w�d#�B��b��������`:���~ <\0�2����R���P�\r�J8D�t@�E��\0\r͜6����7����Y���\"����\r�����3��.�+�z3�;_ʟvL����wJ�94�I�Ja,A����;�s?�N\nR��!��ݐ�Om�s�_��-zۭw���zܭ7���z���M����o����\0��a��ݹ4�8�Pf�Y�?��i��eB�S�1\0�jDTeK��UYS�?66R	�c�6Ry[c���5�]B͔�R�_eA)&�[凕XYRW�6VYaeU�fYe�w��U�b�w�E�ʆ;z�^W�9��ק�ݖ��\0<ޘ�e�9S���da�	�_-��L�8ǅ�Q��TH[!<p\0��Py5�|�#��P�	�9v��2�|Ǹ��fao��,j8�\$A@k����a���b�c��f4!4���cr,;�����b�=��;\0��ź���cd��X�b�x�a�Rx0A�h�+w�xN[��B��p���w�T�8T%��M�l2�������}��s.kY��0\$/�fU�=��s�gK���M� �?���`4c.��!�&�分g��f�/�f1�=��V AE<#̹�f\n�)���Np��`.\"\"�A�����q��X��٬:a�8��f��Vs�G��r�:�V��c�g�Vl��g=��`��W���y�gU��˙�Ẽ�eT=�����x 0� M�@����%κb���w��f��O�筘�*0���|t�%��P��p��gK���?p�@J�<Bٟ#�`1��9�2�g�!3~����nl��f��Vh���.����aC���?���-�1�68>A��a�\r��y�0��i�J�}�������z:\r�)�S���@��h@���Y���mCEg�cyφ��<���h@�@�zh<W��`��:zO���\r��W���V08�f7�(Gy���`St#��f�#����C(9���؀d���8T:���0�� q���79��phAg�6�.��7Fr�b� �j��A5��a1��h�ZCh:�%��gU��D9��Ɉ�׹��0~vTi;�VvS��w��\r΃?��f�����n�ϛiY��a��3�·9�,\n��r��,/,@.:�Y>&��F�)�����}�b���iO�i��:d�A�n��c=�L9O�h{�� 8hY.������������\r��և�����1Q�U	�C�h��e�O���+2o����N�����zp�(�]�h��Z|�O�c�zD���;�T\0j�\0�8#�>Ύ�=bZ8Fj���;�޺T酡w��)���N`���ÅB{��z\r�c���|dTG�i�/��!i��0���'`Z:�CH�(8�`V������\0�ꧩ��W��Ǫ��zgG������-[��	i��N\rq��n���o	ƥfEJ��apb��}6���=o���,t�Y+��EC\r�Px4=����@���.��F��[�zq���X6:FG��#��\$@&�ab��hE:����`�S�1�1g1���2uhY��_:Bߡdc�*���\0�ƗFYF�:���n���=ۨH*Z�Mhk�/�냡�zٹ]��h@����1\0��ZK�������^+�,vf�s��>���O�|���s�\0֜5�X��ѯF��n�A�r]|�Ii4�� ��C� h@ع����cߥ�6smO������gX�V2�6g?~��Y�Ѱ�s�cl \\R�\0��c��A+�1������\n(����^368cz:=z��(�� ;裨�s�F�@`;�,>yT��&��d�Lן��%��-�CHL8\r��b�����Mj]4�Ym9����Z�B��P}<���X���̥�+g�^�M� + B_Fd�X���l�w�~�\r⽋�\":��qA1X������3�ΓE�h�4�ZZ��&����1~!N�f��o���\nMe�଄��XI΄�G@V*X��;�Y5{V�\n���T�z\rF�3}m��p1�[�>�t�e�w����@V�z#��2��	i���{�9��p̝�gh���+[elU���A�ٶӼi1�!��omm�*K���}��!�Ƴ����{me�f`��m��C�z=�n�:}g� T�mLu1F��}=8�Z���O��mFFMf��OO����������/����ޓ���V�oqj���n!+����Z��I�.�9!nG�\\��3a�~�O+��::�K@�\n�@���Hph��\\B��dm�fvC���P�\" ��.nW&��n��HY�+\r���z�i>Mfqۤ��Qc�[�H+��o��*�1'��#āEw�D_X�)>�s��-~\rT=�������- �y�m����{�h��j�M�)�^����'@V�+i�������;F��D[�b!����B	��:MP���ۭoC�vAE?�C�IiY��#�p�P\$k�J�q�.�07���x�l�sC|���bo�2�X�>M�\rl&��:2�~��cQ����o��d�-��U�Ro�Y�nM;�n�#��\0�P�f��Po׿(C�v<���[�o۸����fѿ���;�ẖ�[�Y�.o�Up���pU���.���B!'\0���<T�:1�������<���n��F���I�ǔ��V0�ǁRO8�w��,aF��ɥ�[�Ο��YO����/\0��ox���Q�?��:ً���`h@:�����/M�m�x:۰c1������v�;���^���@��@�����\n{�����;���B���8�� g坒�\\*g�yC)��E�^�O�h	���A�u>���@�D��Y�����`o�<>��p���ķ�q,Y1Q��߸��/qg�\0+\0���D���?�� ����k:�\$����ץ6~I��=@���!��v�zO񁚲�+���9�i����a������g������?��0Gn�q�]{Ҹ,F���O���� <_>f+��,��	���&�����·�y�ǩO�:�U¯�L�\n�úI:2��-;_Ģ�|%�崿!��f�\$���Xr\"Kni����\$8#�g�t-��r@L�圏�@S�<�rN\n�D/rLdQk࣓�����e����Э��\n=4)�B���ך�");
  } else {
    header("Content-Type: image/gif");
    switch ($_GET["file"]) {
      case "plus.gif":
        echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";
      break;
      case "cross.gif":
        echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";
      break;
      case "up.gif":
        echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";
      break;
      case "down.gif":
        echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";
      break;
      case "arrow.gif":
        echo "GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";
      break;
    }
  }
  exit;
}
if ($_GET["script"] == "version") {
  $p = file_open_lock(get_temp_dir() . "/adminer.version");
  if ($p) file_write_unlock($p, serialize(array(
    "signature" => $_POST["signature"],
    "version" => $_POST["version"]
  )));
  exit;
}
global $b, $e, $j, $Ib, $Pb, $Zb, $k, $Cc, $Gc, $ba, $Zc, $y, $ca, $pd, $le, $Pe, $fg, $Lc, $T, $Ng, $Tg, $ah, $ga;
if (!$_SERVER["REQUEST_URI"]) $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
  session_cache_limiter("");
  session_name("adminer_sid");
  $Ge = array(
    0,
    preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) ,
    "",
    $ba
  );
  if (version_compare(PHP_VERSION, '5.2.0') >= 0) $Ge[] = true;
  call_user_func_array('session_set_cookie_params', $Ge);
  session_start();
}
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE
) , $tc);
if (get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
function get_lang() {
  return 'en';
}
function lang($Mg, $ce = null) {
  if (is_array($Mg)) {
    $Se = ($ce == 1 ? 0 : 1);
    $Mg = $Mg[$Se];
  }
  $Mg = str_replace("%d", "%s", $Mg);
  $ce = format_number($ce);
  return sprintf($Mg, $ce);
}
if (extension_loaded('pdo')) {
  class Min_PDO extends PDO {
    var $_result, $server_info, $affected_rows, $errno, $error;
    function __construct() {
      global $b;
      $Se = array_search("SQL", $b->operators);
      if ($Se !== false) unset($b->operators[$Se]);
    }
    function dsn($Mb, $V, $G, $re = array()) {
      try {
        parent::__construct($Mb, $V, $G, $re);
      }
      catch(Exception $ec) {
        auth_error(h($ec->getMessage()));
      }
      $this->setAttribute(13, array(
        'Min_PDOStatement'
      ));
      $this->server_info = @$this->getAttribute(4);
    }
    function query($I, $Ug = false) {
      $J = parent::query($I);
      $this->error = "";
      if (!$J) {
        list(, $this->errno, $this->error) = $this->errorInfo();
        if (!$this->error) $this->error = 'Unknown error.';
        return false;
      }
      $this->store_result($J);
      return $J;
    }
    function multi_query($I) {
      return $this->_result = $this->query($I);
    }
    function store_result($J = null) {
      if (!$J) {
        $J = $this->_result;
        if (!$J) return false;
      }
      if ($J->columnCount()) {
        $J->num_rows = $J->rowCount();
        return $J;
      }
      $this->affected_rows = $J->rowCount();
      return true;
    }
    function next_result() {
      if (!$this->_result) return false;
      $this
        ->_result->_offset = 0;
      return @$this
        ->_result
        ->nextRowset();
    }
    function result($I, $l = 0) {
      $J = $this->query($I);
      if (!$J) return false;
      $L = $J->fetch();
      return $L[$l];
    }
  }
  class Min_PDOStatement extends PDOStatement {
    var $_offset = 0, $num_rows;
    function fetch_assoc() {
      return $this->fetch(2);
    }
    function fetch_row() {
      return $this->fetch(3);
    }
    function fetch_field() {
      $L = (object)$this->getColumnMeta($this->_offset++);
      $L->orgtable = $L->table;
      $L->orgname = $L->name;
      $L->charsetnr = (in_array("blob", (array)$L->flags) ? 63 : 0);
      return $L;
    }
  }
}
$Ib = array();
class Min_SQL {
  var $_conn;
  function __construct($e) {
    $this->_conn = $e;
  }
  function select($Q, $N, $Z, $s, $te = array() , $_ = 1, $F = 0, $Ze = false) {
    global $b, $y;
    $gd = (count($s) < count($N));
    $I = $b->selectQueryBuild($N, $Z, $s, $te, $_, $F);
    if (!$I) $I = "SELECT" . limit(($_GET["page"] != "last" && $_ != "" && $s && $gd && $y == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $N) . "\nFROM " . table($Q) , ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($s && $gd ? "\nGROUP BY " . implode(", ", $s) : "") . ($te ? "\nORDER BY " . implode(", ", $te) : "") , ($_ != "" ? +$_ : null) , ($F ? $_ * $F : 0) , "\n");
    $ag = microtime(true);
    $K = $this->_conn->query($I);
    if ($Ze) echo $b->selectQuery($I, $ag, !$K);
    return $K;
  }
  function delete($Q, $hf, $_ = 0) {
    $I = "FROM " . table($Q);
    return queries("DELETE" . ($_ ? limit1($Q, $I, $hf) : " $I$hf"));
  }
  function update($Q, $P, $hf, $_ = 0, $Kf = "\n") {
    $kh = array();
    foreach ($P as $z => $X) $kh[] = "$z = $X";
    $I = table($Q) . " SET$Kf" . implode(",$Kf", $kh);
    return queries("UPDATE" . ($_ ? limit1($Q, $I, $hf, $Kf) : " $I$hf"));
  }
  function insert($Q, $P) {
    return queries("INSERT INTO " . table($Q) . ($P ? " (" . implode(", ", array_keys($P)) . ")\nVALUES (" . implode(", ", $P) . ")" : " DEFAULT VALUES"));
  }
  function insertUpdate($Q, $M, $Ye) {
    return false;
  }
  function begin() {
    return queries("BEGIN");
  }
  function commit() {
    return queries("COMMIT");
  }
  function rollback() {
    return queries("ROLLBACK");
  }
  function slowQuery($I, $Ag) {
  }
  function convertSearch($Tc, $X, $l) {
    return $Tc;
  }
  function value($X, $l) {
    return (method_exists($this->_conn, 'value') ? $this->_conn->value($X, $l) : (is_resource($X) ? stream_get_contents($X) : $X));
  }
  function quoteBinary($Bf) {
    return q($Bf);
  }
  function warnings() {
    return '';
  }
  function tableHelp($E) {
  }
}
$Ib = array(
  "server" => "MySQL"
) + $Ib;
if (!defined("DRIVER")) {
  $Ve = array(
    "MySQLi",
    "MySQL",
    "PDO_MySQL"
  );
  define("DRIVER", "server");
  if (extension_loaded("mysqli")) {
    class Min_DB extends MySQLi {
      var $extension = "MySQLi";
      function __construct() {
        parent::init();
      }
      function connect($O = "", $V = "", $G = "", $tb = null, $Re = null, $Tf = null) {
        global $b;
        mysqli_report(MYSQLI_REPORT_OFF);
        list($Qc, $Re) = explode(":", $O, 2);
        $Zf = $b->connectSsl();
        if ($Zf) $this->ssl_set($Zf['key'], $Zf['cert'], $Zf['ca'], '', '');
        $K = @$this->real_connect(($O != "" ? $Qc : ini_get("mysqli.default_host")) , ($O . $V != "" ? $V : ini_get("mysqli.default_user")) , ($O . $V . $G != "" ? $G : ini_get("mysqli.default_pw")) , $tb, (is_numeric($Re) ? $Re : ini_get("mysqli.default_port")) , (!is_numeric($Re) ? $Re : $Tf) , ($Zf ? 64 : 0));
        $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
        return $K;
      }
      function set_charset($La) {
        if (parent::set_charset($La)) return true;
        parent::set_charset('utf8');
        return $this->query("SET NAMES $La");
      }
      function result($I, $l = 0) {
        $J = $this->query($I);
        if (!$J) return false;
        $L = $J->fetch_array();
        return $L[$l];
      }
      function quote($eg) {
        return "'" . $this->escape_string($eg) . "'";
      }
    }
  }
  elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
    class Min_DB {
      var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;
      function connect($O, $V, $G) {
        if (ini_bool("mysql.allow_local_infile")) {
          $this->error = sprintf('Disable %s or enable %s or %s extensions.', "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
          return false;
        }
        $this->_link = @mysql_connect(($O != "" ? $O : ini_get("mysql.default_host")) , ("$O$V" != "" ? $V : ini_get("mysql.default_user")) , ("$O$V$G" != "" ? $G : ini_get("mysql.default_password")) , true, 131072);
        if ($this->_link) $this->server_info = mysql_get_server_info($this->_link);
        else $this->error = mysql_error();
        return (bool)$this->_link;
      }
      function set_charset($La) {
        if (function_exists('mysql_set_charset')) {
          if (mysql_set_charset($La, $this->_link)) return true;
          mysql_set_charset('utf8', $this->_link);
        }
        return $this->query("SET NAMES $La");
      }
      function quote($eg) {
        return "'" . mysql_real_escape_string($eg, $this->_link) . "'";
      }
      function select_db($tb) {
        return mysql_select_db($tb, $this->_link);
      }
      function query($I, $Ug = false) {
        $J = @($Ug ? mysql_unbuffered_query($I, $this->_link) : mysql_query($I, $this->_link));
        $this->error = "";
        if (!$J) {
          $this->errno = mysql_errno($this->_link);
          $this->error = mysql_error($this->_link);
          return false;
        }
        if ($J === true) {
          $this->affected_rows = mysql_affected_rows($this->_link);
          $this->info = mysql_info($this->_link);
          return true;
        }
        return new Min_Result($J);
      }
      function multi_query($I) {
        return $this->_result = $this->query($I);
      }
      function store_result() {
        return $this->_result;
      }
      function next_result() {
        return false;
      }
      function result($I, $l = 0) {
        $J = $this->query($I);
        if (!$J || !$J->num_rows) return false;
        return mysql_result($J->_result, 0, $l);
      }
    }
    class Min_Result {
      var $num_rows, $_result, $_offset = 0;
      function __construct($J) {
        $this->_result = $J;
        $this->num_rows = mysql_num_rows($J);
      }
      function fetch_assoc() {
        return mysql_fetch_assoc($this->_result);
      }
      function fetch_row() {
        return mysql_fetch_row($this->_result);
      }
      function fetch_field() {
        $K = mysql_fetch_field($this->_result, $this->_offset++);
        $K->orgtable = $K->table;
        $K->orgname = $K->name;
        $K->charsetnr = ($K->blob ? 63 : 0);
        return $K;
      }
      function __destruct() {
        mysql_free_result($this->_result);
      }
    }
  }
  elseif (extension_loaded("pdo_mysql")) {
    class Min_DB extends Min_PDO {
      var $extension = "PDO_MySQL";
      function connect($O, $V, $G) {
        global $b;
        $re = array(
          PDO::MYSQL_ATTR_LOCAL_INFILE => false
        );
        $Zf = $b->connectSsl();
        if ($Zf) {
          if (!empty($Zf['key'])) $re[PDO::MYSQL_ATTR_SSL_KEY] = $Zf['key'];
          if (!empty($Zf['cert'])) $re[PDO::MYSQL_ATTR_SSL_CERT] = $Zf['cert'];
          if (!empty($Zf['ca'])) $re[PDO::MYSQL_ATTR_SSL_CA] = $Zf['ca'];
        }
        $this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $O)) , $V, $G, $re);
        return true;
      }
      function set_charset($La) {
        $this->query("SET NAMES $La");
      }
      function select_db($tb) {
        return $this->query("USE " . idf_escape($tb));
      }
      function query($I, $Ug = false) {
        $this->setAttribute(1000, !$Ug);
        return parent::query($I, $Ug);
      }
    }
  }
  class Min_Driver extends Min_SQL {
    function insert($Q, $P) {
      return ($P ? parent::insert($Q, $P) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
    }
    function insertUpdate($Q, $M, $Ye) {
      $d = array_keys(reset($M));
      $We = "INSERT INTO " . table($Q) . " (" . implode(", ", $d) . ") VALUES\n";
      $kh = array();
      foreach ($d as $z) $kh[$z] = "$z = VALUES($z)";
      $ig = "\nON DUPLICATE KEY UPDATE " . implode(", ", $kh);
      $kh = array();
      $wd = 0;
      foreach ($M as $P) {
        $Y = "(" . implode(", ", $P) . ")";
        if ($kh && (strlen($We) + $wd + strlen($Y) + strlen($ig) > 1e6)) {
          if (!queries($We . implode(",\n", $kh) . $ig)) return false;
          $kh = array();
          $wd = 0;
        }
        $kh[] = $Y;
        $wd += strlen($Y) + 2;
      }
      return queries($We . implode(",\n", $kh) . $ig);
    }
    function slowQuery($I, $Ag) {
      if (min_version('5.7.8', '10.1.2')) {
        if (preg_match('~MariaDB~', $this
          ->_conn
          ->server_info)) return "SET STATEMENT max_statement_time=$Ag FOR $I";
        elseif (preg_match('~^(SELECT\b)(.+)~is', $I, $C)) return "$C[1] /*+ MAX_EXECUTION_TIME(" . ($Ag * 1000) . ") */ $C[2]";
      }
    }
    function convertSearch($Tc, $X, $l) {
      return (preg_match('~char|text|enum|set~', $l["type"]) && !preg_match("~^utf8~", $l["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($Tc USING " . charset($this->_conn) . ")" : $Tc);
    }
    function warnings() {
      $J = $this
        ->_conn
        ->query("SHOW WARNINGS");
      if ($J && $J->num_rows) {
        ob_start();
        select($J);
        return ob_get_clean();
      }
    }
    function tableHelp($E) {
      $Bd = preg_match('~MariaDB~', $this
        ->_conn
        ->server_info);
      if (information_schema(DB)) return strtolower(($Bd ? "information-schema-$E-table/" : str_replace("_", "-", $E) . "-table.html"));
      if (DB == "mysql") return ($Bd ? "mysql$E-table/" : "system-database.html");
    }
  }
  function idf_escape($Tc) {
    return "`" . str_replace("`", "``", $Tc) . "`";
  }
  function table($Tc) {
    return idf_escape($Tc);
  }
  function connect() {
    global $b, $Tg, $fg;
    $e = new Min_DB;
    $mb = $b->credentials();
    if ($e->connect($mb[0], $mb[1], $mb[2])) {
      $e->set_charset(charset($e));
      $e->query("SET sql_quote_show_create = 1, autocommit = 1");
      if (min_version('5.7.8', 10.2, $e)) {
        $fg['Strings'][] = "json";
        $Tg["json"] = 4294967295;
      }
      return $e;
    }
    $K = $e->error;
    if (function_exists('iconv') && !is_utf8($K) && strlen($Bf = iconv("windows-1250", "utf-8", $K)) > strlen($K)) $K = $Bf;
    return $K;
  }
  function get_databases($vc) {
    $K = get_session("dbs");
    if ($K === null) {
      $I = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
      $K = ($vc ? slow_query($I) : get_vals($I));
      restart_session();
      set_session("dbs", $K);
      stop_session();
    }
    return $K;
  }
  function limit($I, $Z, $_, $ee = 0, $Kf = " ") {
    return " $I$Z" . ($_ !== null ? $Kf . "LIMIT $_" . ($ee ? " OFFSET $ee" : "") : "");
  }
  function limit1($Q, $I, $Z, $Kf = "\n") {
    return limit($I, $Z, 1, 0, $Kf);
  }
  function db_collation($i, $Xa) {
    global $e;
    $K = null;
    $g = $e->result("SHOW CREATE DATABASE " . idf_escape($i) , 1);
    if (preg_match('~ COLLATE ([^ ]+)~', $g, $C)) $K = $C[1];
    elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $g, $C)) $K = $Xa[$C[1]][-1];
    return $K;
  }
  function engines() {
    $K = array();
    foreach (get_rows("SHOW ENGINES") as $L) {
      if (preg_match("~YES|DEFAULT~", $L["Support"])) $K[] = $L["Engine"];
    }
    return $K;
  }
  function logged_user() {
    global $e;
    return $e->result("SELECT USER()");
  }
  function tables_list() {
    return get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
  }
  function count_tables($h) {
    $K = array();
    foreach ($h as $i) $K[$i] = count(get_vals("SHOW TABLES IN " . idf_escape($i)));
    return $K;
  }
  function table_status($E = "", $oc = false) {
    $K = array();
    foreach (get_rows($oc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($E != "" ? "AND TABLE_NAME = " . q($E) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($E != "" ? " LIKE " . q(addcslashes($E, "%_\\")) : "")) as $L) {
      if ($L["Engine"] == "InnoDB") $L["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $L["Comment"]);
      if (!isset($L["Engine"])) $L["Comment"] = "";
      if ($E != "") return $L;
      $K[$L["Name"]] = $L;
    }
    return $K;
  }
  function is_view($R) {
    return $R["Engine"] === null;
  }
  function fk_support($R) {
    return preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
  }
  function fields($Q) {
    $K = array();
    foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $L) {
      preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $L["Type"], $C);
      $K[$L["Field"]] = array(
        "field" => $L["Field"],
        "full_type" => $L["Type"],
        "type" => $C[1],
        "length" => $C[2],
        "unsigned" => ltrim($C[3] . $C[4]) ,
        "default" => ($L["Default"] != "" || preg_match("~char|set~", $C[1]) ? $L["Default"] : null) ,
        "null" => ($L["Null"] == "YES") ,
        "auto_increment" => ($L["Extra"] == "auto_increment") ,
        "on_update" => (preg_match('~^on update (.+)~i', $L["Extra"], $C) ? $C[1] : "") ,
        "collation" => $L["Collation"],
        "privileges" => array_flip(preg_split('~, *~', $L["Privileges"])) ,
        "comment" => $L["Comment"],
        "primary" => ($L["Key"] == "PRI") ,
        "generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $L["Extra"]) ,
      );
    }
    return $K;
  }
  function indexes($Q, $f = null) {
    $K = array();
    foreach (get_rows("SHOW INDEX FROM " . table($Q) , $f) as $L) {
      $E = $L["Key_name"];
      $K[$E]["type"] = ($E == "PRIMARY" ? "PRIMARY" : ($L["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($L["Non_unique"] ? ($L["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
      $K[$E]["columns"][] = $L["Column_name"];
      $K[$E]["lengths"][] = ($L["Index_type"] == "SPATIAL" ? null : $L["Sub_part"]);
      $K[$E]["descs"][] = null;
    }
    return $K;
  }
  function foreign_keys($Q) {
    global $e, $le;
    static $Oe = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
    $K = array();
    $kb = $e->result("SHOW CREATE TABLE " . table($Q) , 1);
    if ($kb) {
      preg_match_all("~CONSTRAINT ($Oe) FOREIGN KEY ?\\(((?:$Oe,? ?)+)\\) REFERENCES ($Oe)(?:\\.($Oe))? \\(((?:$Oe,? ?)+)\\)(?: ON DELETE ($le))?(?: ON UPDATE ($le))?~", $kb, $Dd, PREG_SET_ORDER);
      foreach ($Dd as $C) {
        preg_match_all("~$Oe~", $C[2], $Uf);
        preg_match_all("~$Oe~", $C[5], $ug);
        $K[idf_unescape($C[1]) ] = array(
          "db" => idf_unescape($C[4] != "" ? $C[3] : $C[4]) ,
          "table" => idf_unescape($C[4] != "" ? $C[4] : $C[3]) ,
          "source" => array_map('idf_unescape', $Uf[0]) ,
          "target" => array_map('idf_unescape', $ug[0]) ,
          "on_delete" => ($C[6] ? $C[6] : "RESTRICT") ,
          "on_update" => ($C[7] ? $C[7] : "RESTRICT") ,
        );
      }
    }
    return $K;
  }
  function view($E) {
    global $e;
    return array(
      "select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $e->result("SHOW CREATE VIEW " . table($E) , 1))
    );
  }
  function collations() {
    $K = array();
    foreach (get_rows("SHOW COLLATION") as $L) {
      if ($L["Default"]) $K[$L["Charset"]][-1] = $L["Collation"];
      else $K[$L["Charset"]][] = $L["Collation"];
    }
    ksort($K);
    foreach ($K as $z => $X) asort($K[$z]);
    return $K;
  }
  function information_schema($i) {
    return (min_version(5) && $i == "information_schema") || (min_version(5.5) && $i == "performance_schema");
  }
  function error() {
    global $e;
    return h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $e->error));
  }
  function create_database($i, $Wa) {
    return queries("CREATE DATABASE " . idf_escape($i) . ($Wa ? " COLLATE " . q($Wa) : ""));
  }
  function drop_databases($h) {
    $K = apply_queries("DROP DATABASE", $h, 'idf_escape');
    restart_session();
    set_session("dbs", null);
    return $K;
  }
  function rename_database($E, $Wa) {
    $K = false;
    if (create_database($E, $Wa)) {
      $sf = array();
      foreach (tables_list() as $Q => $U) $sf[] = table($Q) . " TO " . idf_escape($E) . "." . table($Q);
      $K = (!$sf || queries("RENAME TABLE " . implode(", ", $sf)));
      if ($K) queries("DROP DATABASE " . idf_escape(DB));
      restart_session();
      set_session("dbs", null);
    }
    return $K;
  }
  function auto_increment() {
    $za = " PRIMARY KEY";
    if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
      foreach (indexes($_GET["create"]) as $v) {
        if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $v["columns"], true)) {
          $za = "";
          break;
        }
        if ($v["type"] == "PRIMARY") $za = " UNIQUE";
      }
    }
    return " AUTO_INCREMENT$za";
  }
  function alter_table($Q, $E, $m, $xc, $bb, $Xb, $Wa, $ya, $Ke) {
    $sa = array();
    foreach ($m as $l) $sa[] = ($l[1] ? ($Q != "" ? ($l[0] != "" ? "CHANGE " . idf_escape($l[0]) : "ADD") : " ") . " " . implode($l[1]) . ($Q != "" ? $l[2] : "") : "DROP " . idf_escape($l[0]));
    $sa = array_merge($sa, $xc);
    $bg = ($bb !== null ? " COMMENT=" . q($bb) : "") . ($Xb ? " ENGINE=" . q($Xb) : "") . ($Wa ? " COLLATE " . q($Wa) : "") . ($ya != "" ? " AUTO_INCREMENT=$ya" : "");
    if ($Q == "") return queries("CREATE TABLE " . table($E) . " (\n" . implode(",\n", $sa) . "\n)$bg$Ke");
    if ($Q != $E) $sa[] = "RENAME TO " . table($E);
    if ($bg) $sa[] = ltrim($bg);
    return ($sa || $Ke ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $sa) . $Ke) : true);
  }
  function alter_indexes($Q, $sa) {
    foreach ($sa as $z => $X) $sa[$z] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
    return queries("ALTER TABLE " . table($Q) . implode(",", $sa));
  }
  function truncate_tables($S) {
    return apply_queries("TRUNCATE TABLE", $S);
  }
  function drop_views($ph) {
    return queries("DROP VIEW " . implode(", ", array_map('table', $ph)));
  }
  function drop_tables($S) {
    return queries("DROP TABLE " . implode(", ", array_map('table', $S)));
  }
  function move_tables($S, $ph, $ug) {
    $sf = array();
    foreach (array_merge($S, $ph) as $Q) $sf[] = table($Q) . " TO " . idf_escape($ug) . "." . table($Q);
    return queries("RENAME TABLE " . implode(", ", $sf));
  }
  function copy_tables($S, $ph, $ug) {
    queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
    foreach ($S as $Q) {
      $E = ($ug == DB ? table("copy_$Q") : idf_escape($ug) . "." . table($Q));
      if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $E")) || !queries("CREATE TABLE $E LIKE " . table($Q)) || !queries("INSERT INTO $E SELECT * FROM " . table($Q))) return false;
      foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L) {
        $Og = $L["Trigger"];
        if (!queries("CREATE TRIGGER " . ($ug == DB ? idf_escape("copy_$Og") : idf_escape($ug) . "." . idf_escape($Og)) . " $L[Timing] $L[Event] ON $E FOR EACH ROW\n$L[Statement];")) return false;
      }
    }
    foreach ($ph as $Q) {
      $E = ($ug == DB ? table("copy_$Q") : idf_escape($ug) . "." . table($Q));
      $oh = view($Q);
      if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $E")) || !queries("CREATE VIEW $E AS $oh[select]")) return false;
    }
    return true;
  }
  function trigger($E) {
    if ($E == "") return array();
    $M = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($E));
    return reset($M);
  }
  function triggers($Q) {
    $K = array();
    foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $L) $K[$L["Trigger"]] = array(
      $L["Timing"],
      $L["Event"]
    );
    return $K;
  }
  function trigger_options() {
    return array(
      "Timing" => array(
        "BEFORE",
        "AFTER"
      ) ,
      "Event" => array(
        "INSERT",
        "UPDATE",
        "DELETE"
      ) ,
      "Type" => array(
        "FOR EACH ROW"
      ) ,
    );
  }
  function routine($E, $U) {
    global $e, $Zb, $Zc, $Tg;
    $qa = array(
      "bool",
      "boolean",
      "integer",
      "double precision",
      "real",
      "dec",
      "numeric",
      "fixed",
      "national char",
      "national varchar"
    );
    $Vf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
    $Sg = "((" . implode("|", array_merge(array_keys($Tg) , $qa)) . ")\\b(?:\\s*\\(((?:[^'\")]|$Zb)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
    $Oe = "$Vf*(" . ($U == "FUNCTION" ? "" : $Zc) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Sg";
    $g = $e->result("SHOW CREATE $U " . idf_escape($E) , 2);
    preg_match("~\\(((?:$Oe\\s*,?)*)\\)\\s*" . ($U == "FUNCTION" ? "RETURNS\\s+$Sg\\s+" : "") . "(.*)~is", $g, $C);
    $m = array();
    preg_match_all("~$Oe\\s*,?~is", $C[1], $Dd, PREG_SET_ORDER);
    foreach ($Dd as $Fe) $m[] = array(
      "field" => str_replace("``", "`", $Fe[2]) . $Fe[3],
      "type" => strtolower($Fe[5]) ,
      "length" => preg_replace_callback("~$Zb~s", 'normalize_enum', $Fe[6]) ,
      "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Fe[8] $Fe[7]"))) ,
      "null" => 1,
      "full_type" => $Fe[4],
      "inout" => strtoupper($Fe[1]) ,
      "collation" => strtolower($Fe[9]) ,
    );
    if ($U != "FUNCTION") return array(
      "fields" => $m,
      "definition" => $C[11]
    );
    return array(
      "fields" => $m,
      "returns" => array(
        "type" => $C[12],
        "length" => $C[13],
        "unsigned" => $C[15],
        "collation" => $C[16]
      ) ,
      "definition" => $C[17],
      "language" => "SQL",
    );
  }
  function routines() {
    return get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
  }
  function routine_languages() {
    return array();
  }
  function routine_id($E, $L) {
    return idf_escape($E);
  }
  function last_id() {
    global $e;
    return $e->result("SELECT LAST_INSERT_ID()");
  }
  function explain($e, $I) {
    return $e->query("EXPLAIN " . (min_version(5.1) ? "PARTITIONS " : "") . $I);
  }
  function found_rows($R, $Z) {
    return ($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
  }
  function types() {
    return array();
  }
  function schemas() {
    return array();
  }
  function get_schema() {
    return "";
  }
  function set_schema($Df, $f = null) {
    return true;
  }
  function create_sql($Q, $ya, $gg) {
    global $e;
    $K = $e->result("SHOW CREATE TABLE " . table($Q) , 1);
    if (!$ya) $K = preg_replace('~ AUTO_INCREMENT=\d+~', '', $K);
    return $K;
  }
  function truncate_sql($Q) {
    return "TRUNCATE " . table($Q);
  }
  function use_sql($tb) {
    return "USE " . idf_escape($tb);
  }
  function trigger_sql($Q) {
    $K = "";
    foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")) , null, "-- ") as $L) $K .= "\nCREATE TRIGGER " . idf_escape($L["Trigger"]) . " $L[Timing] $L[Event] ON " . table($L["Table"]) . " FOR EACH ROW\n$L[Statement];;\n";
    return $K;
  }
  function show_variables() {
    return get_key_vals("SHOW VARIABLES");
  }
  function process_list() {
    return get_rows("SHOW FULL PROCESSLIST");
  }
  function show_status() {
    return get_key_vals("SHOW STATUS");
  }
  function convert_field($l) {
    if (preg_match("~binary~", $l["type"])) return "HEX(" . idf_escape($l["field"]) . ")";
    if ($l["type"] == "bit") return "BIN(" . idf_escape($l["field"]) . " + 0)";
    if (preg_match("~geometry|point|linestring|polygon~", $l["type"])) return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($l["field"]) . ")";
  }
  function unconvert_field($l, $K) {
    if (preg_match("~binary~", $l["type"])) $K = "UNHEX($K)";
    if ($l["type"] == "bit") $K = "CONV($K, 2, 10) + 0";
    if (preg_match("~geometry|point|linestring|polygon~", $l["type"])) $K = (min_version(8) ? "ST_" : "") . "GeomFromText($K, SRID($l[field]))";
    return $K;
  }
  function support($pc) {
    return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $pc);
  }
  function kill_process($X) {
    return queries("KILL " . number($X));
  }
  function connection_id() {
    return "SELECT CONNECTION_ID()";
  }
  function max_connections() {
    global $e;
    return $e->result("SELECT @@max_connections");
  }
  $y = "sql";
  $Tg = array();
  $fg = array();
  foreach (array(
    'Numbers' => array(
      "tinyint" => 3,
      "smallint" => 5,
      "mediumint" => 8,
      "int" => 10,
      "bigint" => 20,
      "decimal" => 66,
      "float" => 12,
      "double" => 21
    ) ,
    'Date and time' => array(
      "date" => 10,
      "datetime" => 19,
      "timestamp" => 19,
      "time" => 10,
      "year" => 4
    ) ,
    'Strings' => array(
      "char" => 255,
      "varchar" => 65535,
      "tinytext" => 255,
      "text" => 65535,
      "mediumtext" => 16777215,
      "longtext" => 4294967295
    ) ,
    'Lists' => array(
      "enum" => 65535,
      "set" => 64
    ) ,
    'Binary' => array(
      "bit" => 20,
      "binary" => 255,
      "varbinary" => 65535,
      "tinyblob" => 255,
      "blob" => 65535,
      "mediumblob" => 16777215,
      "longblob" => 4294967295
    ) ,
    'Geometry' => array(
      "geometry" => 0,
      "point" => 0,
      "linestring" => 0,
      "polygon" => 0,
      "multipoint" => 0,
      "multilinestring" => 0,
      "multipolygon" => 0,
      "geometrycollection" => 0
    ) ,
  ) as $z => $X) {
    $Tg += $X;
    $fg[$z] = array_keys($X);
  }
  $ah = array(
    "unsigned",
    "zerofill",
    "unsigned zerofill"
  );
  $pe = array(
    "=",
    "<",
    ">",
    "<=",
    ">=",
    "!=",
    "LIKE",
    "LIKE %%",
    "REGEXP",
    "IN",
    "FIND_IN_SET",
    "IS NULL",
    "NOT LIKE",
    "NOT REGEXP",
    "NOT IN",
    "IS NOT NULL",
    "SQL"
  );
  $Cc = array(
    "char_length",
    "date",
    "from_unixtime",
    "lower",
    "round",
    "floor",
    "ceil",
    "sec_to_time",
    "time_to_sec",
    "upper"
  );
  $Gc = array(
    "avg",
    "count",
    "count distinct",
    "group_concat",
    "max",
    "min",
    "sum"
  );
  $Pb = array(
    array(
      "char" => "md5/sha1/password/encrypt/uuid",
      "binary" => "md5/sha1",
      "date|time" => "now",
    ) ,
    array(
      number_type() => "+/-",
      "date" => "+ interval/- interval",
      "time" => "addtime/subtime",
      "char|text" => "concat",
    )
  );
}
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", str_replace(":", "%3a", preg_replace('~\?.*~', '', relative_uri())) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ga = "4.7.7";
class Adminer {
  var $operators;
  function name() {
    return "<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
  }
  function credentials() {
    return array(
      SERVER,
      $_GET["username"],
      get_password()
    );
  }
  function connectSsl() {
  }
  function permanentLogin($g = false) {
    return password_file($g);
  }
  function bruteForceKey() {
    return $_SERVER["REMOTE_ADDR"];
  }
  function serverName($O) {
    return h($O);
  }
  function database() {
    return DB;
  }
  function databases($vc = true) {
    return get_databases($vc);
  }
  function schemas() {
    return schemas();
  }
  function queryTimeout() {
    return 2;
  }
  function headers() {
  }
  function csp() {
    return csp();
  }
  function head() {
    return true;
  }
  function css() {
    $K = array();
    $sc = "adminer.css";
    if (file_exists($sc)) $K[] = "$sc?v=" . crc32(file_get_contents($sc));
    return $K;
  }
  function loginForm() {
    global $Ib;

    if (is_file('config.php')) {
      require_once('config.php');
    }

    if (defined('DB_HOSTNAME')) {
    	$DB_HOSTNAME = DB_HOSTNAME;
    } else {
    	$DB_HOSTNAME = h(SERVER);
    }

    if (defined('DB_USERNAME')) {
    	$DB_USERNAME = DB_USERNAME;
    } else {
      $DB_USERNAME = h($_GET["username"]);
    }

    if (defined('DB_PASSWORD')) {
    	$DB_PASSWORD = DB_PASSWORD;
    } else {
      $DB_PASSWORD = '';
    }

    if (defined('DB_DATABASE')) {
    	$DB_DATABASE = DB_DATABASE;
    } else {
      $DB_DATABASE = h($_GET["db"]);
    }

    echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('driver', '<tr><th>System<td>', html_select("auth[driver]", $Ib, DRIVER, "loginDriver(this);") . "\n"),
    $this->loginFormField('server', '<tr><th>Server<td>', '<input name="auth[server]" value="' . $DB_HOSTNAME . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"),
    $this->loginFormField('username', '<tr><th>Username<td>', '<input name="auth[username]" id="username" value="' . $DB_USERNAME . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")) ,
    $this->loginFormField('password', '<tr><th>Password<td>', '<input type="password" name="auth[password]" value="' . $DB_PASSWORD . '" autocomplete="current-password">' . "\n"),
    $this->loginFormField('db', '<tr><th>Database<td>', '<input name="auth[db]" value="' . $DB_DATABASE . '" autocapitalize="off">' . "\n"), "</table>\n",
    "<p><input type='submit' value='" . 'Login' . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], 'Permanent login') . "\n";
  }
  function loginFormField($E, $Nc, $Y) {
    return $Nc . $Y;
  }
  function login($_d, $G) {
    if ($G == "") return sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.', target_blank());
    return true;
  }
  function tableName($mg) {
    return h($mg["Name"]);
  }
  function fieldName($l, $te = 0) {
    return '<span title="' . h($l["full_type"]) . '">' . h($l["field"]) . '</span>';
  }
  function selectLinks($mg, $P = "") {
    global $y, $j;
    echo '<p class="links">';
    $zd = array(
      "select" => 'Select data'
    );
    if (support("table") || support("indexes")) $zd["table"] = 'Show structure';
    if (support("table")) {
      if (is_view($mg)) $zd["view"] = 'Alter view';
      else $zd["create"] = 'Alter table';
    }
    if ($P !== null) $zd["edit"] = 'New item';
    $E = $mg["Name"];
    foreach ($zd as $z => $X) echo " <a href='" . h(ME) . "$z=" . urlencode($E) . ($z == "edit" ? $P : "") . "'" . bold(isset($_GET[$z])) . ">$X</a>";
    echo doc_link(array(
      $y => $j->tableHelp($E)
    ) , "?") , "\n";
  }
  function foreignKeys($Q) {
    return foreign_keys($Q);
  }
  function backwardKeys($Q, $lg) {
    return array();
  }
  function backwardKeysPrint($Aa, $L) {
  }
  function selectQuery($I, $ag, $nc = false) {
    global $y, $j;
    $K = "</p>\n";
    if (!$nc && ($sh = $j->warnings())) {
      $u = "warnings";
      $K = ", <a href='#$u'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "$K<div id='$u' class='hidden'>\n$sh</div>\n";
    }
    return "<p><code class='jush-$y'>" . h(str_replace("\n", " ", $I)) . "</code> <span class='time'>(" . format_time($ag) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($I) . "' class='edit-select-sql'>" . '&#x270E; Edit' . "</a>" : "") . $K;
  }
  function sqlCommandQuery($I) {
    return shorten_utf8(trim($I) , 1000);
  }
  function rowDescription($Q) {
    return "";
  }
  function rowDescriptions($M, $yc) {
    return $M;
  }
  function selectLink($X, $l) {
  }
  function selectVal($X, $A, $l, $Ae) {
    $K = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $l["type"]) && !preg_match("~var~", $l["type"]) ? "<code>$X</code>" : $X));
    if (preg_match('~blob|bytea|raw|file~', $l["type"]) && !is_utf8($X)) $K = "<i>" . lang(array(
      '%d byte',
      '%d bytes'
    ) , strlen($Ae)) . "</i>";
    if (preg_match('~json~', $l["type"])) $K = "<code class='jush-js'>$K</code>";
    return ($A ? "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : "") . ">$K</a>" : $K);
  }
  function editVal($X, $l) {
    return $X;
  }
  function tableStructurePrint($m) {
    echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr><th>" . 'Column' . "<td>" . 'Type' . (support("comment") ? "<td>" . 'Comment' : "") . "</thead>\n";
    foreach ($m as $l) {
      echo "<tr" . odd() . "><th>" . h($l["field"]) , "<td><span title='" . h($l["collation"]) . "'>" . h($l["full_type"]) . "</span>", ($l["null"] ? " <i>NULL</i>" : "") , ($l["auto_increment"] ? " <i>" . 'Auto Increment' . "</i>" : "") , (isset($l["default"]) ? " <span title='" . 'Default value' . "'>[<b>" . h($l["default"]) . "</b>]</span>" : "") , (support("comment") ? "<td>" . h($l["comment"]) : "") , "\n";
    }
    echo "</table>\n", "</div>\n";
  }
  function tableIndexesPrint($w) {
    echo "<table cellspacing='0'>\n";
    foreach ($w as $E => $v) {
      ksort($v["columns"]);
      $Ze = array();
      foreach ($v["columns"] as $z => $X) $Ze[] = "<i>" . h($X) . "</i>" . ($v["lengths"][$z] ? "(" . $v["lengths"][$z] . ")" : "") . ($v["descs"][$z] ? " DESC" : "");
      echo "<tr title='" . h($E) . "'><th>$v[type]<td>" . implode(", ", $Ze) . "\n";
    }
    echo "</table>\n";
  }
  function selectColumnsPrint($N, $d) {
    global $Cc, $Gc;
    print_fieldset("select", 'Select', $N);
    $t = 0;
    $N[""] = array();
    foreach ($N as $z => $X) {
      $X = $_GET["columns"][$z];
      $c = select_input(" name='columns[$t][col]'", $d, $X["col"], ($z !== "" ? "selectFieldChange" : "selectAddRow"));
      echo "<div>" . ($Cc || $Gc ? "<select name='columns[$t][fun]'>" . optionlist(array(-1 => ""
      ) + array_filter(array(
        'Functions' => $Cc,
        'Aggregation' => $Gc
      )) , $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($z !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($c)" : $c) . "</div>\n";
      $t++;
    }
    echo "</div></fieldset>\n";
  }
  function selectSearchPrint($Z, $d, $w) {
    print_fieldset("search", 'Search', $Z);
    foreach ($w as $t => $v) {
      if ($v["type"] == "FULLTEXT") {
        echo "<div>(<i>" . implode("</i>, <i>", array_map('h', $v["columns"])) . "</i>) AGAINST", " <input type='search' name='fulltext[$t]' value='" . h($_GET["fulltext"][$t]) . "'>", script("qsl('input').oninput = selectFieldChange;", "") , checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]) , "BOOL") , "</div>\n";
      }
    }
    $Ka = "this.parentNode.firstChild.onchange();";
    foreach (array_merge((array)$_GET["where"], array(
      array()
    )) as $t => $X) {
      if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
        echo "<div>" . select_input(" name='where[$t][col]'", $d, $X["col"], ($X ? "selectFieldChange" : "selectAddRow") , "(" . 'anywhere' . ")") , html_select("where[$t][op]", $this->operators, $X["op"], $Ka) , "<input type='search' name='where[$t][val]' value='" . h($X["val"]) . "'>", script("mixin(qsl('input'), {oninput: function () { $Ka }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", "") , "</div>\n";
      }
    }
    echo "</div></fieldset>\n";
  }
  function selectOrderPrint($te, $d, $w) {
    print_fieldset("sort", 'Sort', $te);
    $t = 0;
    foreach ((array)$_GET["order"] as $z => $X) {
      if ($X != "") {
        echo "<div>" . select_input(" name='order[$t]'", $d, $X, "selectFieldChange") , checkbox("desc[$t]", 1, isset($_GET["desc"][$z]) , 'descending') . "</div>\n";
        $t++;
      }
    }
    echo "<div>" . select_input(" name='order[$t]'", $d, "", "selectAddRow") , checkbox("desc[$t]", 1, false, 'descending') . "</div>\n", "</div></fieldset>\n";
  }
  function selectLimitPrint($_) {
    echo "<fieldset><legend>" . 'Limit' . "</legend><div>";
    echo "<input type='number' name='limit' class='size' value='" . h($_) . "'>", script("qsl('input').oninput = selectFieldChange;", "") , "</div></fieldset>\n";
  }
  function selectLengthPrint($zg) {
    if ($zg !== null) {
      echo "<fieldset><legend>" . 'Text length' . "</legend><div>", "<input type='number' name='text_length' class='size' value='" . h($zg) . "'>", "</div></fieldset>\n";
    }
  }
  function selectActionPrint($w) {
    echo "<fieldset><legend>" . 'Action' . "</legend><div>", "<input type='submit' value='" . 'Select' . "'>", " <span id='noindex' title='" . 'Full table scan' . "'></span>", "<script" . nonce() . ">\n", "var indexColumns = ";
    $d = array();
    foreach ($w as $v) {
      $qb = reset($v["columns"]);
      if ($v["type"] != "FULLTEXT" && $qb) $d[$qb] = 1;
    }
    $d[""] = 1;
    foreach ($d as $z => $X) json_row($z);
    echo ";\n", "selectFieldChange.call(qs('#form')['select']);\n", "</script>\n", "</div></fieldset>\n";
  }
  function selectCommandPrint() {
    return !information_schema(DB);
  }
  function selectImportPrint() {
    return !information_schema(DB);
  }
  function selectEmailPrint($Ub, $d) {
  }
  function selectColumnsProcess($d, $w) {
    global $Cc, $Gc;
    $N = array();
    $s = array();
    foreach ((array)$_GET["columns"] as $z => $X) {
      if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $Cc) || in_array($X["fun"], $Gc)))) {
        $N[$z] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
        if (!in_array($X["fun"], $Gc)) $s[] = $N[$z];
      }
    }
    return array(
      $N,
      $s
    );
  }
  function selectSearchProcess($m, $w) {
    global $e, $j;
    $K = array();
    foreach ($w as $t => $v) {
      if ($v["type"] == "FULLTEXT" && $_GET["fulltext"][$t] != "") $K[] = "MATCH (" . implode(", ", array_map('idf_escape', $v["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$t]) . (isset($_GET["boolean"][$t]) ? " IN BOOLEAN MODE" : "") . ")";
    }
    foreach ((array)$_GET["where"] as $z => $X) {
      if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
        $We = "";
        $db = " $X[op]";
        if (preg_match('~IN$~', $X["op"])) {
          $Wc = process_length($X["val"]);
          $db .= " " . ($Wc != "" ? $Wc : "(NULL)");
        }
        elseif ($X["op"] == "SQL") $db = " $X[val]";
        elseif ($X["op"] == "LIKE %%") $db = " LIKE " . $this->processInput($m[$X["col"]], "%$X[val]%");
        elseif ($X["op"] == "ILIKE %%") $db = " ILIKE " . $this->processInput($m[$X["col"]], "%$X[val]%");
        elseif ($X["op"] == "FIND_IN_SET") {
          $We = "$X[op](" . q($X["val"]) . ", ";
          $db = ")";
        }
        elseif (!preg_match('~NULL$~', $X["op"])) $db .= " " . $this->processInput($m[$X["col"]], $X["val"]);
        if ($X["col"] != "") $K[] = $We . $j->convertSearch(idf_escape($X["col"]) , $X, $m[$X["col"]]) . $db;
        else {
          $Ya = array();
          foreach ($m as $E => $l) {
            if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $l["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $l["type"]))) $Ya[] = $We . $j->convertSearch(idf_escape($E) , $X, $l) . $db;
          }
          $K[] = ($Ya ? "(" . implode(" OR ", $Ya) . ")" : "1 = 0");
        }
      }
    }
    return $K;
  }
  function selectOrderProcess($m, $w) {
    $K = array();
    foreach ((array)$_GET["order"] as $z => $X) {
      if ($X != "") $K[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$z]) ? " DESC" : "");
    }
    return $K;
  }
  function selectLimitProcess() {
    return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
  }
  function selectLengthProcess() {
    return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
  }
  function selectEmailProcess($Z, $yc) {
    return false;
  }
  function selectQueryBuild($N, $Z, $s, $te, $_, $F) {
    return "";
  }
  function messageQuery($I, $_g, $nc = false) {
    global $y, $j;
    restart_session();
    $Oc = & get_session("queries");
    if (!$Oc[$_GET["db"]]) $Oc[$_GET["db"]] = array();
    if (strlen($I) > 1e6) $I = preg_replace('~[\x80-\xFF]+$~', '', substr($I, 0, 1e6)) . "\n…";
    $Oc[$_GET["db"]][] = array(
      $I,
      time() ,
      $_g
    );
    $Yf = "sql-" . count($Oc[$_GET["db"]]);
    $K = "<a href='#$Yf' class='toggle'>" . 'SQL command' . "</a>\n";
    if (!$nc && ($sh = $j->warnings())) {
      $u = "warnings-" . count($Oc[$_GET["db"]]);
      $K = "<a href='#$u' class='toggle'>" . 'Warnings' . "</a>, $K<div id='$u' class='hidden'>\n$sh</div>\n";
    }
    return " <span class='time'>" . @date("H:i:s") . "</span>" . " $K<div id='$Yf' class='hidden'><pre><code class='jush-$y'>" . shorten_utf8($I, 1000) . "</code></pre>" . ($_g ? " <span class='time'>($_g)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB) , "db=" . urlencode($_GET["db"]) , ME) . 'sql=&history=' . (count($Oc[$_GET["db"]]) - 1)) . '">Edit</a>' : '') . '</div>';
  }
  function editFunctions($l) {
    global $Pb;
    $K = ($l["null"] ? "NULL/" : "");
    foreach ($Pb as $z => $Cc) {
      if (!$z || (!isset($_GET["call"]) && (isset($_GET["select"]) || where($_GET)))) {
        foreach ($Cc as $Oe => $X) {
          if (!$Oe || preg_match("~$Oe~", $l["type"])) $K .= "/$X";
        }
        if ($z && !preg_match('~set|blob|bytea|raw|file~', $l["type"])) $K .= "/SQL";
      }
    }
    if ($l["auto_increment"] && !isset($_GET["select"]) && !where($_GET)) $K = 'Auto Increment';
    return explode("/", $K);
  }
  function editInput($Q, $l, $wa, $Y) {
    if ($l["type"] == "enum") return (isset($_GET["select"]) ? "<label><input type='radio'$wa value='-1' checked><i>" . 'original' . "</i></label> " : "") . ($l["null"] ? "<label><input type='radio'$wa value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $wa, $l, $Y, 0);
    return "";
  }
  function editHint($Q, $l, $Y) {
    return "";
  }
  function processInput($l, $Y, $q = "") {
    if ($q == "SQL") return $Y;
    $E = $l["field"];
    $K = q($Y);
    if (preg_match('~^(now|getdate|uuid)$~', $q)) $K = "$q()";
    elseif (preg_match('~^current_(date|timestamp)$~', $q)) $K = $q;
    elseif (preg_match('~^([+-]|\|\|)$~', $q)) $K = idf_escape($E) . " $q $K";
    elseif (preg_match('~^[+-] interval$~', $q)) $K = idf_escape($E) . " $q " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $K);
    elseif (preg_match('~^(addtime|subtime|concat)$~', $q)) $K = "$q(" . idf_escape($E) . ", $K)";
    elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $q)) $K = "$q($K)";
    return unconvert_field($l, $K);
  }
  function dumpOutput() {
    $K = array(
      'text' => 'open',
      'file' => 'save'
    );
    if (function_exists('gzencode')) $K['gz'] = 'gzip';
    return $K;
  }
  function dumpFormat() {
    return array(
      'sql' => 'SQL',
      'csv' => 'CSV,',
      'csv;' => 'CSV;',
      'tsv' => 'TSV'
    );
  }
  function dumpDatabase($i) {
  }
  function dumpTable($Q, $gg, $id = 0) {
    if ($_POST["format"] != "sql") {
      echo "\xef\xbb\xbf";
      if ($gg) dump_csv(array_keys(fields($Q)));
    }
    else {
      if ($id == 2) {
        $m = array();
        foreach (fields($Q) as $E => $l) $m[] = idf_escape($E) . " $l[full_type]";
        $g = "CREATE TABLE " . table($Q) . " (" . implode(", ", $m) . ")";
      }
      else $g = create_sql($Q, $_POST["auto_increment"], $gg);
      set_utf8mb4($g);
      if ($gg && $g) {
        if ($gg == "DROP+CREATE" || $id == 1) echo "DROP " . ($id == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
        if ($id == 1) $g = remove_definer($g);
        echo "$g;\n\n";
      }
    }
  }
  function dumpData($Q, $gg, $I) {
    global $e, $y;
    $Fd = ($y == "sqlite" ? 0 : 1048576);
    if ($gg) {
      if ($_POST["format"] == "sql") {
        if ($gg == "TRUNCATE+INSERT") echo truncate_sql($Q) . ";\n";
        $m = fields($Q);
      }
      $J = $e->query($I, 1);
      if ($J) {
        $bd = "";
        $Ia = "";
        $kd = array();
        $ig = "";
        $qc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
        while ($L = $J->$qc()) {
          if (!$kd) {
            $kh = array();
            foreach ($L as $X) {
              $l = $J->fetch_field();
              $kd[] = $l->name;
              $z = idf_escape($l->name);
              $kh[] = "$z = VALUES($z)";
            }
            $ig = ($gg == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $kh) : "") . ";\n";
          }
          if ($_POST["format"] != "sql") {
            if ($gg == "table") {
              dump_csv($kd);
              $gg = "INSERT";
            }
            dump_csv($L);
          }
          else {
            if (!$bd) $bd = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $kd)) . ") VALUES";
            foreach ($L as $z => $X) {
              $l = $m[$z];
              $L[$z] = ($X !== null ? unconvert_field($l, preg_match(number_type() , $l["type"]) && !preg_match('~\[~', $l["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
            }
            $Bf = ($Fd ? "\n" : " ") . "(" . implode(",\t", $L) . ")";
            if (!$Ia) $Ia = $bd . $Bf;
            elseif (strlen($Ia) + 4 + strlen($Bf) + strlen($ig) < $Fd) $Ia .= ",$Bf";
            else {
              echo $Ia . $ig;
              $Ia = $bd . $Bf;
            }
          }
        }
        if ($Ia) echo $Ia . $ig;
      }
      elseif ($_POST["format"] == "sql") echo "-- " . str_replace("\n", " ", $e->error) . "\n";
    }
  }
  function dumpFilename($Sc) {
    return friendly_url($Sc != "" ? $Sc : (SERVER != "" ? SERVER : "localhost"));
  }
  function dumpHeaders($Sc, $Rd = false) {
    $Ce = $_POST["output"];
    $kc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Rd ? "tar" : "csv"));
    header("Content-Type: " . ($Ce == "gz" ? "application/x-gzip" : ($kc == "tar" ? "application/x-tar" : ($kc == "sql" || $Ce != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
    if ($Ce == "gz") ob_start('ob_gzencode', 1e6);
    return $kc;
  }
  function importServerPath() {
    return "adminer.sql";
  }
  function homepage() {
    echo '<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">Alter database' . "</a>\n" : "") , (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? 'Alter schema' : 'Create schema') . "</a>\n" : "") , ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">Database schema' . "</a>\n" : "") , (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . 'Privileges' . "</a>\n" : "");
    return true;
  }
  function navigation($Qd) {
    global $ga, $y, $Ib, $e, $expire_timeleft, $lifetime;
    echo '<h1>', $this->name() , ' <span class="version">', $ga, '</span>
<a href="https://www.adminer.org/#download"', target_blank() , ' id="version">', (version_compare($ga, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : "") , '</a>
</h1><div style="color: white;padding: 10px 0 10px 16px;">Session will end in ' . ($lifetime - $expire_timeleft) . ' sec.</div>';
    if ($Qd == "auth") {
      $Ce = "";
      foreach ((array)$_SESSION["pwds"] as $mh => $Mf) {
        foreach ($Mf as $O => $ih) {
          foreach ($ih as $V => $G) {
            if ($G !== null) {
              $wb = $_SESSION["db"][$mh][$O][$V];
              foreach (($wb ? array_keys($wb) : array(
                ""
              )) as $i) $Ce .= "<li><a href='" . h(auth_url($mh, $O, $V, $i)) . "'>($Ib[$mh]) " . h($V . ($O != "" ? "@" . $this->serverName($O) : "") . ($i != "" ? " - $i" : "")) . "</a>\n";
            }
          }
        }
      }
      if ($Ce) echo "<ul id='logins'>\n$Ce</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
    } else {
      if ($_GET["ns"] !== "" && !$Qd && DB != "") {
        $e->select_db(DB);
        $S = table_status('', true);
      }
      echo script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.7.7");
      if (support("sql")) {
        echo '<script', nonce() , '>';
        if ($S) {
          $zd = array();
          foreach ($S as $Q => $U) $zd[] = preg_quote($Q, '/');
          echo "var jushLinks = { $y: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $zd) . ")\\b/g ] };\n";
          foreach (array(
            "bac",
            "bra",
            "sqlite_quo",
            "mssql_bra"
          ) as $X) echo "jushLinks.$X = jushLinks.$y;\n";
        }
        $Lf = $e->server_info;
        echo 'bodyLoad(\'', (is_object($e) ? preg_replace('~^(\d\.?\d).*~s', '\1', $Lf) : "") , '\'', (preg_match('~MariaDB~', $Lf) ? ", true" : "") , ');</script>';
      }
      $this->databasesPrint($Qd);
      if (DB == "" || !$Qd) {
        echo "<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . " title='SQL command'>" . '&#x25B7;' . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . " title='Import'>" . '&#x23EC;' . "</a>\n" : "") . "";
        if (support("dump")) echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . " title='Export'>" . '&#x23EB;' . "</a>\n";
      }
      if ($_GET["ns"] !== "" && !$Qd && DB != "") {
        echo '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . " title='Create table'>" . '&#x2b;' . "</a>\n";
        if (!$S) echo "<p class='message'>" . 'No tables.' . "\n";
        else $this->tablesPrint($S);
      }
    }
  }
  function databasesPrint($Qd) {
    global $b, $e;
    $h = $this->databases();
    if ($h && !in_array(DB, $h)) array_unshift($h, DB);
    echo '<form action=""><p id="dbs">';
    hidden_fields_get();
    $ub = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
    echo "<span title='" . 'database' . "'>" . 'DB' . "</span>: " . ($h ? "<select name='db'>" . optionlist(array(
      "" => ""
    ) + $h, DB) . "</select>$ub" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n") , "<input type='submit' value='" . 'Use' . "'" . ($h ? " class='hidden'" : "") . ">\n";
    if ($Qd != "db" && DB != "" && $e->select_db(DB)) {
    }
    foreach (array(
      "import",
      "sql",
      "schema",
      "dump",
      "privileges"
    ) as $X) {
      if (isset($_GET[$X])) {
        echo "<input type='hidden' name='$X' value=''>";
        break;
      }
    }
    echo "</p></form>\n";
  }
  function tablesPrint($S) {
    echo "<ul id='tables'>";
    foreach ($S as $Q => $bg) {
      $E = $this->tableName($bg);
      if ($E != "") {
        echo '<li>', (support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array(
          $_GET["table"],
          $_GET["create"],
          $_GET["indexes"],
          $_GET["foreign"],
          $_GET["trigger"]
        )) , (is_view($bg) ? "view" : "structure")) . " title='" . 'Show structure' . "'>$E</a>" : "<span>$E</span>") . "\n";
      }
    }
    echo "</ul>\n";
  }
}
$b = (function_exists('adminer_object') ? adminer_object() : new Adminer);
if ($b->operators === null) $b->operators = $pe;
function page_header($Cg, $k = "", $Ha = array() , $Dg = "") {
  global $ca, $ga, $b, $Ib, $y;
  page_headers();
  if (is_ajax() && $k) {
    page_messages($k);
    exit;
  }
  $Eg = $Cg . ($Dg != "" ? ": $Dg" : "");
  $Fg = strip_tags($Eg . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $b->name());
  echo '<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $Fg, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.7.7") , '">', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.7.7");
  if ($b->head()) {
    echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.7") , '"><link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.7") , '">';
    foreach ($b->css() as $ob) {
      echo '<link rel="stylesheet" type="text/css" href="', h($ob) , '">';
    }
  }
  echo '<body class="ltr nojs">';
  $sc = get_temp_dir() . "/adminer.version";
  if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($sc) && filemtime($sc) + 86400 > time()) {
    $nh = unserialize(file_get_contents($sc));
    $ff = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
    if (openssl_verify($nh["version"], base64_decode($nh["signature"]) , $ff) == 1) $_COOKIE["adminer_version"] = $nh["version"];
  }
  echo '<script', nonce() , '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ga', '" . js_escape(ME) . "', '" . get_token() . "')"); ?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo js_escape('You are offline.') , '\';
var thousandsSeparator = \'', js_escape(',') , '\';
</script>

<div id="help" class="jush-', $y, ' jsonly hidden"></div>', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});") , '
<div id="content">';
  if ($Ha !== null) {
    $A = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME) , 0, -1);
    echo '<p id="breadcrumb"><a href="' . h($A ? $A : ".") . '">' . $Ib[DRIVER] . '</a>';
    $A = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME) , 0, -1);
    $O = $b->serverName(SERVER);
    $O = ($O != "" ? $O : 'Server');
    if ($Ha === false) echo '<span>' . $O . '</span>' . "\n";
    else {
      echo "<a href='" . ($A ? h($A) : ".") . "' accesskey='1' title='Alt+Shift+1'>$O</a>";
      if ($_GET["ns"] != "" || (DB != "" && is_array($Ha))) echo '<a href="' . h($A . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a>';
      if (is_array($Ha)) {
        if ($_GET["ns"] != "") echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a>';
        foreach ($Ha as $z => $X) {
          $Bb = (is_array($X) ? $X[1] : h($X));
          if ($Bb != "") echo "<a href='" . h(ME . "$z=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$Bb</a>";
        }
      }
      echo '<span>' . $Cg . '</span>' . "\n";
    }
  }
  echo "<h2>$Eg</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
  restart_session();
  page_messages($k);
  $h = & get_session("dbs");
  if (DB != "" && $h && !in_array(DB, $h, true)) $h = null;
  stop_session();
  define("PAGE_HEADER", 1);
}
function page_headers() {
  global $b;
  header("Content-Type: text/html; charset=utf-8");
  header("Cache-Control: no-cache");
  header("X-Frame-Options: deny");
  header("X-XSS-Protection: 0");
  header("X-Content-Type-Options: nosniff");
  header("Referrer-Policy: origin-when-cross-origin");
  foreach ($b->csp() as $nb) {
    $Mc = array();
    foreach ($nb as $z => $X) $Mc[] = "$z $X";
    header("Content-Security-Policy: " . implode("; ", $Mc));
  }
  $b->headers();
}
function csp() {
  return array(
    array(
      "script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'",
      "connect-src" => "'self'",
      "frame-src" => "https://www.adminer.org",
      "object-src" => "'none'",
      "base-uri" => "'none'",
      "form-action" => "'self'",
    ),
  );
}
function get_nonce() {
  static $Zd;
  if (!$Zd) $Zd = base64_encode(rand_string());
  return $Zd;
}
function page_messages($k) {
  $ch = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
  $Od = $_SESSION["messages"][$ch];
  if ($Od) {
    echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Od) . "</div>" . script("messagesPrint();");
    unset($_SESSION["messages"][$ch]);
  }
  if ($k) echo "<div class='error'>$k</div>\n";
}
function page_footer($Qd = "") {
  global $b, $T;
  echo '</div>

';
  if ($Qd != "auth") {
    echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="', $T, '">
</p>
</form>
';
  }
  echo '<div id="menu">';
  $b->navigation($Qd);
  echo '</div>', script("setupSubmitHighlight(document);");
}
function int32($Td) {
  while ($Td >= 2147483648) $Td -= 4294967296;
  while ($Td <= - 2147483649) $Td += 4294967296;
  return (int)$Td;
}
function long2str($W, $rh) {
  $Bf = '';
  foreach ($W as $X) $Bf .= pack('V', $X);
  if ($rh) return substr($Bf, 0, end($W));
  return $Bf;
}
function str2long($Bf, $rh) {
  $W = array_values(unpack('V*', str_pad($Bf, 4 * ceil(strlen($Bf) / 4) , "\0")));
  if ($rh) $W[] = strlen($Bf);
  return $W;
}
function xxtea_mx($yh, $xh, $jg, $jd) {
  return int32((($yh >> 5 & 0x7FFFFFF) ^ $xh << 2) + (($xh >> 3 & 0x1FFFFFFF) ^ $yh << 4)) ^ int32(($jg ^ $xh) + ($jd ^ $yh));
}
function encrypt_string($dg, $z) {
  if ($dg == "") return "";
  $z = array_values(unpack("V*", pack("H*", md5($z))));
  $W = str2long($dg, true);
  $Td = count($W) - 1;
  $yh = $W[$Td];
  $xh = $W[0];
  $H = floor(6 + 52 / ($Td + 1));
  $jg = 0;
  while ($H-- > 0) {
    $jg = int32($jg + 0x9E3779B9);
    $Ob = $jg >> 2 & 3;
    for ($De = 0;$De < $Td;$De++) {
      $xh = $W[$De + 1];
      $Sd = xxtea_mx($yh, $xh, $jg, $z[$De & 3 ^ $Ob]);
      $yh = int32($W[$De] + $Sd);
      $W[$De] = $yh;
    }
    $xh = $W[0];
    $Sd = xxtea_mx($yh, $xh, $jg, $z[$De & 3 ^ $Ob]);
    $yh = int32($W[$Td] + $Sd);
    $W[$Td] = $yh;
  }
  return long2str($W, false);
}
function decrypt_string($dg, $z) {
  if ($dg == "") return "";
  if (!$z) return false;
  $z = array_values(unpack("V*", pack("H*", md5($z))));
  $W = str2long($dg, false);
  $Td = count($W) - 1;
  $yh = $W[$Td];
  $xh = $W[0];
  $H = floor(6 + 52 / ($Td + 1));
  $jg = int32($H * 0x9E3779B9);
  while ($jg) {
    $Ob = $jg >> 2 & 3;
    for ($De = $Td;$De > 0;$De--) {
      $yh = $W[$De - 1];
      $Sd = xxtea_mx($yh, $xh, $jg, $z[$De & 3 ^ $Ob]);
      $xh = int32($W[$De] - $Sd);
      $W[$De] = $xh;
    }
    $yh = $W[$Td];
    $Sd = xxtea_mx($yh, $xh, $jg, $z[$De & 3 ^ $Ob]);
    $xh = int32($W[0] - $Sd);
    $W[0] = $xh;
    $jg = int32($jg - 0x9E3779B9);
  }
  return long2str($W, true);
}
$e = '';
$Lc = $_SESSION["token"];
if (!$Lc) $_SESSION["token"] = rand(1, 1e6);
$T = get_token();
$Pe = array();
if ($_COOKIE["adminer_permanent"]) {
  foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
    list($z) = explode(":", $X);
    $Pe[$z] = $X;
  }
}
function add_invalid_login() {
  global $b;
  $p = file_open_lock(get_temp_dir() . "/adminer.invalid");
  if (!$p) return;
  $ed = unserialize(stream_get_contents($p));
  $_g = time();
  if ($ed) {
    foreach ($ed as $fd => $X) {
      if ($X[0] < $_g) unset($ed[$fd]);
    }
  }
  $dd = & $ed[$b->bruteForceKey() ];
  if (!$dd) $dd = array(
    $_g + 30 * 60,
    0
  );
  $dd[1]++;
  file_write_unlock($p, serialize($ed));
}
function check_invalid_login() {
  global $b;
  $ed = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
  $dd = $ed[$b->bruteForceKey() ];
  $Yd = ($dd[1] > 29 ? $dd[0] - time() : 0);
  if ($Yd > 0) auth_error(lang(array(
    'Too many unsuccessful logins, try again in %d minute.',
    'Too many unsuccessful logins, try again in %d minutes.'
  ) , ceil($Yd / 60)));
}
$xa = $_POST["auth"];
if ($xa) {
  session_regenerate_id();
  $mh = $xa["driver"];
  $O = $xa["server"];
  $V = $xa["username"];
  $G = (string)$xa["password"];
  $i = $xa["db"];
  set_password($mh, $O, $V, $G);
  $_SESSION["db"][$mh][$O][$V][$i] = true;
  if ($xa["permanent"]) {
    $z = base64_encode($mh) . "-" . base64_encode($O) . "-" . base64_encode($V) . "-" . base64_encode($i);
    $af = $b->permanentLogin(true);
    $Pe[$z] = "$z:" . base64_encode($af ? encrypt_string($G, $af) : "");
    cookie("adminer_permanent", implode(" ", $Pe));
  }
  if (count($_POST) == 1 || DRIVER != $mh || SERVER != $O || $_GET["username"] !== $V || DB != $i) redirect(auth_url($mh, $O, $V, $i));
}
elseif ($_POST["logout"]) {
  if ($Lc && !verify_token()) {
    page_header('Logout', 'Invalid CSRF token. Send the form again.');
    page_footer("db");
    exit;
  }
  else {
    foreach (array(
      "pwds",
      "db",
      "dbs",
      "queries"
    ) as $z) set_session($z, null);
    unset_permanent();
    redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME) , 0, -1) , 'Logout successful. Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');
  }
}
elseif ($Pe && !$_SESSION["pwds"]) {
  session_regenerate_id();
  $af = $b->permanentLogin();
  foreach ($Pe as $z => $X) {
    list(, $Qa) = explode(":", $X);
    list($mh, $O, $V, $i) = array_map('base64_decode', explode("-", $z));
    set_password($mh, $O, $V, decrypt_string(base64_decode($Qa) , $af));
    $_SESSION["db"][$mh][$O][$V][$i] = true;
  }
}
function unset_permanent() {
  global $Pe;
  foreach ($Pe as $z => $X) {
    list($mh, $O, $V, $i) = array_map('base64_decode', explode("-", $z));
    if ($mh == DRIVER && $O == SERVER && $V == $_GET["username"] && $i == DB) unset($Pe[$z]);
  }
  cookie("adminer_permanent", implode(" ", $Pe));
}
function auth_error($k) {
  global $b, $Lc;
  $Nf = session_name();
  if (isset($_GET["username"])) {
    header("HTTP/1.1 403 Forbidden");
    if (($_COOKIE[$Nf] || $_GET[$Nf]) && !$Lc) $k = 'Session expired, please login again.';
    else {
      restart_session();
      add_invalid_login();
      $G = get_password();
      if ($G !== null) {
        if ($G === false) $k .= '<br>' . sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.', target_blank() , '<code>permanentLogin()</code>');
        set_password(DRIVER, SERVER, $_GET["username"], null);
      }
      unset_permanent();
    }
  }
  if (!$_COOKIE[$Nf] && $_GET[$Nf] && ini_bool("session.use_only_cookies")) $k = 'Session support must be enabled.';
  $Ge = session_get_cookie_params();
  cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()) , $Ge["lifetime"]);
  page_header('Login', $k, null);
  echo "<form action='' method='post'>\n", "<div>";
  if (hidden_fields($_POST, array(
    "auth"
  ))) echo "<p class='message'>" . 'The action will be performed after successful login with the same credentials.' . "\n";
  echo "</div>\n";
  $b->loginForm();
  echo "</form>\n";
  page_footer("auth");
  exit;
}
if (isset($_GET["username"]) && !class_exists("Min_DB")) {
  unset($_SESSION["pwds"][DRIVER]);
  unset_permanent();
  page_header('No extension', sprintf('None of the supported PHP extensions (%s) are available.', implode(", ", $Ve)) , false);
  page_footer("auth");
  exit;
}
stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
  list($Qc, $Re) = explode(":", SERVER, 2);
  if (is_numeric($Re) && ($Re < 1024 || $Re > 65535)) auth_error('Connecting to privileged ports is not allowed.');
  check_invalid_login();
  $e = connect();
  $j = new Min_Driver($e);
}
$_d = null;
if (!is_object($e) || ($_d = $b->login($_GET["username"], get_password())) !== true) {
  $k = (is_string($e) ? h($e) : (is_string($_d) ? $_d : 'Invalid credentials.'));
  auth_error($k . (preg_match('~^ | $~', get_password()) ? '<br>There is a space in the input password which might be the cause.' : ''));
}
if ($xa && $_POST["token"]) $_POST["token"] = $T;
$k = '';
if ($_POST) {
  if (!verify_token()) {
    $Yc = "max_input_vars";
    $Jd = ini_get($Yc);
    if (extension_loaded("suhosin")) {
      foreach (array(
        "suhosin.request.max_vars",
        "suhosin.post.max_vars"
      ) as $z) {
        $X = ini_get($z);
        if ($X && (!$Jd || $X < $Jd)) {
          $Yc = $z;
          $Jd = $X;
        }
      }
    }
    $k = (!$_POST["token"] && $Jd ? sprintf('Maximum number of allowed fields exceeded. Please increase %s.', "'$Yc'") : 'Invalid CSRF token. Send the form again. If you did not send this request from Adminer then close this page.');
  }
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
  $k = sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.', "'post_max_size'");
  if (isset($_GET["sql"])) $k .= ' You can upload a big SQL file via FTP and import it from server.';
}
function select($J, $f = null, $we = array() , $_ = 0) {
  global $y;
  $zd = array();
  $w = array();
  $d = array();
  $Fa = array();
  $Tg = array();
  $K = array();
  odd('');
  for ($t = 0;(!$_ || $t < $_) && ($L = $J->fetch_row());$t++) {
    if (!$t) {
      echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr>";
      for ($x = 0;$x < count($L);$x++) {
        $l = $J->fetch_field();
        $E = $l->name;
        $ve = $l->orgtable;
        $ue = $l->orgname;
        $K[$l->table] = $ve;
        if ($we && $y == "sql") $zd[$x] = ($E == "table" ? "table=" : ($E == "possible_keys" ? "indexes=" : null));
        elseif ($ve != "") {
          if (!isset($w[$ve])) {
            $w[$ve] = array();
            foreach (indexes($ve, $f) as $v) {
              if ($v["type"] == "PRIMARY") {
                $w[$ve] = array_flip($v["columns"]);
                break;
              }
            }
            $d[$ve] = $w[$ve];
          }
          if (isset($d[$ve][$ue])) {
            unset($d[$ve][$ue]);
            $w[$ve][$ue] = $x;
            $zd[$x] = $ve;
          }
        }
        if ($l->charsetnr == 63) $Fa[$x] = true;
        $Tg[$x] = $l->type;
        echo "<th" . ($ve != "" || $l->name != $ue ? " title='" . h(($ve != "" ? "$ve." : "") . $ue) . "'" : "") . ">" . h($E) . ($we ? doc_link(array(
          'sql' => "explain-output.html#explain_" . strtolower($E) ,
          'mariadb' => "explain/#the-columns-in-explain-select",
        )) : "");
      }
      echo "</thead>\n";
    }
    echo "<tr" . odd() . ">";
    foreach ($L as $z => $X) {
      if ($X === null) $X = "<i>NULL</i>";
      elseif ($Fa[$z] && !is_utf8($X)) $X = "<i>" . lang(array(
        '%d byte',
        '%d bytes'
      ) , strlen($X)) . "</i>";
      else {
        $X = h($X);
        if ($Tg[$z] == 254) $X = "<code>$X</code>";
      }
      if (isset($zd[$z]) && !$d[$zd[$z]]) {
        if ($we && $y == "sql") {
          $Q = $L[array_search("table=", $zd) ];
          $A = $zd[$z] . urlencode($we[$Q] != "" ? $we[$Q] : $Q);
        }
        else {
          $A = "edit=" . urlencode($zd[$z]);
          foreach ($w[$zd[$z]] as $Ua => $x) $A .= "&where" . urlencode("[" . bracket_escape($Ua) . "]") . "=" . urlencode($L[$x]);
        }
        $X = "<a href='" . h(ME . $A) . "'>$X</a>";
      }
      echo "<td>$X";
    }
  }
  echo ($t ? "</table>\n</div>" : "<p class='message'>" . 'No rows.') . "\n";
  return $K;
}
function referencable_primary($If) {
  $K = array();
  foreach (table_status('', true) as $ng => $Q) {
    if ($ng != $If && fk_support($Q)) {
      foreach (fields($ng) as $l) {
        if ($l["primary"]) {
          if ($K[$ng]) {
            unset($K[$ng]);
            break;
          }
          $K[$ng] = $l;
        }
      }
    }
  }
  return $K;
}
function adminer_settings() {
  parse_str($_COOKIE["adminer_settings"], $Pf);
  return $Pf;
}
function adminer_setting($z) {
  $Pf = adminer_settings();
  return $Pf[$z];
}
function set_adminer_settings($Pf) {
  return cookie("adminer_settings", http_build_query($Pf + adminer_settings()));
}
function textarea($E, $Y, $M = 10, $Ya = 80) {
  global $y;
  echo "<textarea name='$E' rows='$M' cols='$Ya' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";
  if (is_array($Y)) {
    foreach ($Y as $X) echo h($X[0]) . "\n\n\n";
  }
  else echo h($Y);
  echo "</textarea>";
}
function edit_type($z, $l, $Xa, $o = array() , $mc = array()) {
  global $fg, $Tg, $ah, $le;
  $U = $l["type"];
  echo '<td><select name="', h($z) , '[type]" class="type" aria-labelledby="label-type">';
  if ($U && !isset($Tg[$U]) && !isset($o[$U]) && !in_array($U, $mc)) $mc[] = $U;
  if ($o) $fg['Foreign keys'] = $o;
  echo optionlist(array_merge($mc, $fg) , $U) , '</select><td><input name="', h($z) , '[length]" value="', h($l["length"]) , '" size="3"', (!$l["length"] && preg_match('~var(char|binary)$~', $U) ? " class='required'" : "");
  echo ' aria-labelledby="label-length"><td class="options">', "<select name='" . h($z) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $U) ? "" : " class='hidden'") . '><option value="">(collation)' . optionlist($Xa, $l["collation"]) . '</select>', ($ah ? "<select name='" . h($z) . "[unsigned]'" . (!$U || preg_match(number_type() , $U) ? "" : " class='hidden'") . '><option>' . optionlist($ah, $l["unsigned"]) . '</select>' : '') , (isset($l['on_update']) ? "<select name='" . h($z) . "[on_update]'" . (preg_match('~timestamp|datetime~', $U) ? "" : " class='hidden'") . '>' . optionlist(array(
    "" => "(" . 'ON UPDATE' . ")",
    "CURRENT_TIMESTAMP"
  ) , (preg_match('~^CURRENT_TIMESTAMP~i', $l["on_update"]) ? "CURRENT_TIMESTAMP" : $l["on_update"])) . '</select>' : '') , ($o ? "<select name='" . h($z) . "[on_delete]'" . (preg_match("~`~", $U) ? "" : " class='hidden'") . "><option value=''>(" . 'ON DELETE' . ")" . optionlist(explode("|", $le) , $l["on_delete"]) . "</select> " : " ");
}
function process_length($wd) {
  global $Zb;
  return (preg_match("~^\\s*\\(?\\s*$Zb(?:\\s*,\\s*$Zb)*+\\s*\\)?\\s*\$~", $wd) && preg_match_all("~$Zb~", $wd, $Dd) ? "(" . implode(",", $Dd[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $wd)));
}
function process_type($l, $Va = "COLLATE") {
  global $ah;
  return " $l[type]" . process_length($l["length"]) . (preg_match(number_type() , $l["type"]) && in_array($l["unsigned"], $ah) ? " $l[unsigned]" : "") . (preg_match('~char|text|enum|set~', $l["type"]) && $l["collation"] ? " $Va " . q($l["collation"]) : "");
}
function process_field($l, $Rg) {
  return array(
    idf_escape(trim($l["field"])) ,
    process_type($Rg) ,
    ($l["null"] ? " NULL" : " NOT NULL") ,
    default_value($l) ,
    (preg_match('~timestamp|datetime~', $l["type"]) && $l["on_update"] ? " ON UPDATE $l[on_update]" : "") ,
    (support("comment") && $l["comment"] != "" ? " COMMENT " . q($l["comment"]) : "") ,
    ($l["auto_increment"] ? auto_increment() : null) ,
  );
}
function default_value($l) {
  $yb = $l["default"];
  return ($yb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $l["type"]) || preg_match('~^(?![a-z])~i', $yb) ? q($yb) : $yb));
}
function type_class($U) {
  foreach (array(
    'char' => 'text',
    'date' => 'time|year',
    'binary' => 'blob',
    'enum' => 'set',
  ) as $z => $X) {
    if (preg_match("~$z|$X~", $U)) return " class='$z'";
  }
}
function edit_fields($m, $Xa, $U = "TABLE", $o = array()) {
  global $Zc;
  $m = array_values($m);
  $zb = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
  $cb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");
  echo '<thead><tr>
';
  if ($U == "PROCEDURE") {
    echo '<td>';
  }
  echo '<th id="label-name">', ($U == "TABLE" ? 'Column name' : 'Parameter name') , '<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>', script("qs('#enum-edit').onblur = editingLengthBlur;") , '<td id="label-length">Length
<td>', 'Options';
  if ($U == "TABLE") {
    echo '<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>', doc_link(array(
      'sql' => "example-auto-increment.html",
      'mariadb' => "auto_increment/",
    )) , '<td id="label-default"', $zb, '>Default value
', (support("comment") ? "<td id='label-comment'$cb>" . 'Comment' : "");
  }
  echo '<td>', "<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($m)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . 'Add next' . "'>" . script("row_count = " . count($m) . ";") , '</thead>
<tbody>
', script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
  foreach ($m as $t => $l) {
    $t++;
    $xe = $l[($_POST ? "orig" : "field") ];
    $Fb = (isset($_POST["add"][$t - 1]) || (isset($l["field"]) && !$_POST["drop_col"][$t])) && (support("drop_col") || $xe == "");
    echo '<tr', ($Fb ? "" : " style='display: none;'") , '>
', ($U == "PROCEDURE" ? "<td>" . html_select("fields[$t][inout]", explode("|", $Zc) , $l["inout"]) : "") , '<th>';
    if ($Fb) {
      echo '<input name="fields[', $t, '][field]" value="', h($l["field"]) , '" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
    }
    echo '<input type="hidden" name="fields[', $t, '][orig]" value="', h($xe) , '">';
    edit_type("fields[$t]", $l, $Xa, $o);
    if ($U == "TABLE") {
      echo '<td>', checkbox("fields[$t][null]", 1, $l["null"], "", "", "block", "label-null") , '<td><label class="block"><input type="radio" name="auto_increment_col" value="', $t, '"';
      if ($l["auto_increment"]) {
        echo ' checked';
      }
      echo ' aria-labelledby="label-ai"></label><td', $zb, '>', checkbox("fields[$t][has_default]", 1, $l["has_default"], "", "", "", "label-default") , '<input name="fields[', $t, '][default]" value="', h($l["default"]) , '" aria-labelledby="label-default">', (support("comment") ? "<td$cb><input name='fields[$t][comment]' value='" . h($l["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
    }
    echo "<td>", (support("move_col") ? "<input type='image' class='icon' name='add[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . 'Add next' . "'> " . "<input type='image' class='icon' name='up[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=up.gif&version=4.7.7") . "' alt='↑' title='" . 'Move up' . "'> " . "<input type='image' class='icon' name='down[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=down.gif&version=4.7.7") . "' alt='↓' title='" . 'Move down' . "'> " : "") , ($xe == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.7.7") . "' alt='x' title='" . 'Remove' . "'>" : "");
  }
}
function process_fields(&$m) {
  $ee = 0;
  if ($_POST["up"]) {
    $qd = 0;
    foreach ($m as $z => $l) {
      if (key($_POST["up"]) == $z) {
        unset($m[$z]);
        array_splice($m, $qd, 0, array(
          $l
        ));
        break;
      }
      if (isset($l["field"])) $qd = $ee;
      $ee++;
    }
  }
  elseif ($_POST["down"]) {
    $_c = false;
    foreach ($m as $z => $l) {
      if (isset($l["field"]) && $_c) {
        unset($m[key($_POST["down"]) ]);
        array_splice($m, $ee, 0, array(
          $_c
        ));
        break;
      }
      if (key($_POST["down"]) == $z) $_c = $l;
      $ee++;
    }
  }
  elseif ($_POST["add"]) {
    $m = array_values($m);
    array_splice($m, key($_POST["add"]) , 0, array(
      array()
    ));
  }
  elseif (!$_POST["drop_col"]) return false;
  return true;
}
function normalize_enum($C) {
  return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0] . $C[0][0], $C[0][0], substr($C[0], 1, -1))) , '\\')) . "'";
}
function grant($r, $cf, $d, $ke) {
  if (!$cf) return true;
  if ($cf == array(
    "ALL PRIVILEGES",
    "GRANT OPTION"
  )) return ($r == "GRANT" ? queries("$r ALL PRIVILEGES$ke WITH GRANT OPTION") : queries("$r ALL PRIVILEGES$ke") && queries("$r GRANT OPTION$ke"));
  return queries("$r " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$d, ", $cf) . $d) . $ke);
}
function drop_create($Jb, $g, $Kb, $xg, $Lb, $B, $Nd, $Ld, $Md, $he, $Wd) {
  if ($_POST["drop"]) query_redirect($Jb, $B, $Nd);
  elseif ($he == "") query_redirect($g, $B, $Md);
  elseif ($he != $Wd) {
    $lb = queries($g);
    queries_redirect($B, $Ld, $lb && queries($Jb));
    if ($lb) queries($Kb);
  }
  else queries_redirect($B, $Ld, queries($xg) && queries($Lb) && queries($Jb) && queries($g));
}
function create_trigger($ke, $L) {
  global $y;
  $Bg = " $L[Timing] $L[Event]" . ($L["Event"] == "UPDATE OF" ? " " . idf_escape($L["Of"]) : "");
  return "CREATE TRIGGER " . idf_escape($L["Trigger"]) . ($y == "mssql" ? $ke . $Bg : $Bg . $ke) . rtrim(" $L[Type]\n$L[Statement]", ";") . ";";
}
function create_routine($zf, $L) {
  global $Zc, $y;
  $P = array();
  $m = (array)$L["fields"];
  ksort($m);
  foreach ($m as $l) {
    if ($l["field"] != "") $P[] = (preg_match("~^($Zc)\$~", $l["inout"]) ? "$l[inout] " : "") . idf_escape($l["field"]) . process_type($l, "CHARACTER SET");
  }
  $_b = rtrim("\n$L[definition]", ";");
  return "CREATE $zf " . idf_escape(trim($L["name"])) . " (" . implode(", ", $P) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($L["returns"], "CHARACTER SET") : "") . ($L["language"] ? " LANGUAGE $L[language]" : "") . ($y == "pgsql" ? " AS " . q($_b) : "$_b;");
}
function remove_definer($I) {
  return preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $I);
}
function format_foreign_key($n) {
  global $le;
  $i = $n["db"];
  $ae = $n["ns"];
  return " FOREIGN KEY (" . implode(", ", array_map('idf_escape', $n["source"])) . ") REFERENCES " . ($i != "" && $i != $_GET["db"] ? idf_escape($i) . "." : "") . ($ae != "" && $ae != $_GET["ns"] ? idf_escape($ae) . "." : "") . table($n["table"]) . " (" . implode(", ", array_map('idf_escape', $n["target"])) . ")" . (preg_match("~^($le)\$~", $n["on_delete"]) ? " ON DELETE $n[on_delete]" : "") . (preg_match("~^($le)\$~", $n["on_update"]) ? " ON UPDATE $n[on_update]" : "");
}
function tar_file($sc, $Gg) {
  $K = pack("a100a8a8a8a12a12", $sc, 644, 0, 0, decoct($Gg->size) , decoct(time()));
  $Pa = 8 * 32;
  for ($t = 0;$t < strlen($K);$t++) $Pa += ord($K[$t]);
  $K .= sprintf("%06o", $Pa) . "\0 ";
  echo $K, str_repeat("\0", 512 - strlen($K));
  $Gg->send();
  echo str_repeat("\0", 511 - ($Gg->size + 511) % 512);
}
function ini_bytes($Yc) {
  $X = ini_get($Yc);
  switch (strtolower(substr($X, -1))) {
    case 'g':
      $X *= 1024;
    case 'm':
      $X *= 1024;
    case 'k':
      $X *= 1024;
  }
  return $X;
}
function doc_link($Ne, $yg = "<sup>?</sup>") {
  global $y, $e;
  $Lf = $e->server_info;
  $nh = preg_replace('~^(\d\.?\d).*~s', '\1', $Lf);
  $eh = array(
    'sql' => "https://dev.mysql.com/doc/refman/$nh/en/",
    'sqlite' => "https://www.sqlite.org/",
    'pgsql' => "https://www.postgresql.org/docs/$nh/",
    'mssql' => "https://msdn.microsoft.com/library/",
    'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $Lf) . "&id=",
  );
  if (preg_match('~MariaDB~', $Lf)) {
    $eh['sql'] = "https://mariadb.com/kb/en/library/";
    $Ne['sql'] = (isset($Ne['mariadb']) ? $Ne['mariadb'] : str_replace(".html", "/", $Ne['sql']));
  }
  return ($Ne[$y] ? "<a href='$eh[$y]$Ne[$y]'" . target_blank() . ">$yg</a>" : "");
}
function ob_gzencode($eg) {
  return gzencode($eg);
}
function db_size($i) {
  global $e;
  if (!$e->select_db($i)) return "?";
  $K = 0;
  foreach (table_status() as $R) $K += $R["Data_length"] + $R["Index_length"];
  return format_number($K);
}
function set_utf8mb4($g) {
  global $e;
  static $P = false;
  if (!$P && preg_match('~\butf8mb4~i', $g)) {
    $P = true;
    echo "SET NAMES " . charset($e) . ";\n\n";
  }
}
function connect_error() {
  global $b, $e, $T, $k, $Ib;
  if (DB != "") {
    header("HTTP/1.1 404 Not Found");
    page_header('Database' . ": " . h(DB) , 'Invalid database.', true);
  }
  else {
    if ($_POST["db"] && !$k) queries_redirect(substr(ME, 0, -1) , 'Databases have been dropped.', drop_databases($_POST["db"]));
    page_header('Select database', $k, false);
    echo "<p class='links'>\n";
    foreach (array(
      'database' => 'Create database',
      'privileges' => 'Privileges',
      'processlist' => 'Process list',
      'variables' => 'Variables',
      'status' => 'Status',
    ) as $z => $X) {
      if (support($z)) echo "<a href='" . h(ME) . "$z='>$X</a>\n";
    }
    echo "<p>" . sprintf('%s version: %s through PHP extension %s', $Ib[DRIVER], "<b>" . h($e->server_info) . "</b>", "<b>$e->extension</b>") . "\n", "<p>" . sprintf('Logged as: %s', "<b>" . h(logged_user()) . "</b>") . "\n";
    $h = $b->databases();
    if ($h) {
      $Ef = support("scheme");
      $Xa = collations();
      echo "<form action='' method='post'>\n", "<table cellspacing='0' class='checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});") , "<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . 'Database' . " - <a href='" . h(ME) . "refresh=1'>" . 'Refresh' . "</a>" . "<td>" . 'Collation' . "<td>" . 'Tables' . "<td>" . 'Size' . " - <a href='" . h(ME) . "dbsize=1'>" . 'Compute' . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
      $h = ($_GET["dbsize"] ? count_tables($h) : array_flip($h));
      foreach ($h as $i => $S) {
        $yf = h(ME) . "db=" . urlencode($i);
        $u = h("Db-" . $i);
        echo "<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $i, in_array($i, (array)$_POST["db"]) , "", "", "", $u) : "") , "<th><a href='$yf' id='$u'>" . h($i) . "</a>";
        $Wa = h(db_collation($i, $Xa));
        echo "<td>" . (support("database") ? "<a href='$yf" . ($Ef ? "&amp;ns=" : "") . "&amp;database=' title='" . 'Alter database' . "'>$Wa</a>" : $Wa) , "<td align='right'><a href='$yf&amp;schema=' id='tables-" . h($i) . "' title='" . 'Database schema' . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>", "<td align='right' id='size-" . h($i) . "'>" . ($_GET["dbsize"] ? db_size($i) : "?") , "\n";
      }
      echo "</table>\n", (support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : "") , "<input type='hidden' name='token' value='$T'>\n", "</form>\n", script("tableCheck();");
    }
  }
  page_footer("db");
}
if (isset($_GET["status"])) $_GET["variables"] = $_GET["status"];
if (isset($_GET["import"])) $_GET["sql"] = $_GET["import"];
if (!(DB != "" ? $e->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
  if (DB != "" || $_GET["refresh"]) {
    restart_session();
    set_session("dbs", null);
  }
  connect_error();
  exit;
}
$le = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";
class TmpFile {
  var $handler;
  var $size;
  function __construct() {
    $this->handler = tmpfile();
  }
  function write($gb) {
    $this->size += strlen($gb);
    fwrite($this->handler, $gb);
  }
  function send() {
    fseek($this->handler, 0);
    fpassthru($this->handler);
    fclose($this->handler);
  }
}
$Zb = "'(?:''|[^'\\\\]|\\\\.)*'";
$Zc = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) $_GET["edit"] = $_GET["select"];
if (isset($_GET["callf"])) $_GET["call"] = $_GET["callf"];
if (isset($_GET["function"])) $_GET["procedure"] = $_GET["function"];
if (isset($_GET["download"])) {
  $a = $_GET["download"];
  $m = fields($a);
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=" . friendly_url("$a-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
  $N = array(
    idf_escape($_GET["field"])
  );
  $J = $j->select($a, $N, array(
    where($_GET, $m)
  ) , $N);
  $L = ($J ? $J->fetch_row() : array());
  echo $j->value($L[0], $m[$_GET["field"]]);
  exit;
}
elseif (isset($_GET["table"])) {
  $a = $_GET["table"];
  $m = fields($a);
  if (!$m) $k = error();
  $R = table_status1($a, true);
  $E = $b->tableName($R);
  page_header(($m && is_view($R) ? $R['Engine'] == 'materialized view' ? 'Materialized view' : 'View' : 'Table') . ": " . ($E != "" ? $E : h($a)) , $k);
  $b->selectLinks($R);
  $bb = $R["Comment"];
  if ($bb != "") echo "<p class='nowrap'>" . 'Comment' . ": " . h($bb) . "\n";
  if ($m) $b->tableStructurePrint($m);
  if (!is_view($R)) {
    if (support("indexes")) {
      echo "<h3 id='indexes'>" . 'Indexes' . "</h3>\n";
      $w = indexes($a);
      if ($w) $b->tableIndexesPrint($w);
      echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($a) . '">Alter indexes' . "</a>\n";
    }
    if (fk_support($R)) {
      echo "<h3 id='foreign-keys'>" . 'Foreign keys' . "</h3>\n";
      $o = foreign_keys($a);
      if ($o) {
        echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Source' . "<td>" . 'Target' . "<td>" . 'ON DELETE' . "<td>" . 'ON UPDATE' . "<td></thead>\n";
        foreach ($o as $E => $n) {
          echo "<tr title='" . h($E) . "'>", "<th><i>" . implode("</i>, <i>", array_map('h', $n["source"])) . "</i>", "<td><a href='" . h($n["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($n["db"]) , ME) : ($n["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($n["ns"]) , ME) : ME)) . "table=" . urlencode($n["table"]) . "'>" . ($n["db"] != "" ? "<b>" . h($n["db"]) . "</b>." : "") . ($n["ns"] != "" ? "<b>" . h($n["ns"]) . "</b>." : "") . h($n["table"]) . "</a>", "(<i>" . implode("</i>, <i>", array_map('h', $n["target"])) . "</i>)", "<td>" . h($n["on_delete"]) . "\n", "<td>" . h($n["on_update"]) . "\n", '<td><a href="' . h(ME . 'foreign=' . urlencode($a) . '&name=' . urlencode($E)) . '">Alter</a>';
        }
        echo "</table>\n";
      }
      echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($a) . '">Add foreign key' . "</a>\n";
    }
  }
  if (support(is_view($R) ? "view_trigger" : "trigger")) {
    echo "<h3 id='triggers'>" . 'Triggers' . "</h3>\n";
    $Qg = triggers($a);
    if ($Qg) {
      echo "<table cellspacing='0'>\n";
      foreach ($Qg as $z => $X) echo "<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($z) . "<td><a href='" . h(ME . 'trigger=' . urlencode($a) . '&name=' . urlencode($z)) . "'>" . 'Alter' . "</a>\n";
      echo "</table>\n";
    }
    echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($a) . '">Add trigger' . "</a>\n";
  }
}
elseif (isset($_GET["schema"])) {
  page_header('Database schema', "", array() , h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
  $og = array();
  $pg = array();
  $ea = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB) ]);
  preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Dd, PREG_SET_ORDER);
  foreach ($Dd as $t => $C) {
    $og[$C[1]] = array(
      $C[2],
      $C[3]
    );
    $pg[] = "\n\t'" . js_escape($C[1]) . "': [ $C[2], $C[3] ]";
  }
  $Ig = 0;
  $Ca = - 1;
  $Df = array();
  $pf = array();
  $ud = array();
  foreach (table_status('', true) as $Q => $R) {
    if (is_view($R)) continue;
    $Se = 0;
    $Df[$Q]["fields"] = array();
    foreach (fields($Q) as $E => $l) {
      $Se += 1.25;
      $l["pos"] = $Se;
      $Df[$Q]["fields"][$E] = $l;
    }
    $Df[$Q]["pos"] = ($og[$Q] ? $og[$Q] : array(
      $Ig,
      0
    ));
    foreach ($b->foreignKeys($Q) as $X) {
      if (!$X["db"]) {
        $sd = $Ca;
        if ($og[$Q][1] || $og[$X["table"]][1]) $sd = min(floatval($og[$Q][1]) , floatval($og[$X["table"]][1])) - 1;
        else $Ca -= .1;
        while ($ud[(string)$sd]) $sd -= .0001;
        $Df[$Q]["references"][$X["table"]][(string)$sd] = array(
          $X["source"],
          $X["target"]
        );
        $pf[$X["table"]][$Q][(string)$sd] = $X["target"];
        $ud[(string)$sd] = true;
      }
    }
    $Ig = max($Ig, $Df[$Q]["pos"][0] + 2.5 + $Se);
  }
  echo '<div id="schema" style="height: ', $Ig, 'em;">
<script', nonce() , '>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {', implode(",", $pg) . "\n", '};
var em = qs(\'#schema\').offsetHeight / ', $Ig, ';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'', js_escape(DB) , '\');
</script>
';
  foreach ($Df as $E => $Q) {
    echo "<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>", '<a href="' . h(ME) . 'table=' . urlencode($E) . '"><b>' . h($E) . "</b></a>", script("qsl('div').onmousedown = schemaMousedown;");
    foreach ($Q["fields"] as $l) {
      $X = '<span' . type_class($l["type"]) . ' title="' . h($l["full_type"] . ($l["null"] ? " NULL" : '')) . '">' . h($l["field"]) . '</span>';
      echo "<br>" . ($l["primary"] ? "<i>$X</i>" : $X);
    }
    foreach ((array)$Q["references"] as $vg => $qf) {
      foreach ($qf as $sd => $mf) {
        $td = $sd - $og[$E][1];
        $t = 0;
        foreach ($mf[0] as $Uf) echo "\n<div class='references' title='" . h($vg) . "' id='refs$sd-" . ($t++) . "' style='left: $td" . "em; top: " . $Q["fields"][$Uf]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$td) . "em;'></div></div>";
      }
    }
    foreach ((array)$pf[$E] as $vg => $qf) {
      foreach ($qf as $sd => $d) {
        $td = $sd - $og[$E][1];
        $t = 0;
        foreach ($d as $ug) echo "\n<div class='references' title='" . h($vg) . "' id='refd$sd-" . ($t++) . "' style='left: $td" . "em; top: " . $Q["fields"][$ug]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.7.7") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$td) . "em;'></div></div>";
      }
    }
    echo "\n</div>\n";
  }
  foreach ($Df as $E => $Q) {
    foreach ((array)$Q["references"] as $vg => $qf) {
      foreach ($qf as $sd => $mf) {
        $Pd = $Ig;
        $Hd = - 10;
        foreach ($mf[0] as $z => $Uf) {
          $Te = $Q["pos"][0] + $Q["fields"][$Uf]["pos"];
          $Ue = $Df[$vg]["pos"][0] + $Df[$vg]["fields"][$mf[1][$z]]["pos"];
          $Pd = min($Pd, $Te, $Ue);
          $Hd = max($Hd, $Te, $Ue);
        }
        echo "<div class='references' id='refl$sd' style='left: $sd" . "em; top: $Pd" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Hd - $Pd) . "em;'></div></div>\n";
      }
    }
  }
  echo '</div>
<p class="links"><a href="', h(ME . "schema=" . urlencode($ea)) , '" id="schema-link">Permanent link</a>
';
}
elseif (isset($_GET["dump"])) {
  $a = $_GET["dump"];
  if ($_POST && !$k) {
    $jb = "";
    foreach (array(
      "output",
      "format",
      "db_style",
      "routines",
      "events",
      "table_style",
      "auto_increment",
      "triggers",
      "data_style"
    ) as $z) $jb .= "&$z=" . urlencode($_POST[$z]);
    cookie("adminer_export", substr($jb, 1));
    $S = array_flip((array)$_POST["tables"]) + array_flip((array)$_POST["data"]);
    $kc = dump_headers((count($S) == 1 ? key($S) : DB) , (DB == "" || count($S) > 1));
    $hd = preg_match('~sql~', $_POST["format"]);
    if ($hd) {
      echo "-- Adminer $ga " . $Ib[DRIVER] . " dump\n\n";
      if ($y == "sql") {
        echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
        $e->query("SET time_zone = '+00:00';");
      }
    }
    $gg = $_POST["db_style"];
    $h = array(
      DB
    );
    if (DB == "") {
      $h = $_POST["databases"];
      if (is_string($h)) $h = explode("\n", rtrim(str_replace("\r", "", $h) , "\n"));
    }
    foreach ((array)$h as $i) {
      $b->dumpDatabase($i);
      if ($e->select_db($i)) {
        if ($hd && preg_match('~CREATE~', $gg) && ($g = $e->result("SHOW CREATE DATABASE " . idf_escape($i) , 1))) {
          set_utf8mb4($g);
          if ($gg == "DROP+CREATE") echo "DROP DATABASE IF EXISTS " . idf_escape($i) . ";\n";
          echo "$g;\n";
        }
        if ($hd) {
          if ($gg) echo use_sql($i) . ";\n\n";
          $Be = "";
          if ($_POST["routines"]) {
            foreach (array(
              "FUNCTION",
              "PROCEDURE"
            ) as $zf) {
              foreach (get_rows("SHOW $zf STATUS WHERE Db = " . q($i) , null, "-- ") as $L) {
                $g = remove_definer($e->result("SHOW CREATE $zf " . idf_escape($L["Name"]) , 2));
                set_utf8mb4($g);
                $Be .= ($gg != 'DROP+CREATE' ? "DROP $zf IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$g;;\n\n";
              }
            }
          }
          if ($_POST["events"]) {
            foreach (get_rows("SHOW EVENTS", null, "-- ") as $L) {
              $g = remove_definer($e->result("SHOW CREATE EVENT " . idf_escape($L["Name"]) , 3));
              set_utf8mb4($g);
              $Be .= ($gg != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($L["Name"]) . ";;\n" : "") . "$g;;\n\n";
            }
          }
          if ($Be) echo "DELIMITER ;;\n\n$Be" . "DELIMITER ;\n\n";
        }
        if ($_POST["table_style"] || $_POST["data_style"]) {
          $ph = array();
          foreach (table_status('', true) as $E => $R) {
            $Q = (DB == "" || in_array($E, (array)$_POST["tables"]));
            $rb = (DB == "" || in_array($E, (array)$_POST["data"]));
            if ($Q || $rb) {
              if ($kc == "tar") {
                $Gg = new TmpFile;
                ob_start(array(
                  $Gg,
                  'write'
                ) , 1e5);
              }
              $b->dumpTable($E, ($Q ? $_POST["table_style"] : "") , (is_view($R) ? 2 : 0));
              if (is_view($R)) $ph[] = $E;
              elseif ($rb) {
                $m = fields($E);
                $b->dumpData($E, $_POST["data_style"], "SELECT *" . convert_fields($m, $m) . " FROM " . table($E));
              }
              if ($hd && $_POST["triggers"] && $Q && ($Qg = trigger_sql($E))) echo "\nDELIMITER ;;\n$Qg\nDELIMITER ;\n";
              if ($kc == "tar") {
                ob_end_flush();
                tar_file((DB != "" ? "" : "$i/") . "$E.csv", $Gg);
              }
              elseif ($hd) echo "\n";
            }
          }
          foreach ($ph as $oh) $b->dumpTable($oh, $_POST["table_style"], 1);
          if ($kc == "tar") echo pack("x512");
        }
      }
    }
    if ($hd) echo "-- " . $e->result("SELECT NOW()") . "\n";
    exit;
  }
  page_header('Export', $k, ($_GET["export"] != "" ? array(
    "table" => $_GET["export"]
  ) : array()) , h(DB));
  echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
';
  $vb = array(
    '',
    'USE',
    'DROP+CREATE',
    'CREATE'
  );
  $qg = array(
    '',
    'DROP+CREATE',
    'CREATE'
  );
  $sb = array(
    '',
    'TRUNCATE+INSERT',
    'INSERT'
  );
  if ($y == "sql") $sb[] = 'INSERT+UPDATE';
  parse_str($_COOKIE["adminer_export"], $L);
  if (!$L) $L = array(
    "output" => "text",
    "format" => "sql",
    "db_style" => (DB != "" ? "" : "CREATE") ,
    "table_style" => "DROP+CREATE",
    "data_style" => "INSERT"
  );
  if (!isset($L["events"])) {
    $L["routines"] = $L["events"] = ($_GET["dump"] == "");
    $L["triggers"] = $L["table_style"];
  }
  echo "<tr><th>" . 'Output' . "<td>" . html_select("output", $b->dumpOutput() , $L["output"], 0) . "\n";
  echo "<tr><th>" . 'Format' . "<td>" . html_select("format", $b->dumpFormat() , $L["format"], 0) . "\n";
  echo ($y == "sqlite" ? "" : "<tr><th>" . 'Database' . "<td>" . html_select('db_style', $vb, $L["db_style"]) . (support("routine") ? checkbox("routines", 1, $L["routines"], 'Routines') : "") . (support("event") ? checkbox("events", 1, $L["events"], 'Events') : "")) , "<tr><th>" . 'Tables' . "<td>" . html_select('table_style', $qg, $L["table_style"]) . checkbox("auto_increment", 1, $L["auto_increment"], 'Auto Increment') . (support("trigger") ? checkbox("triggers", 1, $L["triggers"], 'Triggers') : "") , "<tr><th>" . 'Data' . "<td>" . html_select('data_style', $sb, $L["data_style"]) , '</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="', $T, '">

<table cellspacing="0">
', script("qsl('table').onclick = dumpClick;");
  $Xe = array();
  if (DB != "") {
    $Na = ($a != "" ? "" : " checked");
    echo "<thead><tr>", "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Na>" . 'Tables' . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", "") , "<th style='text-align: right;'><label class='block'>" . 'Data' . "<input type='checkbox' id='check-data'$Na></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", "") , "</thead>\n";
    $ph = "";
    $rg = tables_list();
    foreach ($rg as $E => $U) {
      $We = preg_replace('~_.*~', '', $E);
      $Na = ($a == "" || $a == (substr($a, -1) == "%" ? "$We%" : $E));
      $Ze = "<tr><td>" . checkbox("tables[]", $E, $Na, $E, "", "block");
      if ($U !== null && !preg_match('~table~i', $U)) $ph .= "$Ze\n";
      else echo "$Ze<td align='right'><label class='block'><span id='Rows-" . h($E) . "'></span>" . checkbox("data[]", $E, $Na) . "</label>\n";
      $Xe[$We]++;
    }
    echo $ph;
    if ($rg) echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
  }
  else {
    echo "<thead><tr><th style='text-align: left;'>", "<label class='block'><input type='checkbox' id='check-databases'" . ($a == "" ? " checked" : "") . ">" . 'Database' . "</label>", script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", "") , "</thead>\n";
    $h = $b->databases();
    if ($h) {
      foreach ($h as $i) {
        if (!information_schema($i)) {
          $We = preg_replace('~_.*~', '', $i);
          echo "<tr><td>" . checkbox("databases[]", $i, $a == "" || $a == "$We%", $i, "", "block") . "\n";
          $Xe[$We]++;
        }
      }
    }
    else echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
  }
  echo '</table></form>';
  $uc = true;
  foreach ($Xe as $z => $X) {
    if ($z != "" && $X > 1) {
      echo ($uc ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$z%") . "'>" . h($z) . "</a>";
      $uc = false;
    }
  }
}
elseif (isset($_GET["privileges"])) {
  page_header('Privileges');
  echo '<p class="links"><a href="' . h(ME) . 'user=">Create user' . "</a>";
  $J = $e->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
  $r = $J;
  if (!$J) $J = $e->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
  echo "<form action=''><p>\n";
  hidden_fields_get();
  echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n", ($r ? "" : "<input type='hidden' name='grant' value=''>\n") , "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Username' . "<th>" . 'Server' . "<th></thead>\n";
  while ($L = $J->fetch_assoc()) echo '<tr' . odd() . '><td>' . h($L["User"]) . "<td>" . h($L["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($L["User"]) . '&host=' . urlencode($L["Host"])) . '">Edit' . "</a>\n";
  if (!$r || DB != "") echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . 'Edit' . "'>\n";
  echo "</table>\n", "</form>\n";
}
elseif (isset($_GET["sql"])) {
  if (!$k && $_POST["export"]) {
    dump_headers("sql");
    $b->dumpTable("", "");
    $b->dumpData("", "table", $_POST["query"]);
    exit;
  }
  restart_session();
  $Pc = & get_session("queries");
  $Oc = & $Pc[DB];
  if (!$k && $_POST["clear"]) {
    $Oc = array();
    redirect(remove_from_uri("history"));
  }
  page_header((isset($_GET["import"]) ? 'Import' : 'SQL command') , $k);
  if (!$k && $_POST) {
    $p = false;
    if (!isset($_GET["import"])) $I = $_POST["query"];
    elseif ($_POST["webfile"]) {
      $Xf = $b->importServerPath();
      $p = @fopen((file_exists($Xf) ? $Xf : "compress.zlib://$Xf.gz") , "rb");
      $I = ($p ? fread($p, 1e6) : false);
    }
    else $I = get_file("sql_file", true);
    if (is_string($I)) {
      if (function_exists('memory_get_usage')) @ini_set("memory_limit", max(ini_bytes("memory_limit") , 2 * strlen($I) + memory_get_usage() + 8e6));
      if ($I != "" && strlen($I) < 1e6) {
        $H = $I . (preg_match("~;[ \t\r\n]*\$~", $I) ? "" : ";");
        if (!$Oc || reset(end($Oc)) != $H) {
          restart_session();
          $Oc[] = array(
            $H,
            time()
          );
          set_session("queries", $Pc);
          stop_session();
        }
      }
      $Vf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
      $Ab = ";";
      $ee = 0;
      $Wb = true;
      $f = connect();
      if (is_object($f) && DB != "") {
        $f->select_db(DB);
        if ($_GET["ns"] != "") set_schema($_GET["ns"], $f);
      }
      $ab = 0;
      $bc = array();
      $He = '[\'"' . ($y == "sql" ? '`#' : ($y == "sqlite" ? '`[' : ($y == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($y == "pgsql" ? '|\$[^$]*\$' : '');
      $Jg = microtime(true);
      parse_str($_COOKIE["adminer_export"], $la);
      $Nb = $b->dumpFormat();
      unset($Nb["sql"]);
      while ($I != "") {
        if (!$ee && preg_match("~^$Vf*+DELIMITER\\s+(\\S+)~i", $I, $C)) {
          $Ab = $C[1];
          $I = substr($I, strlen($C[0]));
        }
        else {
          preg_match('(' . preg_quote($Ab) . "\\s*|$He)", $I, $C, PREG_OFFSET_CAPTURE, $ee);
          list($_c, $Se) = $C[0];
          if (!$_c && $p && !feof($p)) $I .= fread($p, 1e5);
          else {
            if (!$_c && rtrim($I) == "") break;
            $ee = $Se + strlen($_c);
            if ($_c && rtrim($_c) != $Ab) {
              while (preg_match('(' . ($_c == '/*' ? '\*/' : ($_c == '[' ? ']' : (preg_match('~^-- |^#~', $_c) ? "\n" : preg_quote($_c) . "|\\\\."))) . '|$)s', $I, $C, PREG_OFFSET_CAPTURE, $ee)) {
                $Bf = $C[0][0];
                if (!$Bf && $p && !feof($p)) $I .= fread($p, 1e5);
                else {
                  $ee = $C[0][1] + strlen($Bf);
                  if ($Bf[0] != "\\") break;
                }
              }
            }
            else {
              $Wb = false;
              $H = substr($I, 0, $Se);
              $ab++;
              $Ze = "<pre id='sql-$ab'><code class='jush-$y'>" . $b->sqlCommandQuery($H) . "</code></pre>\n";
              if ($y == "sqlite" && preg_match("~^$Vf*+ATTACH\\b~i", $H, $C)) {
                echo $Ze, "<p class='error'>" . 'ATTACH queries are not supported.' . "\n";
                $bc[] = " <a href='#sql-$ab'>$ab</a>";
                if ($_POST["error_stops"]) break;
              }
              else {
                if (!$_POST["only_errors"]) {
                  echo $Ze;
                  ob_flush();
                  flush();
                }
                $ag = microtime(true);
                if ($e->multi_query($H) && is_object($f) && preg_match("~^$Vf*+USE\\b~i", $H)) $f->query($H);
                do {
                  $J = $e->store_result();
                  if ($e->error) {
                    echo ($_POST["only_errors"] ? $Ze : "") , "<p class='error'>" . 'Error in query' . ($e->errno ? " ($e->errno)" : "") . ": " . error() . "\n";
                    $bc[] = " <a href='#sql-$ab'>$ab</a>";
                    if ($_POST["error_stops"]) break 2;
                  }
                  else {
                    $_g = " <span class='time'>(" . format_time($ag) . ")</span>" . (strlen($H) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($H)) . "'>" . 'Edit' . "</a>" : "");
                    $na = $e->affected_rows;
                    $sh = ($_POST["only_errors"] ? "" : $j->warnings());
                    $th = "warnings-$ab";
                    if ($sh) $_g .= ", <a href='#$th'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$th');", "");
                    $ic = null;
                    $jc = "explain-$ab";
                    if (is_object($J)) {
                      $_ = $_POST["limit"];
                      $we = select($J, $f, array() , $_);
                      if (!$_POST["only_errors"]) {
                        echo "<form action='' method='post'>\n";
                        $be = $J->num_rows;
                        echo "<p>" . ($be ? ($_ && $be > $_ ? sprintf('%d / ', $_) : "") . lang(array(
                          '%d row',
                          '%d rows'
                        ) , $be) : "") , $_g;
                        if ($f && preg_match("~^($Vf|\\()*+SELECT\\b~i", $H) && ($ic = explain($f, $H))) echo ", <a href='#$jc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$jc');", "");
                        $u = "export-$ab";
                        echo ", <a href='#$u'>" . 'Export' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "<span id='$u' class='hidden'>: " . html_select("output", $b->dumpOutput() , $la["output"]) . " " . html_select("format", $Nb, $la["format"]) . "<input type='hidden' name='query' value='" . h($H) . "'>" . " <input type='submit' name='export' value='" . 'Export' . "'><input type='hidden' name='token' value='$T'></span>\n" . "</form>\n";
                      }
                    }
                    else {
                      if (preg_match("~^$Vf*+(CREATE|DROP|ALTER)$Vf++(DATABASE|SCHEMA)\\b~i", $H)) {
                        restart_session();
                        set_session("dbs", null);
                        stop_session();
                      }
                      if (!$_POST["only_errors"]) echo "<p class='message' title='" . h($e->info) . "'>" . lang(array(
                        'Query executed OK, %d row affected.',
                        'Query executed OK, %d rows affected.'
                      ) , $na) . "$_g\n";
                    }
                    echo ($sh ? "<div id='$th' class='hidden'>\n$sh</div>\n" : "");
                    if ($ic) {
                      echo "<div id='$jc' class='hidden'>\n";
                      select($ic, $f, $we);
                      echo "</div>\n";
                    }
                  }
                  $ag = microtime(true);
                }
                while ($e->next_result());
              }
              $I = substr($I, $ee);
              $ee = 0;
            }
          }
        }
      } if ($Wb) echo "<p class='message'>" . 'No commands to execute.' . "\n";
      elseif ($_POST["only_errors"]) {
        echo "<p class='message'>" . lang(array(
          '%d query executed OK.',
          '%d queries executed OK.'
        ) , $ab - count($bc)) , " <span class='time'>(" . format_time($Jg) . ")</span>\n";
      }
      elseif ($bc && $ab > 1) echo "<p class='error'>" . 'Error in query' . ": " . implode("", $bc) . "\n";
    }
    else echo "<p class='error'>" . upload_error($I) . "\n";
  }
  echo '
<form action="" method="post" enctype="multipart/form-data" id="form">
';
  $gc = "<input type='submit' value='" . 'Execute' . "' title='Ctrl+Enter'>";
  if (!isset($_GET["import"])) {
    $H = $_GET["sql"];
    if ($_POST) $H = $_POST["query"];
    elseif ($_GET["history"] == "all") $H = $Oc;
    elseif ($_GET["history"] != "") $H = $Oc[$_GET["history"]][0];
    echo "<p>";
    textarea("query", $H, 20);
    echo script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . remove_from_uri("sql|limit|error_stops|only_errors") . "');") , "<p>$gc\n", 'Limit rows' . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
  }
  else {
    echo "<fieldset><legend>" . 'File upload' . "</legend><div>";
    $Hc = (extension_loaded("zlib") ? "[.gz]" : "");
    echo (ini_bool("file_uploads") ? "SQL$Hc (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$gc" : 'File uploads are disabled.') , "</div></fieldset>\n";
    $Vc = $b->importServerPath();
    if ($Vc) {
      echo "<fieldset><legend>" . 'From server' . "</legend><div>", sprintf('Webserver file %s', "<code>" . h($Vc) . "$Hc</code>") , ' <input type="submit" name="webfile" value="Run file">', "</div></fieldset>\n";
    }
    echo "<p>";
  }
  echo checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"])) , 'Stop on error') . "\n", checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"])) , 'Show only errors') . "\n", "<input type='hidden' name='token' value='$T'>\n";
  if (!isset($_GET["import"]) && $Oc) {
    print_fieldset("history", 'History', $_GET["history"] != "");
    for ($X = end($Oc);$X;$X = prev($Oc)) {
      $z = key($Oc);
      list($H, $_g, $Rb) = $X;
      echo '<a href="' . h(ME . "sql=&history=$z") . '">Edit' . "</a>" . " <span class='time' title='" . @date('Y-m-d', $_g) . "'>" . @date("H:i:s", $_g) . "</span>" . " <code class='jush-$y'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $H)))) , 80, "</code>") . ($Rb ? " <span class='time'>($Rb)</span>" : "") . "<br>\n";
    }
    echo "<input type='submit' name='clear' value='" . 'Clear' . "'>\n", "<a href='" . h(ME . "sql=&history=all") . "'>" . 'Edit all' . "</a>\n", "</div></fieldset>\n";
  }
  echo '</form>
';
}
elseif (isset($_GET["edit"])) {
  $a = $_GET["edit"];
  $m = fields($a);
  $Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $m) : "") : where($_GET, $m));
  $bh = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
  foreach ($m as $E => $l) {
    if (!isset($l["privileges"][$bh ? "update" : "insert"]) || $b->fieldName($l) == "" || $l["generated"]) unset($m[$E]);
  }
  if ($_POST && !$k && !isset($_GET["select"])) {
    $B = $_POST["referer"];
    if ($_POST["insert"]) $B = ($bh ? null : $_SERVER["REQUEST_URI"]);
    elseif (!preg_match('~^.+&select=.+$~', $B)) $B = ME . "select=" . urlencode($a);
    $w = indexes($a);
    $Wg = unique_array($_GET["where"], $w);
    $if = "\nWHERE $Z";
    if (isset($_POST["delete"])) queries_redirect($B, 'Item has been deleted.', $j->delete($a, $if, !$Wg));
    else {
      $P = array();
      foreach ($m as $E => $l) {
        $X = process_input($l);
        if ($X !== false && $X !== null) $P[idf_escape($E) ] = $X;
      }
      if ($bh) {
        if (!$P) redirect($B);
        queries_redirect($B, 'Item has been updated.', $j->update($a, $P, $if, !$Wg));
        if (is_ajax()) {
          page_headers();
          page_messages($k);
          exit;
        }
      }
      else {
        $J = $j->insert($a, $P);
        $rd = ($J ? last_id() : 0);
        queries_redirect($B, sprintf('Item%s has been inserted.', ($rd ? " $rd" : "")) , $J);
      }
    }
  }
  $L = null;
  if ($_POST["save"]) $L = (array)$_POST["fields"];
  elseif ($Z) {
    $N = array();
    foreach ($m as $E => $l) {
      if (isset($l["privileges"]["select"])) {
        $ua = convert_field($l);
        if ($_POST["clone"] && $l["auto_increment"]) $ua = "''";
        if ($y == "sql" && preg_match("~enum|set~", $l["type"])) $ua = "1*" . idf_escape($E);
        $N[] = ($ua ? "$ua AS " : "") . idf_escape($E);
      }
    }
    $L = array();
    if (!support("table")) $N = array(
      "*"
    );
    if ($N) {
      $J = $j->select($a, $N, array(
        $Z
      ) , $N, array() , (isset($_GET["select"]) ? 2 : 1));
      if (!$J) $k = error();
      else {
        $L = $J->fetch_assoc();
        if (!$L) $L = false;
      }
      if (isset($_GET["select"]) && (!$L || $J->fetch_assoc())) $L = null;
    }
  }
  if (!support("table") && !$m) {
    if (!$Z) {
      $J = $j->select($a, array(
        "*"
      ) , $Z, array(
        "*"
      ));
      $L = ($J ? $J->fetch_assoc() : false);
      if (!$L) $L = array(
        $j->primary => ""
      );
    }
    if ($L) {
      foreach ($L as $z => $X) {
        if (!$Z) $L[$z] = null;
        $m[$z] = array(
          "field" => $z,
          "null" => ($z != $j->primary) ,
          "auto_increment" => ($z == $j->primary)
        );
      }
    }
  }
  edit_form($a, $m, $L, $bh);
}
elseif (isset($_GET["create"])) {
  $a = $_GET["create"];
  $Ie = array();
  foreach (array(
    'HASH',
    'LINEAR HASH',
    'KEY',
    'LINEAR KEY',
    'RANGE',
    'LIST'
  ) as $z) $Ie[$z] = $z;
  $of = referencable_primary($a);
  $o = array();
  foreach ($of as $ng => $l) $o[str_replace("`", "``", $ng) . "`" . str_replace("`", "``", $l["field"]) ] = $ng;
  $ze = array();
  $R = array();
  if ($a != "") {
    $ze = fields($a);
    $R = table_status($a);
    if (!$R) $k = 'No tables.';
  }
  $L = $_POST;
  $L["fields"] = (array)$L["fields"];
  if ($L["auto_increment_col"]) $L["fields"][$L["auto_increment_col"]]["auto_increment"] = true;
  if ($_POST) set_adminer_settings(array(
    "comments" => $_POST["comments"],
    "defaults" => $_POST["defaults"]
  ));
  if ($_POST && !process_fields($L["fields"]) && !$k) {
    if ($_POST["drop"]) queries_redirect(substr(ME, 0, -1) , 'Table has been dropped.', drop_tables(array(
      $a
    )));
    else {
      $m = array();
      $ra = array();
      $fh = false;
      $xc = array();
      $ye = reset($ze);
      $pa = " FIRST";
      foreach ($L["fields"] as $z => $l) {
        $n = $o[$l["type"]];
        $Rg = ($n !== null ? $of[$n] : $l);
        if ($l["field"] != "") {
          if (!$l["has_default"]) $l["default"] = null;
          if ($z == $L["auto_increment_col"]) $l["auto_increment"] = true;
          $ef = process_field($l, $Rg);
          $ra[] = array(
            $l["orig"],
            $ef,
            $pa
          );
          if ($ef != process_field($ye, $ye)) {
            $m[] = array(
              $l["orig"],
              $ef,
              $pa
            );
            if ($l["orig"] != "" || $pa) $fh = true;
          }
          if ($n !== null) $xc[idf_escape($l["field"]) ] = ($a != "" && $y != "sqlite" ? "ADD" : " ") . format_foreign_key(array(
            'table' => $o[$l["type"]],
            'source' => array(
              $l["field"]
            ) ,
            'target' => array(
              $Rg["field"]
            ) ,
            'on_delete' => $l["on_delete"],
          ));
          $pa = " AFTER " . idf_escape($l["field"]);
        }
        elseif ($l["orig"] != "") {
          $fh = true;
          $m[] = array(
            $l["orig"]
          );
        }
        if ($l["orig"] != "") {
          $ye = next($ze);
          if (!$ye) $pa = "";
        }
      }
      $Ke = "";
      if ($Ie[$L["partition_by"]]) {
        $Le = array();
        if ($L["partition_by"] == 'RANGE' || $L["partition_by"] == 'LIST') {
          foreach (array_filter($L["partition_names"]) as $z => $X) {
            $Y = $L["partition_values"][$z];
            $Le[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($L["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
          }
        }
        $Ke .= "\nPARTITION BY $L[partition_by]($L[partition])" . ($Le ? " (" . implode(",", $Le) . "\n)" : ($L["partitions"] ? " PARTITIONS " . (+$L["partitions"]) : ""));
      }
      elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"])) $Ke .= "\nREMOVE PARTITIONING";
      $D = 'Table has been altered.';
      if ($a == "") {
        cookie("adminer_engine", $L["Engine"]);
        $D = 'Table has been created.';
      }
      $E = trim($L["name"]);
      queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($E) , $D, alter_table($a, $E, ($y == "sqlite" && ($fh || $xc) ? $ra : $m) , $xc, ($L["Comment"] != $R["Comment"] ? $L["Comment"] : null) , ($L["Engine"] && $L["Engine"] != $R["Engine"] ? $L["Engine"] : "") , ($L["Collation"] && $L["Collation"] != $R["Collation"] ? $L["Collation"] : "") , ($L["Auto_increment"] != "" ? number($L["Auto_increment"]) : "") , $Ke));
    }
  }
  page_header(($a != "" ? 'Alter table' : 'Create table') , $k, array(
    "table" => $a
  ) , h($a));
  if (!$_POST) {
    $L = array(
      "Engine" => $_COOKIE["adminer_engine"],
      "fields" => array(
        array(
          "field" => "",
          "type" => (isset($Tg["int"]) ? "int" : (isset($Tg["integer"]) ? "integer" : "")) ,
          "on_update" => ""
        )
      ) ,
      "partition_names" => array("") ,
    );
    if ($a != "") {
      $L = $R;
      $L["name"] = $a;
      $L["fields"] = array();
      if (!$_GET["auto_increment"]) $L["Auto_increment"] = "";
      foreach ($ze as $l) {
        $l["has_default"] = isset($l["default"]);
        $L["fields"][] = $l;
      }
      if (support("partitioning")) {
        $Bc = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($a);
        $J = $e->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $Bc ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
        list($L["partition_by"], $L["partitions"], $L["partition"]) = $J->fetch_row();
        $Le = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Bc AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
        $Le[""] = "";
        $L["partition_names"] = array_keys($Le);
        $L["partition_values"] = array_values($Le);
      }
    }
  }
  $Xa = collations();
  $Yb = engines();
  foreach ($Yb as $Xb) {
    if (!strcasecmp($Xb, $L["Engine"])) {
      $L["Engine"] = $Xb;
      break;
    }
  }
  echo '
<form action="" method="post" id="form"><p>';
  if (support("columns") || $a == "") {
    echo 'Table name: <input name="name" data-maxlength="64" value="', h($L["name"]) , '" autocapitalize="off">';
    if ($a == "" && !$_POST) echo script("focus(qs('#form')['name']);");
    echo ($Yb ? "<select name='Engine'>" . optionlist(array(
      "" => "(" . 'engine' . ")"
    ) + $Yb, $L["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : "") , ' ', ($Xa && !preg_match("~sqlite|mssql~", $y) ? html_select("Collation", array(
      "" => "(" . 'collation' . ")"
    ) + $Xa, $L["Collation"]) : "") , ' <input type="submit" value="Save">';
  }
  echo '';
  if (support("columns")) {
    echo '<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">';
    edit_fields($L["fields"], $Xa, "TABLE", $o);
    echo '</table>', script("editFields();") , '</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="', h($L["Auto_increment"]) , '">
', checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")) , 'Default values', "columnShow(this.checked, 5)", "jsonly") , (support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")) , 'Comment', "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($L["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : '') , '<p>
<input type="submit" value="Save">';
  }
  echo '
';
  if ($a != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
  }
  if (support("partitioning")) {
    $Je = preg_match('~RANGE|LIST~', $L["partition_by"]);
    print_fieldset("partition", 'Partition by', $L["partition_by"]);
    echo '<p>
', "<select name='partition_by'>" . optionlist(array("" => "") + $Ie, $L["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;") , '(<input name="partition" value="', h($L["partition"]) , '">)
Partitions: <input type="number" name="partitions" class="size', ($Je || !$L["partition_by"] ? " hidden" : "") , '" value="', h($L["partitions"]) , '">
<table cellspacing="0" id="partition-table"', ($Je ? "" : " class='hidden'") , '>
<thead><tr><th>Partition name<th>Values</thead>';
    foreach ($L["partition_names"] as $z => $X) {
      echo '<tr>', '<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">', ($z == count($L["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : '') , '<td><input name="partition_values[]" value="' . h($L["partition_values"][$z]) . '">';
    }
    echo '</table></div></fieldset>';
  }
  echo '<input type="hidden" name="token" value="', $T, '"></form>';
} elseif (isset($_GET["indexes"])) {
  $a = $_GET["indexes"];
  $Xc = array(
    "PRIMARY",
    "UNIQUE",
    "INDEX"
  );
  $R = table_status($a, true);
  if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Xc[] = "FULLTEXT";
  if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Xc[] = "SPATIAL";
  $w = indexes($a);
  $Ye = array();
  if ($y == "mongo") {
    $Ye = $w["_id_"];
    unset($Xc[0]);
    unset($w["_id_"]);
  }
  $L = $_POST;
  if ($_POST && !$k && !$_POST["add"] && !$_POST["drop_col"]) {
    $sa = array();
    foreach ($L["indexes"] as $v) {
      $E = $v["name"];
      if (in_array($v["type"], $Xc)) {
        $d = array();
        $xd = array();
        $Cb = array();
        $P = array();
        ksort($v["columns"]);
        foreach ($v["columns"] as $z => $c) {
          if ($c != "") {
            $wd = $v["lengths"][$z];
            $Bb = $v["descs"][$z];
            $P[] = idf_escape($c) . ($wd ? "(" . (+$wd) . ")" : "") . ($Bb ? " DESC" : "");
            $d[] = $c;
            $xd[] = ($wd ? $wd : null);
            $Cb[] = $Bb;
          }
        }
        if ($d) {
          $hc = $w[$E];
          if ($hc) {
            ksort($hc["columns"]);
            ksort($hc["lengths"]);
            ksort($hc["descs"]);
            if ($v["type"] == $hc["type"] && array_values($hc["columns"]) === $d && (!$hc["lengths"] || array_values($hc["lengths"]) === $xd) && array_values($hc["descs"]) === $Cb) {
              unset($w[$E]);
              continue;
            }
          }
          $sa[] = array(
            $v["type"],
            $E,
            $P
          );
        }
      }
    }
    foreach ($w as $E => $hc) $sa[] = array(
      $hc["type"],
      $E,
      "DROP"
    );
    if (!$sa) redirect(ME . "table=" . urlencode($a));
    queries_redirect(ME . "table=" . urlencode($a) , 'Indexes have been altered.', alter_indexes($a, $sa));
  }
  page_header('Indexes', $k, array(
    "table" => $a
  ) , h($a));
  $m = array_keys(fields($a));
  if ($_POST["add"]) {
    foreach ($L["indexes"] as $z => $v) {
      if ($v["columns"][count($v["columns"]) ] != "") $L["indexes"][$z]["columns"][] = "";
    }
    $v = end($L["indexes"]);
    if ($v["type"] || array_filter($v["columns"], 'strlen')) $L["indexes"][] = array(
      "columns" => array(
        1 => ""
      )
    );
  }
  if (!$L) {
    foreach ($w as $z => $v) {
      $w[$z]["name"] = $z;
      $w[$z]["columns"][] = "";
    }
    $w[] = array(
      "columns" => array(
        1 => ""
      )
    );
    $L["indexes"] = $w;
  }
  echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>', "<input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='Add next'>", '</noscript>
</thead>
';
  if ($Ye) {
    echo "<tr><td>PRIMARY<td>";
    foreach ($Ye["columns"] as $z => $c) {
      echo select_input(" disabled", $m, $c) , "<label><input disabled type='checkbox'>" . 'descending' . "</label> ";
    }
    echo "<td><td>\n";
  }
  $x = 1;
  foreach ($L["indexes"] as $v) {
    if (!$_POST["drop_col"] || $x != key($_POST["drop_col"])) {
      echo "<tr><td>" . html_select("indexes[$x][type]", array(-1 => ""
      ) + $Xc, $v["type"], ($x == count($L["indexes"]) ? "indexesAddRow.call(this);" : 1) , "label-type") , "<td>";
      ksort($v["columns"]);
      $t = 1;
      foreach ($v["columns"] as $z => $c) {
        echo "<span>" . select_input(" name='indexes[$x][columns][$t]' title='" . 'Column' . "'", ($m ? array_combine($m, $m) : $m) , $c, "partial(" . ($t == count($v["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($y == "sql" ? "" : $_GET["indexes"] . "_") . "')") , ($y == "sql" || $y == "mssql" ? "<input type='number' name='indexes[$x][lengths][$t]' class='size' value='" . h($v["lengths"][$z]) . "' title='" . 'Length' . "'>" : "") , (support("descidx") ? checkbox("indexes[$x][descs][$t]", 1, $v["descs"][$z], 'descending') : "") , " </span>";
        $t++;
      }
      echo "<td><input name='indexes[$x][name]' value='" . h($v["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n", "<td><input type='image' class='icon' name='drop_col[$x]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.7.7") . "' alt='x' title='" . 'Remove' . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
    }
    $x++;
  }
  echo '</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["database"])) {
  $L = $_POST;
  if ($_POST && !$k && !isset($_POST["add_x"])) {
    $E = trim($L["name"]);
    if ($_POST["drop"]) {
      $_GET["db"] = "";
      queries_redirect(remove_from_uri("db|database") , 'Database has been dropped.', drop_databases(array(
        DB
      )));
    }
    elseif (DB !== $E) {
      if (DB != "") {
        $_GET["db"] = $E;
        queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($E) , 'Database has been renamed.', rename_database($E, $L["collation"]));
      }
      else {
        $h = explode("\n", str_replace("\r", "", $E));
        $hg = true;
        $qd = "";
        foreach ($h as $i) {
          if (count($h) == 1 || $i != "") {
            if (!create_database($i, $L["collation"])) $hg = false;
            $qd = $i;
          }
        }
        restart_session();
        set_session("dbs", null);
        queries_redirect(ME . "db=" . urlencode($qd) , 'Database has been created.', $hg);
      }
    }
    else {
      if (!$L["collation"]) redirect(substr(ME, 0, -1));
      query_redirect("ALTER DATABASE " . idf_escape($E) . (preg_match('~^[a-z0-9_]+$~i', $L["collation"]) ? " COLLATE $L[collation]" : "") , substr(ME, 0, -1) , 'Database has been altered.');
    }
  }
  page_header(DB != "" ? 'Alter database' : 'Create database', $k, array() , h(DB));
  $Xa = collations();
  $E = DB;
  if ($_POST) $E = $L["name"];
  elseif (DB != "") $L["collation"] = db_collation(DB, $Xa);
  elseif ($y == "sql") {
    foreach (get_vals("SHOW GRANTS") as $r) {
      if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $r, $C) && $C[1]) {
        $E = stripcslashes(idf_unescape("`$C[2]`"));
        break;
      }
    }
  }
  echo '
<form action="" method="post">
<p>
', ($_POST["add_x"] || strpos($E, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($E) . '</textarea><br>' : '<input name="name" id="name" value="' . h($E) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($Xa ? html_select("collation", array(
    "" => "(" . 'collation' . ")"
  ) + $Xa, $L["collation"]) . doc_link(array(
    'sql' => "charset-charsets.html",
    'mariadb' => "supported-character-sets-and-collations/",
  )) : "") , script("focus(qs('#name'));") , '<input type="submit" value="Save">
';
  if (DB != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', DB)) . "\n";
  elseif (!$_POST["add_x"] && $_GET["db"] == "") echo "<input type='image' class='icon' name='add' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . 'Add next' . "'>\n";
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["call"])) {
  $da = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
  page_header('Call' . ": " . h($da) , $k);
  $zf = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
  $Wc = array();
  $Be = array();
  foreach ($zf["fields"] as $t => $l) {
    if (substr($l["inout"], -3) == "OUT") $Be[$t] = "@" . idf_escape($l["field"]) . " AS " . idf_escape($l["field"]);
    if (!$l["inout"] || substr($l["inout"], 0, 2) == "IN") $Wc[] = $t;
  }
  if (!$k && $_POST) {
    $Ja = array();
    foreach ($zf["fields"] as $z => $l) {
      if (in_array($z, $Wc)) {
        $X = process_input($l);
        if ($X === false) $X = "''";
        if (isset($Be[$z])) $e->query("SET @" . idf_escape($l["field"]) . " = $X");
      }
      $Ja[] = (isset($Be[$z]) ? "@" . idf_escape($l["field"]) : $X);
    }
    $I = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($da) . "(" . implode(", ", $Ja) . ")";
    $ag = microtime(true);
    $J = $e->multi_query($I);
    $na = $e->affected_rows;
    echo $b->selectQuery($I, $ag, !$J);
    if (!$J) echo "<p class='error'>" . error() . "\n";
    else {
      $f = connect();
      if (is_object($f)) $f->select_db(DB);
      do {
        $J = $e->store_result();
        if (is_object($J)) select($J, $f);
        else echo "<p class='message'>" . lang(array(
          'Routine has been called, %d row affected.',
          'Routine has been called, %d rows affected.'
        ) , $na) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
      }
      while ($e->next_result());
      if ($Be) select($e->query("SELECT " . implode(", ", $Be)));
    }
  }
  echo '
<form action="" method="post">
';
  if ($Wc) {
    echo "<table cellspacing='0' class='layout'>\n";
    foreach ($Wc as $z) {
      $l = $zf["fields"][$z];
      $E = $l["field"];
      echo "<tr><th>" . $b->fieldName($l);
      $Y = $_POST["fields"][$E];
      if ($Y != "") {
        if ($l["type"] == "enum") $Y = + $Y;
        if ($l["type"] == "set") $Y = array_sum($Y);
      }
      input($l, $Y, (string)$_POST["function"][$E]);
      echo "\n";
    }
    echo "</table>\n";
  }
  echo '<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["foreign"])) {
  $a = $_GET["foreign"];
  $E = $_GET["name"];
  $L = $_POST;
  if ($_POST && !$k && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
    $D = ($_POST["drop"] ? 'Foreign key has been dropped.' : ($E != "" ? 'Foreign key has been altered.' : 'Foreign key has been created.'));
    $B = ME . "table=" . urlencode($a);
    if (!$_POST["drop"]) {
      $L["source"] = array_filter($L["source"], 'strlen');
      ksort($L["source"]);
      $ug = array();
      foreach ($L["source"] as $z => $X) $ug[$z] = $L["target"][$z];
      $L["target"] = $ug;
    }
    if ($y == "sqlite") queries_redirect($B, $D, recreate_table($a, $a, array() , array() , array(
      " $E" => ($_POST["drop"] ? "" : " " . format_foreign_key($L))
    )));
    else {
      $sa = "ALTER TABLE " . table($a);
      $Jb = "\nDROP " . ($y == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($E);
      if ($_POST["drop"]) query_redirect($sa . $Jb, $B, $D);
      else {
        query_redirect($sa . ($E != "" ? "$Jb," : "") . "\nADD" . format_foreign_key($L) , $B, $D);
        $k = 'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' . "<br>$k";
      }
    }
  }
  page_header('Foreign key', $k, array(
    "table" => $a
  ) , h($a));
  if ($_POST) {
    ksort($L["source"]);
    if ($_POST["add"]) $L["source"][] = "";
    elseif ($_POST["change"] || $_POST["change-js"]) $L["target"] = array();
  }
  elseif ($E != "") {
    $o = foreign_keys($a);
    $L = $o[$E];
    $L["source"][] = "";
  }
  else {
    $L["table"] = $a;
    $L["source"] = array(
      ""
    );
  }
  echo '
<form action="" method="post">
';
  $Uf = array_keys(fields($a));
  if ($L["db"] != "") $e->select_db($L["db"]);
  if ($L["ns"] != "") set_schema($L["ns"]);
  $nf = array_keys(array_filter(table_status('', true) , 'fk_support'));
  $ug = ($a === $L["table"] ? $Uf : array_keys(fields(in_array($L["table"], $nf) ? $L["table"] : reset($nf))));
  $me = "this.form['change-js'].value = '1'; this.form.submit();";
  echo "<p>" . 'Target table' . ": " . html_select("table", $nf, $L["table"], $me) . "\n";
  if ($y == "pgsql") echo 'Schema' . ": " . html_select("ns", $b->schemas() , $L["ns"] != "" ? $L["ns"] : $_GET["ns"], $me);
  elseif ($y != "sqlite") {
    $wb = array();
    foreach ($b->databases() as $i) {
      if (!information_schema($i)) $wb[] = $i;
    }
    echo 'DB' . ": " . html_select("db", $wb, $L["db"] != "" ? $L["db"] : $_GET["db"], $me);
  }
  echo '<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';
  $x = 0;
  foreach ($L["source"] as $z => $X) {
    echo "<tr>", "<td>" . html_select("source[" . (+$z) . "]", array(-1 => ""
    ) + $Uf, $X, ($x == count($L["source"]) - 1 ? "foreignAddRow.call(this);" : 1) , "label-source") , "<td>" . html_select("target[" . (+$z) . "]", $ug, $L["target"][$z], 1, "label-target");
    $x++;
  }
  echo '</table>
<p>
ON DELETE: ', html_select("on_delete", array(-1 => ""
  ) + explode("|", $le) , $L["on_delete"]) , ' ON UPDATE: ', html_select("on_update", array(-1 => ""
  ) + explode("|", $le) , $L["on_update"]) , doc_link(array(
    'sql' => "innodb-foreign-key-constraints.html",
    'mariadb' => "foreign-keys/",
  )) , '<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';
  if ($E != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $E));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["view"])) {
  $a = $_GET["view"];
  $L = $_POST;
  $_e = "VIEW";
  if ($y == "pgsql" && $a != "") {
    $bg = table_status($a);
    $_e = strtoupper($bg["Engine"]);
  }
  if ($_POST && !$k) {
    $E = trim($L["name"]);
    $ua = " AS\n$L[select]";
    $B = ME . "table=" . urlencode($E);
    $D = 'View has been altered.';
    $U = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
    if (!$_POST["drop"] && $a == $E && $y != "sqlite" && $U == "VIEW" && $_e == "VIEW") query_redirect(($y == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($E) . $ua, $B, $D);
    else {
      $wg = $E . "_adminer_" . uniqid();
      drop_create("DROP $_e " . table($a) , "CREATE $U " . table($E) . $ua, "DROP $U " . table($E) , "CREATE $U " . table($wg) . $ua, "DROP $U " . table($wg) , ($_POST["drop"] ? substr(ME, 0, -1) : $B) , 'View has been dropped.', $D, 'View has been created.', $a, $E);
    }
  }
  if (!$_POST && $a != "") {
    $L = view($a);
    $L["name"] = $a;
    $L["materialized"] = ($_e != "VIEW");
    if (!$k) $k = error();
  }
  page_header(($a != "" ? 'Alter view' : 'Create view') , $k, array(
    "table" => $a
  ) , h($a));
  echo '
<form action="" method="post">
<p>Name: <input name="name" value="', h($L["name"]) , '" data-maxlength="64" autocapitalize="off">
', (support("materializedview") ? " " . checkbox("materialized", 1, $L["materialized"], 'Materialized view') : "") , '<p>';
  textarea("select", $L["select"]);
  echo '<p>
<input type="submit" value="Save">
';
  if ($a != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["event"])) {
  $aa = $_GET["event"];
  $cd = array(
    "YEAR",
    "QUARTER",
    "MONTH",
    "DAY",
    "HOUR",
    "MINUTE",
    "WEEK",
    "SECOND",
    "YEAR_MONTH",
    "DAY_HOUR",
    "DAY_MINUTE",
    "DAY_SECOND",
    "HOUR_MINUTE",
    "HOUR_SECOND",
    "MINUTE_SECOND"
  );
  $cg = array(
    "ENABLED" => "ENABLE",
    "DISABLED" => "DISABLE",
    "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE"
  );
  $L = $_POST;
  if ($_POST && !$k) {
    if ($_POST["drop"]) query_redirect("DROP EVENT " . idf_escape($aa) , substr(ME, 0, -1) , 'Event has been dropped.');
    elseif (in_array($L["INTERVAL_FIELD"], $cd) && isset($cg[$L["STATUS"]])) {
      $Cf = "\nON SCHEDULE " . ($L["INTERVAL_VALUE"] ? "EVERY " . q($L["INTERVAL_VALUE"]) . " $L[INTERVAL_FIELD]" . ($L["STARTS"] ? " STARTS " . q($L["STARTS"]) : "") . ($L["ENDS"] ? " ENDS " . q($L["ENDS"]) : "") : "AT " . q($L["STARTS"])) . " ON COMPLETION" . ($L["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
      queries_redirect(substr(ME, 0, -1) , ($aa != "" ? 'Event has been altered.' : 'Event has been created.') , queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $Cf . ($aa != $L["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($L["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($L["EVENT_NAME"]) . $Cf) . "\n" . $cg[$L["STATUS"]] . " COMMENT " . q($L["EVENT_COMMENT"]) . rtrim(" DO\n$L[EVENT_DEFINITION]", ";") . ";"));
    }
  }
  page_header(($aa != "" ? 'Alter event' . ": " . h($aa) : 'Create event') , $k);
  if (!$L && $aa != "") {
    $M = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
    $L = reset($M);
  }
  echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="', h($L["EVENT_NAME"]) , '" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="', h("$L[EXECUTE_AT]$L[STARTS]") , '">
<tr><th title="datetime">End<td><input name="ENDS" value="', h($L["ENDS"]) , '">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="', h($L["INTERVAL_VALUE"]) , '" class="size"> ', html_select("INTERVAL_FIELD", $cd, $L["INTERVAL_FIELD"]) , '<tr><th>Status<td>', html_select("STATUS", $cg, $L["STATUS"]) , '<tr><th>Comment<td><input name="EVENT_COMMENT" value="', h($L["EVENT_COMMENT"]) , '" data-maxlength="64">
<tr><th><td>', checkbox("ON_COMPLETION", "PRESERVE", $L["ON_COMPLETION"] == "PRESERVE", 'On completion preserve') , '</table>
<p>';
  textarea("EVENT_DEFINITION", $L["EVENT_DEFINITION"]);
  echo '<p>
<input type="submit" value="Save">
';
  if ($aa != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $aa));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["procedure"])) {
  $da = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
  $zf = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
  $L = $_POST;
  $L["fields"] = (array)$L["fields"];
  if ($_POST && !process_fields($L["fields"]) && !$k) {
    $xe = routine($_GET["procedure"], $zf);
    $wg = "$L[name]_adminer_" . uniqid();
    drop_create("DROP $zf " . routine_id($da, $xe) , create_routine($zf, $L) , "DROP $zf " . routine_id($L["name"], $L) , create_routine($zf, array(
      "name" => $wg
    ) + $L) , "DROP $zf " . routine_id($wg, $L) , substr(ME, 0, -1) , 'Routine has been dropped.', 'Routine has been altered.', 'Routine has been created.', $da, $L["name"]);
  }
  page_header(($da != "" ? (isset($_GET["function"]) ? 'Alter function' : 'Alter procedure') . ": " . h($da) : (isset($_GET["function"]) ? 'Create function' : 'Create procedure')) , $k);
  if (!$_POST && $da != "") {
    $L = routine($_GET["procedure"], $zf);
    $L["name"] = $da;
  }
  $Xa = get_vals("SHOW CHARACTER SET");
  sort($Xa);
  $_f = routine_languages();
  echo '
<form action="" method="post" id="form">
<p>Name: <input name="name" value="', h($L["name"]) , '" data-maxlength="64" autocapitalize="off">
', ($_f ? 'Language' . ": " . html_select("language", $_f, $L["language"]) . "\n" : "") , '<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
  edit_fields($L["fields"], $Xa, $zf);
  if (isset($_GET["function"])) {
    echo "<tr><td>" . 'Return type';
    edit_type("returns", $L["returns"], $Xa, array() , ($y == "pgsql" ? array(
      "void",
      "trigger"
    ) : array()));
  }
  echo '</table>
', script("editFields();") , '</div>
<p>';
  textarea("definition", $L["definition"]);
  echo '<p>
<input type="submit" value="Save">
';
  if ($da != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $da));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["trigger"])) {
  $a = $_GET["trigger"];
  $E = $_GET["name"];
  $Pg = trigger_options();
  $L = (array)trigger($E) + array(
    "Trigger" => $a . "_bi"
  );
  if ($_POST) {
    if (!$k && in_array($_POST["Timing"], $Pg["Timing"]) && in_array($_POST["Event"], $Pg["Event"]) && in_array($_POST["Type"], $Pg["Type"])) {
      $ke = " ON " . table($a);
      $Jb = "DROP TRIGGER " . idf_escape($E) . ($y == "pgsql" ? $ke : "");
      $B = ME . "table=" . urlencode($a);
      if ($_POST["drop"]) query_redirect($Jb, $B, 'Trigger has been dropped.');
      else {
        if ($E != "") queries($Jb);
        queries_redirect($B, ($E != "" ? 'Trigger has been altered.' : 'Trigger has been created.') , queries(create_trigger($ke, $_POST)));
        if ($E != "") queries(create_trigger($ke, $L + array(
          "Type" => reset($Pg["Type"])
        )));
      }
    }
    $L = $_POST;
  }
  page_header(($E != "" ? 'Alter trigger' . ": " . h($E) : 'Create trigger') , $k, array(
    "table" => $a
  ));
  echo '
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>', html_select("Timing", $Pg["Timing"], $L["Timing"], "triggerChange(/^" . preg_quote($a, "/") . "_[ba][iud]$/, '" . js_escape($a) . "', this.form);") , '<tr><th>Event<td>', html_select("Event", $Pg["Event"], $L["Event"], "this.form['Timing'].onchange();") , (in_array("UPDATE OF", $Pg["Event"]) ? " <input name='Of' value='" . h($L["Of"]) . "' class='hidden'>" : "") , '<tr><th>Type<td>', html_select("Type", $Pg["Type"], $L["Type"]) , '</table>
<p>Name: <input name="Trigger" value="', h($L["Trigger"]) , '" data-maxlength="64" autocapitalize="off">
', script("qs('#form')['Timing'].onchange();") , '<p>';
  textarea("Statement", $L["Statement"]);
  echo '<p>
<input type="submit" value="Save">
';
  if ($E != "") {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $E));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["user"])) {
  $fa = $_GET["user"];
  $cf = array(
    "" => array(
      "All privileges" => ""
    )
  );
  foreach (get_rows("SHOW PRIVILEGES") as $L) {
    foreach (explode(",", ($L["Privilege"] == "Grant option" ? "" : $L["Context"])) as $hb) $cf[$hb][$L["Privilege"]] = $L["Comment"];
  }
  $cf["Server Admin"] += $cf["File access on server"];
  $cf["Databases"]["Create routine"] = $cf["Procedures"]["Create routine"];
  unset($cf["Procedures"]["Create routine"]);
  $cf["Columns"] = array();
  foreach (array(
    "Select",
    "Insert",
    "Update",
    "References"
  ) as $X) $cf["Columns"][$X] = $cf["Tables"][$X];
  unset($cf["Server Admin"]["Usage"]);
  foreach ($cf["Tables"] as $z => $X) unset($cf["Databases"][$z]);
  $Vd = array();
  if ($_POST) {
    foreach ($_POST["objects"] as $z => $X) $Vd[$X] = (array)$Vd[$X] + (array)$_POST["grants"][$z];
  }
  $Dc = array();
  $ie = "";
  if (isset($_GET["host"]) && ($J = $e->query("SHOW GRANTS FOR " . q($fa) . "@" . q($_GET["host"])))) {
    while ($L = $J->fetch_row()) {
      if (preg_match('~GRANT (.*) ON (.*) TO ~', $L[0], $C) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Dd, PREG_SET_ORDER)) {
        foreach ($Dd as $X) {
          if ($X[1] != "USAGE") $Dc["$C[2]$X[2]"][$X[1]] = true;
          if (preg_match('~ WITH GRANT OPTION~', $L[0])) $Dc["$C[2]$X[2]"]["GRANT OPTION"] = true;
        }
      }
      if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $L[0], $C)) $ie = $C[1];
    }
  }
  if ($_POST && !$k) {
    $je = (isset($_GET["host"]) ? q($fa) . "@" . q($_GET["host"]) : "''");
    if ($_POST["drop"]) query_redirect("DROP USER $je", ME . "privileges=", 'User has been dropped.');
    else {
      $Xd = q($_POST["user"]) . "@" . q($_POST["host"]);
      $Me = $_POST["pass"];
      if ($Me != '' && !$_POST["hashed"] && !min_version(8)) {
        $Me = $e->result("SELECT PASSWORD(" . q($Me) . ")");
        $k = !$Me;
      }
      $lb = false;
      if (!$k) {
        if ($je != $Xd) {
          $lb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $Xd IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($Me));
          $k = !$lb;
        }
        elseif ($Me != $ie) queries("SET PASSWORD FOR $Xd = " . q($Me));
      }
      if (!$k) {
        $wf = array();
        foreach ($Vd as $de => $r) {
          if (isset($_GET["grant"])) $r = array_filter($r);
          $r = array_keys($r);
          if (isset($_GET["grant"])) $wf = array_diff(array_keys(array_filter($Vd[$de], 'strlen')) , $r);
          elseif ($je == $Xd) {
            $ge = array_keys((array)$Dc[$de]);
            $wf = array_diff($ge, $r);
            $r = array_diff($r, $ge);
            unset($Dc[$de]);
          }
          if (preg_match('~^(.+)\s*(\(.*\))?$~U', $de, $C) && (!grant("REVOKE", $wf, $C[2], " ON $C[1] FROM $Xd") || !grant("GRANT", $r, $C[2], " ON $C[1] TO $Xd"))) {
            $k = true;
            break;
          }
        }
      }
      if (!$k && isset($_GET["host"])) {
        if ($je != $Xd) queries("DROP USER $je");
        elseif (!isset($_GET["grant"])) {
          foreach ($Dc as $de => $wf) {
            if (preg_match('~^(.+)(\(.*\))?$~U', $de, $C)) grant("REVOKE", array_keys($wf) , $C[2], " ON $C[1] FROM $Xd");
          }
        }
      }
      queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? 'User has been altered.' : 'User has been created.') , !$k);
      if ($lb) $e->query("DROP USER $Xd");
    }
  }
  page_header((isset($_GET["host"]) ? 'Username' . ": " . h("$fa@$_GET[host]") : 'Create user') , $k, array(
    "privileges" => array(
      '',
      'Privileges'
    )
  ));
  if ($_POST) {
    $L = $_POST;
    $Dc = $Vd;
  }
  else {
    $L = $_GET + array(
      "host" => $e->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)")
    );
    $L["pass"] = $ie;
    if ($ie != "") $L["hashed"] = true;
    $Dc[(DB == "" || $Dc ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
  }
  echo '<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="', h($L["host"]) , '" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="', h($L["user"]) , '" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="', h($L["pass"]) , '" autocomplete="new-password">
';
  if (!$L["hashed"]) echo script("typePassword(qs('#pass'));");
  echo (min_version(8) ? "" : checkbox("hashed", 1, $L["hashed"], 'Hashed', "typePassword(this.form['pass'], this.checked);")) , '</table>

';
  echo "<table cellspacing='0'>\n", "<thead><tr><th colspan='2'>" . 'Privileges' . doc_link(array(
    'sql' => "grant.html#priv_level"
  ));
  $t = 0;
  foreach ($Dc as $de => $r) {
    echo '<th>' . ($de != "*.*" ? "<input name='objects[$t]' value='" . h($de) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
    $t++;
  }
  echo "</thead>\n";
  foreach (array(
    "" => "",
    "Server Admin" => 'Server',
    "Databases" => 'Database',
    "Tables" => 'Table',
    "Columns" => 'Column',
    "Procedures" => 'Routine',
  ) as $hb => $Bb) {
    foreach ((array)$cf[$hb] as $bf => $bb) {
      echo "<tr" . odd() . "><td" . ($Bb ? ">$Bb<td" : " colspan='2'") . ' lang="en" title="' . h($bb) . '">' . h($bf);
      $t = 0;
      foreach ($Dc as $de => $r) {
        $E = "'grants[$t][" . h(strtoupper($bf)) . "]'";
        $Y = $r[strtoupper($bf) ];
        if ($hb == "Server Admin" && $de != (isset($Dc["*.*"]) ? "*.*" : ".*")) echo "<td>";
        elseif (isset($_GET["grant"])) echo "<td><select name=$E><option><option value='1'" . ($Y ? " selected" : "") . ">" . 'Grant' . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . 'Revoke' . "</select>";
        else {
          echo "<td align='center'><label class='block'>", "<input type='checkbox' name=$E value='1'" . ($Y ? " checked" : "") . ($bf == "All privileges" ? " id='grants-$t-all'>" : ">" . ($bf == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))) , "</label>";
        }
        $t++;
      }
    }
  }
  echo "</table>\n", '<p>
<input type="submit" value="Save">
';
  if (isset($_GET["host"])) {
    echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', "$fa@$_GET[host]"));
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
';
}
elseif (isset($_GET["processlist"])) {
  if (support("kill") && $_POST && !$k) {
    $md = 0;
    foreach ((array)$_POST["kill"] as $X) {
      if (kill_process($X)) $md++;
    }
    queries_redirect(ME . "processlist=", lang(array(
      '%d process has been killed.',
      '%d processes have been killed.'
    ) , $md) , $md || !$_POST["kill"]);
  }
  page_header('Process list', $k);
  echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
', script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
  $t = - 1;
  foreach (process_list() as $t => $L) {
    if (!$t) {
      echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
      foreach ($L as $z => $X) echo "<th>$z" . doc_link(array(
        'sql' => "show-processlist.html#processlist_" . strtolower($z) ,
      ));
      echo "</thead>\n";
    }
    echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $L[$y == "sql" ? "Id" : "pid"], 0) : "");
    foreach ($L as $z => $X) echo "<td>" . (($y == "sql" && $z == "Info" && preg_match("~Query|Killed~", $L["Command"]) && $X != "") || ($y == "pgsql" && $z == "current_query" && $X != "<IDLE>") || ($y == "oracle" && $z == "sql_text" && $X != "") ? "<code class='jush-$y'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($L["db"] != "" ? "db=" . urlencode($L["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">Clone</a>' : h($X));
    echo "\n";
  }
  echo '</table>
</div>
<p>
';
  if (support("kill")) {
    echo ($t + 1) . "/" . sprintf('%d in total', max_connections()) , "<p><input type='submit' value='" . 'Kill' . "'>\n";
  }
  echo '<input type="hidden" name="token" value="', $T, '">
</form>
', script("tableCheck();");
}
elseif (isset($_GET["select"])) {
  $a = $_GET["select"];
  $R = table_status1($a);
  $w = indexes($a);
  $m = fields($a);
  $o = column_foreign_keys($a);
  $fe = $R["Oid"];
  parse_str($_COOKIE["adminer_import"], $ma);
  $xf = array();
  $d = array();
  $zg = null;
  foreach ($m as $z => $l) {
    $E = $b->fieldName($l);
    if (isset($l["privileges"]["select"]) && $E != "") {
      $d[$z] = html_entity_decode(strip_tags($E) , ENT_QUOTES);
      if (is_shortable($l)) $zg = $b->selectLengthProcess();
    }
    $xf += $l["privileges"];
  }
  list($N, $s) = $b->selectColumnsProcess($d, $w);
  $gd = count($s) < count($N);
  $Z = $b->selectSearchProcess($m, $w);
  $te = $b->selectOrderProcess($m, $w);
  $_ = $b->selectLimitProcess();
  if ($_GET["val"] && is_ajax()) {
    header("Content-Type: text/plain; charset=utf-8");
    foreach ($_GET["val"] as $Xg => $L) {
      $ua = convert_field($m[key($L) ]);
      $N = array(
        $ua ? $ua : idf_escape(key($L))
      );
      $Z[] = where_check($Xg, $m);
      $K = $j->select($a, $N, $Z, $N);
      if ($K) echo reset($K->fetch_row());
    }
    exit;
  }
  $Ye = $Zg = null;
  foreach ($w as $v) {
    if ($v["type"] == "PRIMARY") {
      $Ye = array_flip($v["columns"]);
      $Zg = ($N ? $Ye : array());
      foreach ($Zg as $z => $X) {
        if (in_array(idf_escape($z) , $N)) unset($Zg[$z]);
      }
      break;
    }
  }
  if ($fe && !$Ye) {
    $Ye = $Zg = array(
      $fe => 0
    );
    $w[] = array(
      "type" => "PRIMARY",
      "columns" => array(
        $fe
      )
    );
  }
  if ($_POST && !$k) {
    $vh = $Z;
    if (!$_POST["all"] && is_array($_POST["check"])) {
      $Oa = array();
      foreach ($_POST["check"] as $Ma) $Oa[] = where_check($Ma, $m);
      $vh[] = "((" . implode(") OR (", $Oa) . "))";
    }
    $vh = ($vh ? "\nWHERE " . implode(" AND ", $vh) : "");
    if ($_POST["export"]) {
      cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
      dump_headers($a);
      $b->dumpTable($a, "");
      $Bc = ($N ? implode(", ", $N) : "*") . convert_fields($d, $m, $N) . "\nFROM " . table($a);
      $Fc = ($s && $gd ? "\nGROUP BY " . implode(", ", $s) : "") . ($te ? "\nORDER BY " . implode(", ", $te) : "");
      if (!is_array($_POST["check"]) || $Ye) $I = "SELECT $Bc$vh$Fc";
      else {
        $Vg = array();
        foreach ($_POST["check"] as $X) $Vg[] = "(SELECT" . limit($Bc, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $m) . $Fc, 1) . ")";
        $I = implode(" UNION ALL ", $Vg);
      }
      $b->dumpData($a, "table", $I);
      exit;
    }
    if (!$b->selectEmailProcess($Z, $o)) {
      if ($_POST["save"] || $_POST["delete"]) {
        $J = true;
        $na = 0;
        $P = array();
        if (!$_POST["delete"]) {
          foreach ($d as $E => $X) {
            $X = process_input($m[$E]);
            if ($X !== null && ($_POST["clone"] || $X !== false)) $P[idf_escape($E) ] = ($X !== false ? $X : idf_escape($E));
          }
        }
        if ($_POST["delete"] || $P) {
          if ($_POST["clone"]) $I = "INTO " . table($a) . " (" . implode(", ", array_keys($P)) . ")\nSELECT " . implode(", ", $P) . "\nFROM " . table($a);
          if ($_POST["all"] || ($Ye && is_array($_POST["check"])) || $gd) {
            $J = ($_POST["delete"] ? $j->delete($a, $vh) : ($_POST["clone"] ? queries("INSERT $I$vh") : $j->update($a, $P, $vh)));
            $na = $e->affected_rows;
          }
          else {
            foreach ((array)$_POST["check"] as $X) {
              $uh = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $m);
              $J = ($_POST["delete"] ? $j->delete($a, $uh, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($a, $I, $uh)) : $j->update($a, $P, $uh, 1)));
              if (!$J) break;
              $na += $e->affected_rows;
            }
          }
        }
        $D = lang(array(
          '%d item has been affected.',
          '%d items have been affected.'
        ) , $na);
        if ($_POST["clone"] && $J && $na == 1) {
          $rd = last_id();
          if ($rd) $D = sprintf('Item%s has been inserted.', " $rd");
        }
        queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : "") , $D, $J);
        if (!$_POST["delete"]) {
          edit_form($a, $m, (array)$_POST["fields"], !$_POST["clone"]);
          page_footer();
          exit;
        }
      }
      elseif (!$_POST["import"]) {
        if (!$_POST["val"]) $k = 'Ctrl+click on a value to modify it.';
        else {
          $J = true;
          $na = 0;
          foreach ($_POST["val"] as $Xg => $L) {
            $P = array();
            foreach ($L as $z => $X) {
              $z = bracket_escape($z, 1);
              $P[idf_escape($z) ] = (preg_match('~char|text~', $m[$z]["type"]) || $X != "" ? $b->processInput($m[$z], $X) : "NULL");
            }
            $J = $j->update($a, $P, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($Xg, $m) , !$gd && !$Ye, " ");
            if (!$J) break;
            $na += $e->affected_rows;
          }
          queries_redirect(remove_from_uri() , lang(array(
            '%d item has been affected.',
            '%d items have been affected.'
          ) , $na) , $J);
        }
      }
      elseif (!is_string($rc = get_file("csv_file", true))) $k = upload_error($rc);
      elseif (!preg_match('~~u', $rc)) $k = 'File must be in UTF-8 encoding.';
      else {
        cookie("adminer_import", "output=" . urlencode($ma["output"]) . "&format=" . urlencode($_POST["separator"]));
        $J = true;
        $Ya = array_keys($m);
        preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $rc, $Dd);
        $na = count($Dd[0]);
        $j->begin();
        $Kf = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
        $M = array();
        foreach ($Dd[0] as $z => $X) {
          preg_match_all("~((?>\"[^\"]*\")+|[^$Kf]*)$Kf~", $X . $Kf, $Ed);
          if (!$z && !array_diff($Ed[1], $Ya)) {
            $Ya = $Ed[1];
            $na--;
          }
          else {
            $P = array();
            foreach ($Ed[1] as $t => $Ua) $P[idf_escape($Ya[$t]) ] = ($Ua == "" && $m[$Ya[$t]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $Ua))));
            $M[] = $P;
          }
        }
        $J = (!$M || $j->insertUpdate($a, $M, $Ye));
        if ($J) $J = $j->commit();
        queries_redirect(remove_from_uri("page") , lang(array(
          '%d row has been imported.',
          '%d rows have been imported.'
        ) , $na) , $J);
        $j->rollback();
      }
    }
  }
  $ng = $b->tableName($R);
  if (is_ajax()) {
    page_headers();
    ob_start();
  }
  else page_header('Select' . ": $ng", $k);
  $P = null;
  if (isset($xf["insert"]) || !support("table")) {
    $P = "";
    foreach ((array)$_GET["where"] as $X) {
      if ($o[$X["col"]] && count($o[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"])))) $P .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
    }
  }
  $b->selectLinks($R, $P);
  if (!$d && support("table")) echo "<p class='error'>" . 'Unable to select the table' . ($m ? "." : ": " . error()) . "\n";
  else {
    echo "<form action='' id='form'>\n", "<div style='display: none;'>";
    hidden_fields_get();
    echo (DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
    echo '<input type="hidden" name="select" value="' . h($a) . '">', "</div>\n";
    $b->selectColumnsPrint($N, $d);
    $b->selectSearchPrint($Z, $d, $w);
    $b->selectOrderPrint($te, $d, $w);
    $b->selectLimitPrint($_);
    $b->selectLengthPrint($zg);
    $b->selectActionPrint($w);
    echo "</form>\n";
    $F = $_GET["page"];
    if ($F == "last") {
      $Ac = $e->result(count_rows($a, $Z, $gd, $s));
      $F = floor(max(0, $Ac - 1) / $_);
    }
    $Ff = $N;
    $Ec = $s;
    if (!$Ff) {
      $Ff[] = "*";
      $ib = convert_fields($d, $m, $N);
      if ($ib) $Ff[] = substr($ib, 2);
    }
    foreach ($N as $z => $X) {
      $l = $m[idf_unescape($X) ];
      if ($l && ($ua = convert_field($l))) $Ff[$z] = "$ua AS $X";
    }
    if (!$gd && $Zg) {
      foreach ($Zg as $z => $X) {
        $Ff[] = idf_escape($z);
        if ($Ec) $Ec[] = idf_escape($z);
      }
    }
    $J = $j->select($a, $Ff, $Z, $Ec, $te, $_, $F, true);
    if (!$J) echo "<p class='error'>" . error() . "\n";
    else {
      if ($y == "mssql" && $F) $J->seek($_ * $F);
      $Vb = array();
      echo "<form action='' method='post' enctype='multipart/form-data'>\n";
      $M = array();
      while ($L = $J->fetch_assoc()) {
        if ($F && $y == "oracle") unset($L["RNUM"]);
        $M[] = $L;
      }
      if ($_GET["page"] != "last" && $_ != "" && $s && $gd && $y == "sql") $Ac = $e->result(" SELECT FOUND_ROWS()");
      if (!$M) echo "<p class='message'>" . 'No rows.' . "\n";
      else {
        $Ba = $b->backwardKeys($a, $ng);
        echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});") , "<thead><tr>" . (!$s && $N ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . 'Modify' . "</a>");
        $Ud = array();
        $Cc = array();
        reset($N);
        $kf = 1;
        foreach ($M[0] as $z => $X) {
          if (!isset($Zg[$z])) {
            $X = $_GET["columns"][key($N) ];
            $l = $m[$N ? ($X ? $X["col"] : current($N)) : $z];
            $E = ($l ? $b->fieldName($l, $kf) : ($X["fun"] ? "*" : $z));
            if ($E != "") {
              $kf++;
              $Ud[$z] = $E;
              $c = idf_escape($z);
              $Rc = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($z);
              $Bb = "&desc%5B0%5D=1";
              echo "<th>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", "") , '<a href="' . h($Rc . ($te[0] == $c || $te[0] == $z || (!$te && $gd && $s[0] == $c) ? $Bb : '')) . '">';
              echo apply_sql_function($X["fun"], $E) . "</a>";
              echo "<span class='column hidden'>", "<a href='" . h($Rc . $Bb) . "' title='" . 'descending' . "' class='text'> ↓</a>";
              if (!$X["fun"]) {
                echo '<a href="#fieldset-search" title="Search" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($z) . "');");
              }
              echo "</span>";
            }
            $Cc[$z] = $X["fun"];
            next($N);
          }
        }
        $xd = array();
        if ($_GET["modify"]) {
          foreach ($M as $L) {
            foreach ($L as $z => $X) $xd[$z] = max($xd[$z], min(40, strlen(utf8_decode($X))));
          }
        }
        echo ($Ba ? "<th>" . 'Relations' : "") . "</thead>\n";
        if (is_ajax()) {
          if ($_ % 2 == 1 && $F % 2 == 1) odd();
          ob_end_clean();
        }
        foreach ($b->rowDescriptions($M, $o) as $Td => $L) {
          $Wg = unique_array($M[$Td], $w);
          if (!$Wg) {
            $Wg = array();
            foreach ($M[$Td] as $z => $X) {
              if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z)) $Wg[$z] = $X;
            }
          }
          $Xg = "";
          foreach ($Wg as $z => $X) {
            if (($y == "sql" || $y == "pgsql") && preg_match('~char|text|enum|set~', $m[$z]["type"]) && strlen($X) > 64) {
              $z = (strpos($z, '(') ? $z : idf_escape($z));
              $z = "MD5(" . ($y != 'sql' || preg_match("~^utf8~", $m[$z]["collation"]) ? $z : "CONVERT($z USING " . charset($e) . ")") . ")";
              $X = md5($X);
            }
            $Xg .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($z) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($z));
          }
          echo "<tr" . odd() . ">" . (!$s && $N ? "" : "<td>" . checkbox("check[]", substr($Xg, 1) , in_array(substr($Xg, 1) , (array)$_POST["check"])) . ($gd || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($a) . $Xg) . "' class='edit'>" . 'edit' . "</a>"));
          foreach ($L as $z => $X) {
            if (isset($Ud[$z])) {
              $l = $m[$z];
              $X = $j->value($X, $l);
              if ($X != "" && (!isset($Vb[$z]) || $Vb[$z] != "")) $Vb[$z] = (is_mail($X) ? $Ud[$z] : "");
              $A = "";
              if (preg_match('~blob|bytea|raw|file~', $l["type"]) && $X != "") $A = ME . 'download=' . urlencode($a) . '&field=' . urlencode($z) . $Xg;
              if (!$A && $X !== null) {
                foreach ((array)$o[$z] as $n) {
                  if (count($o[$z]) == 1 || end($n["source"]) == $z) {
                    $A = "";
                    foreach ($n["source"] as $t => $Uf) $A .= where_link($t, $n["target"][$t], $M[$Td][$Uf]);
                    $A = ($n["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($n["db"]) , ME) : ME) . 'select=' . urlencode($n["table"]) . $A;
                    if ($n["ns"]) $A = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($n["ns"]) , $A);
                    if (count($n["source"]) == 1) break;
                  }
                }
              }
              if ($z == "COUNT(*)") {
                $A = ME . "select=" . urlencode($a);
                $t = 0;
                foreach ((array)$_GET["where"] as $W) {
                  if (!array_key_exists($W["col"], $Wg)) $A .= where_link($t++, $W["col"], $W["val"], $W["op"]);
                }
                foreach ($Wg as $jd => $W) $A .= where_link($t++, $jd, $W);
              }
              $X = select_value($X, $A, $l, $zg);
              $u = h("val[$Xg][" . bracket_escape($z) . "]");
              $Y = $_POST["val"][$Xg][bracket_escape($z) ];
              $Qb = !is_array($L[$z]) && is_utf8($X) && $M[$Td][$z] == $L[$z] && !$Cc[$z];
              $yg = preg_match('~text|lob~', $l["type"]);
              echo "<td id='$u'";
              if (($_GET["modify"] && $Qb) || $Y !== null) {
                $Ic = h($Y !== null ? $Y : $L[$z]);
                echo ">" . ($yg ? "<textarea name='$u' cols='30' rows='" . (substr_count($L[$z], "\n") + 1) . "'>$Ic</textarea>" : "<input name='$u' value='$Ic' size='$xd[$z]'>");
              }
              else {
                $Ad = strpos($X, "<i>…</i>");
                echo " data-text='" . ($Ad ? 2 : ($yg ? 1 : 0)) . "'" . ($Qb ? "" : " data-warning='" . h('Use edit link to modify this value.') . "'") . ">$X</td>";
              }
            }
          }
          if ($Ba) echo "<td>";
          $b->backwardKeysPrint($Ba, $M[$Td]);
          echo "</tr>\n";
        }
        if (is_ajax()) exit;
        echo "</table>\n", "</div>\n";
      }
      if (!is_ajax()) {
        if ($M || $F) {
          $fc = true;
          if ($_GET["page"] != "last") {
            if ($_ == "" || (count($M) < $_ && ($M || !$F))) $Ac = ($F ? $F * $_ : 0) + count($M);
            elseif ($y != "sql" || !$gd) {
              $Ac = ($gd ? false : found_rows($R, $Z));
              if ($Ac < max(1e4, 2 * ($F + 1) * $_)) $Ac = reset(slow_query(count_rows($a, $Z, $gd, $s)));
              else $fc = false;
            }
          }
          $Ee = ($_ != "" && ($Ac === false || $Ac > $_ || $F));
          if ($Ee) {
            echo (($Ac === false ? count($M) + 1 : $Ac - $F * $_) > $_ ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($F + 1)) . '" class="loadmore">Load more data</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$_) . ", '" . 'Loading' . "…');", "") : '') , "\n";
          }
        }
        echo "<div class='footer'><div>\n";
        if ($M || $F) {
          if ($Ee) {
            $Gd = ($Ac === false ? $F + (count($M) >= $_ ? 2 : 1) : floor(($Ac - 1) / $_));
            echo "<fieldset>";
            if ($y != "simpledb") {
              echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . 'Page' . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . 'Page' . "', '" . ($F + 1) . "')); return false; };") , pagination(0, $F) . ($F > 5 ? " …" : "");
              for ($t = max(1, $F - 4);$t < min($Gd, $F + 5);$t++) echo pagination($t, $F);
              if ($Gd > 0) {
                echo ($F + 5 < $Gd ? " …" : "") , ($fc && $Ac !== false ? pagination($Gd, $F) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Gd'>" . 'last' . "</a>");
              }
            }
            else {
              echo "<legend>" . 'Page' . "</legend>", pagination(0, $F) . ($F > 1 ? " …" : "") , ($F ? pagination($F, $F) : "") , ($Gd > $F ? pagination($F + 1, $F) . ($Gd > $F + 1 ? " …" : "") : "");
            }
            echo "</fieldset>\n";
          }
          echo "<fieldset>", "<legend>" . 'Whole result' . "</legend>";
          $Gb = ($fc ? "" : "~ ") . $Ac;
          echo checkbox("all", 1, 0, ($Ac !== false ? ($fc ? "" : "~ ") . lang(array(
            '%d row',
            '%d rows'
          ) , $Ac) : "") , "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Gb' : checked); selectCount('selected2', this.checked || !checked ? '$Gb' : checked);") . "\n", "</fieldset>\n";
          if ($b->selectCommandPrint()) {
            echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"') , '><legend>Modify</legend><div>
<input type="submit" value="Save"', ($_GET["modify"] ? '' : ' title="Ctrl+click on a value to modify it."') , '>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">', confirm() , '</div></fieldset>
';
          }
          $zc = $b->dumpFormat();
          foreach ((array)$_GET["columns"] as $c) {
            if ($c["fun"]) {
              unset($zc['sql']);
              break;
            }
          }
          if ($zc) {
            print_fieldset("export", 'Export' . " <span id='selected2'></span>");
            $Ce = $b->dumpOutput();
            echo ($Ce ? html_select("output", $Ce, $ma["output"]) . " " : "") , html_select("format", $zc, $ma["format"]) , " <input type='submit' name='export' value='" . 'Export' . "'>\n", "</div></fieldset>\n";
          }
          $b->selectEmailPrint(array_filter($Vb, 'strlen') , $d);
        }
        echo "</div></div>\n";
        if ($b->selectImportPrint()) {
          echo "<div>", "<a href='#import'>" . 'Import' . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", "") , "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array(
            "csv" => "CSV,",
            "csv;" => "CSV;",
            "tsv" => "TSV"
          ) , $ma["format"], 1);
          echo " <input type='submit' name='import' value='" . 'Import' . "'>", "</span>", "</div>";
        }
        echo "<input type='hidden' name='token' value='$T'>\n", "</form>\n", (!$s && $N ? "" : script("tableCheck();"));
      }
    }
  }
  if (is_ajax()) {
    ob_end_clean();
    exit;
  }
}
elseif (isset($_GET["variables"])) {
  $bg = isset($_GET["status"]);
  page_header($bg ? 'Status' : 'Variables');
  $lh = ($bg ? show_status() : show_variables());
  if (!$lh) echo "<p class='message'>" . 'No rows.' . "\n";
  else {
    echo "<table cellspacing='0'>\n";
    foreach ($lh as $z => $X) {
      echo "<tr>", "<th><code class='jush-" . $y . ($bg ? "status" : "set") . "'>" . h($z) . "</code>", "<td>" . h($X);
    }
    echo "</table>\n";
  }
}
elseif (isset($_GET["script"])) {
  header("Content-Type: text/javascript; charset=utf-8");
  if ($_GET["script"] == "db") {
    $kg = array(
      "Data_length" => 0,
      "Index_length" => 0,
      "Data_free" => 0
    );
    foreach (table_status() as $E => $R) {
      json_row("Comment-$E", h($R["Comment"]));
      if (!is_view($R)) {
        foreach (array(
          "Engine",
          "Collation"
        ) as $z) json_row("$z-$E", h($R[$z]));
        foreach ($kg + array(
          "Auto_increment" => 0,
          "Rows" => 0
        ) as $z => $X) {
          if ($R[$z] != "") {
            $X = format_number($R[$z]);
            json_row("$z-$E", ($z == "Rows" && $X && $R["Engine"] == ($Wf == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
            if (isset($kg[$z])) $kg[$z] += ($R["Engine"] != "InnoDB" || $z != "Data_free" ? $R[$z] : 0);
          }
          elseif (array_key_exists($z, $R)) json_row("$z-$E");
        }
      }
    }
    foreach ($kg as $z => $X) json_row("sum-$z", format_number($X));
    json_row("");
  }
  elseif ($_GET["script"] == "kill") $e->query("KILL " . number($_POST["kill"]));
  else {
    foreach (count_tables($b->databases()) as $i => $X) {
      json_row("tables-$i", $X);
      json_row("size-$i", db_size($i));
    }
    json_row("");
  }
  exit;
}
else {
  $sg = array_merge((array)$_POST["tables"], (array)$_POST["views"]);
  if ($sg && !$k && !$_POST["search"]) {
    $J = true;
    $D = "";
    if ($y == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) queries("SET foreign_key_checks = 0");
    if ($_POST["truncate"]) {
      if ($_POST["tables"]) $J = truncate_tables($_POST["tables"]);
      $D = 'Tables have been truncated.';
    }
    elseif ($_POST["move"]) {
      $J = move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
      $D = 'Tables have been moved.';
    }
    elseif ($_POST["copy"]) {
      $J = copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
      $D = 'Tables have been copied.';
    }
    elseif ($_POST["drop"]) {
      if ($_POST["views"]) $J = drop_views($_POST["views"]);
      if ($J && $_POST["tables"]) $J = drop_tables($_POST["tables"]);
      $D = 'Tables have been dropped.';
    }
    elseif ($y != "sql") {
      $J = ($y == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE") , $_POST["tables"]));
      $D = 'Tables have been optimized.';
    }
    elseif (!$_POST["tables"]) $D = 'No tables.';
    elseif ($J = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
      while ($L = $J->fetch_assoc()) $D .= "<b>" . h($L["Table"]) . "</b>: " . h($L["Msg_text"]) . "<br>";
    }
    queries_redirect(substr(ME, 0, -1) , $D, $J);
  }
  page_header(($_GET["ns"] == "" ? 'Database' . ": " . h(DB) : 'Schema' . ": " . h($_GET["ns"])) , $k, true);
  if ($b->homepage()) {
    if ($_GET["ns"] !== "") {
      echo "<h3 id='tables-views'>" . 'Tables and views' . "</h3>\n";
      $rg = tables_list();
      if (!$rg) echo "<p class='message'>" . 'No tables.' . "\n";
      else {
        echo "<form action='' method='post'>\n";
        if (support("table")) {
          echo "<fieldset><legend>" . 'Search data in tables' . " <span id='selected2'></span></legend><div>", "<input type='search' name='query' value='" . h($_POST["query"]) . "'>", script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", "") , " <input type='submit' name='search' value='" . 'Search' . "'>\n", "</div></fieldset>\n";
          if ($_POST["search"] && $_POST["query"] != "") {
            $_GET["where"][0]["op"] = "LIKE %%";
            search_tables();
          }
        }
        echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});") , '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", "") , '<th>Table', '<td>Engine' . doc_link(array(
          'sql' => 'storage-engines.html'
        )) , '<td>Collation' . doc_link(array(
          'sql' => 'charset-charsets.html',
          'mariadb' => 'supported-character-sets-and-collations/'
        )) , '<td>Data Length' . doc_link(array(
          'sql' => 'show-table-status.html',
        )) , '<td>Index Length' . doc_link(array(
          'sql' => 'show-table-status.html',
        )) , '<td>Data Free' . doc_link(array(
          'sql' => 'show-table-status.html'
        )) , '<td>Auto Increment' . doc_link(array(
          'sql' => 'example-auto-increment.html',
          'mariadb' => 'auto_increment/'
        )) , '<td>Rows' . doc_link(array(
          'sql' => 'show-table-status.html',
        )) , (support("comment") ? '<td>Comment' . doc_link(array(
          'sql' => 'show-table-status.html',
        )) : '') , "</thead>\n";
        $S = 0;
        foreach ($rg as $E => $U) {
          $oh = ($U !== null && !preg_match('~table~i', $U));
          $u = h("Table-" . $E);
          echo '<tr' . odd() . '><td>' . checkbox(($oh ? "views[]" : "tables[]") , $E, in_array($E, $sg, true) , "", "", "", $u) , '<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($E) . "' title='" . 'Show structure' . "' id='$u'>" . h($E) . '</a>' : h($E));
          if ($oh) {
            echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($E) . '" title="Alter view">' . (preg_match('~materialized~i', $U) ? 'Materialized view' : 'View') . '</a>', '<td align="right"><a href="' . h(ME) . "select=" . urlencode($E) . '" title="Select data">?</a>';
          }
          else {
            foreach (array(
              "Engine" => array() ,
              "Collation" => array() ,
              "Data_length" => array(
                "create",
                'Alter table'
              ) ,
              "Index_length" => array(
                "indexes",
                'Alter indexes'
              ) ,
              "Data_free" => array(
                "edit",
                'New item'
              ) ,
              "Auto_increment" => array(
                "auto_increment=1&create",
                'Alter table'
              ) ,
              "Rows" => array(
                "select",
                'Select data'
              ) ,
            ) as $z => $A) {
              $u = " id='$z-" . h($E) . "'";
              echo ($A ? "<td align='right'>" . (support("table") || $z == "Rows" || (support("indexes") && $z != "Data_length") ? "<a href='" . h(ME . "$A[0]=") . urlencode($E) . "'$u title='$A[1]'>?</a>" : "<span$u>?</span>") : "<td id='$z-" . h($E) . "'>");
            }
            $S++;
          }
          echo (support("comment") ? "<td id='Comment-" . h($E) . "'>" : "");
        }
        echo "<tr><td><th>" . sprintf('%d in total', count($rg)) , "<td>" . h($y == "sql" ? $e->result("SELECT @@storage_engine") : "") , "<td>" . h(db_collation(DB, collations()));
        foreach (array(
          "Data_length",
          "Index_length",
          "Data_free"
        ) as $z) echo "<td align='right' id='sum-$z'>";
        echo "</table>\n", "</div>\n";
        if (!information_schema(DB)) {
          echo "<div class='footer'><div>\n";
          $jh = "<input type='submit' value='" . 'Vacuum' . "'> " . on_help("'VACUUM'");
          $qe = "<input type='submit' name='optimize' value='" . 'Optimize' . "'> " . on_help($y == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
          echo "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>" . ($y == "sqlite" ? $jh : ($y == "pgsql" ? $jh . $qe : ($y == "sql" ? "<input type='submit' value='" . 'Analyze' . "'> " . on_help("'ANALYZE TABLE'") . $qe . "<input type='submit' name='check' value='" . 'Check' . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . 'Repair' . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . 'Truncate' . "'> " . on_help($y == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($y == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
          $h = (support("scheme") ? $b->schemas() : $b->databases());
          if (count($h) != 1 && $y != "sqlite") {
            $i = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
            echo "<p>" . 'Move to other database' . ": ", ($h ? html_select("target", $h, $i) : '<input name="target" value="' . h($i) . '" autocapitalize="off">') , " <input type='submit' name='move' value='" . 'Move' . "'>", (support("copy") ? " <input type='submit' name='copy' value='" . 'Copy' . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], 'overwrite') : "") , "\n";
          }
          echo "<input type='hidden' name='all' value=''>";
          echo script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }") , "<input type='hidden' name='token' value='$T'>\n", "</div></fieldset>\n", "</div></div>\n";
        }
        echo "</form>\n", script("tableCheck();");
      }
      echo '<p class="links"><a href="' . h(ME) . 'create=">Create table' . "</a>\n", (support("view") ? '<a href="' . h(ME) . 'view=">Create view' . "</a>\n" : "");
      if (support("routine")) {
        echo "<h3 id='routines'>" . 'Routines' . "</h3>\n";
        $Af = routines();
        if ($Af) {
          echo "<table cellspacing='0'>\n", '<thead><tr><th>Name<td>Type<td>Return type' . "<td></thead>\n";
          odd('');
          foreach ($Af as $L) {
            $E = ($L["SPECIFIC_NAME"] == $L["ROUTINE_NAME"] ? "" : "&name=" . urlencode($L["ROUTINE_NAME"]));
            echo '<tr' . odd() . '>', '<th><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">' . h($L["ROUTINE_NAME"]) . '</a>', '<td>' . h($L["ROUTINE_TYPE"]) , '<td>' . h($L["DTD_IDENTIFIER"]) , '<td><a href="' . h(ME . ($L["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($L["SPECIFIC_NAME"]) . $E) . '">Alter' . "</a>";
          }
          echo "</table>\n";
        }
        echo '<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">Create procedure</a>' : '') . '<a href="' . h(ME) . 'function=">Create function' . "</a>\n";
      }
      if (support("event")) {
        echo "<h3 id='events'>" . 'Events' . "</h3>\n";
        $M = get_rows("SHOW EVENTS");
        if ($M) {
          echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "<td>" . 'Schedule' . "<td>" . 'Start' . "<td>" . 'End' . "<td></thead>\n";
          foreach ($M as $L) {
            echo "<tr>", "<th>" . h($L["Name"]) , "<td>" . ($L["Execute at"] ? 'At given time' . "<td>" . $L["Execute at"] : 'Every' . " " . $L["Interval value"] . " " . $L["Interval field"] . "<td>$L[Starts]") , "<td>$L[Ends]", '<td><a href="' . h(ME) . 'event=' . urlencode($L["Name"]) . '">Alter</a>';
          }
          echo "</table>\n";
          $dc = $e->result("SELECT @@event_scheduler");
          if ($dc && $dc != "ON") echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($dc) . "\n";
        }
        echo '<p class="links"><a href="' . h(ME) . 'event=">Create event' . "</a>\n";
      }
      if ($rg) echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
    }
  }
}
page_footer();