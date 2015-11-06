<?php
namespace common\components;

use yii\web\UrlManager;
use common\models\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (is_array($params) && array_key_exists('lang_id', $params)) { //isset($params['lang_id'])
            $lang = Lang::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            $lang = Lang::getCurrent();
        }

        $url = parent::createUrl($params);

        $baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();
        if ($url !== '/') {
            if ($baseUrl === '') {
                return '/' . $lang->url . $url;
            } else {
                return str_replace($baseUrl, "$baseUrl/$lang->url", $url);
            }
        } else {
            return '/' . $lang->url;
        }
    }
}