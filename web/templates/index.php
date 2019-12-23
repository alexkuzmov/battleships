<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" type="text/css" href="/css/main.css" media="all" />
		
		<title>Battleships</title>
	</head>
	
	<body>
		<div class="wrapper">
			<div class="message">
				<?php if(isset($message)) echo '*** ' . $message . ' ***'; ?>
			</div>
		
			<table class="board">
				<?php foreach($layout AS $rowKey => $row){ ?>
					<?php if($rowKey == 0){ ?>
						<tr>
							<td></td>
						
							<?php foreach($row AS $columnKey => $column){ ?>
								<td>
									<?php echo $layoutColumns[$columnKey]; ?>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
					<tr>
						<td>
							<?php echo $layoutRows[$rowKey]; ?>
						</td>
					
						<?php foreach($row AS $column){ ?>
							<td class="point">
								<?php if(isset($_POST['show'])){echo ($column->contents() == 1 ? 'x' : '');}else{echo $column->state();} ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
			
			<div class="gameControls">
				<form method="post" action="/">
					Enter coordinates (row, col), e.g. A5 <input name="shot" type="text" size="2" maxlength="3" /> <input type="submit" value="Submit">
				</form>
			</div>
			
			<div class="gameControls">
				<form method="post" action="/index/new">
					<input type="submit" value="New Game" />
				</form>
			</div>
			
			<div class="gameControls">
				<form method="post" action="/">
					<input type="hidden" name="show" value="1" />
					
					<input type="submit" value="Show Ships (Cheater)" />
				</form>
			</div>
		</div>
	</body>
</html>