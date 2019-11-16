<?php
######################################################################
# SEO-Generator    	          	                                     #
# Copyright (C) 2017 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 4.9.0                       	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
# Line 34 to 399 are partially under the following copyright:        #
# 	@author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design  #
# 	(www.daobydesign.com)- GNU/GPL                                   #
# 	see details in code                                              #
######################################################################


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


// Import library dependencies
jimport('joomla.plugin.plugin');


class plgSystemSEOGenerator extends JPlugin
{
	
	// Constructor
    function __construct( &$subject, $params )
    {
		parent::__construct( $subject, $params );
    }


########################################################################################
#																																											 #
# begin "title-function" and "remove the xreference"                                   #
#   line 43-84 partially under the following copyright:                                #
#   @author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design                    #
#   (www.daobydesign.com)- GNU/GPL                                                     #
#																																											 #
########################################################################################

    function onAfterDispatch()
    {
		$app = JFactory::getApplication();
		$thebuffer;
		$document = JFactory::getDocument();
        $docType = $document->getType();

    	// only mod site pages that are html docs (no admin, install, etc.)
      	if (!$app->isSite()) return ;
    	if ($docType != 'html') return ;

		
		$titOrder = $this->params->def('titorder', 0);
		$fptitle = html_entity_decode($this->params->def('fptitle','Home'));
		$fptitorder = $this->params->def('fptitorder', 0);
		$pageTitle = html_entity_decode($document->getTitle());
		$sitename = html_entity_decode($app->getCfg('sitename'));
		$sep = $this->params->def('separator','|');
		
		if ($this->isFrontPage()):
			if ($fptitorder == 0):
				$newPageTitle = $fptitle . ' ' . $sep . ' ' . $sitename;
			elseif ($fptitorder == 1):
				$newPageTitle = $sitename . ' ' . $sep . ' ' . $fptitle;
			elseif ($fptitorder == 2):
				$newPageTitle = $fptitle;
			elseif ($fptitorder == 3):
				$newPageTitle = $sitename;
			endif;
		else:
			if ($titOrder == 0):
				$newPageTitle = $pageTitle . ' ' . $sep . ' ' . $sitename;
			elseif ($titOrder == 1):
				$newPageTitle = $sitename . ' ' . $sep . ' ' . $pageTitle;
			elseif ($titOrder == 2):
				$newPageTitle = $pageTitle;
			endif;
		endif;

		
		// Set the Title
		$document->setTitle ($newPageTitle);
		
		// remove the xreference
		$document->setMetaData('xreference', '');
	
	}

########################################################################################
#																																											 #
# end "title-function" and "remove the xreference"                                     #
#																																											 #
########################################################################################



########################################################################################
#																																											 #
# begin "on the fly"-function and "regenerate all"-function and "set other meta's"     #
#   line 108-135, 209-230 partially under the following copyright:                     #
#   @author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design                    #
#   (www.daobydesign.com)- GNU/GPL                                                     #
#																																											 #
########################################################################################

	function onContentPrepare($context, &$article, &$params, $limitstart = 0 )

