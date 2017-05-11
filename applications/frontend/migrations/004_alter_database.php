<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_Alter_Database extends CI_Migration
{
	function up()
	{
		// tabel captcha
		echo "  > create table captcha ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('captcha_time float(14, 4) NOT NULL');
		$this->dbforge->add_field('filename varchar(19) NOT NULL');
		$this->dbforge->add_field('ip_address varchar(40) NOT NULL');
		$this->dbforge->add_field('word varchar(4) NOT NULL');
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->create_table('captcha', TRUE);
		echo "OK\n";
		
		// tabel gagal login
		echo "  > create table login_failed ... ";
		$this->dbforge->add_field('id'); // Primary Key
		$this->dbforge->add_field('username varchar(50) NOT NULL');
		$this->dbforge->add_field('password varchar(50) NOT NULL');
		$this->dbforge->add_field('ip_address varchar(40) NOT NULL');
		$this->dbforge->add_field('keterangan varchar(20) NOT NULL'); // jenis fail
		$this->dbforge->add_field('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->create_table('login_failed', TRUE);
		echo "OK\n";
		
		// alter table user
		echo "  > rename column user.auth_key --> user.password ... ";
		$this->db->query("ALTER TABLE `user` CHANGE auth_key password VARCHAR(32)");
		echo "OK\n";
	}
	
	function down()
	{
		// Drop table
		echo "  > drop table login_failed ... ";
		$this->dbforge->drop_table('login_failed');
		echo "OK\n";
		
		// Drop table
		echo "  > drop table captcha ... ";
		$this->dbforge->drop_table('captcha');
		echo "OK\n";
		
		// alter table user
		echo "  > rename column user.password --> user.auth_key ... ";
		$this->db->query("ALTER TABLE `user` CHANGE password auth_key VARCHAR(32)");
		echo "OK\n";
	}
}
