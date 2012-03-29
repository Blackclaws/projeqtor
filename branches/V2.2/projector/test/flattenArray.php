    
  /** ========================================================================
   * Flattens an array of (id, name, array) 
   * @param $tab the array to flatten
   * @return an flat array of id=>name
   */
  static function flattenArray($tab) {
    foreach($tab as $subTab) {
      $fid= $subTab['id'];
      echo $fid;
      echo "=>";
      $fname=$subTab['name'];
      echo "$fname";
      echo "<br/>";
      $list[$fid]=$fname;
      $subsubtab=$subTab['subItems'];
      if ($subsubtab) {
        $sublist=self::flattenArray($subsubtab);
        $list=array_merge_preserve_keys($list,$sublist);
      }
    }
    return $list;
  }