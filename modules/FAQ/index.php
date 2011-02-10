<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $portal, $sugar_config;
$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

$tags = $portal->getChildTags('FAQs');
$tree = array();
$docs_found = $portal->getTagDocs('FAQs');
if(!empty($docs_found) && count($docs_found) > 0) {
   $tree['FAQs'] = $docs_found;
}

foreach($tags as $tag) {
   unset($subdocs);
   $subdocs = array();
   $docs_found = $portal->getTagDocs($tag['id']);

   foreach($docs_found as $d) {
   	  	   $subdocs[$d['doc_id']] = $d;
   }
   recursiveFind(array($tag), $subdocs, $portal);
   if(count($subdocs) > 0) {
      $tree[$tag['name']] = $subdocs;
   }
}
?>
<!-- FAQ -->
<div class="mTop30">
    <h1>Frequently Asked Questions (FAQ)</h1>
    <div class="faqCtn">
<!-- Start -->
<?php
//print_r($tree);
// If there are no entries, just stop
if(count($tree) == 0) {
   echo $mod_strings['LBL_FAQ_EMPTY'];
   echo '<br><img src="include/images/blank.gif" height="250">';
   return;
}

$document_contents = array();
$document_attachments = array();
$basename = '/'.basename($GLOBALS['sugar_config']['parent_site_url']).'/';
$attachmentFields = array('id', 'created_by', 'date_entered', 'file_ext', 'filename');
foreach($tree as $node) {
   foreach($node as $document) {
   	   $id = $document['doc_id'];
           $docname = $document['doc_name'];
           echo '<h2 class="faqQuestion"><a href="#">'.$docname.'</a></h2>';
           echo '<div class="faqAnswer"><div class="block">';
   	   if(empty($document_attachments[$id])) {
	   	   $attachments = $portal->getRelated('KBDocuments', 'DocumentRevisions', $id, $attachmentFields);
	   	   if($attachments && isset($attachments['entry_list']) && count($attachments['entry_list']) > 0) {
	          $document_attachments[$id] = $attachments['entry_list'];
	          //_pp($attachments['entry_list']);
	   	   }
   	   }

   	   if(empty($document_contents[$id])) {
   	      $contentBody = $portal->getKBDocumentBody($id);
   	      $contentBody = html_entity_decode(str_replace("&nbsp;", " ", $contentBody));
   	      preg_match_all("'<img.*?src=[\'\"](.*?)[\'\"].*?>'si", $contentBody, $matches);
          Portal::getImages($matches[1]);
          $replace = array();
          foreach($matches[1] as $img) {
		        if(substr($img, 0, strlen($basename)) == $basename) {
		           //remove basename
		           $img = substr($img, strlen($basename));
		        }
		        //remove leading "/" if found
		        $replace[] = $img[0] == '/' ? substr($img, 1) : $img;
          } //foreach
          $contentBody = str_replace($matches[1], $replace, $contentBody);
          $document_contents[$id] = $contentBody;
   	   } //if
          echo '<div>'.$document_attachments[$id] . $document_contents[$id].'</div>';
		  echo '</div></div>';
   }
}
//print_r($document_attachments);
//print_r();
?>
<!-- END -->
    </div>
</div>

<?php
/*
        <!-- END -->
        <h2 class="faqQuestion"><a href="#">What features do consumer web portals have?</a></h2>
        <div class="faqAnswer">
            <div class="block">
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
            </div>
        </div>
        <!-- END -->
        <h2 class="faqQuestion"><a href="#">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.?</a></h2>
        <div class="faqAnswer">
            <div class="block">
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
            </div>
        </div>
        <!-- END -->
        <h2 class="faqQuestion"><a href="#">Aliquam tincidunt mauris eu risus.?</a></h2>
        <div class="faqAnswer">
            <div class="block">
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
            </div>
        </div>
 */

/**
 * recursiveFind
 * This is a function to recursively scan a tag for its subtags
 * and documents.  Any document(s) found are added to the the
 * initial subtag array.
 */
function recursiveFind($subtags, &$tagdocs, &$portal) {

   foreach($subtags as $st) {
   	       $x = $portal->getChildTags($st['id']);

   	       foreach($x as $childTag) {
   	          $addDocs = $portal->getTagDocs($childTag['id']);
   	          foreach($addDocs as $d) {
   	          	  if(empty($tagdocs[$d['doc_id']])) {
   	          	  	 $tagdocs[$d['doc_id']] = $d;
   	          	  }
   	          }

   	          recursiveFind(array($childTag), $tagdocs, $portal);
   	       }
   }
}
?>
