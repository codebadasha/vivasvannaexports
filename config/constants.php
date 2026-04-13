<?php
	
	return [
		'module' =>  [
			1 => [
				'name' => 'Role',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					// 'add' => [
					// 	'name' => 'Add',
					// 	'selected' => false,
					// ],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
				]
			],
			2 => [
				'name' => 'Investor',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'add' => [
						'name' => 'Add',
						'selected' => false,
					],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'delete' => [
						'name' => 'Delete',
						'selected' => false,
					],
				]
			],
			3 => [
				'name' => 'Supplier Company',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'add' => [
						'name' => 'Add',
						'selected' => false,
					],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'delete' => [
						'name' => 'Delete',
						'selected' => false,
					],
					'authorized' => [
						'name' => 'Authorized Person',
						'selected' => false,
					],
				]
			],
			4 => [
				'name' => 'Team',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					// 'add' => [
					// 	'name' => 'Add',
					// 	'selected' => false,
					// ],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
					'status' =>  [
						'name' => 'Status',
						'selected' => false,
					],
					'sync-team-member' =>  [
						'name' => 'Sync zoho Team Member',
						'selected' => false,
					],
				]
			],
			5 => [
				'name' => 'Client Company',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'add' => [
						'name' => 'Add',
						'selected' => false,
					],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'view' => [
						'name' => 'View',
						'selected' => false,
					],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
					'verify' => [
						'name' => 'Verify',
						'selected' => false,
					],
					'dashboard' => [
						'name' => 'Dashboard',
						'selected' => false,
					],
					// 'download' => [
					// 	'name' => 'Download',
					// 	'selected' => false,
					// ],
					'setting' => [
						'name' => 'Settings',
						'selected' => false,
					],
					'team' => [
						'name' => 'Team Member',
						'selected' => false,
					],
					'users' => [
						'name' => 'Users',
						'selected' => false,
					],
					'status' => [
						'name' => 'Status',
						'selected' => false,
					],
				]
			],
			6 => [
				'name' => 'Product',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					// 'add' => [
					// 	'name' => 'Add',
					// 	'selected' => false,
					// ],
					// 'edit' => [
					// 	'name' => 'Edit',
					// 	'selected' => false,
					// ],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
				]
			],
			7 => [
				'name' => 'Po Module',
				'action' => [
					// 'add' => [
					// 	'name' => 'Add',
					// 	'selected' => false,
					// ],
					// 'edit' => [
					// 	'name' => 'Edit',
					// 	'selected' => false,
					// ],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'view' => [
						'name' => 'View PO',
						'selected' => false,
					],
					'download' => [
						'name' => 'Download PO',
						'selected' => false,
					],
					'view-document' => [
						'name' => 'View Document',
						'selected' => false,
					],
					// 'supplier' => [
					// 	'name' => 'Assign supplier',
					// 	'selected' => false,
					// ],
					// 'invoice' => [
					// 	'name' => 'Upload Invoice',
					// 	'selected' => false,
					// ],
				]
			],
			8 => [
				'name' => 'Project',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'add' => [
						'name' => 'Add',
						'selected' => false,
					],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'delete' => [
						'name' => 'Delete',
						'selected' => false,
					],
				]
			],
			9 => [
				'name' => 'BOQ Module',
				'action' => [
					'add' => [
						'name' => 'Add',
						'selected' => false,
					],
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'delete' => [
						'name' => 'Delete',
						'selected' => false,
					],
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'view' => [
						'name' => 'View BOQ',
						'selected' => false,
					],
					'manage' => [
						'name' => 'Manage PO',
						'selected' => false,
					],
				]
			],
			10 => [
				'name' => 'All Invoices',
				'action' => [
					'list' =>[
						'name' => 'List',
						'selected' => true,
					],
					// 'edit' => [
					// 	'name' => 'Edit',
					// 	'selected' => false,
					// ],
					'view' => [
						'name' => 'View Invoices',
						'selected' => false,
					],
					'assign-investor' => [
						'name' => 'Assign Investor',
						'selected' => false,
					],
					'download' => [
						'name' => 'Download Invoices',
						'selected' => false,
					],
					'view-document' => [
						'name' => 'View Document',
						'selected' => false,
					],
					// 'delete' => [
					// 	'name' => 'Delete',
					// 	'selected' => false,
					// ],
				]
			],
			11 => [
				'name' => 'All Transaction',
				'action' => [
					'list' =>[
						'name' => 'List',
						'selected' => true,
					],
				]
			],
			12 => [
				'name' => 'Policy',
				'action' => [
					'edit' => [
						'name' => 'Edit',
						'selected' => false,
					],
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
				]
			],
			13 => [
				'name' => 'Credit Request',
				'action' => [
					'view' =>[
						'name' => 'View',
						'selected' => false,
					],
					'download' =>[
						'name' => 'Download',
						'selected' => false,
					],
					'list' =>[
						'name' => 'List',
						'selected' => false,
					],
				]
			],
			14 => [
				'name' => 'Invitation',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'send' => [
						'name' => 'Send',
						'selected' => false,
					],
					'create-mater-link' => [
						'name' => 'Create Master link',
						'selected' => false,
					],
					'master_register' => [
						'name' => 'Register By Master Link',
						'selected' => false,
					],
				]
			],
			16 => [
				'name' => 'So Module',
				'action' => [
					'list' => [
						'name' => 'List',
						'selected' => true,
					],
					'view' => [
						'name' => 'View PO',
						'selected' => false,
					],
					'assign-project' => [
						'name' => 'Assign Project',
						'selected' => false,
					],
					'download' => [
						'name' => 'Download PO',
						'selected' => false,
					],
					'view-document' => [
						'name' => 'View Document',
						'selected' => false,
					],
				]
			]
		]
	];	
?>