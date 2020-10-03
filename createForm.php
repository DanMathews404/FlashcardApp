<?php

echo 'this is the create form';
?>
<form action="/create" method="post">
	<label for="id">Id (should remove this and autoincrement!:</label><br>
	<input type="text" id="id" name="id"><br>
	<label for="category">Category:</label><br>
	<input type="text" id="category" name="category"><br>
	<label for="question">Question:</label><br>
	<input type="text" id="question" name="question"><br>
	<label for="answer">Answer:</label><br>
	<input type="text" id="answer" name="answer"><br>
	<input type="submit" value="Submit">
</form>
