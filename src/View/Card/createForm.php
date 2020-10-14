<style>
	input {
		width: 100%;
	}
	form {
		width: 50%;
		margin: auto;
		display: block;
	}
	#submit {
		width: 20%;
		margin: auto;
		display: block;
	}
</style>

<h1>Create form</h1><br><br>

<form action="/create" method="post">
	<label for="category">Category:</label><br>
	<input type="text" id="category" name="category"><br><br>
	<label for="question">Question:</label><br>
	<input type="text" id="question" name="question"><br><br>
	<label for="answer">Answer:</label><br>
	<input type="text" id="answer" name="answer"><br><br>
	<input type="submit" id="submit" value="Submit">
</form>
