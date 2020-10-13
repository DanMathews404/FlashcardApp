<script>
	$(document).ready(function(){

		$(".card").click(function(){
			$(this).find(".question").toggle();
			$(this).find(".answer").toggle();
		});

	});
</script>

<style>
	.answer {
		display:none;
	}

	div {
		margin:30px;
		border:1px solid black;
		padding:5px;
	}

	td {
		display:inline-block;
		padding:0;
	}

    .card {
        cursor: default;
    }

    .card table {
        font-size: inherit;
    }


</style>

<h1>Index</h1>

<?php
foreach($data['cards'] as $card){
	?>
	<div class="card">
		<table style="width:100%;">
			<tr>
				<td style="width:50%;"><?php echo "Category: " . $card->category;?></td>
				<td style="width:50%;text-align:right;"><?php echo "ID: " . $card->id;?></td>
			</tr>
			<tr class="question">
				<td style="width:100%;"><?php echo "Question: " . $card->question;?></td>
			</tr>
			<tr class="answer">
				<td style="width:100%;"><?php echo "Answer: " . $card->answer;?></td>
			</tr>
		</table>
		<form action="/delete" method="post">
			<input type="hidden" id="id" name="id" value="<?php echo $card->id ?>"<br>
			<input type="submit" value="Delete">
		</form>
	</div>
	<?php
}