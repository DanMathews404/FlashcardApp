<?php

declare(strict_types = 1);

class CardsView
{
	public function __construct($cards)
	{
		$this->cards = $cards;
	}

	public function display()
	{
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){

                $(".question").click(function(){
                    $(this).toggle();
                    $(this).siblings(".answer").toggle();
                });

                $(".answer").click(function(){
                    $(this).toggle();
                    $(this).siblings(".question").toggle();
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
        </style>

        <?php
        foreach($this->cards as $card){
        ?>
            <div>
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
            </div>
        <?php
        }
	}
}
