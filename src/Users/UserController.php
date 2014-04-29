<?php

namespace Anax\Users;


class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 	

 	public function init() 
 	{
	 	$this->users = new \Anax\Users\User();
    	$this->users->setDI($this->di);
 	}

    public function listAction() 
    {
    	$this->init();
    	$all = $this->users->findAll();

    	$this->theme->setTitle('List all users');
    	$this->views->add('users/list-all', [
    		'users'	=>	$all;
    		'title'	=>	'View all users';
    	]);
    }


    public function idAction($id = null)
    {
    	$this->init();
    	$user = $this->users->find($id);
    	$this->theme->setTitle('View user with id');
    	$this->views->add('users/view', [
    		'user' => $user
    	]);
    }

    public function addAction($acronym = null)
    {
    	if (!isset($acronym)) {
    		die('Missing acronym');
    	}

    	$now = date(DATE_RFC2822);

    	$this->users->save([
    		'acronym' => $acronym,
        	'email' => $acronym . '@mail.se',
        	'name' => 'Mr/Mrs ' . $acronym,
        	'password' => password_hash($acronym, PASSWORD_DEFAULT),
        	'created' => $now,
        	'active' => $now,
    	]);

    	$url = $this->url->create('users/id/' . $this->users->id);
    	$this->response->redirect($url);
    }

    public function deleteAction($id = null)
    {
    	// Brutala fallet om id inte är satt.
    	if (!isset($id)) {
    		die('Missing id');
    	}

    	$res = $this->users->delete($id);

    	$url = $this->url->create('users');
    	$this->response->redirect($url);
    }

    public function softDeleteAction($id = null)
    {
		if (!isset($id)) {
    		die('Missing id');
    	}

    	$now = date(DATE_RFC2822);

    	$user = $this->users->find($id);

    	$user->deleted = $now;
    	$user->save();

    	$url = $this->url->create('users/id/' . $id);
 		$this->response->redirect($url);   	
    }


    public function activeAction()
    {
    	$all = $this->users->query()
    	->where('active IS NOT NULL')
    	->andWhere('deleted is NULL')
    	->execute();

    	$this->theme->setTitle('Users that are active');
    	$this->views->add('users/list-all', [
    		'users' => $all;
    		'title'	=> 'Users that are active';
    	]);
    }




}