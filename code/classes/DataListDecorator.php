<?php

class DataListDecorator extends DataList {

    /** @var DataList */
    protected $dataList;

    public function __construct($dataList) {
        $this->dataList = $dataList;
    }

    public function setDataList($dataList) {
        $this->dataList = $dataList;
        return $this;
    }

    /**
     * Set the DataModel
     *
     * @param DataModel $model
     */
    public function setDataModel(DataModel $model) {
        $this->dataList->setDataModel($model);
        return $this;
    }

    /**
     * Get the dataClass name for this DataList, ie the DataObject ClassName
     *
     * @return string
     */
    public function dataClass() {
        return $this->dataList->dataClass();
    }

    /**
     * When cloning this object, clone the dataList object as well
     */
    public function __clone() {
        $this->dataList = clone $this->dataList;
    }

    /**
     * Return a copy of the internal {@link DataQuery} object
     *
     * Because the returned value is a copy, modifying it won't affect this list's contents. If
     * you want to alter the data query directly, use the alterDataQuery method
     *
     * @return DataQuery
     */
    public function dataQuery() {
        return $this->dataList->dataQuery();
    }

    /**
     * Return a new DataList instance with the underlying {@link DataQuery} object altered
     *
     * If you want to alter the underlying dataQuery for this list, this wrapper method
     * will ensure that you can do so without mutating the existing List object.
     *
     * It clones this list, calls the passed callback function with the dataQuery of the new
     * list as it's first parameter (and the list as it's second), then returns the list
     *
     * Note that this function is re-entrant - it's safe to call this inside a callback passed to
     * alterDataQuery
     *
     * @param $callback
     * @return $this
     */
    public function alterDataQuery($callback) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->alterDataQuery($callback));
        return $clone;
    }

    /**
     * Return a new DataList instance with the underlying {@link DataQuery} object changed
     *
     * @param DataQuery $dataQuery
     * @return $this
     */
    public function setDataQuery(DataQuery $dataQuery) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->setDataQuery($dataQuery));
        return $clone;
    }

    /**
     * Returns a new DataList instance with the specified query parameter assigned
     *
     * @param string|array $keyOrArray Either the single key to set, or an array of key value pairs to set
     * @param mixed $val If $keyOrArray is not an array, this is the value to set
     * @return $this
     */
    public function setDataQueryParam($keyOrArray, $val = null) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->setDataQueryParam($keyOrArray, $val));
        return $clone;
    }

    /**
     * Returns the SQL query that will be used to get this DataList's records.  Good for debugging. :-)
     *
     * @param array $parameters Out variable for parameters required for this query
     * @param string The resulting SQL query (may be paramaterised)
     */
    public function sql(&$parameters = array()) {
        return $this->dataList->sql($parameters);
    }

    /**
     * Return a new DataList instance with a WHERE clause added to this list's query.
     *
     * Supports parameterised queries.
     * See SQLQuery::addWhere() for syntax examples, although DataList
     * won't expand multiple method arguments as SQLQuery does.
     *
     * @param string|array|SQLConditionGroup $filter Predicate(s) to set, as escaped SQL statements or
     * paramaterised queries
     * @return $this
     */
    public function where($filter) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->where($filter));
        return $clone;
    }

    /**
     * Return a new DataList instance with a WHERE clause added to this list's query.
     * All conditions provided in the filter will be joined with an OR
     *
     * Supports parameterised queries.
     * See SQLQuery::addWhere() for syntax examples, although DataList
     * won't expand multiple method arguments as SQLQuery does.
     *
     * @param string|array|SQLConditionGroup $filter Predicate(s) to set, as escaped SQL statements or
     * paramaterised queries
     * @return $this
     */
    public function whereAny($filter) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->whereAny($filter));
        return $clone;
    }



    /**
     * Returns true if this DataList can be sorted by the given field.
     *
     * @param string $fieldName
     * @return boolean
     */
    public function canSortBy($fieldName) {
        return $this->dataList->canSortBy($fieldName);
    }

    /**
     * Returns true if this DataList can be filtered by the given field.
     *
     * @param string $fieldName (May be a related field in dot notation like Member.FirstName)
     * @return boolean
     */
    public function canFilterBy($fieldName) {
        return $this->dataList->canFilterBy($fieldName);
    }

    /**
     * Return a new DataList instance with the records returned in this query
     * restricted by a limit clause.
     *
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function limit($limit, $offset = 0) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->limit($limit, $offset));
        return $clone;
    }

    /**
     * Return a new DataList instance with distinct records or not
     *
     * @param bool $value
     * @return $this
     */
    public function distinct($value) {
        $clone = clone $this;
        $clone->setDataList($this->dataList->distinct($value));
        return $clone;
    }

    /**
     * Return a new DataList instance as a copy of this data list with the sort
     * order set.
     *
     * @see SS_List::sort()
     * @see SQLQuery::orderby
     * @example $list = $list->sort('Name'); // default ASC sorting
     * @example $list = $list->sort('Name DESC'); // DESC sorting
     * @example $list = $list->sort('Name', 'ASC');
     * @example $list = $list->sort(array('Name'=>'ASC', 'Age'=>'DESC'));
     *
     * @param String|array Escaped SQL statement. If passed as array, all keys and values are assumed to be escaped.
     * @return $this
     */
    public function sort() {
        $clone = clone $this;
        $args = func_get_args();
        $clone->setDataList(call_user_func_array(array($this->dataList, 'sort'), $args));
        return $clone;
    }

    /**
     * Return a copy of this list which only includes items with these charactaristics
     *
     * @see SS_List::filter()
     *
     * @example $list = $list->filter('Name', 'bob'); // only bob in the list
     * @example $list = $list->filter('Name', array('aziz', 'bob'); // aziz and bob in list
     * @example $list = $list->filter(array('Name'=>'bob', 'Age'=>21)); // bob with the age 21
     * @example $list = $list->filter(array('Name'=>'bob', 'Age'=>array(21, 43))); // bob with the Age 21 or 43
     * @example $list = $list->filter(array('Name'=>array('aziz','bob'), 'Age'=>array(21, 43)));
     *          // aziz with the age 21 or 43 and bob with the Age 21 or 43
     *
     * @todo extract the sql from $customQuery into a SQLGenerator class
     *
     * @param string|array Escaped SQL statement. If passed as array, all keys and values will be escaped internally
     * @return $this
     */
    public function filter() {
        $clone = clone $this;
        $args = func_get_args();
        $clone->setDataList(call_user_func_array(array($this->dataList, 'filter'), $args));
        return $clone;
    }

    /**
     * Return a new instance of the list with an added filter
     *
     * @param array $filterArray
     * @return $this
     */
    public function addFilter($filterArray) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->addFilter($filterArray));
    }

    /**
     * Return a copy of this list which contains items matching any of these charactaristics.
     *
     * @example // only bob in the list
     *          $list = $list->filterAny('Name', 'bob');
     *          // SQL: WHERE "Name" = 'bob'
     * @example // azis or bob in the list
     *          $list = $list->filterAny('Name', array('aziz', 'bob');
     *          // SQL: WHERE ("Name" IN ('aziz','bob'))
     * @example // bob or anyone aged 21 in the list
     *          $list = $list->filterAny(array('Name'=>'bob, 'Age'=>21));
     *          // SQL: WHERE ("Name" = 'bob' OR "Age" = '21')
     * @example // bob or anyone aged 21 or 43 in the list
     *          $list = $list->filterAny(array('Name'=>'bob, 'Age'=>array(21, 43)));
     *          // SQL: WHERE ("Name" = 'bob' OR ("Age" IN ('21', '43'))
     * @example // all bobs, phils or anyone aged 21 or 43 in the list
     *          $list = $list->filterAny(array('Name'=>array('bob','phil'), 'Age'=>array(21, 43)));
     *          // SQL: WHERE (("Name" IN ('bob', 'phil')) OR ("Age" IN ('21', '43'))
     *
     * @todo extract the sql from this method into a SQLGenerator class
     *
     * @param string|array See {@link filter()}
     * @return $this
     */
    public function filterAny() {
        $clone = clone $this;
        $args = func_get_args();
        return $clone->setDataList(call_user_func_array(array($this->dataList, 'filterAny'), $args));
    }

    /**
     * Note that, in the current implementation, the filtered list will be an ArrayList, but this may change in a
     * future implementation.
     * @see SS_Filterable::filterByCallback()
     *
     * @example $list = $list->filterByCallback(function($item, $list) { return $item->Age == 9; })
     * @param callable $callback
     * @return ArrayList (this may change in future implementations)
     */
    public function filterByCallback($callback) {
        return $this->dataList->filterByCallback($callback);
    }

    /**
     * Translates a {@link Object} relation name to a Database name and apply
     * the relation join to the query.  Throws an InvalidArgumentException if
     * the $field doesn't correspond to a relation.
     *
     * @throws InvalidArgumentException
     * @param string $field
     *
     * @return string
     */
    public function getRelationName($field) {
        return $this->dataList->getRelationName($field);
    }

    /**
     * Return a copy of this list which does not contain any items with these charactaristics
     *
     * @see SS_List::exclude()
     * @example $list = $list->exclude('Name', 'bob'); // exclude bob from list
     * @example $list = $list->exclude('Name', array('aziz', 'bob'); // exclude aziz and bob from list
     * @example $list = $list->exclude(array('Name'=>'bob, 'Age'=>21)); // exclude bob that has Age 21
     * @example $list = $list->exclude(array('Name'=>'bob, 'Age'=>array(21, 43))); // exclude bob with Age 21 or 43
     * @example $list = $list->exclude(array('Name'=>array('bob','phil'), 'Age'=>array(21, 43)));
     *          // bob age 21 or 43, phil age 21 or 43 would be excluded
     *
     * @todo extract the sql from this method into a SQLGenerator class
     *
     * @param string|array Escaped SQL statement. If passed as array, all keys and values will be escaped internally
     * @return $this
     */
    public function exclude() {
        $clone = clone $this;
        $args = func_get_args();
        return $clone->setDataList(call_user_func_array(array($this->dataList, 'exclude'), $args));
    }

    /**
     * This method returns a copy of this list that does not contain any DataObjects that exists in $list
     *
     * The $list passed needs to contain the same dataclass as $this
     *
     * @param SS_List $list
     * @return $this
     * @throws BadMethodCallException
     */
    public function subtract(SS_List $list) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->subtract($list));
    }

    /**
     * Return a new DataList instance with an inner join clause added to this list's query.
     *
     * @param string $table Table name (unquoted and as escaped SQL)
     * @param string $onClause Escaped SQL statement, e.g. '"Table1"."ID" = "Table2"."ID"'
     * @param string $alias - if you want this table to be aliased under another name
     * @param int $order A numerical index to control the order that joins are added to the query; lower order values
     * will cause the query to appear first. The default is 20, and joins created automatically by the
     * ORM have a value of 10.
     * @param array $parameters Any additional parameters if the join is a parameterised subquery
     * @return $this
     */
    public function innerJoin($table, $onClause, $alias = null, $order = 20, $parameters = array()) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->innerJoin($table, $onClause, $alias, $order, $parameters));
    }

    /**
     * Return a new DataList instance with a left join clause added to this list's query.
     *
     * @param string $table Table name (unquoted and as escaped SQL)
     * @param string $onClause Escaped SQL statement, e.g. '"Table1"."ID" = "Table2"."ID"'
     * @param string $alias - if you want this table to be aliased under another name
     * @param int $order A numerical index to control the order that joins are added to the query; lower order values
     * will cause the query to appear first. The default is 20, and joins created automatically by the
     * ORM have a value of 10.
     * @param array $parameters Any additional parameters if the join is a parameterised subquery
     * @return $this
     */
    public function leftJoin($table, $onClause, $alias = null, $order = 20, $parameters = array()) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->leftJoin($table, $onClause, $alias, $order, $parameters));
    }

    /**
     * Return an array of the actual items that this DataList contains at this stage.
     * This is when the query is actually executed.
     *
     * @return array
     */
    public function toArray() {
        return $this->dataList->toArray();
    }

    /**
     * Return this list as an array and every object it as an sub array as well
     *
     * @return array
     */
    public function toNestedArray() {
        return $this->dataList->toNestedArray();
    }

    /**
     * Walks the list using the specified callback
     *
     * @param callable $callback
     * @return $this
     */
    public function each($callback) {
        $this->dataList->each($callback);
        return $this;
    }

    /**
     * Returns a map of this list
     *
     * @param string $keyField - the 'key' field of the result array
     * @param string $titleField - the value field of the result array
     * @return SS_Map
     */
    public function map($keyField = 'ID', $titleField = 'Title') {
        return $this->dataList->map($keyField, $titleField);
    }

    /**
     * Returns an Iterator for this DataList.
     * This function allows you to use DataLists in foreach loops
     *
     * @return ArrayIterator
     */
    public function getIterator() {
        return $this->dataList->getIterator();
    }

    /**
     * Return the number of items in this DataList
     *
     * @return int
     */
    public function count() {
        return $this->dataList->count();
    }

    /**
     * Return the maximum value of the given field in this DataList
     *
     * @param string $fieldName
     * @return mixed
     */
    public function max($fieldName) {
        return $this->dataList->max($fieldName);
    }

    /**
     * Return the minimum value of the given field in this DataList
     *
     * @param string $fieldName
     * @return mixed
     */
    public function min($fieldName) {
        return $this->dataList->min($fieldName);
    }

    /**
     * Return the average value of the given field in this DataList
     *
     * @param string $fieldName
     * @return mixed
     */
    public function avg($fieldName) {
        return $this->dataList->avg($fieldName);
    }

    /**
     * Return the sum of the values of the given field in this DataList
     *
     * @param string $fieldName
     * @return mixed
     */
    public function sum($fieldName) {
        return $this->dataList->sum($fieldName);
    }


    /**
     * Returns the first item in this DataList
     *
     * @return DataObject
     */
    public function first() {
        return $this->dataList->first();
    }

    /**
     * Returns the last item in this DataList
     *
     *  @return DataObject
     */
    public function last() {
        return $this->dataList->last();
    }

    /**
     * Returns true if this DataList has items
     *
     * @return bool
     */
    public function exists() {
        return $this->dataList->exists();
    }

    /**
     * Find the first DataObject of this DataList where the given key = value
     *
     * @param string $key
     * @param string $value
     * @return DataObject|null
     */
    public function find($key, $value) {
        return $this->dataList->find($key, $value);
    }

    /**
     * Restrict the columns to fetch into this DataList
     *
     * @param array $queriedColumns
     * @return $this
     */
    public function setQueriedColumns($queriedColumns) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->setQueriedColumns($queriedColumns));
    }

    /**
     * Filter this list to only contain the given Primary IDs
     *
     * @param array $ids Array of integers
     * @return $this
     */
    public function byIDs(array $ids) {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->byIDs($ids));
    }

    /**
     * Return the first DataObject with the given ID
     *
     * @param int $id
     * @return DataObject
     */
    public function byID($id) {
        return $this->dataList->byID($id);
    }

    /**
     * Returns an array of a single field value for all items in the list.
     *
     * @param string $colName
     * @return array
     */
    public function column($colName = "ID") {
        return $this->dataList->column($colName);
    }

    // Member altering methods

    /**
     * Sets the ComponentSet to be the given ID list.
     * Records will be added and deleted as appropriate.
     *
     * @param array $idList List of IDs.
     */
    public function setByIDList($idList) {
        $this->dataList->setByIDList($idList);
    }

    /**
     * Returns an array with both the keys and values set to the IDs of the records in this list.
     * Does not respect sort order. Use ->column("ID") to get an ID list with the current sort.
     *
     * @return array
     */
    public function getIDList() {
        return $this->dataList->getIDList();
    }

    /**
     * Returns a HasManyList or ManyMany list representing the querying of a relation across all
     * objects in this data list.  For it to work, the relation must be defined on the data class
     * that you used to create this DataList.
     *
     * Example: Get members from all Groups:
     *
     *     DataList::Create("Group")->relation("Members")
     *
     * @param string $relationName
     * @return HasManyList|ManyManyList
     */
    public function relation($relationName) {
        return $this->dataList->relation($relationName);
    }

    public function dbObject($fieldName) {
        return $this->dataList->dbObject($fieldName);
    }

    /**
     * Add a number of items to the component set.
     *
     * @param array $items Items to add, as either DataObjects or IDs.
     * @return $this
     */
    public function addMany($items) {
        $this->dataList->addMany($items);
        return $this;
    }

    /**
     * Remove the items from this list with the given IDs
     *
     * @param array $idList
     * @return $this
     */
    public function removeMany($idList) {
        $this->dataList->removeMany($idList);
        return $this;
    }

    /**
     * Remove every element in this DataList matching the given $filter.
     *
     * @param string $filter - a sql type where filter
     * @return $this
     */
    public function removeByFilter($filter) {
        $this->dataList->removeByFilter($filter);
        return $this;
    }

    /**
     * Remove every element in this DataList.
     *
     * @return $this
     */
    public function removeAll() {
        $this->dataList->removeAll();
        return $this;
    }

    /**
     * Return a new item to add to this DataList.
     *
     * @todo This doesn't factor in filters.
     */
    public function newObject($initialFields = null) {
        return $this->dataList->newObject($initialFields);
    }

    /**
     * Remove this item by deleting it
     *
     * @param DataClass $item
     * @todo Allow for amendment of this behaviour - for example, we can remove an item from
     * an "ActiveItems" DataList by chaning the status to inactive.
     */
    public function remove($item) {
        $this->dataList->remove($item);
    }

    /**
     * Remove an item from this DataList by ID
     *
     * @param int $itemID - The primary ID
     */
    public function removeByID($itemID) {
        return $this->dataList->removeByID($itemID);
    }

    /**
     * Reverses a list of items.
     *
     * @return DataList
     */
    public function reverse() {
        $clone = clone $this;
        return $clone->setDataList($this->dataList->reverse());
    }

    /**
     * Returns whether an item with $key exists
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key) {
        return $this->dataList->offsetExists($key);
    }

    /**
     * Returns item stored in list with index $key
     *
     * @param mixed $key
     * @return DataObject
     */
    public function offsetGet($key) {
        return $this->dataList->offsetGet($key);
    }

    public function offsetSet($offset, $value) {
        return $this->dataList->offsetSet($offset, $value);
    }

    public function offsetUnset($offset) {
        return $this->dataList->offsetUnset($offset);
    }

    public function add($item) {
        return $this->dataList->add($item);
    }


}