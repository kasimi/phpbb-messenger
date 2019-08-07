<?php

namespace florinp\messenger\notification\type;

use phpbb\user_loader;

class friend_request extends \phpbb\notification\type\base
{
	/** @var user_loader */
	protected $user_loader;

	public function set_user_loader(user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	public function get_type()
	{
		return 'florinp.messenger.notification.type.friend_request';
	}

	public static $notification_option = array(
		'group'	 => 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	public function is_available()
	{
		return true;
	}

	public static function get_item_id($data)
	{
		return (int) $data['request_id'];
	}

	public static function get_item_parent_id($data)
	{
		return 0;
	}

	public function users_to_query()
	{
		return array();
	}

	public function find_users_for_notification($data, $options = array())
	{
		$options = array_merge(array(
			 'ignore_users'			=> array(),
		), $options);

		$users = array($data['user_id']);

		return $this->check_user_notification_options($users, $options);
	}

	public function get_title()
	{
		$user_id = $this->user_loader->load_user_by_username($this->get_data('sender_username'));
		return $this->user->lang('FRIEND_REQUEST_FROM').$this->user_loader->get_username($user_id, 'no_profile');
	}

	public function get_url()
	{
		return append_sid($this->phpbb_root_path.'ucp.'.$this->php_ext, "i=-florinp-messenger-ucp-ucp_friends_module&amp;mode=requests");
	}

	public function get_avatar()
	{
		$user_id = $this->user_loader->load_user_by_username($this->get_data('sender_username'));
		return $this->user_loader->get_avatar($user_id);
	}

	public function get_redirect_url()
	{
		return $this->get_url();
	}

	public function get_email_template()
	{
		return false;
	}

	public function get_email_template_variables()
	{
		return array();
	}

	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('request_id', $data['request_id']);
		$this->set_data('sender_id', $data['sender_id']);
		$this->set_data('sender_username', $data['sender_username']);
		$this->set_data('user_id', $data['user_id']);

		parent::create_insert_array($data, $pre_create_data);
	}
}
