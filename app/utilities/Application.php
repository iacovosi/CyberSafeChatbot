<?php


namespace App\utilities;


class Application
{
    private $category;
    private $where;
    private $type;
    private $description;
    private $personal_data;
    private $personal_details;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @param mixed $where
     */
    public function setWhere($where)
    {
        $this->where = $where;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPersonalData()
    {
        return $this->personal_data;
    }

    /**
     * @param mixed $personal_data
     */
    public function setPersonalData($personal_data)
    {
        $this->personal_data = $personal_data;
    }

    /**
     * @return mixed
     */
    public function getPersonalDetails()
    {
        return $this->personal_details;
    }

    /**
     * @param mixed $personal_details
     */
    public function setPersonalDetails($personal_details)
    {
        $this->personal_details = $personal_details;
    }


    public function returnResultOfChatBot()
    {
        return "Category: " . $this->category . " where :" . $this->where . " type " . $this->type . " description:" . $this->description . " personal data: " . $this->personal_data . " personal details:" . $this->personal_details;

    }

}