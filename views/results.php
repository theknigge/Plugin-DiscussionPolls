<?php if(!defined('APPLICATION')) exit();

function DiscussionPollResults($Poll) {
  ?>
  <div class="DP_ResultsForm">
    <?php
    if(GetValue('Title', $Poll)
            || C('Plugins.DiscussionPolls.DisablePollTitle', FALSE)) {
      echo $Poll->Title;
      if(trim($Poll->Title) != FALSE) {
        echo '<hr />';
      }
    }
    else {
      echo Wrap(T('Plugins.DiscussionPolls.NotFound', 'Poll not found'), 'span');
    }
    ?>
    <ol class="DP_ResultQuestions">
      <?php
      if(!GetValue('Title', $Poll)
              && !C('Plugins.DiscussionPolls.DisablePollTitle', FALSE)) {
        //do nothing
      }
      else if(!count($Poll->Questions)) {
        echo Wrap(T('Plugins.DiscussionPolls.NoReults', 'No results for this poll'), 'span');
      }
      else {
        foreach($Poll->Questions as $Question) {
          ?>
          <li class="DP_ResultQuestion">
            <?php
            echo Wrap($Question->Title, 'span');
            echo Wrap(sprintf(Plural($Question->CountResponses, '%s vote', '%s votes'), $Question->CountResponses), 'span', array('class' => 'Number DP_VoteCount'));

            // k is used to have different option bar colors
            $k = $Question->QuestionID % 10;
            ?>
            <ol class="DP_ResultOptions">
              <?php
              foreach($Question->Options as $Option) {
                $String = Wrap($Option->Title, 'div');
                $Percentage = number_format(($Option->CountVotes / $Question->CountResponses * 100), 2);
                if($Percentage < 10) {
                  // put the text on the outside
                  $String .= '<span class="DP_Bar DP_Bar-' . $k . '" style="width: ' . $Percentage . '%;">&nbsp</span> ' . $Percentage . '%';
                }
                else {
                  // put the text on the inside
                  $String .= '<span class="DP_Bar DP_Bar-' . $k . '" style="width: ' . $Percentage . '%;">' . $Percentage . '%</span>';
                }

                echo Wrap($String, 'li', array('class' => 'DP_ResultOption'));

                $k++;
                $k = $k % 10;
              }
              ?>
            </ol>
          </li>
      <?php
    }
  }
  ?>
    </ol>
  </div>
  <?php
}