	{
		$app = JFactory::getApplication();

		$document = JFactory::getDocument();

		$blackList = $this->params->def('blacklist', 'a, able, about, above, abroad, according, accordingly, across, actually, adj, after, afterwards, again, against, ago, ahead, ain\'t, all, allow, allows, almost, alone, along, alongside, already, also, although, always, am, amid, amidst, among, amongst, an, and, another, any, anybody, anyhow, anyone, anything, anyway, anyways, anywhere, apart, appear, appreciate, appropriate, are, aren\'t, around, as, a\'s, aside, ask, asking, associated, at, available, away, awfully, b, back, backward, backwards, be, became, because, become, becomes, becoming, been, before, beforehand, begin, behind, being, believe, below, beside, besides, best, better, between, beyond, both, brief, but, by, c, came, can, cannot, cant, can\'t, caption, cause, causes, certain, certainly, changes, clearly, c\'mon, co, co\., com, come, comes, concerning, consequently, consider, considering, contain, containing, contains, corresponding, could, couldn\'t, course, c\'s, currently, d, dare, daren\'t, definitely, described, despite, did, didn\'t, different, directly, do, does, doesn\'t, doing, done, don\'t, down, downwards, during, e, each, edu, eg, eight, eighty, either, else, elsewhere, end, ending, enough, entirely, especially, et, etc, even, ever, evermore, every, everybody, everyone, everything, everywhere, ex, exactly, example, except, f, fairly, far, farther, few, fewer, fifth, first, five, followed, following, follows, for, forever, former, formerly, forth, forward, found, four, from, further, furthermore, g, get, gets, getting, given, gives, go, goes, going, gone, got, gotten, greetings, h, had, hadn\'t, half, happens, hardly, has, hasn\'t, have, haven\'t, having, he, he\'d, he\'ll, hello, help, , hence, her, here, hereafter, hereby, herein, here\'s, hereupon, hers, herself, he\'s, hi, him, himself, his, hither, hopefully, how, howbeit, however, hundred, i, i\'d, ie, if, ignored, i\'ll, i\'m, immediate, in, inasmuch, inc, inc\., indeed, indicate, indicated, indicates, inner, inside, insofar, instead, into, inward, is, isn\'t, it, it\'d, it\'ll, its, it\'s, itself, i\'ve, j, just, k, keep, keeps, kept, know, known, knows, l, last, lately, later, latter, latterly, least, less, lest, let, let\'s, like, liked, likely, likewise, little, look, looking, looks, low, lower, ltd, m, made, mainly, make, makes, many, may, maybe, mayn\'t, me, mean, meantime, meanwhile, merely, might, mightn\'t, mine, minus, miss, more, moreover, most, mostly, mr, mrs, much, must, mustn\'t, my, myself, n, name, namely, nd, near, nearly, necessary, need, needn\'t, needs, neither, never, neverf, neverless, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, no-one, nor, normally, not, nothing, notwithstanding, novel, now, nowhere, o, obviously, of, off, often, oh, ok, okay, old, on, once, one, ones, one\'s, only, onto, opposite, or, other, others, otherwise, ought, oughtn\'t, our, ours, ourselves, out, outside, over, overall, own, p, particular, particularly, past, per, perhaps, placed, please, plus, possible, presumably, probably, provided, provides, q, que, quite, qv, r, rather, rd, re, really, reasonably, recent, recently, regarding, regardless, regards, relatively, respectively, right, round, s, said, same, saw, say, saying, says, second, secondly, see, seeing, seem, seemed, seeming, seems, seen, self, selves, sensible, sent, serious, seriously, seven, several, shall, shan\'t, she, she\'d, she\'ll, she\'s, should, shouldn\'t, since, six, so, some, somebody, someday, somehow, someone, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specified, specify, specifying, still, sub, such, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, that\'ll, thats, that\'s, that\'ve, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, there\'d, therefore, therein, there\'ll, there\'re, theres, there\'s, thereupon, there\'ve, these, they, they\'d, they\'ll, they\'re, they\'ve, thing, things, think, third, thirty, this, thorough, thoroughly, those, though, three, through, throughout, thru, thus, till, to, together, too, took, toward, towards, tried, tries, truly, try, trying, t\'s, twice, two, u, un, under, underneath, undoing, unfortunately, unless, unlike, unlikely, until, unto, up, upon, upwards, us, use, used, useful, uses, using, usually, v, value, various, versus, very, via, viz, vs, w, want, wants, was, wasn\'t, way, we, we\'d, welcome, well, we\'ll, went, were, we\'re, weren\'t, we\'ve, what, whatever, what\'ll, what\'s, what\'ve, when, whence, whenever, where, whereafter, whereas, whereby, wherein, where\'s, whereupon, wherever, whether, which, whichever, while, whilst, whither, who, who\'d, whoever, whole, who\'ll, whom, whomever, who\'s, whose, why, will, willing, wish, with, within, without, wonder, won\'t, would, wouldn\'t, x, y, yes, yet, you, you\'d, you\'ll, your, you\'re, yours, yourself, yourselves, you\'ve, z, zero');
		$minLength = $this->params->def('lengthofword', '3' );
		$count = $this->params->def('count', '20' );
		$saveAll = $this->params->def('regenerateall',0);
		$usetitle = $this->params->def('usetitleorcontent',0);
		$thelength = $this->params->def('length', 200);
		$fpdesc = $this->params->def('fpdesc', 0);
		$credit = $this->params->def('credittag', 0);
		$robots = $this->params->def('robots', '' );
		$verificationkey = $this->params->def('verificationkey', '' );
		$statickeywords = $this->params->def('statickeywords', '' );

		// check for Joomla 1.6 - title is not everywhere available e.g. on frontpage - if it is so then use content
		if (isset($article->title)) 
		{
			$title = $article->title;
		} else {
			$title = $article->text;
		}
		
		$thecontent = $article->text;


		// get existing keywords and description saved into database for the shown article if they are not empty
		if (isset($article->metakey)) {$existingkeywords = $article->metakey;} else {$existingkeywords = '';}
		if (isset($article->metadesc)) {$existingdescription = $article->metadesc;} else {$existingdescription = '';}







//echo $existingkeywords;		 //noch entfernen
//echo $existingdescription;



		//Checks to see whether FP should use standard desc or auto-generated one.
		if ($this->isFrontPage() && $fpdesc == 0) {
		 $lang_code = JFactory::getLanguage()->getTag();
		 $languages = JLanguageHelper::getLanguages('lang_code');
		 if (isset($languages[$lang_code]) && $languages[$lang_code]->metadesc) {
		  $document->setDescription($languages[$lang_code]->metadesc);
		 } else {
		  $document->setDescription($app->getCfg('MetaDesc'));
		 }
		 return;
		}
		
		//Bit of code to grab only the first content item in category list.
		if ($document->getDescription() != '') {
			if ($document->getDescription() != $app->getCfg('MetaDesc')) return;
		}





	
    // "on the fly" is only working if meta-key or meta-desc is not saved in backend for article
 		// (global meta und erster artikel funktionieren noch nicht siehe zeile 151-160)
		
    if ((strlen($existingkeywords) == 0) or (strlen($existingdescription) == 0)) {

    	// content will be only prepared if needed for meta-desc or meta-key
    	// only if meta-desc is not saved in backend for article 
    	// or if usetitle is set to "use content for keywords" or "use content and title for keywords" 
    	if ((strlen($existingdescription) == 0) or ($usetitle == 1) or ($usetitle == 2)) {						 		
				// to avoid problems with large articles or slow servers 
				// truncate the content to the otfcut parameter (if higher than 0) - rounding to nearest word
				$otfcut = 10000;
					if ($otfcut > 0) {
						$thecontent = $thecontent . ' ';
						$thecontent = substr($thecontent,0,$otfcut);
						$thecontent = substr($thecontent,0,strrpos($thecontent,' ')); 
      		}
     				
		    // Clean things up and prepare auto-generated Meta Description tag.
				$thecontent = $this->CleanText($thecontent);
			}

			// Truncate the string to the length parameter - rounding to nearest word
			$thecontent = $thecontent . ' ';
			$thecontent = substr($thecontent,0,$thelength);
			$thecontent = substr($thecontent,0,strrpos($thecontent,' '));
		
			// Set the description
			$document->setMetaData('description', $thecontent);



		// create and set keywords 
	
			// Clean things up for auto-generated keywords
			$title = $this->CleanText($title);
			
	    // check if title or content used for keywords
	    if ($usetitle == 0):
	     $keys = $title; 
	    elseif ($usetitle == 1):
	     $keys = $thecontent;
	    elseif ($usetitle == 2):
	     $keys = $title . ' ' . $thecontent;
	    endif; 
	    
	    
	    // Set the keywords
	    $keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
	      // Set the statickeywords
	      if ($statickeywords <> '') {
	        $keywords = $statickeywords . ', '. $keywords;
			  }
	    $document->setMetaData('keywords', $keywords);
		
		}


		
		 ########################################################################################
		 #																																										  #
     # begin "set other meta's"                                                             #
     #																																											#
     ########################################################################################	

			// Set optional Generator tag for SEOGenerator credit.
			if ($credit == 0) {
				$document->setMetaData('generator', 'SEOGenerator (http://www.suchmaschinen-optimierung-seo.org)');
			}
			
			
			// Set robots
	    if ($robots <> '') {
	      $document->setMetaData('robots', $robots);
			}
			
			
			// Set google webmaster verification
	    if ($verificationkey <> '') {
	      $document->setMetaData('google-site-verification', $verificationkey);
			}

		 ########################################################################################
		 #																																										  #
     # end "set other meta's"                                                               #
     #																																											#
     ########################################################################################



		 ########################################################################################
		 #																																										  #
     # begin "regenerate all"-function                                                      #
     #																																											#
     ########################################################################################
		
     // option "regenerate all" - save the modified keywords for all postings

		if ($saveAll == 0) {
		  	$db = JFactory::getDBO();
		  	
			// check joomla version and choose different php to avoid compatibility issues in Joomla 3.0 and above
			$jversion = new JVersion(); 
			// joomla version below 3.0
			if( version_compare( $jversion->getShortVersion(), '3.0', 'lt' ) ) {
					
				$query = "SELECT `id`, `sectionid`, `catid`, `title`, `introtext`, `fulltext`, `created_by_alias`, `created_by` FROM #__content";
			// joomla version 3.0 or above
			} else {

				$query = "SELECT `id`, `catid`, `title`, `introtext`, `fulltext`, `created_by_alias`, `created_by` FROM #__content";
			}

 			

				$db->setQuery($query);
				$rows =  $db->loadAssocList();
				foreach ( $rows as $row ) {
						
						$title = $row['title'];
						$thecontent = $row['introtext'] . " " . $row['fulltext'];

   					// content will be only prepared if needed for meta-key
   					// only if usetitle is set to "use content for keywords" or "use content and title for keywords" 
   					if (($usetitle == 1) or ($usetitle == 2)) {						 		
					 		// to avoid problems with large articles or slow servers 
					 		// truncate the content to the rgacut parameter (if higher than 0) - rounding to nearest word
							$rgacut = 5000;
							if ($rgacut > 0) {
							$thecontent = $thecontent . ' ';
							$thecontent = substr($thecontent,0,$rgacut);
							$thecontent = substr($thecontent,0,strrpos($thecontent,' ')); 
     					}
     				
					    // Clean things up and prepare auto-generated Meta Description tag.
							$thecontent = $this->CleanText($thecontent);
						}
						
						// title will be prepared for keywords
						$title = $this->CleanText($title);
						
						// check if title or content used for keywords
						if ($usetitle == 0):
						 $keys = $title; 
						elseif ($usetitle == 1):
						 $keys = $thecontent;
						elseif ($usetitle == 2):
						 $keys = $title . ' ' . $thecontent;
						endif; 
					
						$keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
					  
						$query = "UPDATE #__content SET `metakey` = '" . $keywords . "' WHERE `id` = " . $row['id'];
						$db->setQuery($query);
						$db->query();									
				}
    }				
		
		 ########################################################################################
		 #																																										  #
     # end "regenerate all"-function                                                        #
     #																																											#
     ########################################################################################
	
	
	
	}

########################################################################################
#																																											 #
# end "on the fly"-function and "regenerate all"-function and "set other meta's"       #
#																																											 #
########################################################################################



########################################################################################
#																																											 #
# begin clean text                                                                     #
#																																											 #
########################################################################################
	
