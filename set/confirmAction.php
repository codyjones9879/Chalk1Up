<?php
/**
 * Page to confirm an action. Typically a delete of some sort.
 * On confirmation, the desired action will be made
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");

$today=date('Y-m-d');
$action = $_GET['Action'];
$callback = $_GET['Callback'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chalk1Up Mobile Trainer</title>
    <? include 'head1.html'; ?>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div data-role="page" id="home" data-theme="c">
      <div data-role="header" data-theme="c">
        <h1>Are you sure?</h1>
      </div>
      <div data-role="content">
        <? if($action) { ?>
          <div class="center-wrapper"><h3><? echo $_GET['Info']; ?></h3></div>
          <form method="get" action=<?echo "'$action'";?> data-ajax="false">
            <input type="hidden" name="Callback" value=<?echo "'$callback'"; ?> >
            <input type="hidden" name="SessionId" value=<?echo '"'.$_GET['SessionId'].'"';?> >
            <input type="hidden" name="SendId" value=<?echo '"'.$_GET['SendId'].'"';?> >
            <input type="hidden" name="CommentId" value=<?echo '"'.$_GET['CommentId'].'"';?> >
            <input type="hidden" name="Comment" value=<?echo '"'.$_GET['Comment'].'"';?> >
            <input type="hidden" name="RouteId" value=<?echo '"'.$_GET['RouteId'].'"';?> >
            <input type="hidden" name="StripDate" value=<?echo '"'.$_GET['StripDate'].'"';?> >
            <div class="ui-grid-a">
              <div class="ui-block-a">
                <input type="submit" value="OK" data-theme="b" data-rel="back" />
              </div>
              <div class="ui-block-b">
                <a href="#" data-role="button" data-rel="back">Cancel</a>
              </div>
            </div>
          </form>
        <? } else { ?>
          <div class="center-wrapper"><h3>Error encountered!</h3></div>
          <a href="#" data-role="button" data-rel="back">Back</a>
        <? } ?>
      </div>
    </div>
  </body>
</html>