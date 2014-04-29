<?php

namespace Anax\MVC;

class CDatabaseModel implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;

	public function getSource()
	{
    	return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
	}

	public function findAll()
	{
		$this->db->select()->from($this->getSource());
		$this->db->execute();
		$this->db->setFetchModeClass(__CLASS__);

		return $this->db->fetchAll();
	}

	public function find($id)
	{
		$this->db->select()->from($this->getSource())->where("id = ?");
		$this->db->execute([$id]);
		return $this->db->fetchInto($this);
	}


	public function save($values = [])
	{
		$this->setProperties($values);
		$values = $this->getProperties();

		if (isset($values['id'])) {
			return $this->update($values);
		} else {
			return $this->create($values);
		}
	}

	public function create($values)
	{
		$keys = array_keys($values);
		$values = array_values($values);

		$this->db->insert(
			$this->getSource(),
			$keys
		);

		$res = $this->db->execute($values);

		$this->id = $this->db->lastInsertId();

		return $res;
	}

	public function update($values)
	{
		$keys = array_keys($values);
		$values = array_values($values);

		unset($keys['id']);
		$values[] = $this->id;

		$this->db->update(
			$this->getSource(),
			$keys,
			"id = ?"
		);

		return $this->db->execute($values);
	}

	public function delete($id)
	{
		$this->db->delete(
			$this->getSource,
			'id = ?'
		);
		return $this->db->execute([$id]);
	}


	public function getProperties() 
	{
		$properties = get_object_vars($this);
		unset($properties['di']);
		unser($properties['db']);

		return $properties;
	}

	public function setProperties()
	{
		if (!empty($properties)) {
			foreach ($properties as $key => $value) {
				$this->key = $value;
			}
		}
	}

}