	/* cleanText function - Thx owed to eXtplorer, joomSEO and Jean-Marie Simonet */
	function CleanText( $text ) {
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );
		$text = preg_replace( '/<!--.+?-->/', '', $text );
		$text = preg_replace( '/{.+?}/', '', $text );

		// convert html entities to chars (with conditional for PHP4 users
		if(( version_compare( phpversion(), '5.0' ) < 0 )) {
			require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'html_entity_decode_php4.php');
			$text = html_entity_decode_php4($text,ENT_QUOTES,'UTF-8');
		}else{
			$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		}

		$text = strip_tags( $text ); // Last check to kill tags
		$text = str_replace('"', '\'', $text); //Make sure all quotes play nice with meta.
        $text = str_replace(array("\r\n", "\r", "\n", "\t"), " ", $text); //Change spaces to spaces

        // remove any extra spaces
		while (strchr($text,"  ")) {
			$text = str_replace("  ", " ",$text);
		}
		
		// general sentence tidyup
		for ($cnt = 1; $cnt < JString::strlen($text); $cnt++) {
			// add a space after any full stops or comma's for readability
			// added as strip_tags was often leaving no spaces
			if ( ($text{$cnt} == '.') || (($text{$cnt} == ',') && !(is_numeric($text{$cnt+1})))) {
				if ($text{strlen($cnt+1)} != ' ')  {
					$text = substr_replace($text, ' ', $cnt + 1, 0);
				}
			}
		}
			
		return $text;
	}	

