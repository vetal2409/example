<?php
if (isset($_POST['template_id']) && $template_id = $_POST['template_id']) {
    require_once('../../components/Controller.php');
    require_once(Controller::getBasePath() . '/include/config.php');
    require_once('./models/MailTemplates.php');

    $controller = new Controller();
    $template = MailTemplates::findOne($template_id);
    $result = array();
    function generate($language = '')
    {
        global $controller;
        global $template;
        $language_part = $language ? '_' . $language : '';
        $body = $controller->renderPartial('/templates/' . $template['file_name'] . $language_part . '.' . $template['file_extension'], $GLOBALS, $GLOBALS['basePath']);
        // $template['info']['embedded_images'] = array();

        ///start embedded_images
        if (isset($template['embedded_images'])) {
            $embeddedImages = explode('|', $template['embedded_images']);
            if (count($embeddedImages) > 0) {
                $path = $cid = array();
                foreach ($embeddedImages as $embeddedImage) {
                    $pathCid = explode('=', $embeddedImage);
                    if (count($pathCid) === 2) {
                        $path[] = $pathCid[0];
                        $cid[] = 'cid:' . $pathCid[1];
                    }
                }
                function getUrlByPath($path)
                {
                    global $baseUrl;
                    return $baseUrl . $path;
                }

                //$template['info']['embedded_images'] = array_combine($path, $cid);
                $body = str_replace($cid, array_map('getUrlByPath', $path), $body);
            }
        }
        ///end embedded_images

        return $body;
    }

    if ($_POST['type'] === 'template') {
        //load language;
        //if count language > 0 load template
        $language_array = $template['file_language'] ? explode('||', $template['file_language']) : array();
        $language_count = count($language_array);

        if ($language_count > 0) {
            //$language_content = $language_count !== 1 ? '<option value=""></option>' : '';
            $language_content = '';
            foreach ($language_array as $lang)
                $language_content .= '<option value="' . $lang . '">' . $lang . '</option>';
            $result['language_content'] = $language_content;
        } else
            $result['language_content'] = '';

//        if ($language_count <= 1) {
//            if ($language_count === 0)
//                $template['body'] = generate();
//            else if ($language_count === 1)
//                $template['body'] = generate($language_array['0']);
//        }

        if ($language_count === 0) {
            $template['body'] = generate();
        } else {
            $template['body'] = generate($language_array['0']);
        }

        $result['template'] = $template;
    } elseif ($_POST['type'] === 'language-template' && $file_language = $_POST['file_language']) {
        $template['body'] = generate($file_language);
        $result['template'] = $template;
    }


    echo json_encode($result);

}