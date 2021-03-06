<?php
$routings = [
	[
		'route'=>'/',
		'address'=>'./controllers/pages/',
		'class_name'=>'Head_controller',
		'func_name'=>'Function1'
	],
	[
		'route'=>'/f1',
		'address'=>'./controllers/pages/',
		'class_name'=>'Head_controller',
		'func_name'=>'Function1'
	],
	[
		'route'=>'/f2',
		'address'=>'./controllers/pages/',
		'class_name'=>'Head_controller',
		'func_name'=>'Function2'
	],
	[
		'route'=>'/f3/[a-zA-Z]{1,10}',
		'address'=>'./controllers/pages/',
		'class_name'=>'Another_controller',
		'func_name'=>'Function1'
	],
	[
		'route'=>'/f4/[0-9]{1,10}/[0-9]{1,10}',
		'address'=>'./controllers/pages/',
		'class_name'=>'Another_controller',
		'func_name'=>'Function2'
	],
];