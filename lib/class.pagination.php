<?
 /*
 * hhdchamara@gmail.com
 * 2011-01-13
 */
class Pagination{
	private $paging_limit;
	private $no_of_records;
	private $no_of_display_page_links;
	private $no_of_pages;
	private $display_links_start_from;
	
	private $sql_total_records;
	private $page_id;
	private $result;
	private $db;
	
	private $next_image;
	private $prv_image;
	private $navigation_page;
	private $page_id_parameter;
	
	public function Pagination($current_page_id){
		$this->db=new mySQL();
		$this->paging_limit  = 0;
		$this->no_of_records = 0;	
		$this->no_of_display_page_links = 3;	
		$this->no_of_pages   = 0;
		$this->page_id       = $current_page_id; 
		$this->page_id_parameter='page_id';
	}
	
	public function __set($attribute, $value){
		$this->$attribute=$value;
	}
	
	public function __get($attribute){
		return $this->$attribute;
	}
	
	public function display_paging(){
		if($this->sql_total_records!=''){
			$this->db->execute($this->sql_total_records,$this->result);
			if(mysql_num_rows($this->result)>0){
				$this->no_of_records = mysql_result($this->result,0,'total_records'); 
				$this->no_of_pages = ceil($this->no_of_records/$this->paging_limit);  
				if($this->paging_limit==1){
					$this->no_of_pages+=1;	
				}
			}  
		}else{
			die('Pagination total records SQL missing');	
		}
		?>
        	<table align="center">
        	<tr>
            	<td>
                	<b>Page:&nbsp;</b>
                </td>
            	<td><?
					if($this->no_of_pages > $this->no_of_display_page_links){//die($this->no_of_pages.'xx');
				?>
                	<? if($this->page_id>1){?>
                	<a href="<?=$this->navigation_page?>?<?=$this->page_id_parameter?>=<?=($this->page_id-1)?>">
                    	<img src="<?=$this->prv_image['src']?>" width="<?=$this->prv_image['width']?>" height="<?=$this->prv_image['height']?>" border="0" />
                    </a>
                    <? }else{
						?>&nbsp;<?
					 }?>
                    <? }else{?>
						&nbsp;
				    <? } ?>
                </td> 
                	<? 
					if($this->no_of_pages > $this->no_of_display_page_links){ 
						
						if($this->no_of_pages>($this->page_id+$this->no_of_display_page_links)){
							$this->display_links_start_from=$this->page_id;
						}else{
							$this->display_links_start_from=($this->no_of_pages-$this->no_of_display_page_links);
						}
						
						for($x=$this->display_links_start_from; $x<($this->no_of_display_page_links + $this->page_id);$x++){
							if($x<$this->no_of_pages){
								?><td><a href="<?=$this->navigation_page?>?<?=$this->page_id_parameter?>=<?=$x?>">
								<? if($this->page_id==$x){?>
									<strong><?=$x?></strong>
                                <? }else{?>
									<?=$x?>
									<? }
								?>
                                </a></td><?
							}else{
								?>&nbsp;<?
							}
						}
					 ?> 
                    <? }elseif($this->no_of_pages >1){ 
						for($x=1;$x<=$this->no_of_pages;$x++){
							?><td>
                            	<a href="<?=$this->navigation_page?>?<?=$this->page_id_parameter?>=<?=$x?>">
							<? if($this->page_id==$x){?>
                                <strong><?=$x?></strong>
                            <? }else{?>
                                <?=$x?>
                                <? }
                            ?>
                           	  </a>
                            </td><?	
						}
					   }else{?>
                    	 <td>&nbsp;</td>
                    <? } ?>
                <td><?
					if($this->no_of_pages>($this->page_id+$this->no_of_display_page_links)){?>
                        <a href="<?=$this->navigation_page?>?<?=$this->page_id_parameter?>=<?=($this->page_id+1)?>">
                            <img src="<?=$this->next_image['src']?>" width="<?=$this->next_image['width']?>" height="<?=$this->next_image['height']?>" border="0" />
                        </a>
                    <? }else{?>
                    	&nbsp;
                    <? }?>
                </td>
            </tr>
        </table>
        <?
	}
}
?>