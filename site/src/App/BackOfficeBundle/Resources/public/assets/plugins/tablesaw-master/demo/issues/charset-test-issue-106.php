<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright. All rights reserved.
//
header( "Content-Type:text/html; charset=windows-1250" );
?>
<!DOCTYPE html>  
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TableSaw Sortable Table</title>

	<link rel="stylesheet" href="../../dist/tablesaw.css">
	<link rel="stylesheet" href="../demo.css">
	<link rel="stylesheet" href="//filamentgroup.github.io/demo-head/demohead.css">

	<!--[if lt IE 9]><script src="../dist/dependencies/respond.js"></script><![endif]-->
	<script src="../../dist/dependencies/jquery.js"></script>
	<script src="../../dist/tablesaw.js"></script>
	<script src="../../dist/tablesaw-init.js"></script>
	<script src="//filamentgroup.github.io/demo-head/loadfont.js"></script>
</head>
<body>
	<div class="demo-header">
		<div class="company">
			<img src="http://filamentgroup.com/images/fg-logo-positive-sm-crop.png">
		</div>
		<div class="details">
			<h1 class="description-container">Demo of <span class="repo-name">Tablesaw</span>
				<span class="description">A group of plugins for responsive tables.</span>
			</h1>
			<ul class="outbound-links">
				<li><a href="https://github.com/filamentgroup/tablesaw">Code</a></li>
				<li><a href="https://github.com/filamentgroup/tablesaw/issues">Issues</a></li>
			</ul>
		</div>
	</div>
	<div class="nav-container">
		<div class="docs-globalnav">
			<nav class="docs-nav">
			<a href="kitchensink.html">Kitchen Sink</a>
			<a href="modeswitch.html">Mode Switch</a>
			<a href="sort.html" class="current">Sortable</a>
			<a href="stack.html">Stack</a>
			<a href="stackonly.html">Stack Only</a>
			<a href="swipe.html">Swipe Table</a>
			<a href="toggle.html">Toggle</a>
			<a href="bare.html">Bare</a>
			</nav>
		</div>
	</div>
	<div class="docs-main">
		<h2>Sortable Table</h2>
		<h3 class="docs">Default appearance (with optional sortable-switch)</h3>

		<table class="tablesaw" data-tablesaw-sortable data-tablesaw-sortable-switch>
			<thead>
				<tr>
					<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Movie Title</th>
					<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Rank</th>
					<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Year</th>
					<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
					<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gross</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Avatar_(2009_film)">Avatar</a></td>
					<td>1</td>
					<td>2009</td>
					<td>83%</td>
					<td>$2.7B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Titanic_(1997_film)">Titanic</a></td>
					<td>2</td>
					<td>1997</td>
					<td>88%</td>
					<td>$2.1B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/The_Avengers_(2012_film)">The Avengers</a></td>
					<td>3</td>
					<td>2012</td>
					<td>92%</td>
					<td>$1.5B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows_%E2%80%93_Part_2">Harry Potter and the Deathly Hallows—Part 2</a></td>
					<td>4</td>
					<td>2011</td>
					<td>96%</td>
					<td>$1.3B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Frozen_(2013_film)">Frozen</a></td>
					<td>5</td>
					<td>2013</td>
					<td>89%</td>
					<td>$1.2B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Iron_Man_3">Iron Man 3</a></td>
					<td>6</td>
					<td>2013</td>
					<td>78%</td>
					<td>$1.2B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Dark_of_the_Moon">Transformers: Dark of the Moon</a></td>
					<td>7</td>
					<td>2011</td>
					<td>36%</td>
					<td>$1.1B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/The_Lord_of_the_Rings:_The_Return_of_the_King">The Lord of the Rings: The Return of the King</a></td>
					<td>8</td>
					<td>2003</td>
					<td>95%</td>
					<td>$1.1B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Skyfall">Skyfall</a></td>
					<td>9</td>
					<td>2012</td>
					<td>92%</td>
					<td>$1.1B</td>
				</tr>
				<tr>
					<td class="title"><a href="http://en.wikipedia.org/wiki/Transformers:_Age_of_Extinction">Transformers: Age of Extinction</a></td>
					<td>10</td>
					<td>2014</td>
					<td>18%</td>
					<td>$1.0B</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
