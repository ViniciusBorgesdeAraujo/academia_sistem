<?php namespace PHPMaker2020\sistema; ?>
<?php

/**
 * Table class for endereco
 */
class endereco extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $idendereco;
	public $idacademia;
	public $idpessoa;
	public $CEP;
	public $UF;
	public $Cidade;
	public $Bairro;
	public $Rua;
	public $Numero;
	public $Complemento;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'endereco';
		$this->TableName = 'endereco';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`endereco`";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// idendereco
		$this->idendereco = new DbField('endereco', 'endereco', 'x_idendereco', 'idendereco', '`idendereco`', '`idendereco`', 3, 11, -1, FALSE, '`idendereco`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idendereco->IsAutoIncrement = TRUE; // Autoincrement field
		$this->idendereco->IsPrimaryKey = TRUE; // Primary key field
		$this->idendereco->Sortable = TRUE; // Allow sort
		$this->idendereco->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idendereco'] = &$this->idendereco;

		// idacademia
		$this->idacademia = new DbField('endereco', 'endereco', 'x_idacademia', 'idacademia', '`idacademia`', '`idacademia`', 3, 11, -1, FALSE, '`idacademia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idacademia->IsForeignKey = TRUE; // Foreign key field
		$this->idacademia->Sortable = TRUE; // Allow sort
		$this->idacademia->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idacademia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->idacademia->Lookup = new Lookup('idacademia', 'academia', FALSE, 'idacademia', ["nome","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idacademia->Lookup = new Lookup('idacademia', 'academia', FALSE, 'idacademia', ["nome","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idacademia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idacademia'] = &$this->idacademia;

		// idpessoa
		$this->idpessoa = new DbField('endereco', 'endereco', 'x_idpessoa', 'idpessoa', '`idpessoa`', '`idpessoa`', 3, 11, -1, FALSE, '`idpessoa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idpessoa->IsForeignKey = TRUE; // Foreign key field
		$this->idpessoa->Sortable = TRUE; // Allow sort
		$this->idpessoa->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idpessoa->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->idpessoa->Lookup = new Lookup('idpessoa', 'pessoa', FALSE, 'idpessoa', ["Nome","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idpessoa->Lookup = new Lookup('idpessoa', 'pessoa', FALSE, 'idpessoa', ["Nome","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idpessoa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idpessoa'] = &$this->idpessoa;

		// CEP
		$this->CEP = new DbField('endereco', 'endereco', 'x_CEP', 'CEP', '`CEP`', '`CEP`', 200, 11, -1, FALSE, '`CEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CEP->Sortable = TRUE; // Allow sort
		$this->fields['CEP'] = &$this->CEP;

		// UF
		$this->UF = new DbField('endereco', 'endereco', 'x_UF', 'UF', '`UF`', '`UF`', 200, 2, -1, FALSE, '`UF`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->UF->Sortable = TRUE; // Allow sort
		$this->fields['UF'] = &$this->UF;

		// Cidade
		$this->Cidade = new DbField('endereco', 'endereco', 'x_Cidade', 'Cidade', '`Cidade`', '`Cidade`', 200, 95, -1, FALSE, '`Cidade`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cidade->Sortable = TRUE; // Allow sort
		$this->fields['Cidade'] = &$this->Cidade;

		// Bairro
		$this->Bairro = new DbField('endereco', 'endereco', 'x_Bairro', 'Bairro', '`Bairro`', '`Bairro`', 200, 85, -1, FALSE, '`Bairro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bairro->Sortable = TRUE; // Allow sort
		$this->fields['Bairro'] = &$this->Bairro;

		// Rua
		$this->Rua = new DbField('endereco', 'endereco', 'x_Rua', 'Rua', '`Rua`', '`Rua`', 200, 85, -1, FALSE, '`Rua`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Rua->Sortable = TRUE; // Allow sort
		$this->fields['Rua'] = &$this->Rua;

		// Numero
		$this->Numero = new DbField('endereco', 'endereco', 'x_Numero', 'Numero', '`Numero`', '`Numero`', 200, 25, -1, FALSE, '`Numero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Numero->Sortable = TRUE; // Allow sort
		$this->fields['Numero'] = &$this->Numero;

		// Complemento
		$this->Complemento = new DbField('endereco', 'endereco', 'x_Complemento', 'Complemento', '`Complemento`', '`Complemento`', 200, 45, -1, FALSE, '`Complemento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Complemento->Sortable = TRUE; // Allow sort
		$this->fields['Complemento'] = &$this->Complemento;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Multiple column sort
	public function updateSort(&$fld, $ctrl)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			if ($ctrl) {
				$orderBy = $this->getSessionOrderBy();
				if (ContainsString($orderBy, $sortField . " " . $lastSort)) {
					$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
				} else {
					if ($orderBy != "")
						$orderBy .= ", ";
					$orderBy .= $sortField . " " . $thisSort;
				}
				$this->setSessionOrderBy($orderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
			}
		} else {
			if (!$ctrl)
				$fld->setSort("");
		}
	}

	// Current master table name
	public function getCurrentMasterTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")];
	}
	public function setCurrentMasterTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
	}

	// Session master WHERE clause
	public function getMasterFilter()
	{

		// Master filter
		$masterFilter = "";
		if ($this->getCurrentMasterTable() == "academia") {
			if ($this->idacademia->getSessionValue() != "")
				$masterFilter .= "`idacademia`=" . QuotedValue($this->idacademia->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "pessoa") {
			if ($this->idpessoa->getSessionValue() != "")
				$masterFilter .= "`idpessoa`=" . QuotedValue($this->idpessoa->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $masterFilter;
	}

	// Session detail WHERE clause
	public function getDetailFilter()
	{

		// Detail filter
		$detailFilter = "";
		if ($this->getCurrentMasterTable() == "academia") {
			if ($this->idacademia->getSessionValue() != "")
				$detailFilter .= "`idacademia`=" . QuotedValue($this->idacademia->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "pessoa") {
			if ($this->idpessoa->getSessionValue() != "")
				$detailFilter .= "`idpessoa`=" . QuotedValue($this->idpessoa->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_academia()
	{
		return "`idacademia`=@idacademia@";
	}

	// Detail filter
	public function sqlDetailFilter_academia()
	{
		return "`idacademia`=@idacademia@";
	}

	// Master filter
	public function sqlMasterFilter_pessoa()
	{
		return "`idpessoa`=@idpessoa@";
	}

	// Detail filter
	public function sqlDetailFilter_pessoa()
	{
		return "`idpessoa`=@idpessoa@";
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`endereco`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect != "") ? $this->SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
		$this->TableFilter = "";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving != "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter, $id = "")
	{
		global $Security;

		// Add User ID filter
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$filter = $this->addUserIDFilter($filter, $id);
		}
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = $this->UserIDAllowSecurity;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			case "lookup":
				return (($allow & 256) == 256);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get recordset
	public function getRecordset($sql, $rowcnt = -1, $offset = -1)
	{
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->selectLimit($sql, $rowcnt, $offset);
		$conn->raiseErrorFn = "";
		return $rs;
	}

	// Get record count
	public function getRecordCount($sql, $c = NULL)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) &&
			!preg_match('/^\s*select\s+distinct\s+/i', $sql) && !preg_match('/\s+order\s+by\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = $c ?: $this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->getRecordCount($sql);
		$this->CurrentFilter = $origFilter;
		return $cnt;
	}

	// Get record count (for current List page)
	public function listRecordCount()
	{
		$filter = $this->getSessionWhere();
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " (" . $names . ") VALUES (" . $values . ")";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {

			// Get insert id if necessary
			$this->idendereco->setDbValue($conn->insert_ID());
			$rs['idendereco'] = $this->idendereco->DbValue;
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsAutoIncrement)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('idendereco', $rs))
				AddFilter($where, QuotedName('idendereco', $this->Dbid) . '=' . QuotedValue($rs['idendereco'], $this->idendereco->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = $this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idendereco->DbValue = $row['idendereco'];
		$this->idacademia->DbValue = $row['idacademia'];
		$this->idpessoa->DbValue = $row['idpessoa'];
		$this->CEP->DbValue = $row['CEP'];
		$this->UF->DbValue = $row['UF'];
		$this->Cidade->DbValue = $row['Cidade'];
		$this->Bairro->DbValue = $row['Bairro'];
		$this->Rua->DbValue = $row['Rua'];
		$this->Numero->DbValue = $row['Numero'];
		$this->Complemento->DbValue = $row['Complemento'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idendereco` = @idendereco@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idendereco', $row) ? $row['idendereco'] : NULL;
		else
			$val = $this->idendereco->OldValue !== NULL ? $this->idendereco->OldValue : $this->idendereco->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idendereco@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") != "" && ReferPageName() != CurrentPageName() && ReferPageName() != "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] != "") {
			return $_SESSION[$name];
		} else {
			return "enderecolist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "enderecoview.php")
			return $Language->phrase("View");
		elseif ($pageName == "enderecoedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "enderecoadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "enderecolist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("enderecoview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("enderecoview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "enderecoadd.php?" . $this->getUrlParm($parm);
		else
			$url = "enderecoadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("enderecoedit.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("enderecoadd.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("enderecodelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "academia" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idacademia=" . urlencode($this->idacademia->CurrentValue);
		}
		if ($this->getCurrentMasterTable() == "pessoa" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idpessoa=" . urlencode($this->idpessoa->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idendereco:" . JsonEncode($this->idendereco->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm != "")
			$url .= $parm . "&";
		if ($this->idendereco->CurrentValue != NULL) {
			$url .= "idendereco=" . urlencode($this->idendereco->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, [128, 204, 205])) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		$arKeys = [];
		$arKey = [];
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("idendereco") !== NULL)
				$arKeys[] = Param("idendereco");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = [];
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys($setCurrent = TRUE)
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter != "") $keyFilter .= " OR ";
			if ($setCurrent)
				$this->idendereco->CurrentValue = $key;
			else
				$this->idendereco->OldValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = $this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->idendereco->setDbValue($rs->fields('idendereco'));
		$this->idacademia->setDbValue($rs->fields('idacademia'));
		$this->idpessoa->setDbValue($rs->fields('idpessoa'));
		$this->CEP->setDbValue($rs->fields('CEP'));
		$this->UF->setDbValue($rs->fields('UF'));
		$this->Cidade->setDbValue($rs->fields('Cidade'));
		$this->Bairro->setDbValue($rs->fields('Bairro'));
		$this->Rua->setDbValue($rs->fields('Rua'));
		$this->Numero->setDbValue($rs->fields('Numero'));
		$this->Complemento->setDbValue($rs->fields('Complemento'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// idendereco
		// idacademia
		// idpessoa
		// CEP
		// UF
		// Cidade
		// Bairro
		// Rua
		// Numero
		// Complemento
		// idendereco

		$this->idendereco->ViewValue = $this->idendereco->CurrentValue;
		$this->idendereco->ViewCustomAttributes = "";

		// idacademia
		$curVal = strval($this->idacademia->CurrentValue);
		if ($curVal != "") {
			$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
			if ($this->idacademia->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->idacademia->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$this->idacademia->ViewValue = $this->idacademia->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idacademia->ViewValue = $this->idacademia->CurrentValue;
				}
			}
		} else {
			$this->idacademia->ViewValue = NULL;
		}
		$this->idacademia->ViewCustomAttributes = "";

		// idpessoa
		$curVal = strval($this->idpessoa->CurrentValue);
		if ($curVal != "") {
			$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
			if ($this->idpessoa->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$this->idpessoa->ViewValue = $this->idpessoa->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
				}
			}
		} else {
			$this->idpessoa->ViewValue = NULL;
		}
		$this->idpessoa->ViewCustomAttributes = "";

		// CEP
		$this->CEP->ViewValue = $this->CEP->CurrentValue;
		$this->CEP->ViewCustomAttributes = "";

		// UF
		$this->UF->ViewValue = $this->UF->CurrentValue;
		$this->UF->ViewCustomAttributes = "";

		// Cidade
		$this->Cidade->ViewValue = $this->Cidade->CurrentValue;
		$this->Cidade->ViewCustomAttributes = "";

		// Bairro
		$this->Bairro->ViewValue = $this->Bairro->CurrentValue;
		$this->Bairro->ViewCustomAttributes = "";

		// Rua
		$this->Rua->ViewValue = $this->Rua->CurrentValue;
		$this->Rua->ViewCustomAttributes = "";

		// Numero
		$this->Numero->ViewValue = $this->Numero->CurrentValue;
		$this->Numero->ViewCustomAttributes = "";

		// Complemento
		$this->Complemento->ViewValue = $this->Complemento->CurrentValue;
		$this->Complemento->ViewCustomAttributes = "";

		// idendereco
		$this->idendereco->LinkCustomAttributes = "";
		$this->idendereco->HrefValue = "";
		$this->idendereco->TooltipValue = "";

		// idacademia
		$this->idacademia->LinkCustomAttributes = "";
		$this->idacademia->HrefValue = "";
		$this->idacademia->TooltipValue = "";

		// idpessoa
		$this->idpessoa->LinkCustomAttributes = "";
		$this->idpessoa->HrefValue = "";
		$this->idpessoa->TooltipValue = "";

		// CEP
		$this->CEP->LinkCustomAttributes = "";
		$this->CEP->HrefValue = "";
		$this->CEP->TooltipValue = "";

		// UF
		$this->UF->LinkCustomAttributes = "";
		$this->UF->HrefValue = "";
		$this->UF->TooltipValue = "";

		// Cidade
		$this->Cidade->LinkCustomAttributes = "";
		$this->Cidade->HrefValue = "";
		$this->Cidade->TooltipValue = "";

		// Bairro
		$this->Bairro->LinkCustomAttributes = "";
		$this->Bairro->HrefValue = "";
		$this->Bairro->TooltipValue = "";

		// Rua
		$this->Rua->LinkCustomAttributes = "";
		$this->Rua->HrefValue = "";
		$this->Rua->TooltipValue = "";

		// Numero
		$this->Numero->LinkCustomAttributes = "";
		$this->Numero->HrefValue = "";
		$this->Numero->TooltipValue = "";

		// Complemento
		$this->Complemento->LinkCustomAttributes = "";
		$this->Complemento->HrefValue = "";
		$this->Complemento->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idendereco
		$this->idendereco->EditAttrs["class"] = "form-control";
		$this->idendereco->EditCustomAttributes = "";
		$this->idendereco->EditValue = $this->idendereco->CurrentValue;
		$this->idendereco->ViewCustomAttributes = "";

		// idacademia
		$this->idacademia->EditAttrs["class"] = "form-control";
		$this->idacademia->EditCustomAttributes = "";
		if ($this->idacademia->getSessionValue() != "") {
			$this->idacademia->CurrentValue = $this->idacademia->getSessionValue();
			$curVal = strval($this->idacademia->CurrentValue);
			if ($curVal != "") {
				$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
				if ($this->idacademia->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idacademia->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idacademia->ViewValue = $this->idacademia->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idacademia->ViewValue = $this->idacademia->CurrentValue;
					}
				}
			} else {
				$this->idacademia->ViewValue = NULL;
			}
			$this->idacademia->ViewCustomAttributes = "";
		} else {
		}

		// idpessoa
		$this->idpessoa->EditAttrs["class"] = "form-control";
		$this->idpessoa->EditCustomAttributes = "";
		if ($this->idpessoa->getSessionValue() != "") {
			$this->idpessoa->CurrentValue = $this->idpessoa->getSessionValue();
			$curVal = strval($this->idpessoa->CurrentValue);
			if ($curVal != "") {
				$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
				if ($this->idpessoa->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idpessoa->ViewValue = $this->idpessoa->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
					}
				}
			} else {
				$this->idpessoa->ViewValue = NULL;
			}
			$this->idpessoa->ViewCustomAttributes = "";
		} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
			$this->idpessoa->CurrentValue = CurrentUserID();
			$curVal = strval($this->idpessoa->CurrentValue);
			if ($curVal != "") {
				$this->idpessoa->EditValue = $this->idpessoa->lookupCacheOption($curVal);
				if ($this->idpessoa->EditValue === NULL) { // Lookup from database
					$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idpessoa->EditValue = $this->idpessoa->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idpessoa->EditValue = $this->idpessoa->CurrentValue;
					}
				}
			} else {
				$this->idpessoa->EditValue = NULL;
			}
			$this->idpessoa->ViewCustomAttributes = "";
		} else {
		}

		// CEP
		$this->CEP->EditAttrs["class"] = "form-control";
		$this->CEP->EditCustomAttributes = "";
		if (!$this->CEP->Raw)
			$this->CEP->CurrentValue = HtmlDecode($this->CEP->CurrentValue);
		$this->CEP->EditValue = $this->CEP->CurrentValue;
		$this->CEP->PlaceHolder = RemoveHtml($this->CEP->caption());

		// UF
		$this->UF->EditAttrs["class"] = "form-control";
		$this->UF->EditCustomAttributes = "";
		if (!$this->UF->Raw)
			$this->UF->CurrentValue = HtmlDecode($this->UF->CurrentValue);
		$this->UF->EditValue = $this->UF->CurrentValue;
		$this->UF->PlaceHolder = RemoveHtml($this->UF->caption());

		// Cidade
		$this->Cidade->EditAttrs["class"] = "form-control";
		$this->Cidade->EditCustomAttributes = "";
		if (!$this->Cidade->Raw)
			$this->Cidade->CurrentValue = HtmlDecode($this->Cidade->CurrentValue);
		$this->Cidade->EditValue = $this->Cidade->CurrentValue;
		$this->Cidade->PlaceHolder = RemoveHtml($this->Cidade->caption());

		// Bairro
		$this->Bairro->EditAttrs["class"] = "form-control";
		$this->Bairro->EditCustomAttributes = "";
		if (!$this->Bairro->Raw)
			$this->Bairro->CurrentValue = HtmlDecode($this->Bairro->CurrentValue);
		$this->Bairro->EditValue = $this->Bairro->CurrentValue;
		$this->Bairro->PlaceHolder = RemoveHtml($this->Bairro->caption());

		// Rua
		$this->Rua->EditAttrs["class"] = "form-control";
		$this->Rua->EditCustomAttributes = "";
		if (!$this->Rua->Raw)
			$this->Rua->CurrentValue = HtmlDecode($this->Rua->CurrentValue);
		$this->Rua->EditValue = $this->Rua->CurrentValue;
		$this->Rua->PlaceHolder = RemoveHtml($this->Rua->caption());

		// Numero
		$this->Numero->EditAttrs["class"] = "form-control";
		$this->Numero->EditCustomAttributes = "";
		if (!$this->Numero->Raw)
			$this->Numero->CurrentValue = HtmlDecode($this->Numero->CurrentValue);
		$this->Numero->EditValue = $this->Numero->CurrentValue;
		$this->Numero->PlaceHolder = RemoveHtml($this->Numero->caption());

		// Complemento
		$this->Complemento->EditAttrs["class"] = "form-control";
		$this->Complemento->EditCustomAttributes = "";
		if (!$this->Complemento->Raw)
			$this->Complemento->CurrentValue = HtmlDecode($this->Complemento->CurrentValue);
		$this->Complemento->EditValue = $this->Complemento->CurrentValue;
		$this->Complemento->PlaceHolder = RemoveHtml($this->Complemento->caption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					$doc->exportCaption($this->idendereco);
					$doc->exportCaption($this->idacademia);
					$doc->exportCaption($this->idpessoa);
					$doc->exportCaption($this->CEP);
					$doc->exportCaption($this->UF);
					$doc->exportCaption($this->Cidade);
					$doc->exportCaption($this->Bairro);
					$doc->exportCaption($this->Rua);
					$doc->exportCaption($this->Numero);
					$doc->exportCaption($this->Complemento);
				} else {
					$doc->exportCaption($this->idendereco);
					$doc->exportCaption($this->idacademia);
					$doc->exportCaption($this->idpessoa);
					$doc->exportCaption($this->CEP);
					$doc->exportCaption($this->UF);
					$doc->exportCaption($this->Cidade);
					$doc->exportCaption($this->Bairro);
					$doc->exportCaption($this->Rua);
					$doc->exportCaption($this->Numero);
					$doc->exportCaption($this->Complemento);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						$doc->exportField($this->idendereco);
						$doc->exportField($this->idacademia);
						$doc->exportField($this->idpessoa);
						$doc->exportField($this->CEP);
						$doc->exportField($this->UF);
						$doc->exportField($this->Cidade);
						$doc->exportField($this->Bairro);
						$doc->exportField($this->Rua);
						$doc->exportField($this->Numero);
						$doc->exportField($this->Complemento);
					} else {
						$doc->exportField($this->idendereco);
						$doc->exportField($this->idacademia);
						$doc->exportField($this->idpessoa);
						$doc->exportField($this->CEP);
						$doc->exportField($this->UF);
						$doc->exportField($this->Cidade);
						$doc->exportField($this->Bairro);
						$doc->exportField($this->Rua);
						$doc->exportField($this->Numero);
						$doc->exportField($this->Complemento);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// Add User ID filter
	public function addUserIDFilter($filter = "", $id = "")
	{
		global $Security;
		$filterWrk = "";
		if ($id == "")
			$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
			$filterWrk = $Security->userIdList();
			if ($filterWrk != "")
				$filterWrk = '`idpessoa` IN (' . $filterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($filterWrk);
		AddFilter($filter, $filterWrk);
		return $filter;
	}

	// User ID subquery
	public function getUserIDSubquery(&$fld, &$masterfld)
	{
		global $UserTable;
		$wrk = "";
		$sql = "SELECT " . $masterfld->Expression . " FROM `endereco`";
		$filter = $this->addUserIDFilter("");
		if ($filter != "")
			$sql .= " WHERE " . $filter;

		// Use subquery
		if (Config("USE_SUBQUERY_FOR_MASTER_USER_ID")) {
			$wrk = $sql;
		} else {

			// List all values
			if ($rs = Conn($UserTable->Dbid)->execute($sql)) {
				while (!$rs->EOF) {
					if ($wrk != "")
						$wrk .= ",";
					$wrk .= QuotedValue($rs->fields[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
					$rs->moveNext();
				}
				$rs->close();
			}
		}
		if ($wrk != "")
			$wrk = $fld->Expression . " IN (" . $wrk . ")";
		else
			$wrk = "0=1"; // No User ID value found
		return $wrk;
	}

	// Add master User ID filter
	public function addMasterUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "pessoa") {
			$filterWrk = $GLOBALS["pessoa"]->addUserIDFilter($filterWrk);
		}
		return $filterWrk;
	}

	// Add detail User ID filter
	public function addDetailUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "pessoa") {
			$mastertable = $GLOBALS["pessoa"];
			if (!$mastertable->userIDAllow()) {
				$subqueryWrk = $mastertable->getUserIDSubquery($this->idpessoa, $mastertable->idpessoa);
				AddFilter($filterWrk, $subqueryWrk);
			}
		}
		return $filterWrk;
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>