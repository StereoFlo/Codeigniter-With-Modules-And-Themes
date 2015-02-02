<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
	}
	
	function index()
	{
		if ($this->db->table_exists('users_groups') and $this->db->table_exists('login_attempts') and $this->db->table_exists('groups') and $this->db->table_exists('users'))
		{
		   die('The tables is exists. I\'m stop the script');
		} 
		
		$groups = "
			CREATE TABLE ".$this->db->dbprefix('groups')." (
			  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(20) NOT NULL,
			  `description` varchar(100) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		
		$groups_data = "
			INSERT INTO ".$this->db->dbprefix('groups')." (`id`, `name`, `description`) VALUES
			     (1,'admin','Administrator'),
			     (2,'members','General User');
		";
		
		$users = "
			CREATE TABLE ".$this->db->dbprefix('users')." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `ip_address` varchar(15) NOT NULL,
			  `username` varchar(100) NOT NULL,
			  `password` varchar(255) NOT NULL,
			  `salt` varchar(255) DEFAULT NULL,
			  `email` varchar(100) NOT NULL,
			  `activation_code` varchar(40) DEFAULT NULL,
			  `forgotten_password_code` varchar(40) DEFAULT NULL,
			  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
			  `remember_code` varchar(40) DEFAULT NULL,
			  `created_on` int(11) unsigned NOT NULL,
			  `last_login` int(11) unsigned DEFAULT NULL,
			  `active` tinyint(1) unsigned DEFAULT NULL,
			  `first_name` varchar(50) DEFAULT NULL,
			  `last_name` varchar(50) DEFAULT NULL,
			  `company` varchar(100) DEFAULT NULL,
			  `phone` varchar(20) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";

		$users_data = "
			INSERT INTO ".$this->db->dbprefix('users')."  (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
 				('1','127.0.0.1','administrator','\$2a\$07\$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,'1268889823','1268889823','1', 'Admin','istrator','ADMIN','0');
		";	
		
		$users_groups = "
			CREATE TABLE ".$this->db->dbprefix('users_groups')." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) unsigned NOT NULL,
			  `group_id` mediumint(8) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `fk_users_groups_users1_idx` (`user_id`),
			  KEY `fk_users_groups_groups1_idx` (`group_id`),
			  CONSTRAINT `uc_users_groups` UNIQUE (`user_id`, `group_id`),
			  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
			  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		
		$users_groups_data = "
			INSERT INTO ".$this->db->dbprefix('users_groups')." (`id`, `user_id`, `group_id`) VALUES
			     (1,1,1),
			     (2,1,2);
		";
		
		$login_attempts = "
			CREATE TABLE ".$this->db->dbprefix('login_attempts')." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `ip_address` varchar(15) NOT NULL,
			  `login` varchar(100) NOT NULL,
			  `time` int(11) unsigned DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		
		if($this->db->query($groups) and $this->db->query($groups_data)
			and $this->db->query($users) and $this->db->query($users_data)
			and $this->db->query($users_groups) and $this->db->query($users_groups_data)
			and $this->db->query($login_attempts)
			)
		{
			print "if you are not see this message, all is ok";
		}
		
	}
}