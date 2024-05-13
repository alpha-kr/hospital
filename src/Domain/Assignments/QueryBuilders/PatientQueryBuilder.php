<?php

namespace Domain\Assignments\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PatientQueryBuilder extends Builder
{
    public function whereName($name) :self
    {
        $name = trim($name);

        if (empty($name)) {
            return $this;
        }

        return $this->where('first_name', 'ILIKE', "%{$name}%");
    }

    public function whereDocument($document) :self
    {
        $document = trim($document);

        if (empty($document)) {
            return $this;
        }

        return $this->where('document', 'ILIKE', "%{$document}%");
    }

    public function whereLastName($lastName) :self
    {
        $lastName = trim($lastName);

        if (empty($lastName)) {
            return $this;
        }

        return $this->where('last_name', 'ILIKE', "%{$lastName}%");
    }
}
