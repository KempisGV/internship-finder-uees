<?php

$feedback_positive = Session::get('feedback_positive');
$feedback_negative = Session::get('feedback_negative');

if (isset($feedback_positive)) {
	foreach ($feedback_positive as $feedback) {
?>
<div class="noo-messages noo-message-success"><?= $feedback; ?><i class="fa fa-close"></i></div>
<?php
	}
}

if (isset($feedback_negative)) {
	foreach ($feedback_negative as $feedback) {
?>
<div class="noo-messages noo-message-error"><?= $feedback; ?><i class="fa fa-close"></i></div>
<?php
	}
}
?>