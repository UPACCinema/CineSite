<html>
<head>
<title>Mah Jong Scoring</title>
<style type="text/css">
table {
	border-collapse: separate;
	empty-cells: show;
}

table#tiles{
	width:100%;
}

table#tiles td {
	width:10%;
	text-align:center;
	border-bottom:thin #000000 solid;
}

table.hands td.blank {
	width:10px;
}

table.hands {
	border-collapse:collapse;
}

table.hands td {
	border-bottom:thin #000000 solid;
}
td.hand {
	font-weight:bold;
	font-style:italic;
	width:200px;
}
td.points {
	font-weight:bold;
}
td.english{
	text-align:center;
	font-weight:bold;
}
td.category{
	font-weight:bold;
	/*border-right:thin solid #000000;*/
}
h2.newpage {
	page-break-before:always;
}
</style>
</head>
<body>
		<? $suits = array ("Char", "Dot", "Stick") ?>

<h2>Mah Jong tiles</h2>
<table id="tiles">
	<tr>
		<td></td>
		<? for ($i = 1; $i <= 9; $i++){ ?>
		<td class="english"><?=$i?></td>
		<? } ?>
	</tr>
	<tr>
		<td class="category">Dots</td>
		<? for ($i = 1; $i <= 9; $i++){ ?>
		<td><img src="Dot-<?=$i?>.gif"></td>
		<? } ?>
	</tr>
	<tr>
		<td class="category">Sticks</td>
		<? for ($i = 1; $i <= 9; $i++){ ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
	</tr>
	<tr>
		<td class="category">Characters</td>
		<? for ($i = 1; $i <= 9; $i++){ ?>
		<td><img src="Char-<?=$i?>.gif"></td>
		<? } ?>
	</tr>
	<tr>
		<td></td>
		<? $winds = array("E" => "East", 
				  "S" => "South",
				  "W" => "West",
				  "N" => "North");
		foreach ($winds as $abbr => $wind){ ?>
		<td class="english"><?=$abbr?></td>
		<? } ?>
	</tr>
	<tr>
		<td class="category">Winds</td>
		<? foreach ($winds as $abbr => $wind){ ?>
		<td><img src="<?=$wind?>-Wind.gif"></td>
		<? } ?>
	</tr>
	<tr>
		<td></td>
		<? $dragons = array("Green", "Red", "White");
		foreach ($dragons as $dragon){ ?>
		<td class="English"><?=$dragon?></td>
		<? } ?>
	</tr>
	<tr>
		<td class="category">Dragons</td>
		<? foreach ($dragons as $dragon){ ?>
		<td><img src="<?=$dragon?>-Dragon.gif"></td>
		<? } ?>
	</tr>
	<tr>
		<td></td>
		<? for ($i = 1; $i <= 4; $i++ ){ ?>
		<td class="english"><?=$i?></td>
		<? } ?>
	</tr>
	<? $flowers = array("Red", "Blue"); 
	foreach ($flowers as $flower) { ?>
	<tr>	
		<td class="category"><?=$flower?> Flowers</td>
		<? for ($i = 1; $i <= 4; $i++ ){ ?>
		<td><img src="<?=$flower?>-Flower-<?=$i?>.gif"></td>
		<? } ?>
	</tr>
	<? } ?>
</table>


<h2 class="newpage">Standard Hands and point values</h2>

<table class="hands">
	<tr id="allpong">
		<td class="hand">All Pong</td>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Stick-2.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Char-4.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Stick-8.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="North-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="Dot-3.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">3 Points</td>
	</tr>
</table>
<table class="hands">	
	<tr id="allchow">
		<td class="hand">All Chow</td>
		<td class="blank"></td>
		<? for ($i = 1; $i <= 3; $i++) { ?>
		<td><img src="Dot-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 5; $i <= 7; $i++) { ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 3; $i <= 5; $i++) { ?>
		<td><img src="Dot-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 6; $i <= 8; $i++) { ?>
		<td><img src="Char-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 1; $i <= 2; $i++) { ?>
		<td><img src="Dot-5.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">1 Point</td>
	</tr>
</table>
<table class="hands">
	<tr id="pairs">
		<td class="hand">7 Pairs</td>
		<td class="blank"></td>
		<? foreach (array(1, 3, 5, 2, 9, 7, 6) as $i){ ?>
		<?$suit = $suits[rand(0,2)];?>
		<? for ($j=0; $j<2; $j++){ ?>
		<td><img src="<?=$suit?>-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? } ?>
		<td class="points">4 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="purity">
		<td class="hand">Purity</td>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Stick-5.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Stick-8.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 1; $i <= 3; $i++){ ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 6; $i <= 8; $i++){ ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="Stick-9.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">6 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="semipurity">
		<td class="hand">Semi-Purity</td>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="Stick-5.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="South-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 1; $i <= 3; $i++){ ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 6; $i <= 8; $i++){ ?>
		<td><img src="Stick-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="Red-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">3 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="dragon1">
		<td class="hand">1 pong of Dragons</td>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="Green-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
			<? for ($j=0; $j<3; $j++){ ?>
				<td><img src="default.gif"></td>
			<? } ?>
			<td class="blank"></td>
		<? } ?>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="default.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">1 Point</td>
	</tr>
</table>
<table class="hands">
	<tr id="dragon2">
		<td class="hand">2 pongs of Dragons</td>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="Green-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="Red-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 2; $i++){ ?>
			<? for ($j=0; $j<3; $j++){ ?>
				<td><img src="default.gif"></td>
			<? } ?>
			<td class="blank"></td>
		<? } ?>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="default.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">2 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="dragon2+">
		<td class="hand">2 pongs + Pair of Dragons</td>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="Green-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="Red-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 2; $i++){ ?>
			<? for ($j=0; $j<3; $j++){ ?>
				<td><img src="default.gif"></td>
			<? } ?>
			<td class="blank"></td>
		<? } ?>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="White-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">4 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="dragon3">
		<td class="hand">3 pongs of Dragons</td>
		<? foreach ($dragons as $dragon){ ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="<?=$dragon?>-Dragon.gif"></td>
		<? } ?>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="default.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="default.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">6 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="dragon-wind">
		<td class="hand">Winds &amp; Dragons</td>
		<? for ($j = 0; $j< 2; $j++){ ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="<?=$dragons[$j]?>-Dragon.gif"></td>
		<? } ?>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="<?=$winds['E']?>-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 3; $i++){ ?>
		<td><img src="<?=$winds['W']?>-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="<?=$winds['N']?>-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">7 Points</td>
	</tr>
</table>
<table class="hands">
	<tr id="winds">
		<td class="hand">Round Wind OR<br>Seat Wind</td>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
		<td><img src="East-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i < 3; $i++){ ?>
			<? for ($j=0; $j<3; $j++){ ?>
				<td><img src="default.gif"></td>
			<? } ?>
			<td class="blank"></td>
		<? } ?>
		<? for ($i = 0; $i < 2; $i++){ ?>
		<td><img src="default.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">1 Point (each)</td>
	</tr>
</table>
<table class="hands">
	<tr>
		<td class="hand">Flowers</td>
		<td class="blank"></td>
		<td colspan="19">Your Flower(s) = 1 Point each<br>
		No Flowers = 1 Point<br>
		All Red/Blue Flowers = 1 Point more<br>
		All Eight Flowers = 2 Points more</td>
	</tr>
</table>
<table class="hands">
	<tr>
		<td class="hand">Going Out</td>
		<td class="blank"></td>
		<td colspan="19">Self Pick = 1 Point<br>
		Self Pick Kong = 2 Points<br>
		&quot;Robbing&quot; a Kong = 1 Point<br>
		All tiles concealed = 1 Point<br>
	        Last Tile = 1 Point</td>
	</tr>
</table>


<h2 class="newpage">Special Hands</h2>

	<? $specials=array(
			0 => array("Dragon" => "Red",
				   "Name" => "Ruby",
				   "Suit" => "Char"),
			1 => array("Dragon" => "White",
				   "Name" => "Pearl",
				   "Suit" => "Dot"),
			2 => array("Dragon" => "Green",
				   "Name" => "Jade",
				   "Suit" => "Stick")
			);
	for ($i = 0; $i < 3; $i++){ ?>
<table class="hands">
	<tr id="<?=$specials[$i]['Name']?>">
		<td class="hand"><?=$specials[$i]['Name']?> Dragon</td>
		<td class="blank"></td>
		<? foreach (array(3, 5, 9) as $num) { ?>
		<? for ($j = 0; $j < 3; $j++) { ?>
		<td><img src="<?=$specials[$i]['Suit']?>-<?=$num?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? } ?>
		<? for ($j = 0; $j < 3; $j++) { ?>
		<td><img src="<?=$specials[$i]['Dragon']?>-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($j = 0; $j < 2; $j++) { ?>
		<td><img src="<?=$specials[$i]['Suit']?>-8.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">MAX HAND</td>
	</tr>
</table>
	<? } ?>
<table class="hands">
	<tr id="wonders">
		<td class="hand">13 Unique Wonders</td>
		<td class="blank"></td>
		<? foreach ($dragons as $dragon) { ?>
		<td><img src="<?=$dragon?>-Dragon.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? foreach ($suits as $suit) { ?>
		<td><img src="<?=$suit?>-1.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? foreach ($suits as $suit) { ?>
		<td><img src="<?=$suit?>-9.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? foreach ($winds as $wind) { ?>
		<td><img src="<?=$wind?>-Wind.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td><img src="default.gif"></td>
		<td class="blank"></td>
		<td class="points">MAX HAND</td>
	</tr>
</table>
<table class="hands">
	<tr id="Gates">
		<td class="hand">Gates of Heaven<br>
		<span style="font-size:smaller">(Must be all concealed)</span>
		</td>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Dot-1.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=2; $i<=8; $i++) { ?>
		<td><img src="Dot-<?=$i?>.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Dot-9.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td><img src="default.gif"></td>
		<td class="blank"></td>
		<td class="points">MAX HAND</td>
	</tr>
</table>
<table class="hands">
	<tr id="onesnines">
		<td class="hand">Ones &amp; Nines</td>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Stick-1.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Dot-9.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Char-1.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i<3; $i++) { ?>
		<td><img src="Dot-1.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<? for ($i=0; $i<2; $i++) { ?>
		<td><img src="Stick-9.gif"></td>
		<? } ?>
		<td class="blank"></td>
		<td class="points">MAX HAND</td>
	</tr>
</table>


<h2>Errata</h2>
<p><span style="font-weight:bold">Scoring:</span><br>
All players "pay" the winner based on the point value of his/her hand.  Player
that throws the winning tile must pay double.  If winner self-picks, all 
players pay double:</p>
<table>
	<tr valign="top">
		<td><b>Option A</b><br>
<ul>
<li>0 point hand: Pay 1 unit</li>
<li>1 point hand: Pay 2 units</li>
<li>2 point hand: Pay 4 units</li>
<li>3 point hand: Pay 8 units</li>
<li>4-6 point hands: Pay 16 units</li>
<li>7-9 point hands: Pay 32 units</li>
<li>10 point (MAX) hand: Pay 64 units</li>
</ul>
		</td>
		<td><b>Option B</b><br>
<!--<ul>
<li>0 point hand: Pay 1 unit</li>
<li>1 point hand: Pay 2 units</li>
<li>2 point hand: Pay 4 units</li>
<li>3 point hand: Pay 8 units</li>
<li>4 point hand: Pay 16 unit</li>
<li>5 point hand: Pay 32 units</li>
<li>6 point hand: Pay 64 units</li>
<li>7 point hand: Pay 128 units</li>
<li>8 point hand: Pay 256 units</li>
<li>9 point hand: Pay 512 units</li>
<li>10 point hand: Pay 1024 units</li>
<li>11 point hand: Pay 2048 units</li>
<li>12 point (MAX) hand: Pay 4096 units</li>
</ul>-->
		<ul>
		<li>X point hand: Pay 2<sup>X</sup> units (0 <= X <= 12)</li>
		<li>12 points is MAX hand</li>
		</ul>
		</td>
	</tr>
</table>

<p><span style="font-weight:bold">Penalties:</span><br>
There are various penalties that can be accrued:
<ul>
<li>Nine-Piece: If Player A is showing 9 pieces of purity, and Player B throws 
the winning tile, letting Player A Mah Jong with purity, Player B must pay for
all players.</li>
<li>Twelve-Piece: If Player A is showing 9 pieces of purity, and Player B 
throws a tile that gives Player A twelve pieces, and Player A later self-picks
with Purity, Player B must pay for all players</li>
<li>Five-Piece: If there are five or less tiles remaining in the wall, and 
Player A throws a piece that was previously unseen that causes another player 
to Mah Jong, Player A must pay for all players</li>
<li>False Mah Jong: If a player falsely declares a Mah Jong, he must pay 128 
units to each player.</li>
</ul>

<p><span style="font-weight:bold">Minimum Hand</span><br>
Most often, a game is played with a three point minimum.  If a player goes
out with less than three points in his hand, it is a False Mahjong.</p>

<p><span style="font-weight:bold">Accelerating Minimum</span><br>
(This is purely a UPAC Cinema invention)<br>
The minimum hand for each player is increased by one every round that player 
does not win.  The minimum hand for the winning player is reset to the base
minimum (generally three points)</p>
		
		

</table>
<h3 style="page-break-before:always"><a href="scores2.cgi">Cinema Mahjong Scores and Standings</a></h3>
</body>
</html>