<?php
/*é
  $Id: language.php,v 1.6 2003/06/28 16:53:09 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  browser language detection logic Copyright phpMyAdmin (select_lang.lib.php3 v1.24 04/19/2002)
                                   Copyright Stephane Garin <sgarin@sgarin.com> (detect_language.php v0.1 04/02/2002)
*/

class language
{
    var $languages, $catalog_languages, $browser_languages, $language;

    function language($lng = '')
    {
        $this->languages =
            array('ar' => 'ar([-_][[:alpha:]]{2})?|arabic', 'bg' => 'bg|bulgarian', 'br' => 'pt[-_]br|brazilian portuguese', 'ca' => 'ca|catalan',
                'cs' => 'cs|czech', 'da' => 'da|danish', 'de' => 'de([-_][[:alpha:]]{2})?|german', 'el' => 'el|greek',
                'en' => 'en([-_][[:alpha:]]{2})?|english', 'es' => 'es([-_][[:alpha:]]{2})?|spanish', 'et' => 'et|estonian', 'fi' => 'fi|finnish',
                'fr' => 'fr([-_][[:alpha:]]{2})?|french', 'gl' => 'gl|galician', 'he' => 'he|hebrew', 'hu' => 'hu|hungarian', 'id' => 'id|indonesian',
                'it' => 'it|italian', 'ja' => 'ja|japanese', 'ko' => 'ko|korean', 'ka' => 'ka|georgian', 'lt' => 'lt|lithuanian',
                'lv' => 'lv|latvian', 'nl' => 'nl([-_][[:alpha:]]{2})?|dutch', 'no' => 'no|norwegian', 'pl' => 'pl|polish',
                'pt' => 'pt([-_][[:alpha:]]{2})?|portuguese', 'ro' => 'ro|romanian', 'ru' => 'ru|russian', 'sk' => 'sk|slovak', 'sr' => 'sr|serbian',
                'sv' => 'sv|swedish', 'th' => 'th|thai', 'tr' => 'tr|turkish', 'uk' => 'uk|ukrainian', 'tw' => 'zh[-_]tw|chinese traditional',
                'vi' => 'vi|vietnamese', 'zh' => 'zh|chinese simplified');

        $languages = getLanguages();
        foreach($languages as $iso => $language) {
            $this->catalog_languages[$iso] = $language;
        }
        /*$this->catalog_languages['fr'] = array('id' => 1, 'name' => 'Français', 'image' => DIR_WS_IMAGES.'fr.png', 'width' => 24, 'height' => 15, 'iso' => 'fr');
        $this->catalog_languages['en'] = array('id' => 2, 'name' => 'English', 'image' =>  DIR_WS_IMAGES.'en.png', 'width' => 24, 'height' => 15, 'iso' => 'en');
        $this->catalog_languages['es'] = array('id' => 3, 'name' => 'Español', 'image' =>  DIR_WS_IMAGES.'es.png', 'width' => 24, 'height' => 15, 'iso' => 'es');
        $this->catalog_languages['vi'] = array('id' => 4, 'name' => 'Việt', 'image' =>  DIR_WS_IMAGES.'vi.png', 'width' => 24, 'height' => 15, 'iso' => 'vi');
        $this->catalog_languages['de'] = array('id' => 5, 'name' => 'Deutsch', 'image' =>  DIR_WS_IMAGES.'de.png', 'width' => 22, 'height' => 13, 'iso' => 'de');
        $this->catalog_languages['it'] = array('id' => 6, 'name' => 'Italiano', 'image' =>  DIR_WS_IMAGES.'it.png', 'width' => 22, 'height' => 15, 'iso' => 'it');
        $this->catalog_languages['id'] = array('id' => 7, 'name' => 'Bahasa Indonesia', 'image' =>  DIR_WS_IMAGES.'id.png', 'width' => 22, 'height' => 15, 'iso' => 'id');*/

        $this->browser_languages = '';
        $this->language = '';

        $this->set_language($lng);
    }

    function set_language($language)
    {
        if ((tep_not_null($language)) && (isset($this->catalog_languages[$language]))) {
            $this->language = $this->catalog_languages[$language];
        } else {
            $this->language = $this->catalog_languages[DEFAULT_LANGUAGE];
        }
    }

    function get_browser_language()
    {
        $this->browser_languages = explode(',', getenv('HTTP_ACCEPT_LANGUAGE'));

        for ($i = 0, $n = sizeof($this->browser_languages); $i < $n; $i++) {
            reset($this->languages);
            while (list($key, $value) = each($this->languages)) {
                if (preg_match('%^(' . $value . ')(;q=[0-9]\\.[0-9])?$%', $this->browser_languages[$i]) && isset($this->catalog_languages[$key])) {
                    $this->language = $this->catalog_languages[$key];
                    break 2;
                }
            }
        }
    }
}

?>
