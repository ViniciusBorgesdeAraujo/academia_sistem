<?php namespace PHPMaker2020\sistema; ?>
<?php

/**
 * Table class for aulas
 */
class aulas extends DbTable
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
	public $idaulas;
	public $idturnos;
	public $idaluno;
	public $nome;
	public $ativado;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'aulas';
		$this->TableName = 'aulas';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`aulas`";
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
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// idaulas
		$this->idaulas = new DbField('aulas', 'aulas', 'x_idaulas', 'idaulas', '`idaulas`', '`idaulas`', 3, 11, -1, FALSE, '`idaulas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idaulas->IsAutoIncrement = TRUE; // Autoincrement field
		$this->idaulas->IsPrimaryKey = TRUE; // Primary key field
		$this->idaulas->IsForeignKey = TRUE; // Foreign key field
		$this->idaulas->Sortable = TRUE; // Allow sort
		$this->idaulas->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idaulas'] = &$this->idaulas;

		// idturnos
		$this->idturnos = new DbField('aulas', 'aulas', 'x_idturnos', 'idturnos', '`idturnos`', '`idturnos`', 3, 11, -1, FALSE, '`idturnos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idturnos->IsForeignKey = TRUE; // Foreign key field
		$this->idturnos->Sortable = TRUE; // Allow sort
		$this->idturnos->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idturnos->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->idturnos->Lookup = new Lookup('idturnos', 'turnos', FALSE, 'idturnos', ["turmas","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idturnos->Lookup = new Lookup('idturnos', 'turnos', FALSE, 'idturnos', ["turmas","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idturnos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idturnos'] = &$this->idturnos;

		// idaluno
		$this->idaluno = new DbField('aulas', 'aulas', 'x_idaluno', 'idaluno', '`idaluno`', '`idaluno`', 3, 11, -1, FALSE, '`idaluno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idaluno->Sortable = TRUE; // Allow sort
		$this->idaluno->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idaluno->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->idaluno->Lookup = new Lookup('idaluno', 'pessoa', FALSE, 'idpessoa', ["Nome","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idaluno->Lookup = new Lookup('idaluno', 'pessoa', FALSE, 'idpessoa', ["Nome","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idaluno->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idaluno'] = &$this->idaluno;

		// nome
		$this->nome = new DbField('aulas', 'aulas', 'x_nome', 'nome', '`nome`', '`nome`', 200, 25, -1, FALSE, '`nome`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nome->Sortable = TRUE; // Allow sort
		$this->nome->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nome->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->nome->Lookup = new Lookup('nome', 'academia', FALSE, 'idacademia', ["nome","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->nome->Lookup = new Lookup('nome', 'academia', FALSE, 'idacademia', ["nome","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['nome'] = &$this->nome;

		// ativado
		$this->ativado = new DbField('aulas', 'aulas', 'x_ativado', 'ativado', '`ativado`', '`ativado`', 3, 11, -1, FALSE, '`ativado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->ativado->Nullable = FALSE; // NOT NULL field
		$this->ativado->Required = TRUE; // Required field
		$this->ativado->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->ativado->Lookup = new Lookup('ativado', 'aulas', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->ativado->Lookup = new Lookup('ativado', 'aulas', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->ativado->OptionCount = 2;
		$this->ativado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['ativado'] = &$this->ativado;
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
		if ($this->getCurrentMasterTable() == "turnos") {
			if ($this->idturnos->getSessionValue() != "")
				$masterFilter .= "`idturnos`=" . QuotedValue($this->idturnos->getSessionValue(), DATATYPE_NUMBER, "DB");
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
		if ($this->getCurrentMasterTable() == "turnos") {
			if ($this->idturnos->getSessionValue() != "")
				$detailFilter .= "`idturnos`=" . QuotedValue($this->idturnos->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_turnos()
	{
		return "`idturnos`=@idturnos@";
	}

	// Detail filter
	public function sqlDetailFilter_turnos()
	{
		return "`idturnos`=@idturnos@";
	}

	// Current detail table name
	public function getCurrentDetailTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")];
	}
	public function setCurrentDetailTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
	}

	// Get detail url
	public function getDetailUrl()
	{

		// Detail url
		$detailUrl = "";
		if ($this->getCurrentDetailTable() == "pessoa") {
			$detailUrl = $GLOBALS["pessoa"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_idaulas=" . urlencode($this->idaulas->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "videos") {
			$detailUrl = $GLOBALS["videos"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_idaulas=" . urlencode($this->idaulas->CurrentValue);
		}
		if ($detailUrl == "")
			$detailUrl = "aulaslist.php";
		return $detailUrl;
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`aulas`";
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
		$this->TableFilter = "`ativado`=1";
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
			$this->idaulas->setDbValue($conn->insert_ID());
			$rs['idaulas'] = $this->idaulas->DbValue;
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
			if (array_key_exists('idaulas', $rs))
				AddFilter($where, QuotedName('idaulas', $this->Dbid) . '=' . QuotedValue($rs['idaulas'], $this->idaulas->DataType, $this->Dbid));
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
		$this->idaulas->DbValue = $row['idaulas'];
		$this->idturnos->DbValue = $row['idturnos'];
		$this->idaluno->DbValue = $row['idaluno'];
		$this->nome->DbValue = $row['nome'];
		$this->ativado->DbValue = $row['ativado'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idaulas` = @idaulas@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idaulas', $row) ? $row['idaulas'] : NULL;
		else
			$val = $this->idaulas->OldValue !== NULL ? $this->idaulas->OldValue : $this->idaulas->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idaulas@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "aulaslist.php";
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
		if ($pageName == "aulasview.php")
			return $Language->phrase("View");
		elseif ($pageName == "aulasedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "aulasadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "aulaslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("aulasview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("aulasview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "aulasadd.php?" . $this->getUrlParm($parm);
		else
			$url = "aulasadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("aulasedit.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("aulasedit.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
		if ($parm != "")
			$url = $this->keyUrl("aulasadd.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("aulasadd.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
		return $this->keyUrl("aulasdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "turnos" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idturnos=" . urlencode($this->idturnos->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idaulas:" . JsonEncode($this->idaulas->CurrentValue, "number");
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
		if ($this->idaulas->CurrentValue != NULL) {
			$url .= "idaulas=" . urlencode($this->idaulas->CurrentValue);
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
			if (Param("idaulas") !== NULL)
				$arKeys[] = Param("idaulas");
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
				$this->idaulas->CurrentValue = $key;
			else
				$this->idaulas->OldValue = $key;
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
		$this->idaulas->setDbValue($rs->fields('idaulas'));
		$this->idturnos->setDbValue($rs->fields('idturnos'));
		$this->idaluno->setDbValue($rs->fields('idaluno'));
		$this->nome->setDbValue($rs->fields('nome'));
		$this->ativado->setDbValue($rs->fields('ativado'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// idaulas
		// idturnos
		// idaluno
		// nome
		// ativado
		// idaulas

		$this->idaulas->ViewValue = $this->idaulas->CurrentValue;
		$this->idaulas->ViewCustomAttributes = "";

		// idturnos
		$curVal = strval($this->idturnos->CurrentValue);
		if ($curVal != "") {
			$this->idturnos->ViewValue = $this->idturnos->lookupCacheOption($curVal);
			if ($this->idturnos->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idturnos`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->idturnos->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$this->idturnos->ViewValue = $this->idturnos->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idturnos->ViewValue = $this->idturnos->CurrentValue;
				}
			}
		} else {
			$this->idturnos->ViewValue = NULL;
		}
		$this->idturnos->ViewCustomAttributes = "";

		// idaluno
		$curVal = strval($this->idaluno->CurrentValue);
		if ($curVal != "") {
			$this->idaluno->ViewValue = $this->idaluno->lookupCacheOption($curVal);
			if ($this->idaluno->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->idaluno->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$this->idaluno->ViewValue = $this->idaluno->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idaluno->ViewValue = $this->idaluno->CurrentValue;
				}
			}
		} else {
			$this->idaluno->ViewValue = NULL;
		}
		$this->idaluno->ViewCustomAttributes = "";

		// nome
		$curVal = strval($this->nome->CurrentValue);
		if ($curVal != "") {
			$this->nome->ViewValue = $this->nome->lookupCacheOption($curVal);
			if ($this->nome->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
				$sqlWrk = $this->nome->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$this->nome->ViewValue = $this->nome->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nome->ViewValue = $this->nome->CurrentValue;
				}
			}
		} else {
			$this->nome->ViewValue = NULL;
		}
		$this->nome->ViewCustomAttributes = "";

		// ativado
		if (strval($this->ativado->CurrentValue) != "") {
			$this->ativado->ViewValue = $this->ativado->optionCaption($this->ativado->CurrentValue);
		} else {
			$this->ativado->ViewValue = NULL;
		}
		$this->ativado->ViewCustomAttributes = "";

		// idaulas
		$this->idaulas->LinkCustomAttributes = "";
		$this->idaulas->HrefValue = "";
		$this->idaulas->TooltipValue = "";

		// idturnos
		$this->idturnos->LinkCustomAttributes = "";
		$this->idturnos->HrefValue = "";
		$this->idturnos->TooltipValue = "";

		// idaluno
		$this->idaluno->LinkCustomAttributes = "";
		$this->idaluno->HrefValue = "";
		$this->idaluno->TooltipValue = "";

		// nome
		$this->nome->LinkCustomAttributes = "";
		$this->nome->HrefValue = "";
		$this->nome->TooltipValue = "";

		// ativado
		$this->ativado->LinkCustomAttributes = "";
		$this->ativado->HrefValue = "";
		$this->ativado->TooltipValue = "";

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

		// idaulas
		$this->idaulas->EditAttrs["class"] = "form-control";
		$this->idaulas->EditCustomAttributes = "";
		$this->idaulas->EditValue = $this->idaulas->CurrentValue;
		$this->idaulas->ViewCustomAttributes = "";

		// idturnos
		$this->idturnos->EditAttrs["class"] = "form-control";
		$this->idturnos->EditCustomAttributes = "";
		if ($this->idturnos->getSessionValue() != "") {
			$this->idturnos->CurrentValue = $this->idturnos->getSessionValue();
			$curVal = strval($this->idturnos->CurrentValue);
			if ($curVal != "") {
				$this->idturnos->ViewValue = $this->idturnos->lookupCacheOption($curVal);
				if ($this->idturnos->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idturnos`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idturnos->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idturnos->ViewValue = $this->idturnos->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idturnos->ViewValue = $this->idturnos->CurrentValue;
					}
				}
			} else {
				$this->idturnos->ViewValue = NULL;
			}
			$this->idturnos->ViewCustomAttributes = "";
		} else {
		}

		// idaluno
		$this->idaluno->EditAttrs["class"] = "form-control";
		$this->idaluno->EditCustomAttributes = "";
		if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
			$this->idaluno->CurrentValue = CurrentUserID();
			$curVal = strval($this->idaluno->CurrentValue);
			if ($curVal != "") {
				$this->idaluno->EditValue = $this->idaluno->lookupCacheOption($curVal);
				if ($this->idaluno->EditValue === NULL) { // Lookup from database
					$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idaluno->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idaluno->EditValue = $this->idaluno->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaluno->EditValue = $this->idaluno->CurrentValue;
					}
				}
			} else {
				$this->idaluno->EditValue = NULL;
			}
			$this->idaluno->ViewCustomAttributes = "";
		} else {
		}

		// nome
		$this->nome->EditAttrs["class"] = "form-control";
		$this->nome->EditCustomAttributes = "";

		// ativado
		$this->ativado->EditCustomAttributes = "";
		$this->ativado->EditValue = $this->ativado->options(FALSE);

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
					$doc->exportCaption($this->idaulas);
					$doc->exportCaption($this->idturnos);
					$doc->exportCaption($this->idaluno);
					$doc->exportCaption($this->nome);
					$doc->exportCaption($this->ativado);
				} else {
					$doc->exportCaption($this->idaulas);
					$doc->exportCaption($this->idturnos);
					$doc->exportCaption($this->idaluno);
					$doc->exportCaption($this->nome);
					$doc->exportCaption($this->ativado);
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
						$doc->exportField($this->idaulas);
						$doc->exportField($this->idturnos);
						$doc->exportField($this->idaluno);
						$doc->exportField($this->nome);
						$doc->exportField($this->ativado);
					} else {
						$doc->exportField($this->idaulas);
						$doc->exportField($this->idturnos);
						$doc->exportField($this->idaluno);
						$doc->exportField($this->nome);
						$doc->exportField($this->ativado);
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
				$filterWrk = '`idaluno` IN (' . $filterWrk . ')';
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
		$sql = "SELECT " . $masterfld->Expression . " FROM `aulas`";
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