<?php
/**
 * IUBENDA - Privacy Policy Generator
 *
 * @author     iubenda <info@iubenda.com>
 * @category   legal
 * @package    Iubenda_Policy
 * @copyright  Copyright (c) 2003-2012 iubenda srl (http://www.iubenda.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.html (GPL)
 */

class Iubenda_Policy_Helper_data extends Mage_Core_Helper_Data{
	
	// Path to store config if privacy policy embedding is enabled
	const XML_PATH_ENABLED 				= 'iubenda_privacy_policy/embedding/enabled';	
	
	// Path to store privacy policy id config info
	const XML_PATH_POLICY_PUBLIC_ID		= 'iubenda_privacy_policy/embedding/policy_public_id';	

	// Path to store privacy policy id config info
	const XML_PATH_POLICY_CONFIG_URL	= 'iubenda_privacy_policy/embedding/policy_config_url';	

	// Path to store config if privacy policy should be embedded via badge
	const XML_PATH_EMBED_BADGE 			= 'iubenda_privacy_policy/embedding/embed_badge';

	// Path to store comma separated url portions in case embedding via badge must be skipped
	const XML_PATH_SKIP_BADGE_ON_URL	= 'iubenda_privacy_policy/embedding/skip_badge_on_url';
	
	// Path to store config if privacy policy body should be embedded as a page
	const XML_PATH_DIRECT_EMBED 		= 'iubenda_privacy_policy/embedding/direct_embed';
		
	# Check if privacy policy embedding is enabled
	public function isEmbeddingEnabled($store = null)
	{
		return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
	}
	
	# Return the privacy policy public id
	public function policyPublicId($store=null)
	{
		return Mage::getStoreConfig(self::XML_PATH_POLICY_PUBLIC_ID, $store);
	}
	
	public function policyConfigUrl($store=null)
	{
		return Mage::getStoreConfig(self::XML_PATH_POLICY_CONFIG_URL, $store);
	}
	
	# Check if badge embedding must be skipped for current url
	public function skipBadgeOnCurrentUrl($store=null){
		$skip_this 		= false;
		$current_url 	= Mage::helper('core/url')->getCurrentUrl();
		$urls_to_skip	= explode(",",Mage::getStoreConfig(self::XML_PATH_SKIP_BADGE_ON_URL, $store));
		foreach ($urls_to_skip as &$url_to_skip){
			if(strpos($current_url,trim($url_to_skip)) !== false){
				$skip_this = true;
			}
		}
		return $skip_this;
	}
	
	# Check if privacy policy badge should be embedded
	public function embedViaBadge($store=null)
	{
		$policy_id = trim($this->policyPublicId($store));
		return ($policy_id != '') && Mage::getStoreConfigFlag(self::XML_PATH_EMBED_BADGE, $store) && (!$this->skipBadgeOnCurrentUrl($store));
	}
	
	# Check if privacy policy body sould be embedded as a apge
	public function directEmbed($store=null)
	{
		$policy_id = trim($this->policyPublicId($store));
		return ($policy_id != '') && Mage::getStoreConfigFlag(self::XML_PATH_DIRECT_EMBED, $store);
	}

	# Return the code to be embedded into page.
	# Input parameter:
	#	- false (default), the returned code embeds pp body into page
	#	- true, the returned code creates a iubenda pp badge anchored to the bottom of the page
	public function embeddedCode($badge=false){
		
		$badgeStyle 	= "iubenda-white";
		$badgeNoBrand 	= false;
		$legalOnly 		= false;
		$isAnchored		= $badge;
		$embedBody		= !$badge;
		$ppId			= trim($this->policyPublicId($store)); // example: 193321

		//$embedCode	= "<a href=\"https://staging.mater.iubenda.com/privacy-policy/";
		$embedCode	= "<a href=\"https://www.iubenda.com/privacy-policy/";
		$embedCode .= $ppId;
		$embedCode .= "\" class=\"iubenda-embed ";
		$embedCode .= (" ".$badgeStyle);
		$embedCode .= ($badgeNoBrand) 	? " no-brand" 		: "";
		$embedCode .= ($legalOnly) 		? " iub-legal-only" : "";
		$embedCode .= (!$isAnchored) 	? " iub-body-embed" : "";
		$embedCode .= ($isAnchored) 	? " iub-anchor" 	: "";
		$embedCode .= "\" title=\"Privacy Policy\">Privacy Policy</a><script type=\"text/javascript\">(function (w,d) {var loader = function () {var s = d.createElement(\"script\"), tag = d.getElementsByTagName(\"script\")[0]; s.src = \"https://cdn.iubenda.com/iubenda.js\"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener(\"load\", loader, false);}else if(w.attachEvent){w.attachEvent(\"onload\", loader);}else{w.onload = loader;}})(window, document);</script>";
		if($isAnchored){
			$embedCode = stripslashes($embedCode);
		}
		return $embedCode;
	}
	
	# Validate domain name.
	# In case of successfull validation, the domain is returned. Otherwise null is returned.
	# Some valid domain names are:
	# - http://www.somewebsite.com
	# - https://www.somewebsite.com
	# - https://somewebsite.com
	# - www.somewebsite.com
	# - somewebsite.com
	public function validateDomain($domain=""){
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
		if(preg_match($pattern, $domain)) {
			return $domain;
		}else{
			return null;
		}
	}
	
}
?>