########################################################################################
#																																											 #
# end clean text                                                                       #
#																																											 #
########################################################################################



########################################################################################
#																																											 #
# begin check frontpage for "title-function" and "on the fly"-function                 #
#																																											 #
########################################################################################
	
  function isFrontPage() {
	 $menu = JFactory::getApplication()->getMenu();
	 $lang = JFactory::getLanguage();
	 if ($menu->getActive() == $menu->getDefault($lang->getTag()) || $menu->getActive() == $menu->getDefault()) {	
	  return true;
	 }
	 return false;
	}
	
########################################################################################
#																																											 #
# end check frontpage for "title-function" and "on the fly"-function                   #
#																																											 #
########################################################################################	
	
	
	
########################################################################################
#																																											 #
# begin kill title buffer for "title-function"                                         #
#   partially under the following copyright:                                           #
#   @author Ryan McLaughlin - Copyright (C) 2008-2009 Dao By Design                    #
#   (www.daobydesign.com)- GNU/GPL                                                     #
#																																											 #
########################################################################################

	function killTitleinBuffer ($buff, $tit)
	{
		$cleanTitle = $buff;
		if (substr($buff, 0, strlen($tit)) == $tit) {
			$cleanTitle = substr($buff, strlen($tit) + 1);
		} 
		return $cleanTitle;
	}
	
