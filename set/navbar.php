<?php
/**
 * Navigation bar for the mobile version of the climber portal
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
 ?>
 <!DOCTYPE html>
<div data-role="header" data-id="train-header" data-theme="c">
  <a href="./index.php" data-icon="home" data-iconpos="notext"></a>
  <h1>Chalk1Up: <? echo $_SESSION['SetterName']; ?></h1>
	<!-- <a href="./search.php" data-icon="search" data-iconpos="notext"></a> -->
	<div data-role="navbar">
		<ul>
			<li><a <? if (strpos($_SERVER['PHP_SELF'], 'set.php')) echo 'class="ui-btn-active ui-state-persist"'; ?> href="./set.php">Set</a></li>
      <li><a <? if (strpos($_SERVER['PHP_SELF'], 'feed.php')) echo 'class="ui-btn-active ui-state-persist"'; ?> href="./feed.php">Feed</a></li>
      <li><a <? if (strpos($_SERVER['PHP_SELF'], 'setters.php')) echo 'class="ui-btn-active ui-state-persist"'; ?> href="./setters.php">Stats</a></li>
		</ul>
	</div>
</div>