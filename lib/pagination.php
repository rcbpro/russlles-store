<?php

class Pagination{

	var $pagination = "";
    var $counter = 0;

	function generate_pagination($total_records, $path, $recordsLimit){

        $counter____ = 0;
		$condition = "";
		$tmp_condition = "";		
		$adjacents = "2";
        $last = "";

		if ($_GET['page'] == 0){ $page = 1; } else { $page = $_GET['page']; }
		
		if ((isset($_GET['notes_page'])) && (isset($_GET['page']))){
			$page = $_GET['notes_page'];
		}elseif ((isset($_GET['history_page'])) && (isset($_GET['page']))){
			$page = $_GET['history_page'];
		}elseif ((isset($_GET['notes_page'])) && (!isset($_GET['page']))){
			$page = $_GET['notes_page'];
		}elseif ((isset($_GET['history_page'])) && (!isset($_GET['page']))){
			$page = $_GET['history_page'];			
		}elseif ((!isset($_GET['notes_page'])) && (isset($_GET['page']))){
			$page = $_GET['page'];			
		}elseif ((!isset($_GET['history_page'])) && (isset($_GET['page']))){
			$page = $_GET['page'];			
		}else{
			$page = 0;						
		}

		if ($page == 0){
			$page = 1;
		}else{
			if (isset($_GET['notes_page'])) $page = $_GET['notes_page'];
			elseif (isset($_GET['history_page'])) $page = $_GET['history_page'];			
			else $page = $_GET['page'];								
		}

		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($total_records/$recordsLimit);
		$lpm1 = $lastpage - 1;
		$this->pagination = "";

		if($lastpage > 1){	
		
			$this->pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1){ 
				if (isset($_GET['notes_page'])){
					$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$prev, $path)."\">&laquo; previous</a>";										
				}elseif (isset($_GET['history_page'])){
					$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$prev, $path)."\">&laquo; previous</a>";										
				}else{
					if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
						$this->pagination.=  "<a href=\"".str_replace("page=".$_GET['page'], "page=".$prev, $path)."\">&laquo; previous</a>";						
					}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
						$this->pagination.=  "<a href=\"".str_replace("page=".$_GET['page'], "page=".$prev, $path)."\">&laquo; previous</a>";						
					}else{
						$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$prev."\">&laquo; previous</a>";											
					}	
				}
			}else{
				$this->pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
			}	
			
			//not enough pages to bother breaking it up
			if ($lastpage < 7 + ($adjacents * 2)){	
				for ($counter = 1; $counter <= $lastpage; $counter++){
					if ($counter == $page){
						$this->pagination.= "<span class=\"current\">$counter</span>";
					}else{					
						if (isset($_GET['notes_page'])){
							$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$counter, $path)."\">$counter</a>";										
						}elseif (isset($_GET['history_page'])){
							$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$counter, $path)."\">$counter</a>";										
						}else{	
							if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){											
								$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
							}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){											
								$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
							}else{
								$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
							}
						}	
					}						
				}
			}
			//enough pages to hide some			
			elseif($lastpage > 5 + ($adjacents * 2)){
			
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2)){
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
						if ($counter == $page){
							$this->pagination.= "<span class=\"current\">$counter</span>";
						}else{
							if (isset($_GET['notes_page'])){
								$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$counter, $path)."\">$counter</a>";										
							}elseif (isset($_GET['history_page'])){
								$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$counter, $path)."\">$counter</a>";										
							}else{	
								if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}else{
									$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
								}
							}	
						}	
					}
					$this->pagination.= "...";
					if (isset($_GET['notes_page'])){
						$this->pagination.= "<a href=\"".str_replace("&notes_page=".$_GET['notes_page'], "&notes_page=".$lpm1, $path)."\">$lpm1</a>";
						$this->pagination.= "<a href=\"".str_replace("&notes_page=".$_GET['notes_page'], "&notes_page=".$lastpage, $path)."\">$lastpage</a>";		
					}elseif (isset($_GET['history_page'])){
						$this->pagination.= "<a href=\"".str_replace("&history_page=".$_GET['history_page'], "&history_page=".$lpm1, $path)."\">$lpm1</a>";
						$this->pagination.= "<a href=\"".str_replace("&history_page=".$_GET['history_page'], "&history_page=".$lastpage, $path)."\">$lastpage</a>";		
					}else{	
						if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lpm1, $path)."\">$lpm1</a>";
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lastpage, $path)."\">$lastpage</a>";		
						}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lpm1, $path)."\">$lpm1</a>";
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lastpage, $path)."\">$lastpage</a>";		
						}else{
							$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$lastpage."\">$lastpage</a>";							
						}
					}	
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
				
					if (isset($_GET['notes_page'])){
						$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=1", $path)."\">1</a>";		
						$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=2", $path)."\">2</a>";														
					}elseif (isset($_GET['history_page'])){
						$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=1", $path)."\">1</a>";		
						$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=2", $path)."\">2</a>";														
					}else{	
						if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){	
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=1", $path)."\">1</a>";		
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=2", $path)."\">2</a>";
						}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){	
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=1", $path)."\">1</a>";		
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=2", $path)."\">2</a>";														
						}else{
							$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
						}
					}	
						
					$this->pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
						if ($counter == $page){
							$this->pagination.= "<span class=\"current\">$counter</span>";
						}else{

							if (isset($_GET['notes_page'])){
								$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$counter, $path)."\">$counter</a>";										
							}elseif (isset($_GET['history_page'])){
								$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$counter, $path)."\">$counter</a>";										
							}else{	
								if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}else{
									$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
								}
							}	

						}	
					}
					$this->pagination.= "...";
					
					if (isset($_GET['notes_page'])){
						$this->pagination.= "<a href=\"".str_replace("&notes_page=".$_GET['notes_page'], "&notes_page=".$lpm1, $path)."\">$lpm1</a>";
						$this->pagination.= "<a href=\"".str_replace("&notes_page=".$_GET['notes_page'], "&notes_page=".$lastpage, $path)."\">$lastpage</a>";	
					}elseif (isset($_GET['history_page'])){
						$this->pagination.= "<a href=\"".str_replace("&history_page=".$_GET['history_page'], "&history_page=".$lpm1, $path)."\">$lpm1</a>";
						$this->pagination.= "<a href=\"".str_replace("&history_page=".$_GET['history_page'], "&history_page=".$lastpage, $path)."\">$lastpage</a>";		
					}else{	
						if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lpm1, $path)."\">$lpm1</a>";
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lastpage, $path)."\">$lastpage</a>";		
						}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lpm1, $path)."\">$lpm1</a>";
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$lastpage, $path)."\">$lastpage</a>";		
						}else{
							$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$lastpage."\">$lastpage</a>";							
						}
					}	
					
				//close to end; only hide early pages					
				}else{
				
					if (isset($_GET['notes_page'])){
						$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=1", $path)."\">1</a>";		
						$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=2", $path)."\">2</a>";														
					}elseif (isset($_GET['history_page'])){
						$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=1", $path)."\">1</a>";		
						$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=2", $path)."\">2</a>";														
					}else{	
						if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){	
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=1", $path)."\">1</a>";		
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=2", $path)."\">2</a>";														
						}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){	
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=1", $path)."\">1</a>";		
							$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=2", $path)."\">2</a>";														
						}else{
							$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
						}
					}	
					
					$this->pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
						if ($counter == $page){
							$this->pagination.= "<span class=\"current\">$counter</span>";
						}else{
							if (isset($_GET['notes_page'])){
								$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$counter, $path)."\">$counter</a>";										
							}elseif (isset($_GET['history_page'])){
								$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$counter, $path)."\">$counter</a>";										
							}else{	
								if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
									$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$counter, $path)."\">$counter</a>";													
								}else{
									$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$counter."\">$counter</a>";							
								}
							}	
						}	
					}
				}
			}
			//next button
			if ($page < $counter - 1){
				if (isset($_GET['page'])){ 
					$this->pagination.= "<a href=\"".str_replace("page=".$_GET['page'], "page=".$next, $path)."\">next &raquo;</a>";
				}else{
					if (isset($_GET['notes_page'])){
						$this->pagination.= "<a href=\"".str_replace("notes_page=".$_GET['notes_page'], "notes_page=".$next, $path)."\">next &raquo;</a>";										
					}elseif (isset($_GET['history_page'])){
						$this->pagination.= "<a href=\"".str_replace("history_page=".$_GET['history_page'], "history_page=".$next, $path)."\">next &raquo;</a>";										
					}else{
						if ((isset($_GET['page'])) && (!isset($_GET['notes_page']))){			
							$this->pagination.=  "<a href=\"".str_replace("page=".$_GET['page'], "page=".$next, $path)."\">next &raquo;</a>";						
						}elseif ((isset($_GET['page'])) && (!isset($_GET['history_page']))){			
							$this->pagination.=  "<a href=\"".str_replace("page=".$_GET['page'], "page=".$next, $path)."\">next &raquo;</a>";						
						}else{
							$this->pagination.= "<a href=\"".$path.((empty($_SERVER['QUERY_STRING'])) ? "?page=" : "&page=").$next."\">next &raquo;</a>";											
						}	
					}
				}	
			}else{
				$this->pagination.= "<span class=\"disabled\">next &raquo;</span>";
			}	
			$this->pagination.= "</div>\n";		
			
			return $this->pagination;
		}
	}	
}
?>