########################################################################################
#																																											 #
# end kill title buffer for "title-function"                                           #
#																																											 #
########################################################################################



########################################################################################
#																																											 #
# begin generating keywords                                                            #
#																																											 #
########################################################################################

  // generate keywords

  function seogeneratekeywords($keys, $blackList, $count, $minLength) {
		
		$keywords ='';
	  
	  $keys = preg_replace('/<[^>]*>/', ' ', $keys);	
	  $keys = preg_replace('/[\.;:!?|\'|\"|\`|\,|\(|\)|\-|\+]/', ' ', $keys);	  	  	
	  $keysArray = explode(" ", $keys);
	  $keysArray = array_count_values(array_map('utf8_strtolower', $keysArray));
	
  	$blackArray = explode(",", $blackList);
	
	  foreach($blackArray as $blackWord){
		  if(isset($keysArray[trim($blackWord)]))
			  unset($keysArray[trim($blackWord)]);
	  }
	
	  arsort($keysArray);
	
	  $i = 1;
	
	  foreach($keysArray as $word=>$instances){
		  if($i > $count)
			  break;
		  if(strlen(trim($word)) >= $minLength ) {
			  $keywords .= $word . ", ";
			  $i++;
		  }
	  }
	
	  $keywords = rtrim($keywords, ", ");
	  return($keywords);
  }	
	
########################################################################################
#																																											 #
# end generating keywords                                                              #
#																																											 #
########################################################################################



