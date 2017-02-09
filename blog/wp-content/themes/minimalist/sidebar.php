<div id="leftcol" >
<div id="menu">

<div id="searchone" style="padding: 0px;">
<form id="searchform" method="get" action="/index.php">
<div>
<input type="text" id="searchtopone" placeholder="Search..." name="s" id="s" size="20" style="border-radius:6px; background-image:url('http://chalk1up.net/images/search.jpg'); background-repeat:no-repeat; background-position:right center" />
</div>
</form>
</div>

<h2 class="menuheader">Pages</h2>
<div class="menucontent">
<ul>
<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
</ul>
</div>

<h2 class="menuheader">Categories</h2>
<div class="menucontent">
<ul>
<?php wp_list_categories('title_li=&show_count=0'); ?>
</ul>
</div>


<h2 class="menuheader">Authors</h2>
<div class="menucontent">
<ul>
<?php wp_list_authors(); ?>
</ul>
</div>


<h2 class="menuheader">Archives</h2>
<div class="menucontent">
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</div>


<h2 class="menuheader">Customize</h2>
<div class="menucontent">

<ul>
<li><a href="#" onclick="setActiveStyleSheet('chalk1up'); return false;">Chalk1Up</a></li>
<li><a href="#" onclick="setActiveStyleSheet('white'); return false;">White</a></li>
<li><a href="#" onclick="setActiveStyleSheet('black'); return false;">Black</a></li>
<li><a href="#" onclick="setActiveStyleSheet('blue'); return false;">Blue</a></li>
<li><a href="#" onclick="setActiveStyleSheet('green'); return false;">Green</a></li>
<li><a href="#" onclick="setActiveStyleSheet('grey'); return false;">Grey</a></li>
</ul>

</div>


<?php if ( !function_exists('dynamic_sidebar')         || !dynamic_sidebar() ); ?>

<div>
RSS Feed: <a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>">
<img src="http://www.mozilla.org/images/feed-icon-14x14.png" alt="RSS Feed" title="RSS Feed" />
</a>
</div>

</div>
</div>