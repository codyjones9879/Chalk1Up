<?
  $url = $_SERVER['PHP_SELF'];
  $domain = $_SERVER['SERVER_NAME'];
  $selected = 'class="selected"';
?>
<div id="header">
  <div id="nav">
    <img onclick="window.location.href = 'http://chalk1up.net'" src="/images/chalk1up-logo-400.png" alt="Home" title="Home"/>
    <ul>
      <li><a id="train" <? if (strpos($domain, 'limb')) echo $selected; ?> href="http://climb.chalk1up.net">Climb</a></li>
      <li><a id="about" <? if (strpos($url, 'about')) echo $selected; ?> href="/about">About</a></li>
      <li><a id="contact" <? if (strpos($url, 'contact')) echo $selected; ?> href="/contact">Contact</a></li>
    </ul>
  </div>
</div>