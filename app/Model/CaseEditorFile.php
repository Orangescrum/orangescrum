<?php
class CaseEditorFile extends AppModel{
	var $name = 'CaseEditorFile';
	public function removeFile($name=null, $comp_id)
	{	
		$retArr['status'] = 'success';
		$dataSource = $this->getDataSource();
		try{
			$dataSource->begin();	
			if($name){
				$existImages = $this->find('first', array('conditions' => array('CaseEditorFile.name' => $name, 'CaseEditorFile.company_id' => $comp_id, 'CaseEditorFile.is_deleted' => 2)));
				if(!empty($existImages)){
					$existImages['CaseEditorFile']['is_deleted'] = 1;					
					if($this->saveAll($existImages)){
						$Easycase = ClassRegistry::init('Easycase');						
						$ec = $Easycase->find('first', array('conditions' => array('Easycase.project_id' => $existImages['CaseEditorFile']['project_id'],'Easycase.message LIKE "%'.$name.'%"')));
						/*$f = fopen(WWW_ROOT.'fll.txt','a');
						fwrite($f, print_r($ec, true));
						fclose($f);*/
						if($ec){
							$orgi_contentxt = '';
							$dom = new DOMDocument();
							$dom->loadHTML($ec['Easycase']['message']);
							foreach ($dom->getElementsByTagName('img') as $k => $item) {
									$srcs = $item->getAttribute('src');
									if(stristr($srcs, $name)){
										$item->parentNode->removeChild($item);
										$orgi_content = $dom->saveHTML();
										$orgi_contentArr = explode('<body>', $orgi_content);
										$orgi_contentxt = str_replace("</body></html>","",$orgi_contentArr[1]);
									}
							}
							$ec['Easycase']['message'] = $orgi_contentxt;
							$t_mesg = trim(strip_tags(nl2br($ec['Easycase']['message'])));
							
							if(empty($t_mesg) && $ec['Easycase']['istype'] == 2){
								if(!$Easycase->delete($ec['Easycase']['id'])){
									throw new Exception(__('Failed to update task record.'));
								}
							}else{
								if(!$Easycase->save($ec)){
									throw new Exception(__('Failed to update task record.'));
								}
							}
						}
					}else{
						throw new Exception(__('Failed to update record.'));
					}
				}else{
					throw new Exception(__('Failed to update record.'));
				}
			}else{
				throw new Exception(__('Failed to update record.'));
			}
			$dataSource->commit();
		}catch(Exception $e){
			$retArr['status'] = 'err';
			$retArr['msg'] = $e->getMessage();
			$dataSource->rollback();
		}
		
		return $retArr;
	}
}	
?>
