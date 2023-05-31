<?php
// To add and get posts details from the DB.
class Post{
	private $_db,
			$_data,
			$_userData;
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	public function addPost($fields){
		if(!$this->_db->insert('posts',$fields)){
			throw new Exception("POSTING FIALED");
			return false;
		}
		return true;
	}
	public function getPosts(){
		$data = $this->_db->getAll('posts');

		if($data->count()){
			$this->_data = $data->results();
			return true;
		}
		return false;
	}
	public function getComments(){
		$data = $this->_db->getAll('comments');

		if($data->count()){
			$this->_data = $data->results();
			return true;
		}
		return false;
	}
	public function addComment($fields){
		if(!$this->_db->insert('comments',$fields)){
			throw new Exception("POSTING FIALED");
			return false;
		}
		return true;
	}
	public function getPost($id){
		$data = $this->_db->get('posts',array('id','=',$id));
		if($data->count()){
			$this->_data = $data->first();
			return true;
		}
		return false;
	}
	public function search($name){
		$data = $this->_db->getByLike('users', "uname", $name);
		if($data->count()){
			$this->_data = $data->results();
			return true;
		}
		return false;
	}
	public function getPage($page){
		$data = $this->_db->getForPagination("users", $page, 4, "ASC");
		//$p = $data; 
		if($data->count()){
			$this->_data = $data->results();
			return true;
		}
		//return $p;
		return false;
	}
	public function getUser($id){
		$data = $this->_db->get('users', array('id','=',$id));
		if($data->count()){
			$this->_userData = $data->first();
			return true;
		}
		return false;
	}
	public function data(){
		return $this->_data;
	}
	public function userData(){
		return $this->_userData;
	}

}