########################################################################################
#																																											 #
# begin "save by writing"-function                                                     #
#																																											 #
########################################################################################

		// saved keywords and description by writing an article
		
		public function onContentBeforeSave($context, $article, $isNew)
        {
        
			// checking the context, do you want the code to be execute for articles, categories, etc., or only for articles? If it's only for articles, you should check if context equals "com_content.article"
			// now "save by writing" is only working if an article is saved
			if ( $context != "com_content.article") {
      			return;
   			}		
			
          $app = JFactory::getApplication();
    			
    			$blackList = $this->params->get('blacklist');
					$minLength = $this->params->get('lengthofword');
					$count = $this->params->get('count');
			    $thelength = $this->params->get('length');
			    $savedbywriting = $this->params->get('savedbywriting');
		      $usetitle = $this->params->get('usetitleorcontent');
			//$title = $article->title;
   			if (isset($article->title)){$title = $article->title;} else {$title = '';}			
			//$thecontent = $article->introtext.$article->fulltext;
			if (isset($article->introtext)){$introtext = $article->introtext;} else {$introtext = '';}
			if (isset($article->fulltext)){$fulltext = $article->fulltext;} else {$fulltext = '';}
			$thecontent = $introtext.$fulltext;
			//$metakey = $article->metakey;
    		if (isset($article->metakey)){$metakey = $article->metakey;} else {$metakey = '';}
			//$metadesc = $article->metadesc;
			if (isset($article->metadesc)){$metadesc = $article->metadesc;} else {$metadesc = '';}
			
					// only working if "save by writing" is on    
    			if ($savedbywriting == 0) {
    				// "save by writing" is only working if meta-key or meta-desc is cleaned in backend
    				if ((strlen($metakey) == 0) or (strlen($metadesc) == 0)) {
    					
    					// content will be only prepared if needed for meta-desc or meta-key
    					// only if meta-desc is cleaned in backend  
    					// or if usetitle is set to "use content for keywords" or "use content and title for keywords" 
    					if ((strlen($metadesc) == 0) or ($usetitle == 1) or ($usetitle == 2)) {						 		
						 		// to avoid problems with large articles or slow servers 
						 		// truncate the content to the sbwcut parameter (if higher than 0) - rounding to nearest word
								$sbwcut = 150000;
								if ($sbwcut > 0) {
								$thecontent = $thecontent . ' ';
								$thecontent = substr($thecontent,0,$sbwcut);
								$thecontent = substr($thecontent,0,strrpos($thecontent,' ')); 
      					}
      				
						    // Clean things up and prepare auto-generated Meta Description tag.
								$thecontent = $this->CleanText($thecontent);
							}
							
							// title will be prepared for keywords
							$title = $this->CleanText($title);
							
								// check if title or content used for keywords
						    if ($usetitle == 0):
						     $keys = $title; 
						    elseif ($usetitle == 1):
						     $keys = $thecontent;
						    elseif ($usetitle == 2):
						     $keys = $title . ' ' . $thecontent;
						    endif; 
						    
						      // work on the article
    							// keywords will be only prepared if needed for meta-key
    							// only if meta-key is cleaned in backend 
    							if (strlen($metakey) == 0) {						 		
										$keywords = $this->seogeneratekeywords($keys, $blackList, $count, $minLength);
									}
												
										if (isset($metakey)) {      // meta-key will be only filled with keywords if meta-key is cleaned in backend
								      if(strlen($metakey) == 0)
								      $metakey = $keywords;
										}
		
										if (isset($metadesc)) {      // meta-desc will be only filled with content if meta-desc is cleaned in backend
								      if(strlen($metadesc) == 0)
								      $metadesc = substr(trim($thecontent), 0, $thelength);
										}
						      
						      $article->metakey = $metakey;
									$article->metadesc = $metadesc;
						      
				
						} else {
    
    		  	}
    		  		
    		  		
    			} else {
    
    		  }
    			
    			
    			
            return true;
        }
        
########################################################################################
#																																											 #
# end "save by writing"-function                                                       #
#																																											 #
########################################################################################        



}



?>