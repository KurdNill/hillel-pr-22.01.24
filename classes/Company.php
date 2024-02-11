<?php

class Company
{
    protected array $employees = [];

    /**
     * @param array $employees
     */
    public function setEmployee(Employee $employees): void
    {
        $this->employees[] = $employees;
    }

    public function createSoftware()
    {
        foreach ($this->employees as $employee) {
            $employee->doJob();
        }
    }
}