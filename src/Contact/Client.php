<?php

namespace Clicksports\LexOffice\Contact;

use Clicksports\LexOffice\PaginationClient;

class Client extends PaginationClient {
    protected string $resource = 'contacts';

    public string $sortDirection = 'ASC';

    public string $sortProperty = 'name';

    private $filters = [];

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string {
        $filters = $this->filters;
        array_walk($filters, function (&$value, $key) {
            $value = "{$key}=${value}";
        });
        return parent::generateUrl($page) .
            '&direction=' . $this->sortDirection .
            '&property=' . $this->sortProperty . (sizeof($filters) > 0 ? "&" : '') . implode('&', $filters);
    }

    /**
     * set filters for the Contacts query. Currently available:
     * 
     * - email: filters contacts where any of their email addresses inside the emailAddresses JSON object match the given email value. At least 3 characters are necessary to successfully complete the query.
     * - name: filters contacts whose name matches the given name value. At least 3 characters are necessary to successfully complete the query.
     * - number: returns the contacts with the specified contact number. Number is either the customer number or the vendor number located in the roles object.
     * - customer: if set to true filters contacts that have the role customer. If set to false filters contacts that do not have the customer role.
     * - vendor: if set to true filters contacts that have the role vendor. If set to false filters contacts that do not have the vendor role.
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters($filters = []) {
        $this->filters = $filters;
        return $this;
    }

    /**
     * reset all filters
     *
     * @return $this
     */
    public function resetFilters() {
        $this->filters = [];
        return $this;
    }
}
