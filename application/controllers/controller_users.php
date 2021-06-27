<?php
// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');


// Render a template
echo $templates->render('users_view', ['page'=>($vars)]);
