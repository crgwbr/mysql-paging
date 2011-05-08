#mysql-paging usage

Sample Code:

    // Include Library
    include('paging.php');

	// Page number should be 1 indexed, not 0 indexed.
	$page_num = 1;

	// Set up Paginator
	$paginator = new Paginator();
	$paginator->table_name = 'posts';
	$paginator->rows_per_page = 5;
	
	// Get Page from table
	$page = $paginator->get_page($page_num);
	
    // Do something with the page
	while ($row = mysql_fetch_assoc($page)) {
	    // Do stuff
	}