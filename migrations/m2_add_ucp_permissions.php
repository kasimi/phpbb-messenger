<?php

namespace florinp\messenger\migrations;

class m2_add_ucp_permissions extends \phpbb\db\migration\migration
{

	public function update_data()
	{
		return array(
		  array('permission.add', array('u_access_messenger')),
		  array('permission.permission_set', array('REGISTERED', 'u_access_messenger', 'group'))
		);
	}

}
